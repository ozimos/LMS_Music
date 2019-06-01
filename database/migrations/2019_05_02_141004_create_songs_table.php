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
                $table->string('file');
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
