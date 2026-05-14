<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('company')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('Bangladesh');
            $table->string('category')->nullable();        // কোন ধরনের product supply করে
            $table->decimal('balance', 12, 2)->default(0); // due/advance balance
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // inventories table এ supplier_id foreign key add
        Schema::table('inventories', function (Blueprint $table) {
            $table->foreignId('supplier_id')->nullable()->after('supplier')
                  ->constrained('suppliers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropForeignIfExists(['supplier_id']);
            $table->dropColumnIfExists('supplier_id');
        });
        Schema::dropIfExists('suppliers');
    }
};