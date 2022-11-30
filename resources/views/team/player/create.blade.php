@extends('layouts.team')

@section('css')
<link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
<link href="/team/css/common.css" rel="stylesheet" type="text/css" />
<link href="/team/css/style.css" rel="stylesheet" type="text/css" />
<link href="/team/css/form.css" rel="stylesheet" type="text/css" />
<link href="/team/css/player.css" rel="stylesheet" type="text/css" />
<link type="text/css" rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/cupertino/jquery-ui.min.css" />
<style>
	span.required{
	color:red;
	font-size:11px;
}
</style>
@stop

@section('js')
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

<script>
	$(function() {
		$.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
		$( ".inputCal" ).datepicker({ dateFormat: 'yy-mm-dd' });
	});
</script>
@stop

@section('overlay')
<div class="content_title">
	<div class="inner">
		<h1>
			<span>選手情報</span>
			<span>PLAYER INFORMATION</span>
		</h1>
	</div><!-- /.inner -->
</div><!-- /.content_title -->
@stop

@section('content')

@include('layouts.parts.error')
<article>
	<div id="player">
		<div class="inner">
			<div id="create">
				{!!Form::open(['files'=>true,'url'=>route('team.player.store'),'class'=>'form-horizontal form-label-left'])!!}
					<div class="box">

						<h2>選手名<span>必須</span></h2>
						{!!Form::text('name',old('name'),['class'=>'w30'])!!}

						{{-- <h2>ブロック選手</h2>
						
						{!!Form::select('is_block',config('app.is_block'), old('is_block'),['class'=>'w30'])!!} --}}

						<h2>生年月日<span>必須</span></h2>

						{!!Form::text('birthday',old('birthday'),['class'=>'w30 form-control inputCal'])!!}


						<h2>学年</h2>
						{!!Form::select('school_year',config('app.schoolYearAry'),old('school_year'),['class'=>"width:100px",'style'=>'width:100px'])!!}

						<h2>ポジション</h2>
						<input type='radio' name='position' id='position-0' value='0' checked>GK
						<input type='radio' name='position' id='position-1' value='1'>DF
						<input type='radio' name='position' id='position-2' value='2'>MF
						<input type='radio' name='position' id='position-3' value='3'>FW

						<h2>出身地</h2>
						{!!Form::select('birthplace',config('app.prefAry')+[99=>'その他'],old('birthplace'),['class'=>'w20'])!!}


						<h2>出身チーム</h2>
						{!!Form::text('related_team',old('related_team'),['class'=>'w30'])!!}

						<h2>利き足</h2>

						<input type='radio' name='pivot' id='pivot-0' value='0' checked>右足
						<input type='radio' name='pivot' id='pivot-1' value='1'>左足

						<h2>身長</h2>
						{!!Form::text('height',old('height'),['class'=>'w20'])!!}
						<span>cm</span>

						<h2>体重</h2>

						{!!Form::text('weight',old('weight'),['class'=>'w20'])!!}
						<span>kg</span>

						<h2>今年の目標</h2>

						{!!Form::text('goal',old('goal'))!!}

						<h2>選手写真</h2>
						{!!Form::file('img')!!}

						<div class="ln_solid"></div>

					</div><!-- /.box -->

					<div class="btn_reg">
						<input type="button" value="戻る"  onclick="javascript:history.back();">
						<input type="submit" value="登録">
					</div><!-- /.btn_reg -->

				</form>

			</div><!-- /.create -->

		</div><!-- /.inner -->
	</div>
</article>
@endsection