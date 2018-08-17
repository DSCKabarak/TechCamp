<?php

namespace App\Listeners;

use App\Events\OrderCompletedEvent;
use App\Jobs\GenerateTicket;
use App\Jobs\SendOrderNotification;
use App\Jobs\SendOrderTickets;
use App\Jobs\ProcessGenerateAndSendTickets;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class OrderCompletedListener implements ShouldQueue
{

    use DispatchesJobs;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Generate the ticket and send it to the attendee. If the ticket can't be generated don't attempt to send the ticket
     * to the attendee as the ticket is attached as a PDF.
     *
     * @param  OrderCompletedEvent  $event
     * @return void
     */
    public function handle(OrderCompletedEvent $event)
    {
        /**
         * Generate the PDF tickets and send notification emails etc.
         */
        Log::info('Begin Processing Order: ' . $event->order->order_reference);
        ProcessGenerateAndSendTickets::withChain([
            new GenerateTicket($event->order->order_reference),
            new SendOrderTickets($event->order)
        ])->dispatch();

        $this->dispatch(new SendOrderNotification($event->order));
    }
}
