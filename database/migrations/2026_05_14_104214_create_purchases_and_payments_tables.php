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
    // purchases table
    Schema::create('purchases', function (Blueprint $table) {
        $table->id();
        $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
        $table->string('product_name');
        $table->integer('quantity');
        $table->decimal('buying_price', 10, 2);
        $table->date('purchase_date');
        $table->text('notes')->nullable();
        $table->timestamps();
    });

    // supplier_payments table
    Schema::create('supplier_payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
        $table->decimal('paid_amount', 12, 2);
        $table->date('payment_date');
        $table->string('method')->default('cash');
        $table->text('note')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('supplier_payments');
    Schema::dropIfExists('purchases');
}
};
