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
    Schema::create('email_logs', function (Blueprint $table) {
        $table->id();
        $table->string('to_email');
        $table->string('to_name')->nullable();
        $table->string('subject');
        $table->text('body')->nullable();
        $table->string('type')->default('custom');
        $table->string('status')->default('sent');
        $table->text('error')->nullable();
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
