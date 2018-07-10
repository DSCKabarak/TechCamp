<?php

namespace App\Services;

class Order
{

    public function calculateFinalCosts($orderTotal, $totalBookingFee, $event)
    {
        $orderTotalWithBookingFee = $orderTotal + $totalBookingFee;
        $taxAmount = ($event->organiser->charge_tax == 1) ? ($orderTotalWithBookingFee * $event->organiser->tax_value)/100
                                                         : 0;

        $grandTotal = $orderTotalWithBookingFee + $taxAmount;

        return ['orderTotalWithBookingFee' => money($orderTotalWithBookingFee, $event->currency),
                'taxAmount' => money($taxAmount, $event->currency),
                'grandTotal' => money($grandTotal, $event->currency )];
    }

}
