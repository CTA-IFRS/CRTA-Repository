<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('tags')->insert(['nome' => 'Recurso de TA']);

		DB::table('tags')->insert(['nome' => 'Metodologia']);

		DB::table('tags')->insert(['nome' => 'Estratégia']);

		DB::table('tags')->insert(['nome' => 'Material Pedagógico Acessível']);
    }
}
