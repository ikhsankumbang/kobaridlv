<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('login', function (Blueprint $table) {
            $table->string('id_login', 20)->primary();
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('nama', 100)->nullable();
            $table->timestamps();
        });
        
        // Insert default admin user
        DB::table('login')->insert([
            'id_login' => 'USR001',
            'username' => 'admin',
            'password' => 'admin123',
            'nama' => 'Administrator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login');
    }
};
