{{$email}} 様

お世話になります。「{{config('mail.from.name')}}管理人」です。

以下のURLをクリックすると、アカウントが承認されます。

{{config('app.url')}}authorize?email={{urlencode($email)}}&token={{$token}}

ご不明な点がございましたらなんなりとご連絡ください。

================================
【{{config('mail.from.name')}}】運営事務局
Email : {{config('mail.from.address')}}
Web : {{config('app.url')}}
================================