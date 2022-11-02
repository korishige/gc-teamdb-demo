@extends('layouts.front',['page_title'=>(Input::has('page'))?Input::get('page').'ページ目 | ':''.'お知らせ一覧｜'.env('title')])

@section('css')
<link href="css/news.css" rel="stylesheet" type="text/css" />
@endsection

@section('footer_sub')
@endsection

@section('contents')
    <div class="content_title">
        <div class="inner">
            <h1>お知らせ</h1>
        </div><!-- /.inner -->
    </div><!-- /.content_title -->
    
    <div class="bc">
        <span><a href="{{route('front.index')}}">TOP</a></span>
        <span><a href="{{route('front.news.index')}}">お知らせ</a></span>
    </div><!-- /.bc -->

    <main class="content">
    
    <div class="inner">
        <div class="main">

        <article>
                <div id="news">
                    <div class="inner">

                        <section>
                        <div class="row">

                            @foreach($newsObj as $news)
                            <div class="col">
                                <img src="img/common/dammy_img_news.png">
                                <div class="txt">
                                    <h3>{{$news->title}}</h3>
                                    <span>{{date('Y.m.d',strtotime($news->dis_dt))}}</span>
                                </div><!-- /.txt -->
                                <a href="{{route('front.news.show',['id'=>$news->id])}}"></a>
                            </div><!-- /.col -->
                            @endforeach
                        </div><!-- /.row -->
                        </section>

                        <div class="pager">
                            <ul>
                                {!!$newsObj->appends(Input::except('page'))->render()!!}
<!--                                 <li><span class="current">1</span></li>
    <li><a href="">2</a></li>
    <li><a href="">3</a></li>
    <li><a href="">4</a></li>
    <li><a href="">5</a></li>
-->                            </ul>
</div><!-- /.pager -->

</div><!-- /.inner -->
</div>

</article>

</div><!-- /.main -->

@include('front.parts.side')

</div><!-- /.inner -->
</main>
@stop

