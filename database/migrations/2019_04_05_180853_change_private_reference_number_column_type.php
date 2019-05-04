<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePrivateReferenceNumberColumnType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		
		/**
        * Change Private Reference Number from INT to VARCHAR ColumnType
        */
        Schema::create('attendees', function (Blueprint $table)
        {
            $table->string('private_reference_number', 15)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendees', function ($t) {
			$t->integer('private_reference_number')->change();
		});
    }
}
