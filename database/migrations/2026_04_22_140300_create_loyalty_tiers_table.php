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
        Schema::create('loyalty_tiers', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned()->index();
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->string('name');
            $table->integer('level')->default(1)->index();
            $table->decimal('min_total_points', 22, 4)->default(0);
            $table->decimal('min_lifetime_sales', 22, 4)->default(0);
            $table->decimal('bonus_multiplier', 12, 4)->default(1);
            $table->decimal('extra_discount_percent', 12, 4)->default(0);
            $table->tinyInteger('is_active')->default(1)->index();
            $table->text('benefits')->nullable();
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
        Schema::dropIfExists('loyalty_tiers');
    }
};
