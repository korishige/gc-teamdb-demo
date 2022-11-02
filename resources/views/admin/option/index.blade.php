@extends('layouts.admin')

@section('content')
@if(Session::has('msg'))
  <div class="alert alert-success">{{Session::get('msg')}}</div>
  @endif
<div class="x_panel">
	<div class="x_title">
	    <h2>大会設定 <small></small></h2>
	    <div class="clearfix"></div>
	</div>
	<div class="x_content">
	  {!!Form::open(['url'=>route('admin.option.store'),'method'=>'post','class'=>'row form-inline'])!!}

      {{-- <h2>・ブロック選手の登録期間</h2>
      @if(count($options) != 0)
        <br>&nbsp;&nbsp;現在の登録期間<br>
        @foreach ($options as $option)
          @if($option->option_number == 0)
            <ul>
              <li>
                {{$option->value}}
              </li>
            </ul>
          @endif
        @endforeach<br>
      @endif
      <div id="form_area">
        <input type="hidden" id="count" name="count" value="0">
        期間1 開始&nbsp;<input class="form-control" type="date" id="block_start_0" name="block_start_0">&nbsp;&nbsp;
        終了&nbsp;<input class="form-control" type="date" id="block_end_0" name="block_end_0">&nbsp;&nbsp;<br>
      </div><br>
      <input class="btn btn-info btn-sm" type="button" value="期間の追加" onclick="addForm()">
      <br> --}}

      <h2 style="margin-top: 50px;">・警告者の表示範囲</h2>
      ※チーム専用ページでのブロック選手・警告者を表示する範囲を決定します。<br><br>&nbsp;&nbsp;
      <input type='radio' name='view' id='view-0' value='0' {{ $view == 0 ? 'checked' : '' }}><label for="view-0" style="font-size: 18px">&nbsp;全ての選手を表示&nbsp;</label>
      <input type='radio' name='view' id='view-1' value='1' {{ $view == 1 ? 'checked' : '' }}><label for="view-1" style="font-size: 18px">&nbsp;同じリーグの選手のみ表示&nbsp;</label>
      {{-- <input type='radio' name='view' id='view-2' value='2' {{ $view == 2 ? 'checked' : '' }}><label for="view-2" style="font-size: 18px">&nbsp;対戦相手の選手のみ表示&nbsp;</label> --}}
      <br>

      <h2 style="margin-top: 50px;">・イエローカードの出場停止になる枚数</h2>
      <input type='number' class="form-control" name='yellow' value='{{ $yellow == 0 ? '2' : $yellow }}'>
      <br><br><br>
      
      <div style="width: 50px; margin: 0 auto">
        <input type="submit" class="btn btn-primary" value="保存">
      </div>
    {!!Form::close()!!}
	</div>
</div>

<script>
var i = 1 ;
function addForm() {
  var j = i + 1;

  var count = document.getElementById('count');
  count.value = Number( count.value ) + 1;

  var a_text = document.createElement('a');
  a_text.innerHTML = '期間' + j + ' 開始 ';
  a_text.id = 'a_start_' + i;
  var parent = document.getElementById('form_area');
  parent.appendChild(a_text);

  var input_data = document.createElement('input');
  input_data.type = 'date';
  input_data.className = 'form-control';
  input_data.id = 'block_start_' + i;
  input_data.name = 'block_start_' + i;
  var parent = document.getElementById('form_area');
  parent.appendChild(input_data);

  var a_text = document.createElement('a');
  a_text.innerHTML = '　終了 ';
  a_text.id = 'a_end_' + i;
  var parent = document.getElementById('form_area');
  parent.appendChild(a_text);

  var input_data = document.createElement('input');
  input_data.type = 'date';
  input_data.className = 'form-control';
  input_data.id = 'block_end_' + i;
  input_data.name = 'block_end_' + i;
  var parent = document.getElementById('form_area');
  parent.appendChild(input_data);

  var button_data = document.createElement('button');
  button_data.id = i;
  button_data.className = 'btn btn-danger btn-sm';
  button_data.onclick = function(){deleteBtn(this,count.value);}
  button_data.innerHTML = 'ー';
  var input_area = document.getElementById(input_data.id);
  parent.appendChild(button_data);

  var input_data = document.createElement('br');
  input_data.id = 'br_' + i;
  var parent = document.getElementById('form_area');
  parent.appendChild(input_data);

  i++ ;
}

function deleteBtn(target, count) {
  var target_id = target.id;
  var parent = document.getElementById('form_area');

  var input_data = document.getElementById('count');
  input_data.value = count - 1;

  var ipt_id1 = document.getElementById('br_' + target_id);
  parent.removeChild(ipt_id1);

  var ipt_id1 = document.getElementById('a_start_' + target_id);
  parent.removeChild(ipt_id1);

  var ipt_id2 = document.getElementById('a_end_' + target_id);
  parent.removeChild(ipt_id2);
  
  var ipt_id3 = document.getElementById('block_start_' + target_id);
  parent.removeChild(ipt_id3);

  var ipt_id4 = document.getElementById('block_end_' + target_id);
  var tgt_id4 = document.getElementById(target_id);
  parent.removeChild(ipt_id4);
  parent.removeChild(tgt_id4);	
}
</script>
@stop