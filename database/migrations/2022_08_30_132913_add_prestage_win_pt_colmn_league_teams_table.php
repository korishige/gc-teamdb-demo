<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrestageWinPtColmnLeagueTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('league_teams', function (Blueprint $table) {
            $table->integer('prestage_win_pt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('league_teams', function (Blueprint $table) {
            $table->dropColumn('prestage_win_pt');
        });
    }
}
