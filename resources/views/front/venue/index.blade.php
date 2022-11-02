@extends('layouts.front',['page_title'=>(Input::has('page'))?Input::get('page').'ページ目 | ':''.'会場情報一覧｜'.env('title')])

@section('css')
<link href="/css/stadium.css" rel="stylesheet" type="text/css" />
@endsection

@section('footer_sub')
@endsection

@section('contents')
    <div class="content_title">
        <div class="inner">
            <h1>会場情報</h1>
        </div><!-- /.inner -->
    </div><!-- /.content_title -->
    
    <div class="bc">
        <span><a href="{{route('front.index')}}">TOP</a></span>
        <span><a href="{{route('front.venue.index')}}">会場情報</a></span>
    </div><!-- /.bc -->

    <main class="content">
       
        <div class="content_stitle">
            <div class="inner">
                <h2>会場情報</h2>
            </div><!-- /.inner -->
        </div><!-- /.content_stitle -->
        
        <div class="inner">
        <div class="main">

        <article>
            <div id="stadium">
                <div class="inner">

                    <div class="row">
                        @foreach($venues as $venue)
                        <div class="col">
                            <div class="img">
                                @if(empty($venue->img))
                                <img src="/img/common/dammy_img_stadium.png">
                                @else
                                <img src="/upload/original/{{$venue->img}}">
                                @endif
                            </div><!-- /.img -->
                            <div class="txt">
                                <span>{{$venue->name}}</span>
                                @if(!empty($venue->zip))〒{{$venue->zip}}@endif {{array_get(Config::get('app.prefAry'),$venue->pref_id)}} {{$venue->add1}}{{$venue->add2}}
                            </div><!-- /.txt -->
                            <a href="{{route('front.venue.show',['id'=>$venue->id])}}"></a>
                        </div><!-- /.col -->
                        @endforeach

                    <div class="pager">
                        {!!$venues->appends(Input::except('page'))->render()!!}
                    </div><!-- /.pager -->

                </div><!-- /.inner -->
            </div>
        </article>
        
        </div><!-- /.main -->

		@include('front.parts.side')
	
	</div><!-- /.inner -->
	</main>
@stop

