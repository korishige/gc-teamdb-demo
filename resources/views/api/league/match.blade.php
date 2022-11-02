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
    <title>[{{array_get(config('app.genreAry'),$league->sports_slug)}}]　リーグ戦試合結果　{{array_get($prefAry,$league->pref)}}</title>
</head>

<body>
    <main>

        <div class="top">
            <h3>[{{array_get(config('app.genreAry'),$league->sports_slug)}}]　リーグ戦試合結果　{{array_get($prefAry,$league->pref)}}</h3>
            <div class="update">最終更新日: {{ date('Y年m月d日 H:i',strtotime($league->matches()->max('updated_at'))) }}  </div>
            <div class="title">{{$league->name}}</div>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{route('api.league.order',['league_id'=>$league->id])}}">全順位</a></li>
                <li><a href="#" class="current">試合</a></li>
                <li><a href="{{route('api.league.table',['league_id'=>$league->id])}}">戦績表</a></li>
            </ul>
        </div><!-- /.menu -->

        <div class="match">
            <table cellspacing="0" cellpadding="0" border="0">
                <thead>
                    <tr>
                        <th>キックオフ</th>
                        <th></th>
                        <th>試合状況</th>
                        <th></th>
                        <th>試合会場</th>
                    </tr>
                </thead>
            <tbody>
            @foreach($matchObj as $match)
              <tr >
                <td class="textC">
                @if($match->match_at=='0000-00-00')
                -
                @else
                {{date('m/d',strtotime($match->match_at))}} 
                (
                {{array_get( Config::get('app.week'),date('w',strtotime($match->match_at)))}}
                )
                @endif
                </td>
                <td class="team">
                  {{$match->home->name}}
                </td>
                <td class="score">
                  {{$match->home_pt}}&nbsp;-&nbsp;{{$match->away_pt}}
                  @if($match->home_pt == $match->away_pt and $match->home_pk!='' and $match->away_pk!='')
                  <br>PK : {{$match->home_pk}} - {{$match->away_pk}}
                  @endif
                  <small class="status">試合終了</small>
                </td>
                <td class="team">
                  {{$match->away->name}}
                </td>
                <td>{{$match->place}}</td>
              </tr>
            @endforeach
            </tbody>

            </table>

            <div class="bottom">
                <div class="produce">
                    <a href="">produce by Special-League</a>
                </div><!-- /.produce -->
            </div>

        </div>
    </main>
</body>

</html>
