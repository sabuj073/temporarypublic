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
        Schema::create('esl_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned()->index();
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->integer('product_id')->unsigned()->nullable()->index();
            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();
            $table->unsignedBigInteger('esl_device_id')->nullable()->index();
            $table->foreign('esl_device_id')->references('id')->on('esl_devices')->nullOnDelete();
            $table->string('status', 20)->default('pending')->index();
            $table->text('payload')->nullable();
            $table->text('response_body')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('synced_at')->nullable()->index();
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
        Schema::dropIfExists('esl_sync_logs');
    }
};
