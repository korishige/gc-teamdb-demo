@extends('layouts.team')

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/form.css" rel="stylesheet" type="text/css" />
<link href="/team/css/team.css" rel="stylesheet" type="text/css" />
@stop

@section('overlay')
    <div class="content_title">
        <div class="inner">
            <h1>
                <span>チーム情報</span>
                <span>TEAM INFORMATION</span>
            </h1>
        </div><!-- /.inner -->
    </div><!-- /.content_title -->
@stop

@section('content')

@include('layouts.parts.error')
<article>

    <section>
        <div id="team">
            <div class="inner">
                <div id="create">

                    <div class="box">
                        {!!Form::open(['files'=>true,'url'=>route('team.info.update'),'class'=>"form-horizontal form-label-left"])!!}
                        <input type="hidden" name="id" value="{{$team->id}}">

                        <h2>所属リーグ<span>必須</span></h2>
                        <?php
                        $groups = \App\Groups::get()->lists('name', 'id');
                        ?>
                        {!!Form::select('group_id',$groups, $team->group_id,['class'=>'league','disabled'=>true])!!}

                        <h2>チーム名<span>必須</span></h2>

                        <p>※「県立」「私立」や「高校」「サッカー部」などの記載は省きます。　Ｂチームなどの場合は末尾に必ず入れてください。</p>

                        {!!Form::text('name',$team->name)!!}

                        <h2>設立年</h2>
                        
                        <div class="year_est row">
                            <span>西暦</span>
                            {!!Form::text('year',$team->year,['class'=>'w20'])!!}
                            <span>年</span>
                        </div><!-- /.year_est -->

                        <h2>所在地</h2>
                        <div class="address">
                            <span>都道府県</span>
                            {!!Form::select('pref_id',config('app.prefAry'),$team->pref_id,['class'=>'form-control w30'])!!}
                        </div><!-- /.address -->
                        <div class="address">
                            <span>市区町村</span>
                            {!!Form::text('add1',$team->add1,['class'=>'w30'])!!}
                        </div><!-- /.address -->
                        <div class="address">
                            <span>以降の住所</span>
                            {!!Form::text('add2',$team->add2,['class'=>'w30'])!!}
                        </div><!-- /.address -->

                        <h2>電話番号</h2>
                        {!!Form::text('tel',$team->tel,['class'=>'w30'])!!}
                        
                        <h2>エンブレム画像</h2>
                        @if($team->emblem_img!='')
                        <img src="/upload/300_crop/{{$team->emblem_img}}">
                        <input type="checkbox" value="1" name="emblem_img_delete">写真削除
                        @endif
                        {!!Form::file('emblem_img')!!}

                        <h2>集合写真（カメラ横向き撮影）</h2>
                        @if($team->group_img!='')
                        <img src="/upload/300/{{$team->group_img}}">
                        <input type="checkbox" value="1" name="group_img_delete">写真削除
                        @endif
                        {!!Form::file('group_img')!!}

                        <h2>監督動画</h2>
                        @if($team->manager_mov!='')
                        <video controls playsinline width="300" height="300" src="/upload/movie/{{$team->manager_mov}}"></video>
                        <input type="checkbox" value="1" name="manager_mov_delete">写真削除
                        @endif
                        {!!Form::file('manager_mov')!!}

                        <h2>主将動画</h2>
                        @if($team->captain_mov!='')
                        <video controls playsinline width="300" height="300" src="/upload/movie/{{$team->captain_mov}}"></video>
                        <input type="checkbox" value="1" name="captain_mov_delete">写真削除
                        @endif
                        {!!Form::file('captain_mov')!!}

                        <h2>チームの監督</h2>
                        {!!Form::text('manager',$team->manager,['placeholder'=>'監督の名前を入れてください','class'=>'w50'])!!}
                        
                        <h2>チームコーチ</h2>
                        {!!Form::text('coach',$team->coach,['placeholder'=>'コーチの名前を入れてください','class'=>'w50'])!!}
                        
                        
                        <h2>ユニフォーム色</h2>
                        
                        <div class="uniform">
                          
                            <div class="head">
                                <span>シャツ</span>
                                <span>ショーツ</span>
                                <span>ソックス</span>
                            </div><!-- /.head -->
                           
                            <div class="col">
                                <h3>FP(正)</h3>
                                <span>{!!Form::text('fp_pri_shirt',$team->fp_pri_shirt,['placeholder'=>'シャツカラー'])!!}</span>
                                <span>{!!Form::text('fp_pri_shorts',$team->fp_pri_shorts,['placeholder'=>'ショーツカラー'])!!}</span>
                                <span>{!!Form::text('fp_pri_socks',$team->fp_pri_socks,['placeholder'=>'ソックスカラー'])!!}</span>
                            </div><!-- /.col -->
                            
                            <div class="col">
                                <h3>FP(副)</h3>
                                <span>{!!Form::text('fp_sub_shirt',$team->fp_sub_shirt,['placeholder'=>'シャツカラー'])!!}</span>
                                <span>{!!Form::text('fp_sub_shorts',$team->fp_sub_shorts,['placeholder'=>'ショーツカラー'])!!}</span>
                                <span>{!!Form::text('fp_sub_socks',$team->fp_sub_socks,['placeholder'=>'ソックスカラー'])!!}</span>
                            </div><!-- /.col -->
                            
                            <div class="col">
                                <h3>GK(正)</h3>
                                <span>{!!Form::text('gk_pri_shirt',$team->gk_pri_shirt,['placeholder'=>'シャツカラー'])!!}</span>
                                <span>{!!Form::text('gk_pri_shorts',$team->gk_pri_shorts,['placeholder'=>'ショーツカラー'])!!}</span>
                                <span>{!!Form::text('gk_pri_socks',$team->gk_pri_socks,['placeholder'=>'ソックスカラー'])!!}</span>
                            </div><!-- /.col -->
                            
                            <div class="col">
                                <h3>GK(副)</h3>
                                <span>{!!Form::text('gk_sub_shirt',$team->gk_sub_shirt,['placeholder'=>'シャツカラー'])!!}</span>
                                <span>{!!Form::text('gk_sub_shorts',$team->gk_sub_shorts,['placeholder'=>'ショーツカラー'])!!}</span>
                                <span>{!!Form::text('gk_sub_socks',$team->gk_sub_socks,['placeholder'=>'ソックスカラー'])!!}</span>
                            </div><!-- /.col -->

                        </div><!-- /.uniform -->
                       
                            
                        <h2>指導方針や目標</h2>
                        {!!Form::textarea('policy',$team->policy,['size'=>'30x3'])!!}
                        
                        <h2>過去の主な実績</h2>
                        {!!Form::textarea('record',$team->record,['size'=>'30x5'])!!}
                        
                        <h2>学校ホームページ　URL</h2>
                        {!!Form::text('url_school',$team->url_school)!!}
                        
                        <h2>チームホームページ　URL</h2>
                        {!!Form::text('url_team',$team->url_team)!!}
                        
                        <h2>ブログ　URL</h2>
                        {!!Form::text('url_blog',$team->url_blog)!!}
                        
                        <h2>Facebook　URL</h2>
                        {!!Form::text('url_facebook',$team->url_facebook)!!}
                        
                        <h2>Twitter　URL</h2>
                        {!!Form::text('url_twitter',$team->url_twitter)!!}
                        
                        <h2>Instagram　URL</h2>
                        {!!Form::text('url_instagram',$team->url_instagram)!!}

                        <div class="btn_reg">
                            <input type="button" value="戻る" onClick='history.back();' >
                            <input type="submit" value="登録">
                        </div><!-- /.btn_reg -->
                        
                        {!!Form::close()!!}
                    </div><!-- /.box -->
                    
                </div><!-- /.new_reg -->
                
            </div><!-- /.inner -->
        </div>
    </section>

</article>
@stop