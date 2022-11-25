<?php

return [

    //'debug' => array_key_exists('REMOTE_ADDR', $_SERVER)?in_array($_SERVER['REMOTE_ADDR'], array('116.94.0.103','212.102.50.151','113.42.82.26')):false,
    'debug' => true,

    //	'nendo' => date('Y', strtotime('-4 month')),
    'nendo' => 2022,
    'nendo_backend' => 2022,
    'user_reg_nendo' => date('Y'),    # ユーザ登録された年で一旦登録する

    'period' => (date('md') >= '1001' or date('md') <= '0320') ? 'second' : 'first',

    'title' => env('TITLE'),

    'url' => env('URL'),
    'fqdn' => env('FQDN'),
    'aspver' => 'ダッシュボード',
    'aspnameK' => 'ダッシュボード',
    'aspname' => 'ffa',
    'version' => '0.1',
    'copy' => '&copy; 2015- ALE.',

    'sortAry' => ['new' => '新着', 'pv' => '表示回数'],

    'conventionAry' => ['boost', '熱冬', '蹴道'],
    'convention' => 1,
    'conventionArea' => ['5' => '九州', '6' => '関西', '4' => '中四国'],

    'ageAry' => [
        'U-6' => 'U-6(園児)', 'U-7' => 'U-7(小学1年)', 'U-8' => 'U-8(小学2年)', 'U-9' => 'U-9(小学3年)', 'U-10' => 'U-10(小学4年)', 'U-11' => 'U-11(小学5年)', 'U-12' => 'U-12(小学6年)',
        'U-13' => 'U-13(中学1年)', 'U-14' => 'U-14(中学2年)', 'U-15' => 'U-15(中学3年)',
        'U-18' => '高校生', 'U-22' => '大学生', 'society' => '社会人'
    ],

    'genreAry' => ['soccer' => 'サッカー', 'futsal' => 'フットサル'],

    'cardsAry' => ['yellow' => '警告', 'red' => '退場'],
    'seasonAry' => ['1st stage', '2nd stage', '通年', ''],
    'positionAry' => ['GK', 'DF', 'MF', 'FW'],
    'pivotAry' => ['右足', '左足'],
    'pivotAlphabetAry' => ['R', 'L'],
    'is_publish' => ['未公開', '公開', '延期', '未定'],
    'is_filled' => ['結果未記入', '結果記入済'],
    'is_block' => ['非ブロック選手', 'ブロック選手'],
    //	'schoolYearAry' => [1=>'高校１年生',2=>'高校２年生',3=>'高校３年生',11=>'中学１年生',12=>'中学２年生',13=>'中学３年生'],
    'schoolYearAry' => [3 => '高校３年', 2 => '高校２年', 1 => '高校１年', 13 => '中学３年', 12 => '中学２年', 11 => '中学１年'] + [2020 => '2020年度OB', 2021 => '2021年度OB', 2022 => '2022年度OB'],

    'is_wanted' => [0 => '募集停止中', 1 => '募集中'],
    'sexAry' => [0 => '男性', 1 => '女性'],
    'RAry' => ['success', 'info', 'warning', 'danger'],

    'levelAry' => ['超初心者', '初心者', '普通', 'そこそこ', '競技レベル'],
    'ageType' => ['幼児', '小学生', '中学生', '高校生', '大学生以上'],

    'prefAry' => [
        1 => '北海道',
        2 => '青森県', 3 => '岩手県', 4 => '宮城県', 5 => '秋田県', 6 => '山形県', 7 => '福島県',
        8 => '茨城県', 9 => '栃木県', 10 => '群馬県', 11 => '埼玉県', 12 => '千葉県', 13 => '東京都', 14 => '神奈川県',
        15 => '新潟県', 16 => '富山県', 17 => '石川県', 18 => '福井県',
        19 => '山梨県', 20 => '長野県', 21 => '岐阜県', 22 => '静岡県', 23 => '愛知県', 24 => '三重県',
        25 => '滋賀県', 26 => '京都府', 27 => '大阪府', 28 => '兵庫県', 29 => '奈良県', 30 => '和歌山県',
        31 => '鳥取県', 32 => '島根県', 33 => '岡山県', 34 => '広島県', 35 => '山口県',
        36 => '徳島県', 37 => '香川県', 38 => '愛媛県', 39 => '高知県',
        40 => '福岡県', 41 => '佐賀県', 42 => '長崎県', 43 => '熊本県', 44 => '大分県', 45 => '宮崎県', 46 => '鹿児島県', 47 => '沖縄県'
    ],

    // first half / second half
    'matchTimeAry' => [
        '前半 1分', '前半 2分', '前半 3分', '前半 4分', '前半 5分', '前半 6分', '前半 7分', '前半 8分', '前半 9分', '前半 10分',
        '前半 11分', '前半 12分', '前半 13分', '前半 14分', '前半 15分', '前半 16分', '前半 17分', '前半 18分', '前半 19分', '前半 20分',
        '前半 21分', '前半 22分', '前半 23分', '前半 24分', '前半 25分', '前半 26分', '前半 27分', '前半 28分', '前半 29分', '前半 30分',
        '前半 31分', '前半 32分', '前半 33分', '前半 34分', '前半 35分', '前半 36分', '前半 37分', '前半 38分', '前半 39分', '前半 40分',
        '前半 41分', '前半 42分', '前半 43分', '前半 44分', '前半 45分', '前半AT 1分', '前半AT 2分', '前半AT 3分', '前半AT 4分', '前半AT 5分',
        '後半 1分', '後半 2分', '後半 3分', '後半 4分', '後半 5分', '後半 6分', '後半 7分', '後半 8分', '後半 9分', '後半 10分',
        '後半 11分', '後半 12分', '後半 13分', '後半 14分', '後半 15分', '後半 16分', '後半 17分', '後半 18分', '後半 19分', '後半 20分',
        '後半 21分', '後半 22分', '後半 23分', '後半 24分', '後半 25分', '後半 26分', '後半 27分', '後半 28分', '後半 29分', '後半 30分',
        '後半 31分', '後半 32分', '後半 33分', '後半 34分', '後半 35分', '後半 36分', '後半 37分', '後半 38分', '後半 39分', '後半 40分',
        '後半 41分', '後半 42分', '後半 43分', '後半 44分', '後半 45分', '後半AT 1分', '後半AT 2分', '後半AT 3分', '後半AT 4分', '後半AT 5分',
    ],
    // 'matchTimeAry' => [
    //     '前半 1分'=>'前半 1分', '前半 2分'=>'前半 2分', '前半 3分'=>'前半 3分', '前半 4分'=>'前半 4分', '前半 5分'=>'前半 5分', '前半 6分'=>'前半 6分', '前半 7分'=>'前半 7分', '前半 8分'=>'前半 8分', '前半 9分'=>'前半 9分', '前半 10分'=>'前半 10分', '前半 11分'=>'前半 11分', '前半 12分'=>'前半 12分', '前半 13分'=>'前半 13分', '前半 14分'=>'前半 14分', '前半 15分'=>'前半 15分', '前半 16分'=>'前半 16分', '前半 17分'=>'前半 17分', '前半 18分'=>'前半 18分', '前半 19分'=>'前半 19分', '前半 20分'=>'前半 20分', '前半 21分'=>'前半 21分', '前半 22分'=>'前半 22分', '前半 23分'=>'前半 23分', '前半 24分'=>'前半 24分', '前半 25分'=>'前半 25分', '前半 26分'=>'前半 26分', '前半 27分'=>'前半 27分', '前半 28分'=>'前半 28分', '前半 29分'=>'前半 29分', '前半 30分'=>'前半 30分', '前半 31分'=>'前半 31分', '前半 32分'=>'前半 32分', '前半 33分'=>'前半 33分', '前半 34分'=>'前半 34分', '前半 35分'=>'前半 35分', '前半 36分'=>'前半 36分', '前半 37分'=>'前半 37分', '前半 38分'=>'前半 38分', '前半 39分'=>'前半 39分', '前半 40分'=>'前半 40分', '前半 41分'=>'前半 41分', '前半 42分'=>'前半 42分', '前半 43分'=>'前半 43分', '前半 44分'=>'前半 44分', '前半 45分'=>'前半 45分', '前半AT 1分'=>'前半AT 1分', '前半AT 2分'=>'前半AT 2分', '前半AT 3分'=>'前半AT 3分', '前半AT 4分'=>'前半AT 4分', '前半AT 5分'=>'前半AT 5分',
    //     '後半 1分'=>'後半 1分', '後半 2分'=>'後半 2分', '後半 3分'=>'後半 3分', '後半 4分'=>'後半 4分', '後半 5分'=>'後半 5分', '後半 6分'=>'後半 6分', '後半 7分'=>'後半 7分', '後半 8分'=>'後半 8分', '後半 9分'=>'後半 9分', '後半 10分'=>'後半 10分', '後半 11分'=>'後半 11分', '後半 12分'=>'後半 12分', '後半 13分'=>'後半 13分', '後半 14分'=>'後半 14分', '後半 15分'=>'後半 15分', '後半 16分'=>'後半 16分', '後半 17分'=>'後半 17分', '後半 18分'=>'後半 18分', '後半 19分'=>'後半 19分', '後半 20分'=>'後半 20分', '後半 21分'=>'後半 21分', '後半 22分'=>'後半 22分', '後半 23分'=>'後半 23分', '後半 24分'=>'後半 24分', '後半 25分'=>'後半 25分', '後半 26分'=>'後半 26分', '後半 27分'=>'後半 27分', '後半 28分'=>'後半 28分', '後半 29分'=>'後半 29分', '後半 30分'=>'後半 30分', '後半 31分'=>'後半 31分', '後半 32分'=>'後半 32分', '後半 33分'=>'後半 33分', '後半 34分'=>'後半 34分', '後半 35分'=>'後半 35分', '後半 36分'=>'後半 36分', '後半 37分'=>'後半 37分', '後半 38分'=>'後半 38分', '後半 39分'=>'後半 39分', '後半 40分'=>'後半 40分', '後半 41分'=>'後半 41分', '後半 42分'=>'後半 42分', '後半 43分'=>'後半 43分', '後半 44分'=>'後半 44分', '後半 45分'=>'後半 45分', '後半AT 1分'=>'後半AT 1分', '後半AT 2分'=>'後半AT 2分', '後半AT 3分'=>'後半AT 3分', '後半AT 4分'=>'後半AT 4分', '後半AT 5分'=>'後半AT 5分',
    // ],

    'week' => ['日', '月', '火', '水', '木', '金', '土'],

    'timezone' => 'Asia/Tokyo',
    'locale' => 'ja',
    'fallback_locale' => 'en',
    'key' => env('APP_KEY', 'SomeRandomString'),

    'cipher' => 'AES-256-CBC',
    'log' => 'single',
    'providers' => [
        Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Routing\ControllerServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\MacroServiceProvider::class,

        Collective\Html\HtmlServiceProvider::class,
        Barryvdh\Debugbar\ServiceProvider::class,
        Laravel\Socialite\SocialiteServiceProvider::class,

        Intervention\Image\ImageServiceProvider::class,
        Flynsarmy\DbBladeCompiler\DbBladeCompilerServiceProvider::class,
    ],

    'aliases' => [

        'App'       => Illuminate\Support\Facades\App::class,
        'Artisan'   => Illuminate\Support\Facades\Artisan::class,
        'Auth'      => Illuminate\Support\Facades\Auth::class,
        'Blade'     => Illuminate\Support\Facades\Blade::class,
        'Bus'       => Illuminate\Support\Facades\Bus::class,
        'Cache'     => Illuminate\Support\Facades\Cache::class,
        'Config'    => Illuminate\Support\Facades\Config::class,
        'Cookie'    => Illuminate\Support\Facades\Cookie::class,
        'Crypt'     => Illuminate\Support\Facades\Crypt::class,
        'DB'        => Illuminate\Support\Facades\DB::class,
        'Eloquent'  => Illuminate\Database\Eloquent\Model::class,
        'Event'     => Illuminate\Support\Facades\Event::class,
        'File'      => Illuminate\Support\Facades\File::class,
        'Gate'      => Illuminate\Support\Facades\Gate::class,
        'Hash'      => Illuminate\Support\Facades\Hash::class,
        'Input'     => Illuminate\Support\Facades\Input::class,
        'Inspiring' => Illuminate\Foundation\Inspiring::class,
        'Lang'      => Illuminate\Support\Facades\Lang::class,
        'Log'       => Illuminate\Support\Facades\Log::class,
        'Mail'      => Illuminate\Support\Facades\Mail::class,
        'Password'  => Illuminate\Support\Facades\Password::class,
        'Queue'     => Illuminate\Support\Facades\Queue::class,
        'Redirect'  => Illuminate\Support\Facades\Redirect::class,
        'Redis'     => Illuminate\Support\Facades\Redis::class,
        'Request'   => Illuminate\Support\Facades\Request::class,
        'Response'  => Illuminate\Support\Facades\Response::class,
        'Route'     => Illuminate\Support\Facades\Route::class,
        'Schema'    => Illuminate\Support\Facades\Schema::class,
        'Session'   => Illuminate\Support\Facades\Session::class,
        'Storage'   => Illuminate\Support\Facades\Storage::class,
        'URL'       => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View'      => Illuminate\Support\Facades\View::class,
        'Form' => Collective\Html\FormFacade::class,
        'Html' => Collective\Html\HtmlFacade::class,
        'Debugbar' => Barryvdh\Debugbar\Facade::class,
        'Socialite' => Laravel\Socialite\Facades\Socialite::class,
        'Image' => Intervention\Image\Facades\Image::class,
        'DbView' => Flynsarmy\DbBladeCompiler\Facades\DbView::class,

    ],

];
