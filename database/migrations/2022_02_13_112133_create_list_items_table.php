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
        Schema::create('list_items', function (Blueprint $table) {
            $table->bigIncrements("id");

            $table->unsignedBigInteger('list_id');
            $table->string('text', 200);
            $table->integer('qty')->unsigned()->default(1);
            $table->boolean('done')->default(false);

            $table->foreign('list_id')
            ->references('id')->on('shared_lists')
            ->onDelete('cascade');

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
        Schema::dropIfExists('list_items');
    }
};
