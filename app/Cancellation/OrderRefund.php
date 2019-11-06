<?php namespace App\Cancellation;

use App\Models\Attendee;
use Superbalist\Money\Money;
use Log;

class OrderRefund
{
    private $order;
    private $attendees;
    private $currency;
    private $organiserAmount;
    private $refundedAmount;
    private $maximumRefundableAmount;
    private $organiserTaxRate;
    private $refundAmount;

    public function __construct($order, $attendees)
    {
        $this->order = $order;
        $this->attendees = $attendees;
        // We need to set the refund starting amounts first
        $this->setRefundAmounts();
        // Then we need to check for a valid refund state before we can continue
        $this->checkValidRefundState();
    }

    public static function make($order, $attendees)
    {
        return new static($order, $attendees);
    }

    public function refund()
    {

    }

    private function setRefundAmounts()
    {
        $this->currency = $this->order->getEventCurrency();
        // Get the full order amount, tax and booking fees included
        $this->organiserAmount = new Money($this->order->organiser_amount, $this->currency);
        Log::debug(sprintf("Total Order Value: %s", $this->organiserAmount->display()));

        $this->refundedAmount = new Money($this->order->amount_refunded, $this->currency);
        Log::debug(sprintf("Already refunded amount: %s", $this->refundedAmount->display()));

        $this->maximumRefundableAmount = $this->organiserAmount->subtract($this->refundedAmount);
        Log::debug(sprintf("Maxmimum refundable amount: %s", $this->maximumRefundableAmount->display()));

        // We need the organiser tax value to calculate what the attendee would've paid
        $event = $this->order->event;
        $organiserTaxAmount = new Money($event->organiser->tax_value);
        $this->organiserTaxRate = $organiserTaxAmount->divide(100)->__toString();
        Log::debug(sprintf("Organiser Tax Rate: %s", $organiserTaxAmount->format() . '%'));

        // Sets refund total based on attendees, their ticket prices and the organiser tax rate
        $this->setRefundTotal();
    }

    /**
     * Calculates the refund amount from the selected attendees from the ticket price perspective.
     *
     * It will add the tax value from the organiser if it's set and build the refund amount to equal
     * the amount of tickets purchased by the selected attendees. Ex:
     * Refunding 2 attendees @ 100EUR with 15% VAT = 230EUR
     */
    private function setRefundTotal()
    {
        $organiserTaxRate = $this->organiserTaxRate;
        $currency = $this->currency;

        $this->refundAmount = new Money($this->attendees->map(function(Attendee $attendee) use ($organiserTaxRate, $currency) {
            $ticketPrice = new Money($attendee->ticket->price, $currency);
            Log::debug(sprintf("Ticket Price: %s", $ticketPrice->display()));
            Log::debug(sprintf("Ticket Tax: %s", $ticketPrice->multiply($organiserTaxRate)->display()));
            return $ticketPrice->add($ticketPrice->multiply($organiserTaxRate));
        })->reduce(function($carry, $singleTicketWithTax) use ($currency) {
            $refundTotal = (new Money($carry, $currency));
            return $refundTotal->add($singleTicketWithTax)->format();
        }), $currency);

        Log::debug(sprintf("Requested Refund should include Tax: %s", $this->refundAmount->display()));
    }

    private function checkValidRefundState()
    {
        $errorMessage = false;
        if (!$this->order->transaction_id) {
            $errorMessage = trans("Controllers.order_cant_be_refunded");
        }
        if ($this->order->is_refunded) {
            $errorMessage = trans('Controllers.order_already_refunded');
        } elseif ($this->maximumRefundableAmount->isZero()) {
            $errorMessage = trans('Controllers.nothing_to_refund');
        } elseif ($this->refundAmount->isGreaterThan($this->maximumRefundableAmount)) {
            // Error if the partial refund tries to refund more than allowed
            $errorMessage = trans('Controllers.maximum_refund_amount', [
                'money' => $this->maximumRefundableAmount->display(),
            ]);
        }

        if ($errorMessage) {
            throw new OrderRefundException($errorMessage);
        }
    }


    // Takes an order and attendees collection
    // Calculate the refund amounts including tax
    // refund()
}