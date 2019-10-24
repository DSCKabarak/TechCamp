<?php

namespace App\Models;

/**
 * Class PaymentGateway
 * @package App\Models
 */
class PaymentGateway extends MyBaseModel
{

    public $timestamps = false;

    /**
     * @return array
     */
    static public function getAllWithDefaultSet()
    {
        $payment_gateways = PaymentGateway::all()->toArray();
        $payment_gateway = PaymentGateway::select('id')->where('default', 1)->get()->first();
        if (empty($payment_gateway)) {
            $default_payment_gateway_id = config('attendize.default_payment_gateway');
            foreach ($payment_gateways as &$payment_gateway) {
                if ($payment_gateway['id'] == $default_payment_gateway_id) {
                    $payment_gateway['default'] = 1;
                }
            }
        }

        return $payment_gateways;
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    static public function getDefaultPaymentGatewayId()
    {
        $payment_gateway = PaymentGateway::select('id')->where('default', 1)->get()->first();
        if (empty($payment_gateway)) {
            $default_payment_gateway_id = config('attendize.default_payment_gateway');
            return $default_payment_gateway_id;
        }

        return $payment_gateway['id'];
    }
}
