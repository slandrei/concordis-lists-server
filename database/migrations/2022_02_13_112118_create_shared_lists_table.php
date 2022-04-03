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
        Schema::create('shared_lists', function (Blueprint $table) {
            $table->bigIncrements("id");

            $table->string('title', 50);
            $table->integer('owner')->default(1); // Id from user table
            $table->string('allowedUsers', 100)->default(""); // WARNING: Size needs to be increased if are too many allowed users //TODO


            // To be Added - when users are ready to use
            // $table->foreign('owner')
            // ->references('id')->on('users')
            // ->onDelete('cascade');

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
        Schema::dropIfExists('shared_lists');
    }
};
