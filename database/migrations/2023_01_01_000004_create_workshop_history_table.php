<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshop_history', function (Blueprint $table) {
            $table->increments("id");
            $table->string("name");
            $table->string("creator");
            $table->string("description");
            $table->string("addressed_to")->nullable();
            $table->integer('max_students');
            $table->string('material');
            $table->string('observations')->nullable();
            $table->year('created');
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
        Schema::dropIfExists('workshop_history');
    }
};
