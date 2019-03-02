@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>こんにちは {{$first_name}}</p>
<p>
    {{config（ 'attendize.app_name'）}}に登録していただきありがとうございます。登録していただきとても嬉しいです。
</p>

<p>
    あなたは最初のイベントを作成し、下記のリンクを使ってあなたのメールアドレスを確認することができます。
</p>

<div style="padding: 5px; border: 1px solid #ccc;">
   {{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}
</div>
<br><br>
<p>
    ご質問、ご意見、ご提案がありましたら、このメールにお気軽にお問い合わせください。
</p>
<p>
    ありがとう
</p>

@stop

@section('footer')


@stop
