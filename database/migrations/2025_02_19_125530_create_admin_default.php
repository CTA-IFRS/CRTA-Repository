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
        $adminUser = DB::table('users')->where('email', '=', 'admin@admin.com')->first();
        if ($adminUser == null) {
            DB::table('users')->insert([
                    'name' => 'Admin',
                    'email' => 'admin@admin.com',
                    'password' => Hash::make('admin123'),
                ]);
            }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Schema::dropIfExists('admin_default');
    }
};
