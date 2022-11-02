@extends('layouts.front',['page_title'=>'参加チーム一覧｜'.env('title')])

@section('css')
<link href="/css/team.css" rel="stylesheet" type="text/css" />
@endsection

@section('js')
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/jquery.tablesorter.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/css/theme.default.min.css">
    <script>
        $(function () {
            $('.group3_first').on('click', () => {
                // $('#group31').show();
                // $('#group32').hide();
                $('#g31_on').attr('class', 'on');
                $('#g32_on').attr('class', '');
                // $(".fp3").show()
                // $(".sp3").hide()
            });
            $('.group3_second').on('click', () => {
                // $('#group32').show();
                // $('#group31').hide();
                $('#g32_on').attr('class', 'on');
                $('#g31_on').attr('class', '');
                // $(".sp3").show()
                // $(".fp3").hide()
            });
        });
    </script>
@endsection

@section('footer_sub')
@endsection

@section('contents')
    <div class="content_title">
        <div class="inner">
            <h1>チーム</h1>
        </div><!-- /.inner -->
    </div><!-- /.content_title -->
    
    <div class="bc">
        <span><a href="{{route('front.index')}}">TOP</a></span>
        <span><a href="{{route('front.team.index')}}">チーム</a></span>
    </div><!-- /.bc -->

    <main class="content">
    
    <div class="league_list">
        <div class="inner">
            <ul>
                {{-- <li><a href="#1">九州</a></li>
                <li><a href="#2">関西</a></li> --}}
                {{-- <li><a href="#3">3部</a></li> --}}
                @foreach($groups as $group)
                    <li><a href="#{{ $group->id }}">{{ $group->name }}</a></li>
                @endforeach
            </ul>
        </div><!-- /.inner -->
    </div><!-- /.league_type -->
    
    <div class="inner">
        <div class="main">

        <article>
            <div id="team">
                <div class="inner">
                            {{--                        @if($_SERVER['REMOTE_ADDR']=='116.94.0.103')--}}
                            {{--                        @foreach(range(1,3) as $group)--}}
                            {{--                            <div id="{{$group}}"></div>--}}
                            {{--                            <h2>{{$group}}部</h2>--}}
                            {{--                            <div class="head">--}}
                            {{--                                <div class="title">参加チーム数</div>--}}
                            {{--                                <div class="number">全<span>{{count($groups[1])}}</span>チーム</div>--}}
                            {{--                            </div><!-- /.head -->--}}

                            {{--                            <div class="row">--}}
                            {{--                                @foreach($teams[1] as $team)--}}
                            {{--                                    <div class="col">--}}
                            {{--                                        <div class="img">--}}
                            {{--                                            @if(!empty($team->group_img))--}}
                            {{--                                                <img src="/upload/300/{{$team->group_img}}">--}}
                            {{--                                            @else--}}
                            {{--                                                <img src="/img/common/dammy_img_team.png">--}}
                            {{--                                            @endif--}}
                            {{--                                        </div><!-- /.img -->--}}
                            {{--                                        <h2>{{$team->name}}</h2>--}}
                            {{--                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>--}}
                            {{--                                    </div><!-- /.col -->--}}
                            {{--                                @endforeach--}}
                            {{--                            </div><!-- /.row -->--}}
                            {{--                        @endforeach--}}
                            {{--                        @endif--}}

                    @foreach($groups as $group)
                        <div id="{{ $group->id }}"></div><br>
                        <h2>{{ $group->name }}</h2>

                        <div class="head">
                            <div class="title">参加チーム数</div>
                            <div class="number">全<span>{{count($teams[$group->id])}}</span>チーム</div>
                        </div><!-- /.head -->

                        <div class="row">
                            @foreach($teams[$group->id] as $team)
                                <div class="col">
                                    <div class="img">
                                        @if(!empty($team->group_img))
                                            <img src="/upload/300/{{$team->group_img}}">
                                        @else
                                            <img src="/img/common/dammy_img_team.png">
                                        @endif
                                    </div><!-- /.img -->
                                    <h2>{{$team->name}}</h2>
                                    <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                </div><!-- /.col -->
                            @endforeach
                        </div><!-- /.row -->
                    @endforeach
                        
                        {{-- <div id="2"></div>
                        <h2>関西</h2>

                        <div class="head">
                            <div class="title">参加チーム数</div>
                            <div class="number">全<span>{{count($teams[2])}}</span>チーム</div>
                        </div><!-- /.head --> --}}

                        {{-- <div class="part_list">
                            <div class="inner">
                                <ul>
                                    <li><a href="#a_p2">2部A</a></li>
                                    <li><a href="#b_p2">2部B</a></li>
                                    @if(config('app.nendo')==2020)
                                    <li><a href="#c_p2">2部C</a></li>
                                    <li><a href="#d_p2">2部D</a></li>
                                    @endif
                                </ul>
                            </div><!-- /.inner -->
                        </div><!-- /.part_list --> --}}

                        {{-- <div id="a_p2" class="row">
                            <h2>2部A</h2>
                            @foreach($teams[2] as $team)
                                <div class="col">
                                    <div class="img">
                                        @if(!empty($team->group_img))
                                            <img src="/upload/300/{{$team->group_img}}">
                                        @else
                                            <img src="/img/common/dammy_img_team.png">
                                        @endif
                                    </div><!-- /.img -->
                                    <h2>{{$team->name}}</h2>
                                    <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                </div><!-- /.col -->
                            @endforeach
                        </div><!-- /.row --> --}}

                        {{-- <div id="b_p2" class="row">
                            <h2>2部B</h2>
                            @foreach($teams['2B'] as $team)
                            <div class="col">
                                <div class="img">
                                    @if(!empty($team->group_img))
                                        <img src="/upload/300/{{$team->group_img}}">
                                    @else
                                        <img src="/img/common/dammy_img_team.png">
                                    @endif
                                </div><!-- /.img -->
                                <h2>{{$team->name}}</h2>
                                <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                            </div><!-- /.col -->
                            @endforeach                            
                        </div><!-- /.row -->

                        @if(config('app.nendo')==2020)
                        <div id="c_p2" class="row">
                            <h2>2部C</h2>
                            @foreach($teams['2C'] as $team)
                                <div class="col">
                                    <div class="img">
                                        @if(!empty($team->group_img))
                                            <img src="/upload/300/{{$team->group_img}}">
                                        @else
                                            <img src="/img/common/dammy_img_team.png">
                                        @endif
                                    </div><!-- /.img -->
                                    <h2>{{$team->name}}</h2>
                                    <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                </div><!-- /.col -->
                            @endforeach
                        </div><!-- /.row -->

                        <div id="d_p2" class="row">
                            <h2>2部D</h2>
                            @foreach($teams['2D'] as $team)
                                <div class="col">
                                    <div class="img">
                                        @if(!empty($team->group_img))
                                            <img src="/upload/300/{{$team->group_img}}">
                                        @else
                                            <img src="/img/common/dammy_img_team.png">
                                        @endif
                                    </div><!-- /.img -->
                                    <h2>{{$team->name}}</h2>
                                    <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                </div><!-- /.col -->
                            @endforeach
                        </div><!-- /.row -->
                        @endif

                        <div id="3"></div>
                        <h2>3部</h2>

                        <div class="head">
                            <div class="title">参加チーム数</div>
                            <div class="number">全<span>{{count($groups[3])}}</span>チーム</div>
                        </div><!-- /.head -->

                        <div class="period_list">
                            <div class="inner">
                                <ul>
                                    <li id="g31_on" class="{{($period=='first')?'on':''}}"><a class="group3_first" href="{{route('front.team.index',['period'=>'first'])}}#3">前　期</a></li>
                                    <li id="g32_on" class="{{($period=='second')?'on':''}}"><a class="group3_second" href="{{route('front.team.index',['period'=>'second'])}}#3">後　期</a></li>
                                </ul>
                            </div><!-- /.inner -->
                        </div><!-- /.period_list -->

                        <div class="part_list" id="group31" style="{{($period=='first')?'':'display:none'}}">
                            <div class="inner">
                                <ul> --}}
                                    {{-- TODO:ここに、３部の場合の前期・後期の表示変更も対応する必要あり--}}
                                    {{-- <li><a href="#a_p3">3部A</a></li>
                                    <li><a href="#b_p3">3部B</a></li>
                                    <li><a href="#c_p3">3部C</a></li>
                                    <li><a href="#d_p3">3部D</a></li>
                                    <li><a href="#e_p3">3部E</a></li>
                                    <li><a href="#f_p3">3部F</a></li>
                                    <li><a href="#g_p3">3部G</a></li>
                                    <li><a href="#h_p3">3部H</a></li>
                                    @if(config('app.nendo')!=2020)
                                    <li><a href="#i_p3">3部I</a></li>
                                    @endif
                                    @if(config('app.nendo')==2022)
                                        <li><a href="#j_p3">3部J</a></li>
                                    @endif
                                </ul>
                            </div><!-- /.inner -->
                        </div><!-- /.part_list -->

                        <div class="part_list" id="group32" style="{{($period=='second')?'':'display:none'}}">
                            <div class="inner">
                                <ul> --}}
                                    {{-- TODO:ここに、３部の場合の前期・後期の表示変更も対応する必要あり--}}
                                    {{-- <li><a href="#f_3a">上位A</a></li>
                                    <li><a href="#f_3b">上位B</a></li>
                                    <li><a href="#f_3c">上位C</a></li>
                                    <li><a href="#f_3d">上位D</a></li>
                                    <li><a href="#f_3e">上位E</a></li>
                                    <li><a href="#f_3f">上位F</a></li>
                                    <li><a href="#s_3a">下位A</a></li>
                                    <li><a href="#s_3b">下位B</a></li>
                                    <li><a href="#s_3c">下位C</a></li>
                                    <li><a href="#s_3d">下位D</a></li>
                                    <li><a href="#s_3e">下位E</a></li>
                                    <li><a href="#s_3f">下位F</a></li>
                                </ul>
                            </div><!-- /.inner -->
                        </div><!-- /.part_list -->

                        @if($period=='first')
                        <div class="fp3">
                            <div id="a_p3" class="row">
                                <h2>3部A</h2>
                                @foreach($teams['3A'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="b_p3" class="row">
                                <h2>3部B</h2>
                                @foreach($teams['3B'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="c_p3" class="row">
                                <h2>3部C</h2>
                                @foreach($teams['3C'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="d_p3" class="row">
                                <h2>3部D</h2>
                                @foreach($teams['3D'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="e_p3" class="row">
                                <h2>3部E</h2>
                                @foreach($teams['3E'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="f_p3" class="row">
                                <h2>3部F</h2>
                                @foreach($teams['3F'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="g_p3" class="row">
                                <h2>3部G</h2>
                                @foreach($teams['3G'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="h_p3" class="row">
                                <h2>3部H</h2>
                                @foreach($teams['3H'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            @if(config('app.nendo')!=2020)
                            <div id="i_p3" class="row">
                                <h2>3部I</h2>
                                @foreach($teams['3I'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->
                            @endif

                            @if(config('app.nendo')==2022)
                                <div id="j_p3" class="row">
                                    <h2>3部J</h2>
                                    @foreach($teams['3J'] as $team)
                                        <div class="col">
                                            <div class="img">
                                                @if(!empty($team->group_img))
                                                    <img src="/upload/300/{{$team->group_img}}">
                                                @else
                                                    <img src="/img/common/dammy_img_team.png">
                                                @endif
                                            </div><!-- /.img -->
                                            <h2>{{$team->name}}</h2>
                                            <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                        </div><!-- /.col -->
                                    @endforeach
                                </div><!-- /.row -->
                            @endif

                        </div>
                        @else
                        <div class="sp3">
                            <div id="f_3a" class="row">
                                <h2>上位A</h2>
                                @foreach($teams['3FA'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="f_3b" class="row">
                                <h2>上位B</h2>
                                @foreach($teams['3FB'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="f_3c" class="row">
                                <h2>上位C</h2>
                                @foreach($teams['3FC'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="f_3d" class="row">
                                <h2>上位D</h2>
                                @foreach($teams['3FD'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="f_3e" class="row">
                                <h2>上位E</h2>
                                @foreach($teams['3FE'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="f_3f" class="row">
                                <h2>上位F</h2>
                                @foreach($teams['3FF'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="s_3a" class="row">
                                <h2>下位A</h2>
                                @foreach($teams['3SA'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="s_3b" class="row">
                                <h2>下位B</h2>
                                @foreach($teams['3SB'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="s_3c" class="row">
                                <h2>下位C</h2>
                                @foreach($teams['3SC'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="s_3d" class="row">
                                <h2>下位D</h2>
                                @foreach($teams['3SD'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="s_3e" class="row">
                                <h2>下位E</h2>
                                @foreach($teams['3SE'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                            <div id="s_3f" class="row">
                                <h2>下位F</h2>
                                @foreach($teams['3SF'] as $team)
                                    <div class="col">
                                        <div class="img">
                                            @if(!empty($team->group_img))
                                                <img src="/upload/300/{{$team->group_img}}">
                                            @else
                                                <img src="/img/common/dammy_img_team.png">
                                            @endif
                                        </div><!-- /.img -->
                                        <h2>{{$team->name}}</h2>
                                        <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>
                                    </div><!-- /.col -->
                                @endforeach
                            </div><!-- /.row -->

                        </div>
                        @endif --}}

                        
{{--                        <div id="i_p3" class="row">--}}
{{--                            <h2>3部I</h2>--}}
{{--                            @foreach($teams['3I'] as $team)--}}
{{--                            <div class="col">--}}
{{--                                <div class="img">--}}
{{--                                    <img src="/img/common/dammy_img_team.png">--}}
{{--                                </div><!-- /.img -->--}}
{{--                                <h2>{{$team->name}}</h2>--}}
{{--                                <a href="{{route('front.team.show',['id'=>$team->id])}}"></a>--}}
{{--                            </div><!-- /.col -->--}}
{{--                            @endforeach--}}
{{--                        </div><!-- /.row -->--}}
                   
                    </div><!-- /.inner -->
                </div>

        </article>

        </div><!-- /.main -->

		@include('front.parts.side')
	
	</div><!-- /.inner -->
	</main>
@stop

