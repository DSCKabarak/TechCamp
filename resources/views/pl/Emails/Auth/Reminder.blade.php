@extends('en.Emails.Layouts.Master')

@section('message_content')
    <div>
        Witaj,<br><br>
        aby zresetować hasło, wypełnij ten formularz: {{ route('showResetPassword', ['token' => $token]) }}.
        <br><br><br>
        Dziękujemy,<br>
        Zespół Attendize.
    </div>
@stop