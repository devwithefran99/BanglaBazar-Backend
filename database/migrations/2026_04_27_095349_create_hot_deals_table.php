<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hot_deals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('old_price', 10, 2)->nullable();
            $table->string('image')->nullable();
            $table->string('category')->nullable();
            $table->integer('stock')->default(0);
            $table->integer('low_stock_threshold')->default(5);
            $table->boolean('is_best_sale')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamp('deal_ends_at')->nullable(); // countdown এর জন্য
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hot_deals');
    }
};