<?php namespace App\Cancellation;

use App\Models\Attendee;
use Superbalist\Money\Money;

class OrderCancellation
{
    /** @var \App\Models\Order $order */
    private $order;
    private $attendees;
    private $orderRefund;

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
            $orderRefund = OrderRefund::make($this->order, $this->attendees);
            $orderRefund->refund();
            $this->orderRefund = $orderRefund;
        }

        // TODO if no refunds can be done, mark the order as cancelled to indicate attendees are cancelled

        // Cancel the attendees
        $this->attendees->map(function(Attendee $attendee) {
            $attendee->is_cancelled = true;
            $attendee->save();
        });
    }

    public function getRefundAmount()
    {
        if (is_null($this->orderRefund)) {
            return new Money('0');
        }

        return $this->orderRefund->getRefundAmount();
    }
}