@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Hey!</p>
<p>Du hast eine Nachricht von <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> zu der Veranstaltung <b>{{ $event->title }}</b> bekommen.</p>
<p style="padding: 10px; margin:10px; border: 1px solid #f3f3f3;">
    {{nl2br($message_content)}}
</p>

<p>
    Du kannst <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> gleich hier <a href='mailto:{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}'>{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}</a> kontaktieren oder dieser E-Mail antworten.
</p>
@stop

@section('footer')


@stop
