<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // esse metodo cria usuário, para cada usuário deve-se repetir as linhas abaixo com novos dados
        //       \DB::table('users')->insert(
        //           [
        //              'name' => 'admintrator',
        //               'email' => 'admin@admin.com',
        //               'email_verified_at' => now(),
//                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
//                'remember_token' => 'kokokokkoko',
        //           ]
        //      );
        factory(\App\User::class, 10)->create()->each(function ($user) { //cria usuários aleatorios (não será usado no repositorio)
            $user->store()->save(factory(\App\Store::class)->make()); //não será usado no repositorio
        });
    }
}
