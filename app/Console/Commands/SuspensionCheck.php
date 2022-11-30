<?php

namespace App\Console\Commands;

use App\PlayerSuspend;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use App\Players;
use App\Cards;


class SuspensionCheck extends Command
{
	protected $signature = 'suspend.check';
	protected $description = '出場停止クリア監視スクリプト';

	public function handle()
	{

		$start = microtime(true);

		//		$players = Players::whereNotNull('suspension_at')->where('suspension_at','<=',date('Y-m-d H:i:s'))->get();
		$suspends = PlayerSuspend::where('is_suspend', 1)->where('suspension', '<=', date('Y-m-d H:i:s'))->get();
		//		$players = Players::whereNotNull('suspension_at')->get();

		//		dd($players);

		foreach ($suspends as $suspend) {
			//			Cards::where('player_id', $player->id)->where('color', 'yellow')->where('is_cleared', 0)->update(['is_cleared' => 1]);
			//			Cards::where('player_id', $player->id)->where('color', 'red')->where('is_cleared', 0)->update(['is_cleared' => 1]);
			Players::where('id', $suspend->player_id)->where('team_id', $suspend->team_id)->update(['suspension_at' => NULL]);
			// 出場停止解除となる選手のチームIDのみを解除
			// 場合によっては、suspension を消したほうがいいのかもしれない
			PlayerSuspend::where('id', $suspend->id)->update(['suspension' => null, 'is_suspend' => 0, 'suspended' => $suspend->suspention]);

			//2022/9/20 バッチ処理でクリアをするように変更
			Cards::where('player_id', $suspend->player_id)->where('team_id', $suspend->team_id)->where('color', 'red')->where('is_cleared', 0)->update(['is_cleared' => 1]);
			Cards::where('player_id', $suspend->player_id)->where('team_id', $suspend->team_id)->where('color', 'yellow')->where('is_cleared', 0)->update(['is_cleared' => 1]);
		}

		$duration = microtime(true) - $start;
		$memory = memory_get_peak_usage(true);
		echo $duration, ' seconds using ', $memory, ' bytes', PHP_EOL;
		die(0);
	}
}
