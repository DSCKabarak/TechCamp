@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Bonjour {{$first_name}}</p>
<p>
    Merci de vous être enregistré à {{ config('attendize.app_name') }}. Nous sommes ravis de vous compter parmi nous.
</p>

<p>
    Vous pouvez créer votre premier événement et confirmer votre courriel avec le lien ci-dessous.
</p>

<div style="padding: 5px; border: 1px solid #ccc;">
   {{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}
</div>
<br><br>
<p>
    Si vous avez des questions, des retours ou des suggestions, vous pouvez répondre à ce message.
</p>
<p>
    Merci
</p>

@stop

@section('footer')


@stop
