<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('tags')->insert([ 'nome' => 'Recurso de TA',
                                    'publicacao_autorizada' => true,
                                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);

        DB::table('tags')->insert([ 'nome' => 'Metodologia',
                                    'publicacao_autorizada' => true,
                                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);        

        DB::table('tags')->insert([ 'nome' => 'Estratégia',
                                    'publicacao_autorizada' => true,
                                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);

        DB::table('tags')->insert([ 'nome' => 'Material Pedagógico Acessível',
                                    'publicacao_autorizada' => true,
                                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}
