お世話になります。「{{env('MAIL_FROM_NAME')}}管理人」です。

運営事務局よりお知らせがあります。

---
<?php
print($body);
?>
---

ご不明な点がございましたらなんなりとご連絡ください。

================================
【{{config('mail.from.name')}}】運営事務局
Email : {{config('mail.from.address')}}
Web : {{config('app.url')}}
================================