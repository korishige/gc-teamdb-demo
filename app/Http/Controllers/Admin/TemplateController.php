<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Template;
// use App\Cfg;

class TemplateController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth.admin');
  }

  public function index()
  {
    $templates = Template::get();
    return view('admin.templates.index')->with(compact('templates'));
  }

  public function edit($id, Request $req)
  {

    // $cfg = Cfg::find(1);
    $target = $req->has('page') ? $req->get('page') : 'abstract';

    $template = Template::find($id);

    return view('admin.templates.edit')->with(compact('template', 'target'));
    // render
    // return \DbView::make($template)->field($target)->with(['foo' => 'Bar'])->render();
  }

  public function update($id, Request $req)
  {
    $data = $req->except('_token');

    // $data = '';
    // return view('dummy')->with(compact('data'));

    Template::where('id', $id)->update($data);
    return redirect()->route('admin.template.edit', ['id' => $id])->with('msg', '保存しました');
  }
}
