<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixTicketOrderTableForeignKeyConstraints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('APP_ENV') !== 'testing') {
            Schema::table('ticket_order', function (Blueprint $table) {
                $table->dropForeign('ticket_order_ticket_id_foreign');
                $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Do nothing.
    }
}
