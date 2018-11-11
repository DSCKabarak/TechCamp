@extends('es.Emails.Layouts.Master')

@section('message_content')

    <p>Hola,</p>
    <p>
        Has recibido un reembolso por de su entrada cancelada por <b>{{{$attendee->event->title}}}</b>.
        <b>{{{ $refund_amount }}} ha sido devuelto al beneficiario original, deberías recibir el pago en unos días.</b>
    </p>

    <p>
        Puede ponerse en contacto con <b>{{{ $attendee->event->organiser->name }}}</b> directamente en <a
                href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> o
        respondiendo a este correo electrónico en caso de que necesite más información.
    </p>
@stop

@section('footer')

@stop