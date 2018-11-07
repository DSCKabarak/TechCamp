@extends('es.Emails.Layouts.Master')

@section('message_content')

    <p>Hola,</p>
    <p>
        Su entrada para el evento <b>{{{$attendee->event->title}}}</b> ha sido cancelada.
    </p>

    <p>
        Puede ponerse en contacto con <b>{{{$attendee->event->organiser->name}}}</b> directamente en <a
                href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> o
        respondiendo a este correo electrónico en caso de que necesite más información.
    </p>
@stop

@section('footer')

@stop
