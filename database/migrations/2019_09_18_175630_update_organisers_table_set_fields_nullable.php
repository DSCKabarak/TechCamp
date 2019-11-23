<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrganisersTableSetFieldsNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organisers', function (Blueprint $table) {
            $table->text('about')->nullable()->change();
            $table->string('tax_id')->nullable()->change();
            $table->string('tax_name')->nullable()->change();
            $table->string('tax_value')->nullable()->change();
            $table->string('facebook')->nullable()->change();
            $table->string('twitter')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organisers', function (Blueprint $table) {
            $table->text('about')->nullable(false)->default('')->change();
            $table->string('tax_id')->nullable(false)->default('')->change();
            $table->string('tax_name')->nullable(false)->default('')->change();
            $table->string('tax_value')->nullable(false)->default('')->change();
            $table->string('facebook')->nullable(false)->default('')->change();
            $table->string('twitter')->nullable(false)->default('')->change();
        });
    }
}
