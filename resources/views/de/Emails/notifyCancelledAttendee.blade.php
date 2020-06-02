@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Hey,</p>
<p>
    Dein Ticket für die Veranstaltung <b>{{{$attendee->event->title}}}</b> wurde storniert.
</p>

<p>
    Solltest Du mehr Informationen brauchen kannst Du <b>{{{$attendee->event->organiser->name}}}</b> gleich hier <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> kontaktieren oder dieser E-Mail antworten.
</p>
@stop

@section('footer')

@stop
