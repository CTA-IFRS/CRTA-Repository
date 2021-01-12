<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PaginaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('paginas')->insert([ 'nome' => 'Aprender',
									'titulo_texto' => 'Adicione o Título do Texto',
									'texto' => 'Adicione o texto da página "Aprender"',
                                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);

        DB::table('paginas')->insert([ 'nome' => 'Sobre',
									'titulo_texto' => 'Adicione o Título do Texto',
									'texto' => 'Adicione o texto da página "Sobre" ',
                                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);      
    }
}
