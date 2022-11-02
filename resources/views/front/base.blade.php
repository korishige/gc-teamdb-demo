@extends('layouts.front',['page_title'=>(Input::has('page'))?Input::get('page').'ページ目 | ':''.'お知らせ一覧｜'.env('title')])

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

        <article>
                <div id="contact">
                    <div class="inner">
                    
                        <form action="">
                        <dl>
                            <div>
                                <dt>お名前<span>必須</span></dt>
                                <dd>
                                    <input type="text">
                                </dd>
                            </div>
                            <div>
                                <dt>ﾒｰﾙアドレス<span>必須</span></dt>
                                <dd>
                                    <input type="text">
                                </dd>
                            </div>
                            <div>
                                <dt>メッセージ本文<span>必須</span></dt>
                                <dd>
                                    <textarea name="" id="" cols="30" rows="10"></textarea>
                                </dd>
                            </div>
                        </dl>
                        
                        <div class="btn">
                            <input type="submit" value="送信する">
                        </div><!-- /.btn -->
                        </form>

                    </div><!-- /.inner -->
                </div>

        </article>

        </div><!-- /.main -->

		@include('front.parts.side')
	
	</div><!-- /.inner -->
	</main>
@stop

