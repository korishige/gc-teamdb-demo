# composer
https://github.com/Flynsarmy/laravel-db-blade-compiler

composer require flynsarmy/db-blade-compiler:2.*

php -d memory_limit=-1 /usr/local/bin/composer require flynsarmy/db-blade-compiler:2.*

php artisan vendor:publish --provider="Flynsarmy\DbBladeCompiler\DbBladeCompilerServiceProvider"

php -d memory_limit=-1 /usr/local/bin/composer update

# 参考サイト
https://qiita.com/kngsym2018/items/514bf738ce1c6a1c81ba

## summernote module
https://summernote.org/deep-dive/#range--selection-api

### Laravel + summernote
https://niwacan.com/1607-summernote-php/
http://ffa.tkss.xyz/admin/team/edit/1

## アップロードできる拡張子制限
https://webbibouroku.com/Blog/Article/html5-file-accept

summernote.min.js を変更

https://unisharp.github.io/laravel-filemanager/integration

https://sharediary.net/2019/04/17/laravel-filemanager-%E5%B0%8E%E5%85%A5/
https://reffect.co.jp/laravel/how_to_upload_file_in_laravel

https://www.webopixel.net/php/1264.html

https://github.com/jeroennoten/laravel-ckeditor

https://github.com/summernote/awesome-summernote#connectors

### upsert
#### https://awesome-linus.com/2019/07/03/laravel-upsert/
##### Eloquent @ updateOrCreate
##### クエリビルダ @ updateOrInsert

User::updateOrCreate(
    ['user_id' => 1001],
    ['name' => 'Takeru', 'age' => 33]
);

### laravel5.1で、複数ファイルをアップロードしてダウンロードするやり方を調べてみた(日本語ファイル名対応済)
https://www.messiahworks.com/archives/10621

### validator
https://qiita.com/fagai/items/9904409d3703ef6f79a2


# リーグ戦
https://stackoverflow.com/questions/31983330/mysql-league-table
https://okwave.jp/qa/q8262903.html
https://oshiete.goo.ne.jp/qa/7734853.html

# bootstrap
## レスポンシブ対応
https://www.alt-plus.jp/archives/1648