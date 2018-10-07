@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Bonjour,</p>
<p>
    Votre billet pour l'événement <b>{{{$attendee->event->title}}}</b> a été annulé.
</p>

<p>
    Vous pouvez contacter <b>{{{$attendee->event->organiser->name}}}</b> directement à <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> ou en répondant à ce message, si vous avez besoin de plus d'information.
</p>
@stop

@section('footer')

@stop
