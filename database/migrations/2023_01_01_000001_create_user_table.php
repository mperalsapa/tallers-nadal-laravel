<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('email')->unique();
            $table->enum("stage", ["ESO", "BAT", "FPB", "ASIX", "DAW", "SMX"])->nullable();
            $table->smallInteger("course")->nullable();
            $table->char("group")->nullable();
            $table->enum("role", ["Alumne", "Profesor"])->default("Alumne");
            $table->enum("authority", ["Usuari", "Administrador", "Super Administrador"])->default("Usuari");
            $table->smallInteger("firstChoice")->nullable();
            $table->smallInteger("secondChoice")->nullable();
            $table->smallInteger("thirdChoice")->nullable();
            $table->smallInteger("tallerAssigned")->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("user");
    }
};
