お世話になります。「{{env('MAIL_FROM_NAME')}}管理人」です。<br>
<br>
運営事務局よりお知らせがあります。<br>
<br>
---<br>
<?php
print($body);
?>
---<br>
<br>
ご不明な点がございましたらなんなりとご連絡ください。<br>
<br>
<pre>
================================
【{{config('mail.from.name')}}】運営事務局
Email : {{config('mail.from.address')}}
Web : {{config('app.url')}}
================================
</pre>