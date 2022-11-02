<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="ja"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="ja"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="ja"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="ja">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Teko:wght@300;400;500&display=swap" rel="stylesheet">

    <title></title>

    <link href="/team/css/reset.css" rel="stylesheet" type="text/css" media="all" />
    <link href="/team/css/common.css" rel="stylesheet" type="text/css" />
    <link href="/team/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/team/css/index.css" rel="stylesheet" type="text/css" />
    <link href="/team/css/starter_setting.css?d=20210403" rel="stylesheet" type="text/css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/team/js/common.js"></script>

</head>

<body>
    <!-- #wrap -->
    <div id="wrap">

        <main>
            <div id="starter">
                <div class="head">
                    <h1>Blue Wave U-17リーグ~Boost~{{config('app.nendo')}}</h1>
					<?php
					if($match->away_id == \Session::get('team_id')){
						$away = $match->home0->name;
						$home = $match->away0->name;
					}else{
						$away = $match->away0->name;
						$home = $match->home0->name;
					}
					?>
                    <div class="row">
                        <div class="date">
                            開催日：{{date('Y年n月j日',strtotime($match->match_date))}}
                        </div><!-- /.date -->
                        <div class="opp">
                            対戦相手：{{$away}}
                        </div><!-- /.opp -->
                        <div class="team">
                            チーム名：{{$home}}
                        </div><!-- /.team -->
                    </div><!-- /.row -->
                    <div class="note">
                        先発選手 〇　交代選手 IN △ OUT ×
                    </div><!-- /.note -->
                </div><!-- /.head -->

                <table>
                    <tr>
                        <th colspan="7"></th>
                        <th colspan="7">交代</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>Cap</th>
                        <th>背番号</th>
                        <th>Pos</th>
                        <th>選手名</th>
                        <th>学年</th>
                        <th>先発</th>
                        <th>①</th>
                        <th>②</th>
                        <th>③</th>
                        <th>④</th>
                        <th>⑤</th>
                        <th>⑥</th>
                        <th>⑦</th>
                    </tr>
                    @for($i=0;$i<25;$i++)
                    <tr>
					<?php
					if($i == $pop['cap']){
						$checked = '○';
					}else{
						$checked = '';
					}
					$player = \App\Players::where('id', $pop['player_id'][$i])->first();
					?>
                        <td>{{$i+1}}</td>
                        <td>{{$checked}}</td>
                        <td>{{$pop['number'][$i]}}</td>
                        <td>{{array_get(config('app.positionAry'),$pop['position'][$i],null)}}</td>
                        <td>{{array_get($players, $pop['player_id'][$i], null)}}</td>
                        <td>
                            <?php
                            if($player !== null){
                        	    print(array_get(config('app.schoolYearAry'),$player->school_year));
                            }else{
                            	print("");
                            }
                            ?>
                        </td>
                        <td>{{($pop['is_starter'][$i])?'○':''}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endfor
                </table>

                <table>
                    <tr>
                        <th colspan="3">ベンチ入りスタッフ</th>
                        <th colspan="4">ユニフォーム色</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th>役職</th>
                        <th>スタッフ名</th>
                        <th></th>
                        <th>シャツ</th>
                        <th>ショーツ</th>
                        <th>ソックス</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>{{$pop['staff_role'][0]}}</td>
                        <td>{{$pop['staff_name'][0]}}</td>
                        <td>FP(正)</td>
                        <td>{{$pop['fp_pri_shirt']}}</td>
                        <td>{{$pop['fp_pri_shorts']}}</td>
                        <td>{{$pop['fp_pri_socks']}}</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>{{$pop['staff_role'][1]}}</td>
                        <td>{{$pop['staff_name'][1]}}</td>
                        <td>FP(副)</td>
                        <td>{{$pop['fp_sub_shirt']}}</td>
                        <td>{{$pop['fp_sub_shorts']}}</td>
                        <td>{{$pop['fp_sub_socks']}}</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>{{$pop['staff_role'][2]}}</td>
                        <td>{{$pop['staff_name'][2]}}</td>
                        <td>GK(正)</td>
                        <td>{{$pop['gk_pri_shirt']}}</td>
                        <td>{{$pop['gk_pri_shorts']}}</td>
                        <td>{{$pop['gk_pri_socks']}}</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>{{$pop['staff_role'][3]}}</td>
                        <td>{{$pop['staff_name'][3]}}</td>
                        <td>GK(副)</td>
                        <td>{{$pop['gk_sub_shirt']}}</td>
                        <td>{{$pop['gk_sub_shorts']}}</td>
                        <td>{{$pop['gk_sub_socks']}}</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>{{$pop['staff_role'][4]}}</td>
                        <td>{{$pop['staff_name'][4]}}</td>
                        <td colspan="4" rowspan="2" class="sign">監督署名</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>{{$pop['staff_role'][5]}}</td>
                        <td>{{$pop['staff_name'][5]}}</td>
                    </tr>
                </table>
            </div><!-- /#starter -->

        </main>

    </div>
    <!-- /#wrap -->

</body>
</html>
