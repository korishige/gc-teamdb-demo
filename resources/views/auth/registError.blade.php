@extends('layouts.plain')

@section('content')
<div class="">
  <div id="wrapper">
    <div id="login" class="animate form">
      <section class="login_content">
        <h1>{{$msg['title']}}</h1>
        <div>
          {{$msg['desc']}}
        </div>
        <div class="clearfix"></div>
        <div class="separator">

          <div>
            <p>{{Config::get('app.copy')}} All Rights Reserved.</p>
          </div>
        </div>
      </section>
      <!-- content -->
    </div>
  </div>
</div>
@stop