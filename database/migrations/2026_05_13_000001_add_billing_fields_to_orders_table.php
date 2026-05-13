<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('billing_first_name')->nullable()->after('user_id');
            $table->string('billing_last_name')->nullable()->after('billing_first_name');
            $table->string('billing_email')->nullable()->after('billing_last_name');
            $table->string('billing_phone')->nullable()->after('billing_email');
            $table->string('billing_country')->nullable()->after('billing_phone');
            $table->string('billing_state')->nullable()->after('billing_country');
            $table->string('billing_zip', 20)->nullable()->after('billing_state');
            $table->string('billing_address')->nullable()->after('billing_zip');
            $table->string('payment_method')->nullable()->after('status');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('total_price');
            $table->string('coupon_code')->nullable()->after('discount_amount');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'billing_first_name',
                'billing_last_name',
                'billing_email',
                'billing_phone',
                'billing_country',
                'billing_state',
                'billing_zip',
                'billing_address',
                'payment_method',
                'discount_amount',
                'coupon_code',
            ]);
        });
    }
};