<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('users')->insert([ 'name' => 'Admin',
									   'email' => 'retace@ifrs.edu.br',
									   'password' => Hash::make("adminadmin"),
                                       'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                       'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
