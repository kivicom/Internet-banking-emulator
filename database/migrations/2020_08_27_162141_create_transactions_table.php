<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id_from');
            $table->unsignedBigInteger('user_id_to');
            $table->unsignedBigInteger('account_from');
            $table->string('currency_from');
            $table->unsignedBigInteger('account_to');
            $table->string('currency_to');
            $table->string('operation_code');
            $table->string('type_of_operation');

            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
