@extends('es.Emails.Layouts.Master')

@section('message_content')

    <p>Hola</p>
    <p>
        Ha sido agregado a una cuenta {{ config('attendize.app_name') }}
        por {{$inviter->first_name.' '.$inviter->last_name}}.
    </p>

    <p>
        Puede iniciar sesión utilizando la siguiente información<br><br>

        Nombre de usuario: <b>{{$user->email}}</b> <br>
        Contraseña: <b>{{$temp_password}}</b>
    </p>

    <p>
        Puedes cambiar tu contraseña temporal una vez que hayas iniciado sesión.
    </p>

    <div style="padding: 5px; border: 1px solid #ccc;">
        {{route('login')}}
    </div>
    <br><br>
    <p>
        Si tienes alguna pregunta, por favor responde a este correo electrónico.
    </p>
    <p>
        Gracias
    </p>

@stop

@section('footer')


@stop
