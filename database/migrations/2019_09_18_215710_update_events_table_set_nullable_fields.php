<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEventsTableSetNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', static function (Blueprint $table) {
            $table->string('location_address_line_1', 355)->nullable()->change();
            $table->string('location_address_line_2', 355)->nullable()->change();
            $table->string('location_state', 355)->nullable()->change();
            $table->string('location_post_code', 355)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', static function (Blueprint $table) {
            $table->string('location_address_line_1', 355)->nullable(false)->default('')->change();
            $table->string('location_address_line_2', 355)->nullable(false)->default('')->change();
            $table->string('location_state', 355)->nullable(false)->default('')->change();
            $table->string('location_post_code', 355)->nullable(false)->default('')->change();
        });
    }
}
