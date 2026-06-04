<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('steadfast_consignment_id')->nullable()->after('status');
            $table->string('steadfast_tracking_code')->nullable()->after('steadfast_consignment_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['steadfast_consignment_id', 'steadfast_tracking_code']);
        });
    }
};