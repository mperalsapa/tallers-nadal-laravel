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
        Schema::create("workshop", function (Blueprint $table) {
            $table->increments("id");
            $table->string("name", 200);
            $table->unsignedInteger("user_id");
            $table->string("assistants")->nullable();
            $table->string("manager")->nullable();
            $table->string("description", 1000);
            $table->string("addressed_to")->nullable();
            $table->integer("max_students");
            $table->string("material", 128);
            $table->string("observations", 1024)->nullable();
            $table->string("place")->nullable();
            $table->year("created");
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("user")->onDelete("cascade");
        });

        // Schema::table('user', function (Blueprint $table) {
        //     $table->foreign("assignedWorkshop")->references("id")->on("workshop")->onDelete("cascade");
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("workshop");
    }
};
