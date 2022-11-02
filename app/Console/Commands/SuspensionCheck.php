<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use App\Players;
use App\Cards;
use Carbon\Carbon;


class SuspensionCheck extends Command
{
	protected $signature = 'suspend.check';
	protected $description = '出場停止クリア監視スクリプト';

	public function handle()
	{

		$start = microtime(true);

		//		$players = Players::whereNotNull('suspension_at')->where('suspension_at','<=',date('Y-m-d H:i:s'))->get();
		$players = Players::whereNotNull('suspension_at')->get();

		//		dd($players);

		$today = new Carbon();

		foreach ($players as $player) {
			$suspension_at = new Carbon($player->suspension_at);
			if ($suspension_at->lt($today)) {
				Cards::where('player_id', $player->id)->where('color', 'yellow')->where('is_cleared', 0)->update(['is_cleared' => 1]);
				Cards::where('player_id', $player->id)->where('color', 'red')->where('is_cleared', 0)->update(['is_cleared' => 1]);
				Players::where('id', $player->id)->update(['suspension_at' => NULL]);
			}
		}

		$duration = microtime(true) - $start;
		$memory = memory_get_peak_usage(true);
		echo $duration, ' seconds using ', $memory, ' bytes', PHP_EOL;
		die(0);
	}
}
