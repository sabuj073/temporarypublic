<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement("ALTER TABLE transaction_payments MODIFY COLUMN method ENUM('cash', 'card', 'cheque', 'bank_transfer', 'advance', 'custom_pay_1', 'custom_pay_2', 'custom_pay_3', 'custom_pay_4', 'custom_pay_5', 'custom_pay_6', 'custom_pay_7', 'gift_card', 'other')");

        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('gift_card_id')->nullable()->after('transaction_id')->index();
            $table->foreign('gift_card_id')->references('id')->on('gift_cards')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->dropForeign(['gift_card_id']);
            $table->dropColumn('gift_card_id');
        });

        DB::statement("ALTER TABLE transaction_payments MODIFY COLUMN method ENUM('cash', 'card', 'cheque', 'bank_transfer', 'custom_pay_1', 'custom_pay_2', 'custom_pay_3', 'other')");
    }
};
