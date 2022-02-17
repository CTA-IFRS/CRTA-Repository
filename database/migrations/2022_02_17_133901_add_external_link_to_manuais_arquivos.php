<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExternalLinkToManuaisArquivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manuals', function (Blueprint $table) {
            $table->boolean('link_externo')->default(false);
        });

        Schema::table('arquivos', function (Blueprint $table) {
            $table->boolean('link_externo')->default(false);
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
            $table->dropColumn('link_externo');
        });

        Schema::table('arquivos', function (Blueprint $table) {
            $table->dropColumn('link_externo');
        });
    }
}
