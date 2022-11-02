<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Cookie;
use Config;
use Session;
use Input;

use App\Branch;

class ApiController extends Controller
{
  public function __construct()
  {
    // do something...
  }

  public function genBranch(){
    $pref_id   = Input::get('pref_id');

    $branchs = ['*'=>'選択してください']+\DB::table('branch')->where('pref_id',$pref_id)->orderBy('bSort','desc')->lists('name','id');
    $html = \Form::select('branch_id',$branchs,'*',['id'=>'branch_id','class'=>'form-control']);
    return $html;
  }


}
