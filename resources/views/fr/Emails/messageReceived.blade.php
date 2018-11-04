@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Bonjour,</p>
<p>Vous avez reçu un message de <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> en rapport avec l'événement <b>{{ $event->title }}</b>.</p>
<p style="padding: 10px; margin:10px; border: 1px solid #f3f3f3;">
    {{nl2br($message_content)}}
</p>

<p>
    Vous pouvez contacter <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> directement à <a href='mailto:{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}'>{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}</a>, ou en répondant à ce message.
</p>
@stop

@section('footer')


@stop
