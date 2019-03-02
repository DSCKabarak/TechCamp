@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>こんにちは</p>
<p>
    You have been added to an {{ config('attendize.app_name') }} account by {{$inviter->first_name.' '.$inviter->last_name}}.
</p>

<p>
    以下の詳細を使用してログインできます。<br><br>
    
    Username: <b>{{$user->email}}</b> <br>
    Password: <b>{{$temp_password}}</b>
</p>

<p>
    ログイン後、一時パスワードを変更することができます。
</p>

<div style="padding: 5px; border: 1px solid #ccc;" >
   {{route('login')}}
</div>
<br><br>
<p>
    ご質問がある場合は、このメールに返信してください。
</p>
<p>
    ありがとう
</p>

@stop

@section('footer')


@stop
