@extends('es.Emails.Layouts.Master')

@section('message_content')

    <p>Hola,</p>
    <p>Ha recibido un mensaje de <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> en relación
        al evento <b>{{ $event->title }}</b>.</p>
    <p style="padding: 10px; margin:10px; border: 1px solid #f3f3f3;">
        {{nl2br($message_content)}}
    </p>

    <p>
        Puede ponerse en contacto con <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b>
        directamente en <a
                href='mailto:{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}'>{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}</a>,
        o respondiendo a este correo electrónico.
    </p>
@stop

@section('footer')


@stop
