<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdditionalTaxFieldRenameCurrentTaxFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organisers', function (Blueprint $table) {
            $table->boolean('charge_tax')->default(0);
            $table->renameColumn('taxname', 'tax_name');
            $table->renameColumn('taxvalue', 'tax_value');
            $table->renameColumn('taxid', 'tax_id');
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
            $table->dropColumn('charge_tax');
            $table->renameColumn('tax_name', 'taxname');
            $table->renameColumn('tax_value', 'taxvalue');
            $table->renameColumn('tax_id', 'taxid');
        });
    }
}
