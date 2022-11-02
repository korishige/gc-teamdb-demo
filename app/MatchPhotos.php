<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatchPhotos extends Model
{


	protected $table = 'match_photos';
	protected $guarded = array('id');
	// use SoftDeletes;
	// protected $dates = ['deleted_at'];

	public function match()
	{
		return $this->hasOne('App\Matches', 'id', 'match_id');
	}
}
