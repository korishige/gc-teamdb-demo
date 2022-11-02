{{$email_new}} 様

お世話になります。「{{env('MAIL_FROM_NAME')}}管理人」です。

メールアドレス変更のご依頼をお受けしました。  

以下のURLをクリックすると、メールアドレス変更が承認されます。

{{env('URL')}}email_update?token={{$token}}

ご不明な点がございましたらなんなりとご連絡ください。

================================
【{{config('mail.from.name')}}】運営事務局
Email : {{config('mail.from.address')}}
Web : {{config('app.url')}}
================================