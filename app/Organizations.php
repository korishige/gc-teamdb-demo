<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organizations extends Model
{

  protected $table = 'organizations';
  protected $guarded = array('id');
}
