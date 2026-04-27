<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique()->nullable();
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2);
        $table->decimal('old_price', 10, 2)->nullable(); // sale price এর জন্য
        $table->integer('stock')->default(0);
        $table->integer('low_stock_threshold')->default(5);
        $table->string('image')->nullable();
        $table->string('category')->nullable();
        $table->boolean('is_featured')->default(false); // popular section এ দেখাবে
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}
};
