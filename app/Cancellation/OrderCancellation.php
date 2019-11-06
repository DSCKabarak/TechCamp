<?php namespace App\Cancellation;

class OrderCancellation
{
    private $order;
    private $attendees;

    public function __construct($order, $attendees)
    {
        $this->order = $order;
        $this->attendees = $attendees;
    }

    public static function make($order, $attendees)
    {
        return new static($order, $attendees);
    }

    public function cancel()
    {
        // If order can do a refund then refund first
        if ($this->order->canRefund()) {
            OrderRefund::make($this->order, $this->attendees)->refund();
        }

        // Cancel the attendees
        $this->attendees->map(function(Attendee $attendee) {
            $attendee->is_cancelled = true;
            $attendee->save();
        });
    }

    // Refund is automatic but only if the order can be refunded
    // Takes collection of attendees
    // cancel()
        // if can refund
            // OrderRefund::make($order, $attendees)->refund()

    // Updates to stats
        // Ticket
        // Attendee
        // Order
        // EventStats

}