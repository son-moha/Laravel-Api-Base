@extends('core::_email.text.layout')
@section('content')
{{ $name }} 様

「LINEワクチン接種予約システム」にログインしました。
ログインID：{{ $email }}
IPアドレス：{{ $requestIp }}
ログイン日時：{{ $time }}

このメールは送信専用のため、ご返信はできません。

===
株式会社コネクター・ジャパン
サポート時間：平日10:00~18:00
TEL：050-5050-0309
メールアドレス：govtech@cnctor.jp
（土日祝日・GW・年末年始を除く）
@endsection
