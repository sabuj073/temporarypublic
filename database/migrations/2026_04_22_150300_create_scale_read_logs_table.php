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
        Schema::create('scale_read_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned()->index();
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->unsignedBigInteger('scale_device_id')->nullable()->index();
            $table->foreign('scale_device_id')->references('id')->on('scale_devices')->nullOnDelete();
            $table->decimal('weight', 22, 6)->nullable();
            $table->string('unit', 20)->nullable();
            $table->string('barcode', 64)->nullable()->index();
            $table->string('status', 20)->default('success')->index();
            $table->text('response_body')->nullable();
            $table->text('error_message')->nullable();
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
        Schema::dropIfExists('scale_read_logs');
    }
};
