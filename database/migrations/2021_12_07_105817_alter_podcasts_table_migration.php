<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\PodcastAudio;
use App\Podcast;

class AlterPodcastsTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->movePodcastLinks();
        Schema::table('podcasts', function (Blueprint $table) {
             $table->dropColumn('link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('podcasts', function (Blueprint $table) {
            $table->string('link')->after('description');
        });
        $this->returnPodcastLinks();
    }

    /**
     * Moves links from podcasts table to podcasts_audios table
     *
     * @return void
     */
    public function movePodcastLinks()
    {
        $podcasts= Podcast::all();

        foreach ($podcasts as $podcast) {
            PodcastAudio::create([
                'podcast_id' => $podcast->id,
                'link' => $podcast->link
            ]);
        }
    }

    /**
     * Moves first link from podcasts_audios table to podcasts table
     *
     * @return void
     */
    public function returnPodcastLinks()
    {
        $podcasts= Podcast::all();

        foreach ($podcasts as $podcast) {
            $audio = $podcast->audios()->get()->first();
            $podcast->link = $audio->link;
            $podcast->save();
        }
    }
}
