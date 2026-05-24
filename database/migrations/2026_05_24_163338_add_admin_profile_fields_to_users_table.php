<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Admin profile columns — nullable so existing records are unaffected
            $table->string('username')->unique()->nullable()->after('name');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('role');
            $table->timestamp('last_login_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'status', 'last_login_at']);
        });
    }
};