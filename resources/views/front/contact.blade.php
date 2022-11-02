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

          @include('layouts.parts.error')
        <article>
                <div id="contact">
                    <div class="inner">
                    
                        {!!Form::open(['url'=>route('front.contact.post')])!!}
                        <dl>
                            <div>
                                <dt>お名前<span>必須</span></dt>
                                <dd>
                                    <input type="text" name="name" value="{{old('name')}}">
                                </dd>
                            </div>
                            <div>
                                <dt>ﾒｰﾙアドレス<span>必須</span></dt>
                                <dd>
                                    <input type="text" name="email" value="{{old('email')}}">
                                </dd>
                            </div>
                            <div>
                                <dt>メッセージ本文<span>必須</span></dt>
                                <dd>
                                    <textarea name="body" id="" cols="30" rows="10">{!!nl2br(old('body'))!!}</textarea>
                                </dd>
                            </div>
                        </dl>
                        
                        <div class="btn">
                            <input type="submit" value="送信する">
                        </div><!-- /.btn -->
                        {!!Form::close()!!}

                    </div><!-- /.inner -->
                </div>

        </article>

        </div><!-- /.main -->

		@include('front.parts.side')
	
	</div><!-- /.inner -->
	</main>
@stop

