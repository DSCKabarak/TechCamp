@extends('es.Emails.Layouts.Master')

@section('message_content')
    Hola {{$attendee->first_name}},<br><br>

    Has sido invitado al evento <b>{{$attendee->order->event->title}}</b>.<br/>
    Tu entrada para el evento se adjunta a este correo electrónico.

    <br><br>
    Un cordial saludo
@stop
