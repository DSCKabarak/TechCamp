<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBusinessFieldsToOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('is_business')->default(false)->after('is_payment_received');
            $table->string('business_name')->after('email')->nullable();
            $table->string('business_tax_number')->after('business_name')->nullable();
            $table->text('business_address')->after('business_tax_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['is_business', 'business_name', 'business_tax_number', 'business_address']);
        });
    }
}
