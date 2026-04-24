<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_card_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned()->index();
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->unsignedBigInteger('gift_card_id')->index();
            $table->foreign('gift_card_id')->references('id')->on('gift_cards')->onDelete('cascade');
            $table->integer('transaction_id')->unsigned()->nullable()->index();
            $table->foreign('transaction_id')->references('id')->on('transactions')->nullOnDelete();
            $table->integer('transaction_payment_id')->unsigned()->nullable()->index();
            $table->foreign('transaction_payment_id')->references('id')->on('transaction_payments')->nullOnDelete();
            $table->enum('type', ['issue', 'bonus', 'redeem', 'reversal', 'adjustment'])->index();
            $table->decimal('amount', 22, 4)->default(0);
            $table->decimal('balance_before', 22, 4)->default(0);
            $table->decimal('balance_after', 22, 4)->default(0);
            $table->text('note')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
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
        Schema::dropIfExists('gift_card_transactions');
    }
};
