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
    Schema::table('carts', function (Blueprint $table) {
        // পুরনো FK drop করো
        $table->dropForeign(['product_id']);
        // FK ছাড়া রাখো — product_type দিয়ে handle হবে
        $table->unsignedBigInteger('product_id')->change();
    });
}

public function down(): void
{
    Schema::table('carts', function (Blueprint $table) {
        $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
    });
}
};
