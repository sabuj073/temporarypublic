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
        Schema::create('promotion_usages', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned()->index();
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->unsignedBigInteger('promotion_id')->index();
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
            $table->integer('transaction_id')->unsigned()->nullable()->index();
            $table->foreign('transaction_id')->references('id')->on('transactions')->nullOnDelete();
            $table->integer('contact_id')->unsigned()->nullable()->index();
            $table->foreign('contact_id')->references('id')->on('contacts')->nullOnDelete();
            $table->string('coupon_code', 80)->nullable()->index();
            $table->decimal('discount_amount', 22, 4)->default(0);
            $table->text('meta')->nullable();
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
        Schema::dropIfExists('promotion_usages');
    }
};
