<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('id');
            $table->string('product_type')->nullable()->after('product_id'); // 'product' or 'hotdeal'
            $table->index(['product_id', 'product_type']);
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropIndex(['product_id', 'product_type']);
            $table->dropColumn(['product_id', 'product_type']);
        });
    }
};