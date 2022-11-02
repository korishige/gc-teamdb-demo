@extends('layouts.front',['page_title'=>'個人情報保護方針｜'.env('title')])

@section('css')
<link href="css/contents.css" rel="stylesheet" type="text/css" />
@endsection

@section('footer_sub')
@endsection

@section('contents')
    <div class="content_title">
        <div class="inner">
            <h1>個人情報保護方針</h1>
        </div><!-- /.inner -->
    </div><!-- /.content_title -->
    
    <div class="bc">
        <span><a href="{{route('front.index')}}">TOP</a></span>
        <span><a href="{{route('front.personal')}}">個人情報保護方針</a></span>
    </div><!-- /.bc -->

    <main class="content">
    
    <div class="inner">
        <div class="main">

        <article>
            <div id="terms">
                <div class="inner">

                    <div class="txt">
                        BlueWave sports concierge officeより委託され、BlueWave U-17リーグ～Boost～公式ウェブサイトを運営する株式会社グリーンカード（以下「当社」と称します。）は、次の各項所定の基本方針に基づき個人情報を適切に取得、管理、利用し、個人情報保護法その他の関連法令の理念に則った個人情報の保護を徹底するため、以下の取り組みを実施致します。
                    </div><!-- /.txt -->

                    <h2 class="bar">
                        1.取得に関する基本方針
                    </h2>
                    
                    当社は、適法且つ適正な手段により利用目的を開示して本人その他の開示権限のある者から個人情報を取得します。
                    
                    <h2 class="bar">
                        2.管理に関する基本方針
                    </h2>
                    
                    当社は、個人情報への不正アクセス、個人情報の紛失、破壊、改ざん及び漏えい等のあるまじき事態を防止するための適法且つ適正な措置を講じて個人情報を管理します。
                    
                    <h2 class="bar">
                        3.利用に関する基本方針
                    </h2>
                    
                    当社は、取得時に開示された利用目的の範囲内で適法且つ適正な手段により個人情報を利用します。
                    
                    <h2 class="bar">
                        3.利用に関する基本方針
                    </h2>
                    
                    当社は、取得時に開示された利用目的の範囲内で適法且つ適正な手段により個人情報を利用します。
                    
                    <h2 class="bar">
                        4.取扱委託に関する基本方針
                    </h2>
                    
                    当社は、個人情報を取り扱う業務を第三者に委託する場合には、本協会の安全管理措置に準じる個人情報の安全管理措置を講じている第三者を選択し、委託後も適法且つ適正な手段により委託先の監督を行います。
                    
                    <h2 class="bar">
                        5.第三者への提供に関する基本方針
                    </h2>
                    
                    当社は、個人情報保護法その他の関連法令上認められる場合を除き、本人の同意なく第三者に個人情報を提供しません。
                    
                    <h2 class="bar">
                        6.消去に関する基本方針
                    </h2>
                    
                    当社は、個人情報を利用する必要がなくなったときは、個人情報を遅滞なく消去するよう努めます。
                    
                    <h2 class="bar">
                        7.本人の権利確保に関する基本方針
                    </h2>
                    
                    当社は、本人から請求があった場合には、その請求に従い、適法且つ適正な手段により個人情報の開示、訂正、追加若しくは削除、利用停止、消去若しくは第三者に対する提供停止を個人情報保護法の規定に従って実施します。
                    
                    <div class="sign">
                        2021年4月1日　高円宮杯 JFA U-18 サッカーリーグ 2021 福岡
                    </div><!-- /.bottom -->
               
                </div><!-- /.inner -->
            </div>
        </article>

        </div><!-- /.main -->

		@include('front.parts.side')
	
	</div><!-- /.inner -->
	</main>
@stop

