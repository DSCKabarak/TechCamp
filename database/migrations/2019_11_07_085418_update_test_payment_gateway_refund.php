<?php

use Illuminate\Database\Migrations\Migration;

class UpdateTestPaymentGatewayRefund extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('payment_gateways')
            ->where('name', 'Stripe\PaymentIntents')
            ->update(['can_refund' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
