@extends('es.Emails.Layouts.Master')

@section('message_content')
    <div>
        Hola,<br><br>
        Para restablecer tu contraseña, completa este formulario: {{ route('password.reset', ['token' => $token]) }}.
        <br><br><br>
        Gracias, <br>
        El equipo de Attendize
    </div>
@stop