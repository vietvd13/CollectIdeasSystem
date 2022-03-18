<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IdeaAttatchFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idea_attatch_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idea_id')->unsigned();
            $table->string('file_extension');
            $table->string('path');
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
