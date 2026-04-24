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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('promotion_code', 80)->nullable()->after('discount_amount')->index();
            $table->decimal('promotion_discount_amount', 22, 4)->default(0)->after('promotion_code');
            $table->text('promotion_meta')->nullable()->after('promotion_discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['promotion_code', 'promotion_discount_amount', 'promotion_meta']);
        });
    }
};
