<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="ja"><![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="ja">
<![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="ja">
<![endif]-->
<!--[if (gte IE 9)|!(IE)]>
<!-->
<html lang="ja">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{env('URL')}}api/css/reset.css" rel="stylesheet" type="text/css" />
    <link href="{{env('URL')}}api/css/tool.css" rel="stylesheet" type="text/css" />
    <title>[{{array_get(config('app.genreAry'),$league->sports_slug)}}]　リーグ戦　戦績表　{{array_get($prefAry,$league->pref)}}</title>
</head>

<body>
    <main>

        <div class="top">
            <h3>[{{array_get(config('app.genreAry'),$league->sports_slug)}}]　リーグ戦　戦績表　{{array_get($prefAry,$league->pref)}}</h3>
            <div class="update">最終更新日: {{ date('Y年m月d日 H:i',strtotime($league->matches()->max('updated_at'))) }}  </div>
            <div class="title">{{$league->name}}</div>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{route('api.league.order',['league_id'=>$league->id])}}">全順位</a></li>
                <li><a href="{{route('api.league.match',['league_id'=>$league->id])}}">試合</a></li>
                <li><a href="#" class="current">戦績表</a></li>
            </ul>
        </div><!-- /.menu -->

        <div class="table">
          @if(count($resultObj)>0)
          <table cellspacing="0" cellpadding="0" border="0">
            <thead>
              <tr>
                <th></th>
                @foreach($resultObj as $result)
                <th>{{$result->name}}
                @endforeach
                <th class="last">暫定順位</th>
              </tr>
            </thead>
            <tbody>
              <?php $k=0;?>
              @foreach($table as $i=>$row)
              <tr class="home">
                <td>{{$resultObj[$k]->name}}</td>
                @foreach($row as $j=>$col)
                  @if($i==$j)
                  <td class="none">&nbsp;</td>
                  @else
                  <td>
                    @foreach($col as $val)
                    {{$val}}<br>
                    @endforeach
                  </td>
                  @endif
                @endforeach
                <th class="last">{{$resultObj[$k]->rank}}</th>
              </tr>
              <?php $k++;?>
              @endforeach
            </tbody>

          </table>
          @else
          リーグ戦がありません
          @endif
        </div><!-- /.tool_table -->
        <div class="bottom">
            <div class="desp">
                ○：勝ち　●：負け　△：引き分け
            </div><!-- /.icon -->
            <div class="produce">
                <a href="">produce by Special-League</a>
            </div><!-- /.produce -->
        </div><!-- /.bottom -->
    </main>

</body>

</html>
