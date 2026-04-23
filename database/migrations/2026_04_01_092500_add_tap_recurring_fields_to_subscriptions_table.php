<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->string('tap_customer_id')->nullable();
            $table->string('tap_card_id')->nullable();
            $table->string('tap_payment_agreement_id')->nullable();
            $table->string('tap_last_charge_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn([
                'tap_customer_id',
                'tap_card_id',
                'tap_payment_agreement_id',
                'tap_last_charge_id',
            ]);
        });
    }
};
