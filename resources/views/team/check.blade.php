@extends('layouts.team')

@section('css')
  <link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all"/>
  <link href="/team/css/common.css" rel="stylesheet" type="text/css"/>
  <link href="/team/css/style.css?20210330" rel="stylesheet" type="text/css"/>
  <link href="/team/css/form.css" rel="stylesheet" type="text/css"/>
  <link href="/team/css/team.css?20210330" rel="stylesheet" type="text/css"/>
@stop

@section('js')
  <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>

  <script>
      $(function () {
          $.datepicker.setDefaults($.datepicker.regional["ja"]);
          $(".inputCal").datepicker({dateFormat: 'yy-mm-dd'});
      });
  </script>
  <script>
      $(function () {
          $(".alert-msg").hide(2000);
      });
      $("a.confirm").click(function (e) {
          e.preventDefault();
          thisHref = $(this).attr('href');
          if (confirm('削除して良いですか？')) {
              window.location = thisHref;
          }
      })

  </script>
@stop

@section('content')
  <article>

    <section>
      <div id="team">
        <div class="inner">
          <div id="accumulation">

            <div class="row">

              <div class="col">

                <h2>自チーム名</h2>

                <h3>警　告</h3>
                <table>
                  @foreach($home_players as $p)
                    @if($p->yellow!=0)
                      <tr>
                        <td>{{$p->name}}</td>
                      </tr>
                    @endif
                  @endforeach
                </table>

                <h3>退　場</h3>
                <table>
                  @foreach($home_players as $p)
                    @if($p->red!=0)
                      <tr>
                        <td>{{$p->name}}</td>
                      </tr>
                    @endif
                  @endforeach
                </table>

                <h3>ブロック選手</h3>
                <table>
                  @foreach($home_players as $p)
                    @if($p->is_block!=0)
                      <tr>
                        <td>{{$p->name}}</td>
                      </tr>
                    @endif
                  @endforeach
                </table>

              </div><!-- /.col -->

              <div class="col">

                <h2>相手チーム名</h2>

                <h3>警　告</h3>
                <table>
                  @foreach($away_players as $p)
                    @if($p->yellow!=0)
                      <tr>
                        <td>{{$p->name}}</td>
                      </tr>
                    @endif
                  @endforeach
                </table>

                <h3>退　場</h3>
                <table>
                  @foreach($away_players as $p)
                    @if($p->red!=0)
                      <tr>
                        <td>{{$p->name}}</td>
                      </tr>
                    @endif
                  @endforeach
                </table>

                <h3>ブロック選手</h3>
                <table>
                  @foreach($away_players as $p)
                    @if($p->is_block!=0)
                      <tr>
                        <td>{{$p->name}}</td>
                      </tr>
                    @endif
                  @endforeach
                </table>

              </div><!-- /.col -->

            </div><!-- /.row -->

          </div><!-- /#accumulation -->

          <div class="btn_reg">
            {{--            <input type="button" value="戻る" onclick="javascript:history.back();">--}}
            <a href="#" onclick="javascript:history.back();">戻　る</a>
            {{--            <a href="index.html">戻　る</a>--}}
          </div><!-- /.btn_reg -->

        </div><!-- /.inner -->
      </div>
    </section>

  </article>

@stop