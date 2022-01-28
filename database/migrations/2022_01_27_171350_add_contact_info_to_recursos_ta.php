<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactInfoToRecursosTa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recursos_ta', function (Blueprint $table) {
            $table->string("contato_nome")->nullable();
            $table->string("contato_email")->nullable();
            $table->string("contato_telefone")->nullable();
            $table->string("contato_instituicao")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recursos_ta', function (Blueprint $table) {
            $table->dropColumn("contato_nome");
            $table->dropColumn("contato_email");
            $table->dropColumn("contato_telefone");
            $table->dropColumn("contato_instituicao");
        });
    }
}
