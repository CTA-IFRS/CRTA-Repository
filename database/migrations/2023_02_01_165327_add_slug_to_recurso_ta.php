<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\RecursoTA;

class AddSlugToRecursoTa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recursos_ta', function (Blueprint $table) {
            $table->string('slug');
        });

        foreach (RecursoTa::all() as $recurso) {
            $slug = Str::slug($recurso->titulo, '-');
            if (RecursoTa::where('slug', $slug)->exists()) {
                $recurso->slug = $slug . '-' . $recurso->id; 
            } else {
                $recurso->slug = $slug;
            }
            $recurso->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recursos_ta', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
