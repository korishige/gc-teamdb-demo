<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use \App\Options;
use stdClass;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = Options::get();
        //オプションの初期値
        $view = 0;
        $yellow = 2;

        //DBのオプションの値を取得して格納
        foreach ($options as $option) {
            if ($option->option_number == 1) {
                $view = $option->value;
            } elseif ($option->option_number == 2) {
                $yellow = $option->value;
            }
        }

        return view('admin.option.index', [
            'options' => $options,
            'view' => $view,
            'yellow' => $yellow,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $options = Options::get();

        //すでに設定されていたら更新前に削除
        if (count($options) != 0) {
            if ($request->block_start_0 == "" || $request->block_end_0 == "") {
                foreach ($options as $option) {
                    if ($option->option_number == 1 || $option->option_number == 2) {
                        $option->delete();
                    }
                }
            } else {
                foreach ($options as $option) {
                    $option->delete();
                }
            }
        }

        //ブロック登録期間を保存
        if ($request->block_start_0 != null) {
            $count = $request->count;
            for ($i = 0; $i <= $count; $i++) {
                $start = 'block_start_' . $i;
                $end = 'block_end_' . $i;
                $value = $request->$start . '~' . $request->$end;

                $options = new Options;

                $options->option_number = 0;
                $options->option_name = 'ブロック選手登録期間';
                $options->value = $value;

                $options->save();
            }
        }

        $options = new Options;

        $options->option_number = 1;
        $options->option_name = 'ブロック選手・警告者表示範囲';
        $options->value = $request->view;

        $options->save();


        $options = new Options;

        $options->option_number = 2;
        $options->option_name = 'イエローの出場停止の枚数';
        $options->value = $request->yellow;

        $options->save();

        return redirect()->route('admin.option.index', [])->with('msg', '保存しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
