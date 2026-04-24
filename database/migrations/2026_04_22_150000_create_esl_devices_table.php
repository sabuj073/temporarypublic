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
        Schema::create('esl_devices', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned()->index();
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->string('vendor', 60)->default('generic')->index();
            $table->string('device_name', 120);
            $table->string('device_identifier', 120)->nullable()->index();
            $table->string('location_ref', 120)->nullable();
            $table->tinyInteger('is_active')->default(1)->index();
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
        Schema::dropIfExists('esl_devices');
    }
};
