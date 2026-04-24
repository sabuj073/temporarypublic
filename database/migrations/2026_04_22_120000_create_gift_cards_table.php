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
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('business_id')->unsigned()->index();
            $table->foreign('business_id')->references('id')->on('business')->onDelete('cascade');
            $table->integer('contact_id')->unsigned()->nullable()->index();
            $table->foreign('contact_id')->references('id')->on('contacts')->nullOnDelete();
            $table->string('card_number', 64)->index();
            $table->decimal('issue_amount', 22, 4)->default(0);
            $table->decimal('bonus_amount', 22, 4)->default(0);
            $table->decimal('initial_balance', 22, 4)->default(0);
            $table->decimal('current_balance', 22, 4)->default(0);
            $table->enum('status', ['active', 'inactive', 'expired'])->default('active')->index();
            $table->timestamp('expires_at')->nullable()->index();
            $table->text('note')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['business_id', 'card_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gift_cards');
    }
};
