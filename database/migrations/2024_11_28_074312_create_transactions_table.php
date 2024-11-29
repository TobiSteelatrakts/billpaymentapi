<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('id')->primary()->unique();
            $table->float(column: 'amount');    // amount for the transaction
            $table->string('network_id')->nullable(); // network id for the transaction eg mtn , glo 9mobile , its null when funding wallet
            $table->string('phone_number')->nullable(); // phone number being funded, it is null when funding wallet and has not null when purchasing airtime
            $table->string(column: 'transaction_type')->default("airtime_purchase");    // type of transaction eg airtime_purchase, fund_wallet
            $table->string(column: 'payment_type')->default("wallet");  // eg wallet or card payment
            $table->string('user_id')->index();   // user id 
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
