<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
        App\Models\Order::all()->map(function($order) {
            $event = $order->event()->first();
            $tickets = $event->tickets()->get();
            $orderItems = $order->orderItems()->get();
            $mapOrderItemTitles = $orderItems->map(function($orderItem) {
                return $orderItem->title;
            });

            $ticketsFound = $tickets->filter(function($ticket) use ($mapOrderItemTitles) {
                return ($mapOrderItemTitles->contains($ticket->title));
            });

            $ticketsFound->map(function($ticket) use ($order) {
                \Log::debug(sprintf("Attaching Ticket:%d to Order:%d\n", $ticket->id, $order->id));                
                $order->tickets()->attach($ticket); // TODO uncomment this to actually save
            });
        });

        // orders
            // Check `order_items` table
            // Compare order values by using `quantity` and `unit_price`
            // Fix order `amount` if `refunded_amount` exists

            // attendees
                // Mark cancelled/refunded if refunded amount/status exists on the order

        // tickets
            // Check quantity sold from order_items
            // Fix sales_volume from order_items

        // event_stats
            // Keep the dates as is and try to find orders that has the same timestamps
                // Fix the sales volume value from orders, order_items and tickets (amount - amount_refunded)
                // Fix the tickets_sold value from order_items

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
