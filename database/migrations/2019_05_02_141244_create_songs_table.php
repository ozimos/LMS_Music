<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSongsTable.
 */
class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'songs',
            function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('title');
                $table->text('description')->nullable();
                $table->date('release_date')->nullable();
                $table->string('file')->nullable();

                $table->unsignedBigInteger('album_id')->nullable();
                $table->unsignedBigInteger('genre_id')->nullable();
                $table->timestamps();

                $table->foreign('album_id')
                ->references('id')
                ->on('albums')
                ->onDelete('cascade');
                $table->foreign('genre_id')
                ->references('id')
                ->on('genres');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('songs');
    }
}
