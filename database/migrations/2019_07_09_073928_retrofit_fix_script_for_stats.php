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
        // TODO

        // ticket_order
            // Link tickets to orders

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
