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
    <link href="/team/css/starter_setting.css" rel="stylesheet" type="text/css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="/team/js/common.js"></script>

    <style>
        @media print{
            #starter th {
                color: black !important;
            }
        }
    </style>

</head>

<body>
    <!-- #wrap -->
    <div id="wrap">

        <main>
            <div id="starter">
                <div class="head">
                    <h1>{{$match->leagueOne->name}}</h1>
                </div>

                <table style="width: 50%; margin: 0 auto;">
                    <tr>
                        <th style="width: 30%;">チーム名</th>
                        <td>{{ $team->name }}</td>
                    </tr>
                    <tr>
                        <th>監督名</th>
                        <td>{{$pop['staff_name'][0]}}</td>
                    </tr>
                </table>

                <br>

                <table>
                    {{-- <tr>
                        <th colspan="8"></th>
                        <th colspan="2">交代</th>
                    </tr> --}}
                    <tr>
                        <th style="width: 10%;">選手名</th>
                        <th style="width: 8%;">学年</th>
                        <th style="width: 3%;">Pos</th>
                        <th style="width: 4%;">身長</th>
                        <th style="width: 10%;">前所属チーム</th>
                        <th style="width: 3%;">背番号</th>
                        <th style="width: 6%;">スタート</th>
                        <th style="width: 6%;">リザーブ</th>
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

                        $s_or_b = '';
                        if(isset($pop['is_bench']) and $pop['is_starter'][$i]){
                        $s_or_b = 'S';
                        }elseif(isset($pop['is_bench']) and $pop['is_bench'][$i]){
                        $s_or_b = 'B';
                        }
                        ?>
                        <td>
                            @if(isset($pop['position']))
                                {{array_get($players, $pop['player_id'][$i], null)}}
                            @endif
                            &nbsp;
                        </td>
                        <td>
                            <?php
                            if($player !== null){
                                print(array_get(config('app.schoolYearAry'),$player->school_year));
                            }else{
                                print("");
                            }
                            ?>
                        </td>
                        <td>
                            @if(isset($pop['position']))
                                {{array_get(config('app.positionAry'),$pop['position'][$i],null)}}
                            @endif
                        </td>
                        <td>
                            <?php
                            if($player !== null){
                                if($player->height != 0.0){
                                    print($player->height);
                                }
                            }else{
                                print("");
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if($player !== null){
                                if($player->related_team != null){
                                    print($player->related_team);
                                }
                            }else{
                                print("");
                            }
                            ?>
                        </td>
                        <td>{{$checked}}{{$pop['number'][$i]}}</td>
                        <td>
                            @if($s_or_b == 'S')
                            ○
                            @endif
                        </td>
                        <td>
                            @if($s_or_b == 'B')
                            ○
                            @endif
                        </td>
                    </tr>
                    @endfor
                </table>

                {{-- <table>
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
                </table> --}}
            </div><!-- /#starter -->

        </main>

    </div>
    <!-- /#wrap -->

</body>
</html>
