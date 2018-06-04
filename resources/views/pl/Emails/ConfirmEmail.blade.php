@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Hi {{$first_name}}</p>
<p>
    Dziękujemy, że zechciałeś się zarejestrować do {{ config('attendize.app_name') }}. Jest nam miło, że chcesz z nami współpracować.
</p>

<p>
    Możesz utworzyć pierwsze wydarzenie klikając link poniżej, przy okazji potwierdzisz własność tego adresu email.
</p>

<div style="padding: 5px; border: 1px solid #ccc;">
   {{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}
</div>
<br><br>
<p>
    Jeżeli masz jakieś pytania, sugestie, odpisz na tego emaila.
</p>
<p>
    Dziękujemy.
</p>

@stop

@section('footer')


@stop
