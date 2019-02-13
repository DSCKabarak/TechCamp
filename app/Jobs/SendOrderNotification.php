<?php

namespace App\Jobs;

use App\Mailers\OrderMailer;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class SendOrderNotification extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    public $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(OrderMailer $orderMailer)
    {
        try {
            $orderMailer->sendOrderNotification($this->order);
        } catch(\Exception $e) {
            Log::error("Cannot send actual ticket to : " . $this->order->email . " as ticket file does not exist on disk");
            Log::error("Error message. " . $e->getMessage());
            Log::error("Error stack trace" . $e->getTraceAsString());
            $this->fail($e);
        }


    }
}
