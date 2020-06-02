@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Ciao,</p>
<p>Hai ricevuto un messaggio da <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> per l'evento <b>{{ $event->title }}</b>.</p>
<p style="padding: 10px; margin:10px; border: 1px solid #f3f3f3;">
    {!! nl2br($message_content) !!}
</p>

<p>
    Puoi contattare <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> direttamente via <a href='mailto:{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}'>{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}</a> o rispondendo a questa email.
</p>
@stop

@section('footer')


@stop
