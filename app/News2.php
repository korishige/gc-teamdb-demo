<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News2 extends Model
{

	protected $table = 'news2';
	protected $guarded = array('id');
	use SoftDeletes;
	protected $dates = ['deleted_at'];

	public function pref()
	{
		return $this->belongsTo('App\Pref');
	}
}
