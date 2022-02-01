<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeManuaisAndArquivosMakeInfoNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manuals', function (Blueprint $table) {
           $table->string('nome')->nullable()->change();
           $table->string('formato')->nullable()->change();
           $table->float('tamanho')->nullable()->change();
        });

        Schema::table('arquivos', function (Blueprint $table) {
           $table->string('nome')->nullable()->change();
           $table->string('formato')->nullable()->change();
           $table->float('tamanho')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('manuals', function (Blueprint $table) {
            $table->string('nome')->nullable(false)->change();
            $table->string('formato')->nullable(false)->change();
            $table->float('tamanho')->nullable(false)->change();
         });
 
         Schema::table('arquivos', function (Blueprint $table) {
            $table->string('nome')->nullable(false)->change();
            $table->string('formato')->nullable(false)->change();
            $table->float('tamanho')->nullable(false)->change();
         });
    }
}
