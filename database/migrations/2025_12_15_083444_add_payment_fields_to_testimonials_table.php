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
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('payment_method')->default('bkash')->after('status');
            $table->string('bkash_transaction_id')->nullable()->after('payment_method');
            $table->string('bkash_phone_number')->nullable()->after('bkash_transaction_id');
            $table->decimal('payment_amount', 8, 2)->default(100.00)->after('bkash_phone_number');
            $table->enum('payment_status', ['unpaid', 'pending', 'paid'])->default('unpaid')->after('payment_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'bkash_transaction_id', 'bkash_phone_number', 'payment_amount', 'payment_status']);
        });
    }
};
