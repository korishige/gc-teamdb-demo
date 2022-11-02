<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniformColumnTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->string('fp_pri_shirt');
            $table->string('fp_pri_shorts');
            $table->string('fp_pri_socks');
            $table->string('fp_sub_shirt');
            $table->string('fp_sub_shorts');
            $table->string('fp_sub_socks');
            $table->string('gk_pri_shirt');
            $table->string('gk_pri_shorts');
            $table->string('gk_pri_socks');
            $table->string('gk_sub_shirt');
            $table->string('gk_sub_shorts');
            $table->string('gk_sub_socks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('fp_pri_shirt');
            $table->dropColumn('fp_pri_shorts');
            $table->dropColumn('fp_pri_socks');
            $table->dropColumn('fp_sub_shirt');
            $table->dropColumn('fp_sub_shorts');
            $table->dropColumn('fp_sub_socks');
            $table->dropColumn('gk_pri_shirt');
            $table->dropColumn('gk_pri_shorts');
            $table->dropColumn('gk_pri_socks');
            $table->dropColumn('gk_sub_shirt');
            $table->dropColumn('gk_sub_shorts');
            $table->dropColumn('gk_sub_socks');
        });
    }
}
