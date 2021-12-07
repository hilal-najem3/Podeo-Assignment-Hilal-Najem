<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePodcastAudiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcast_audios', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('podcast_id');
            $table->string('link');
            $table->timestamps();

            $table->foreign('podcast_id')->references('id')->on('podcasts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('podcast_audios', function (Blueprint $table) {
            $table->dropForeign(['podcast_id']);
        });
        Schema::dropIfExists('podcast_audios');
    }
}
