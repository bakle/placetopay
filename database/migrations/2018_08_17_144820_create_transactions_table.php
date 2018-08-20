<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('transaction_id');
            $table->string('session_id', 32)->nullable();            
            $table->string('reference', 32)->nullable();
            $table->decimal('amount', 10, 0)->nullable();
            $table->timestamp('request_date')->nullable();
            $table->timestamp('bank_process_date')->nullable();
            $table->boolean('on_test')->default(0);
            $table->string('return_code', 30)->nullable();
            $table->string('trazability_code', 40)->nullable();
            $table->integer('transaction_cycle')->nullable();
            $table->string('transaction_state', 20)->nullable();
            $table->string('bank_currency', 3)->nullable();
            $table->decimal('bank_factor', 5, 1)->nullable();
            $table->string('bank_url')->nullable();            
            $table->integer('response_code')->nullable();
            $table->string('response_reason_code', 3)->nullable();
            $table->string('response_reason_text')->nullable();
            $table->unsignedInteger('user_id')->nullable();            
            $table->timestamps();

            $table->primary('transaction_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
