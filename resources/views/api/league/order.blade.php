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
    <title>[{{array_get(config('app.genreAry'),$league->sports_slug)}}]　リーグ戦全順位　{{array_get($prefAry,$league->pref)}}</title>
</head>

<body>
<main>
   
    <div class="top">
        <h3>[{{array_get(config('app.genreAry'),$league->sports_slug)}}]　リーグ戦全順位　{{array_get($prefAry,$league->pref)}}</h3>
            <div class="update">最終更新日: {{ date('Y年m月d日 H:i',strtotime($league->matches()->max('updated_at'))) }}  </div>
            <div class="title">{{$league->name}}</div>
    </div>
    
    <div class="menu">
        <ul>
                <li><a href="#" class="current">全順位</a></li>
                <li><a href="{{route('api.league.match',['league_id'=>$league->id])}}">試合</a></li>
                <li><a href="{{route('api.league.table',['league_id'=>$league->id])}}">戦績表</a></li>
        </ul>
    </div><!-- /.menu -->

    <div class="order">
        <table>
            <thead>
                <tr>
                    <th>順位</th>
                    <th>チーム名</th>
                    <th>勝点</th>
                    <th>試合数</th>
                    <th>勝数</th>
                    <th>引分数</th>
                    <th>敗数</th>
                    <th>得点</th>
                    <th>失点</th>
                    <th>得失点差</th>
                </tr>
            </thead>
            <tbody>
                            @foreach($resultObj as $i=>$result)
                            <tr {{($i%2)?'':'class="bgColor"'}}>
                                <td class="textC">{{$result->rank}}</td>
                                <td class="team">{{$result->name}}</td>
                                <td class="textC">{{$result->win_pt}}</td>
                                <td class="textC">{{$result->match_cnt}}</td>
                                <td class="textC">{{$result->win_cnt}}</td>
                                <td class="textC">{{$result->draw_cnt}}</td>
                                <td class="textC">{{$result->lose_cnt}}</td>
                                <td class="textC">{{$result->get_pt}}</td>
                                <td class="textC">{{$result->lose_pt}}</td>
                                <td class="textC last">{{$result->get_lose}}</td>
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