<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriaRecursosTA extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recursos_ta', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable(false);
            $table->string('descricao')->nullable(false);
            $table->boolean('produtoComercial');
            $table->string('siteFabricante')->nullable(false);
            $table->string('licenca');
            $table->boolean('publicacaoAutorizada')->default(false);
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recursos_ta');
    }
}
