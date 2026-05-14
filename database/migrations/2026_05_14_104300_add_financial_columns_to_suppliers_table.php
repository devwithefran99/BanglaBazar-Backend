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
    Schema::table('suppliers', function (Blueprint $table) {
        $table->decimal('total_purchase', 12, 2)->default(0)->after('notes');
        $table->decimal('total_paid', 12, 2)->default(0)->after('total_purchase');
    });
}

public function down(): void
{
    Schema::table('suppliers', function (Blueprint $table) {
        $table->dropColumn(['total_purchase', 'total_paid']);
    });
}
};
