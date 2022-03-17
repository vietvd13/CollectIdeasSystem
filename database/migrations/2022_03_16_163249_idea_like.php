<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IdeaLike extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idea_likes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idea_id')->unsigned();
            $table->bigInteger('owner')->unsigned();
            $table->boolean('status');// like true and dislike false
            $table->timestamps();

            $table->foreign('idea_id')->references('id')->on('ideas')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
