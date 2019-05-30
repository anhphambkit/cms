<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('customer_id')->nullable();
            $table->text('description')->nullable();
            $table->string('transaction_id')->nullable();
            $table->decimal('amount', 20, 2)->nullable();
            $table->string('status', 50)->nullable();
            $table->string('payment_type')->nullable();
            $table->string('last_4')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('currency')->default('USD');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_transactions');
    }
}
