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
        Schema::table('contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('loyalty_tier_id')->nullable()->after('customer_group_id')->index();
            $table->foreign('loyalty_tier_id')->references('id')->on('loyalty_tiers')->nullOnDelete();
            $table->decimal('lifetime_sale_total', 22, 4)->default(0)->after('total_rp_used');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['loyalty_tier_id']);
            $table->dropColumn(['loyalty_tier_id', 'lifetime_sale_total']);
        });
    }
};
