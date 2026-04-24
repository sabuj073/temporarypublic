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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned()->index();
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->string('name');
            $table->string('rule_type', 50)->index();
            $table->string('discount_type', 20)->nullable();
            $table->decimal('discount_value', 22, 4)->nullable();
            $table->string('coupon_code', 80)->nullable()->index();
            $table->string('target_scope', 40)->default('all_products');
            $table->unsignedBigInteger('target_id')->nullable()->index();
            $table->decimal('min_order_total', 22, 4)->nullable();
            $table->decimal('min_qty', 22, 4)->nullable();
            $table->decimal('max_discount_amount', 22, 4)->nullable();
            $table->decimal('buy_qty', 22, 4)->nullable();
            $table->decimal('get_qty', 22, 4)->nullable();
            $table->decimal('bundle_qty', 22, 4)->nullable();
            $table->decimal('bundle_price', 22, 4)->nullable();
            $table->decimal('tier_min_qty', 22, 4)->nullable();
            $table->integer('usage_limit_per_coupon')->nullable();
            $table->integer('usage_limit_per_customer')->nullable();
            $table->tinyInteger('is_active')->default(1)->index();
            $table->integer('priority')->default(1)->index();
            $table->timestamp('starts_at')->nullable()->index();
            $table->timestamp('ends_at')->nullable()->index();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('promotions');
    }
};
