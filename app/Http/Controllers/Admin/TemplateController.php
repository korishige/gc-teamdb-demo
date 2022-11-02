<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Template;
// use App\Cfg;

class TemplateController extends Controller
{
  public function __construct(){
    $this->middleware('auth.admin');
  }

  public function edit(Request $req){

    // $cfg = Cfg::find(1);
    $target = $req->has('page')?$req->get('page'):'abstract';

    $template = Template::find(1);

    return view('admin.template')->with(compact('template','target'));
    // render
    // return \DbView::make($template)->field($target)->with(['foo' => 'Bar'])->render();
  }

  public function update(Request $req){
    $data = $req->except('_token');

    // $data = '';
    // return view('dummy')->with(compact('data'));

    Template::where('id',1)->update($data);
    return redirect()->route('admin.template.edit')->with('msg','保存しました');
  }

}
