@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Ciao,</p>
<p>
    Il tuo biglietto per l'evento <b>{{{$attendee->event->title}}}</b> è stato annullato.
</p>

<p>
    Puoi contattare <b>{{{$attendee->event->organiser->name}}}</b> direttamente via <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> o rispondendo a questa email, se desideri maggiori informazioni.
</p>
@stop

@section('footer')

@stop
