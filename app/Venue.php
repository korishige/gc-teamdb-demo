<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venue extends Model
{


    protected $table = 'venues';
    protected $guarded = array('id');
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function league()
    {
        return $this->belongsTo('App\Leagues');
    }
    public function pref()
    {
        return $this->belongsTo('App\Pref');
    }
}
