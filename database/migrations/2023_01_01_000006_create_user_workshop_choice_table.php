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
        Schema::create('user_workshop_choice', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("first_choice")->nullable();
            $table->unsignedInteger("second_choice")->nullable();
            $table->unsignedInteger("third_choice")->nullable();
            $table->unsignedInteger("assigned_workshop")->nullable();
            $table->foreign("user_id")->references("id")->on("user")->onDelete("cascade");
            $table->foreign("first_choice")->references("id")->on("workshop")->onDelete("set null");
            $table->foreign("second_choice")->references("id")->on("workshop")->onDelete("set null");
            $table->foreign("third_choice")->references("id")->on("workshop")->onDelete("set null");
            $table->foreign("assigned_workshop")->references("id")->on("workshop")->onDelete("set null");
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
        Schema::dropIfExists('user_workshop_choice');
    }
};
