<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('product_id');
            $table->string('product_type')->default('product'); // 'product' or 'hotdeal'
            $table->tinyInteger('rating');                      // 1 to 5
            $table->text('body')->nullable();                   // optional comment
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            // same user same product এ একটার বেশি review দিতে পারবে না
            $table->unique(['user_id', 'product_id', 'product_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};