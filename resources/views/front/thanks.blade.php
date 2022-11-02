@extends('layouts.front',['page_title'=>'お問合せ｜'.env('title')])

@section('css')
<link href="css/contact.css" rel="stylesheet" type="text/css" />
@endsection

@section('footer_sub')
@endsection

@section('contents')
    <div class="content_title">
        <div class="inner">
            <h1>お問合せ</h1>
        </div><!-- /.inner -->
    </div><!-- /.content_title -->
    
    <div class="bc">
        <span><a href="{{route('front.index')}}">TOP</a></span>
        <span><a href="{{route('front.contact')}}">お問合せ</a></span>
    </div><!-- /.bc -->

    <main class="content">
    
    <div class="inner">
        <div class="main">
            <div class="thanks">送信完了しました。</div>
            <a href="{{route('front.index')}}">TOPページへ戻る</a>
        </div><!-- /.main -->

		@include('front.parts.side')
	
	</div><!-- /.inner -->
	</main>
@stop

