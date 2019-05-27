<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateAlbumsTable.
 */
class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'albums',
            function (Blueprint $table) {
                $table->bigIncrements('id');

                $table->string('title');
                $table->text('description')->nullable();
                $table->date('release_date')->nullable();
                $table->string('image')->nullable();

                $table->unsignedBigInteger('genre_id')->nullable();
                $table->unsignedBigInteger('user_id');
                $table->timestamps();

                $table->foreign('genre_id')
                    ->references('id')
                    ->on('genres');
                $table->foreign('user_id')
                    ->references('id')
                    ->on('users');
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
        Schema::dropIfExists('albums');
    }
}
