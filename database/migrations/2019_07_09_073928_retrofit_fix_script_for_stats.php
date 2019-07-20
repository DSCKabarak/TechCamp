<?php

use App\Models\EventStats;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Superbalist\Money\Money;

class RetrofitFixScriptForStats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * Link tickets to their orders based on the order items on each order record. It will try and 
         * find the ticket on the event and match the order item title to the ticket title.
         */
        Order::all()->map(function($order) {
            $event = $order->event()->first();
            $tickets = $event->tickets()->get();
            $orderItems = $order->orderItems()->get();
            // We would like a list of titles from the order items to map against tickets
            $mapOrderItemTitles = $orderItems->map(function($orderItem) {
                return $orderItem->title;
            });

            // Filter tickets who's title is contained in the order items set
            $ticketsFound = $tickets->filter(function($ticket) use ($mapOrderItemTitles) {
                return ($mapOrderItemTitles->contains($ticket->title));
            });

            // Attach the ticket to it's order
            $ticketsFound->map(function($ticket) use ($order) {
                $pivotExists = $order->tickets()->where('ticket_id', $ticket->id)->exists();
                if (!$pivotExists) {
                    \Log::debug(sprintf("Attaching Ticket (ID:%d) to Order (ID:%d)", $ticket->id, $order->id));
                    $order->tickets()->attach($ticket);
                }
            });

            $orderStringValue = $orderItems->reduce(function($carry, $orderItem) {
                $orderTotal = (new Money($carry));
                $orderItemValue = (new Money($orderItem->unit_price))->multiply($orderItem->quantity);

                return $orderTotal->add($orderItemValue)->format();
            });

            // Refunded orders had their amounts wiped in previous versions so we need to fix that before we can work on stats
            $orderItemsValue = (new Money($orderStringValue));
            $oldOrderAmount = (new Money($order->amount));

            // We are checking to see if there is a change from what is stored vs what the order items says
            if ($oldOrderAmount->equals($orderItemsValue) === false) {
                \Log::debug(sprintf(
                    "Setting Order (ID:%d, OLD_AMOUNT:%s) amount to match Order Items Amount: %s",
                    $order->id,
                    $oldOrderAmount->format(),
                    $orderItemsValue->format()
                ));
                $order->amount = $orderItemsValue->toFloat();
                $order->save();
            }

            if ($order->is_refunded) {
                $order->attendees()->get()->map(function($attendee) {
                    if (!$attendee->is_refunded) {
                        \Log::debug(sprintf("Marking Attendee (ID:%d) as refunded",$attendee->id));
                        $attendee->is_refunded = true;
                    }

                    if (!$attendee->is_cancelled) {
                        \Log::debug(sprintf("Marking Attendee (ID:%d) as cancelled",$attendee->id));
                        $attendee->is_cancelled = true;
                    }
                    // Update the attendee to reflect the real world
                    $attendee->save();
                });
            }
        });

        Ticket::all()->map(function($ticket) {
            // NOTE: We need to ignore refunded orders when calculating the ticket sales volume.
            /** @var Ticket $ticket */
            $orders = $ticket->orders()->where('is_refunded', false)->get();

            $ticketStringValue = $orders->reduce(function($ticketCarry, $order) use ($ticket) {
                $ticketTotal = (new Money($ticketCarry));

                /** @var Order $order */
                $orderItems = $order->orderItems()->get();
                $orderStringValue = $orderItems->reduce(function($carry, $orderItem) use ($ticket) {
                    $orderTotal = (new Money($carry));
                    $orderItemValue = (new Money($orderItem->unit_price))->multiply($orderItem->quantity);

                    // Only count the order items related to the ticket
                    if (trim($ticket->title) === trim($orderItem->title)) {
                        return $orderTotal->add($orderItemValue)->format();
                    }

                    return $orderTotal->format();
                });

                $orderValue = (new Money($orderStringValue));

                return $ticketTotal->add($orderValue)->format();
            });

            $oldTicketSalesVolume = (new Money($ticket->sales_volume));
            $orderItemsTicketSalesVolume = (new Money($ticketStringValue));
            if ($oldTicketSalesVolume->equals($orderItemsTicketSalesVolume) === false) {
                \Log::debug(sprintf(
                    "Updating Ticket (ID:%d, OLD_AMOUNT:%s) - New Sales Volume (%s)",
                    $ticket->id,
                    $oldTicketSalesVolume->format(),
                    $orderItemsTicketSalesVolume->format()
                ));
                $ticket->sales_volume = $orderItemsTicketSalesVolume->toFloat();
                $ticket->save();
            }

            // Do the same check for ticket quantity sold
            $ticketQuantity = $orders->reduce(function ($ticketCarry, $order) use ($ticket) {
                $orderItems = $order->orderItems()->get();
                $orderQuantity = $orderItems->reduce(function ($carry, $orderItem) use ($ticket) {
                    if (trim($ticket->title) === trim($orderItem->title)) {
                        return $carry + $orderItem->quantity;
                    }
                    return $carry;
                });

                return $ticketCarry + $orderQuantity;
            });

            // We need to update the ticket quantity if the order items reflect otherwise
            if ((int)$ticket->quantity_sold !== (int)$ticketQuantity) {
                \Log::debug(sprintf(
                    "Updating Ticket (ID:%d, OLD_QUANTITY:%d) - New Quantity (%d)",
                    $ticket->id,
                    $ticket->quantity_sold,
                    $ticketQuantity
                ));
                $ticket->quantity_sold = $ticketQuantity;
                $ticket->save();
            }
        });

        Event::all()->map(function($event) {
            /** @var $event Event */
            $orders = $event->orders()->where('is_refunded', false)->get();

            $orderTimeBasedStats = [];
            $orders->map(function($order) use (&$orderTimeBasedStats) {
                /** @var $order Order */
                $orderItems = $order->orderItems()->get();
                $quantity = $orderItems->reduce(function ($carry, $orderItem) {
                    return $carry + $orderItem->quantity;
                });

                $orderDay = Carbon::createFromTimeString($order->created_at)->format('Y-m-d');
                if (!isset($orderTimeBasedStats[$orderDay])) {
                    $orderTimeBasedStats[$orderDay] = [
                        'quantity' => 0,
                        'sales_volume' => new Money(0),
                    ];
                }
                $orderTimeBasedStats[$orderDay]['quantity'] += $quantity;
                /** @var Money $previousSalesVolume */
                $previousSalesVolume = $orderTimeBasedStats[$orderDay]['sales_volume'];

                $orderAmount = new Money($order->amount);
                $orderTimeBasedStats[$orderDay]['sales_volume'] = $previousSalesVolume->add($orderAmount);
            });

            /**
             * Event stats needs to be checked so the dashboard time series graphs match the historical order amounts
             * and amount of tickets sold per day.
             */
            EventStats::where('event_id', $event->id)->get()->map(function($eventStat) use ($orderTimeBasedStats) {
                /** @var $eventStat EventStats */
                if (isset($orderTimeBasedStats[$eventStat->date])) {
                    $timeBasedQuantity = $orderTimeBasedStats[$eventStat->date]['quantity'];
                    if ($eventStat->tickets_sold !== $timeBasedQuantity) {
                        \Log::debug(sprintf(
                            "Updating Event Stat (ID:%d, OLD_QUANTITY:%d) - New Quantity %d",
                            $eventStat->id,
                            $eventStat->tickets_sold,
                            $timeBasedQuantity
                        ));
                        $eventStat->tickets_sold = $timeBasedQuantity;
                    }

                    $oldEventStatsSalesVolume = new Money($eventStat->sales_volume);
                    $timeBasedSalesVolume = $orderTimeBasedStats[$eventStat->date]['sales_volume'];
                    if ($oldEventStatsSalesVolume->equals($timeBasedSalesVolume) === false) {
                        \Log::debug(sprintf(
                            "Updating Event Stat (ID:%d, OLD_SALES_VOLUME:%s) - New Sales Volume %s",
                            $eventStat->id,
                            $oldEventStatsSalesVolume->format(),
                            $timeBasedSalesVolume->format()
                        ));
                        $eventStat->sales_volume = $timeBasedSalesVolume->toFloat();
                    }
                    if ($eventStat->isDirty()) {
                        // Persist event stat changes to reflect order amounts and tickets sold
                        $eventStat->save();
                    }
                } else {
                    /*
                     * If the order stats does not exist, but the event stat has quantity and sales_volume then
                     * we need to kill the values since there is no subsequent order information to back their
                     * existance.
                     */
                    if ($eventStat->tickets_sold > 0) {
                        \Log::debug(sprintf(
                            "Clearing Event Stat (ID:%d, TICKETS_SOLD:%d, SALES_VOLUME:%f) due to no order information",
                            $eventStat->id,
                            $eventStat->tickets_sold,
                            $eventStat->sales_volume
                        ));
                        $eventStat->tickets_sold = 0;
                        $eventStat->sales_volume = 0.0;
                        $eventStat->save();
                    }
                }
            });
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        // Nothing to do here. This can run multiple times and will only attempt to fix the stats across events,
        // tickets and orders in the database.
    }
}
