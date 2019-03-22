@extends('en.Emails.Layouts.Master')

@section('message_content')
    <div>
        こんにちは、<br><br>
        パスワードを再設定するには、次の形式で入力してください: {{ route('password.reset', ['token' => $token]) }}.
        <br><br><br>
        ありがとう、<br>
        Team Attendize
    </div>
@stop