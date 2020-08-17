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
		DB::table('tags')->insert([
            'nome' => 'Recurso de TA',
            'descricao' => 'Proporciona ou amplia habilidades funcionais']);

		DB::table('tags')->insert([
            'nome' => 'Metodologia',
            'descricao' => 'Instrumento para a construção do conhecimento']);

		DB::table('tags')->insert([
            'nome' => 'Estratégia',
            'descricao' => 'Técnica que visa auxiliar na construção do conhecimento']);

		DB::table('tags')->insert([
            'nome' => 'Material Pedagógico Acessível',
            'descricao' => 'Recurso para auxiliar o processo de ensino-aprendizagem']);
    }
}
