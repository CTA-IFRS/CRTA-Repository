<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUploadsTableAndUploadTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
        });

        DB::table('upload_tipos')->insert([
            ['nome' => 'Manual'],
            ['nome' => 'Arquivo']
        ]);

        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('arquivo')->nullable();
            $table->string('url_alternativa')->nullable();
            $table->unsignedBigInteger('upload_tipo_id');
            $table->unsignedBigInteger('recurso_ta_id');
            $table->timestamps();

            $table->foreign('upload_tipo_id')->references('id')->on('upload_tipos');
            $table->foreign('recurso_ta_id')->references('id')->on('recursos_ta')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uploads');
        Schema::dropIfExists('upload_tipos');
    }
}
