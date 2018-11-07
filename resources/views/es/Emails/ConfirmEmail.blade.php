@extends('es.Emails.Layouts.Master')

@section('message_content')

    <p>Hola {{$first_name}}</p>
    <p>
        Gracias por registrarse en {{ config('attendize.app_name') }}. Estamos encantados de tenerte con nosotros.
    </p>

    <p>
        Puedes crear tu primer evento y confirmar tu correo electrónico usando el siguiente enlace.
    </p>

    <div style="padding: 5px; border: 1px solid #ccc;">
        {{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}
    </div>
    <br><br>
    <p>
        Si tiene alguna pregunta, comentario o sugerencia, no dude en responder a este correo electrónico.
    </p>
    <p>
        Gracias
    </p>

@stop

@section('footer')


@stop
