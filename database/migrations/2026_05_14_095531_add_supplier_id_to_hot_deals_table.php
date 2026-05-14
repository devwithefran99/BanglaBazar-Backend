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
    Schema::table('hot_deals', function (Blueprint $table) {
        $table->foreignId('supplier_id')
              ->nullable()
              ->after('category')
              ->constrained('suppliers')
              ->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('hot_deals', function (Blueprint $table) {
        $table->dropForeignIfExists(['supplier_id']);
        $table->dropColumn('supplier_id');
    });
}
};
