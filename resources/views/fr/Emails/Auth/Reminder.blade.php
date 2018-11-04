@extends('en.Emails.Layouts.Master')

@section('message_content')
    <div>
        Bonjour,<br><br>
        Pour réinitialiser votre mot de passe, remplissez ce formulaire : {{ route('showResetPassword', ['token' => $token]) }}.
        <br><br><br>
        Merci,<br>
        L'équipe Attendize
    </div>
@stop
