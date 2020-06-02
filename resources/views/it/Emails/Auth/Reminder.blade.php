@extends('en.Emails.Layouts.Master')

@section('message_content')
    <div>
        Ciao,<br><br>
        per resettare la tua password, compila questo form: {{ route('password.reset', ['token' => $token]) }}.
        <br><br><br>
        Grazie,<br>
        Team Attendize
    </div>
@stop