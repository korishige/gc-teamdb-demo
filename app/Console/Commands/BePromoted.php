<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use App\Players;


class BePromoted extends Command
{
	protected $signature = 'ffa:promoted';
	protected $description = '進級スクリプト 11→12→13→1→2→3->YYYYOB';

	public function handle(){

		// 'schoolYearAry' => [3=>'高校３年',2=>'高校２年',1=>'高校１年',13=>'中学３年',12=>'中学２年',11=>'中学１年'],
		$start = microtime(true);

		$players = Players::all();
//		$players = Players::where('id','>=',5549)->where('id','<=',5554)->get();
		// 2022-02-18 もしかすると　team_id 150,152,153は除外。
//		$players = Players::whereNotIn('team_id',[150,152,153])->get();

		foreach($players as $player) {
			if((int)$player->school_year > 2000) continue;
			switch($player->school_year){
				case 1:
				case 2:
				case 11:
				case 12:
					$next_year = (int)$player->school_year+1;
					break;
				case 13:	# 中学３年生
					$next_year = 1;
					break;
				case 3:	# 高校３年生
					$next_year = date('Y') - 1;
					break;
				default:
					break;
			}
			printf("%d %d → %d　%s",$player->id, $player->school_year, $next_year, PHP_EOL);

			Players::where('id',$player->id)->update(['school_year'=>$next_year]);
		}

		$duration = microtime(true) - $start;
		$memory = memory_get_peak_usage(true);
		echo $duration, ' seconds using ', $memory, ' bytes', PHP_EOL;
	}
}
