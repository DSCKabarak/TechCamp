@extends('es.Emails.Layouts.Master')

@section('message_content')
    Hola {{$attendee->first_name}},<br><br>

    Tu entrada para el evento <b>{{$attendee->order->event->title}}</b> se adjunta a este correo electrónico.

    <br><br>
    Gracias
@stop
