@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Witaj,</p>
<p>
    Twój bilet na  <b>{{{$attendee->event->title}}}</b> został anulowany.
</p>

<p>
    Możesz nazwiązać kontakt z <b>{{{$attendee->event->organiser->name}}}</b> korzystając z adresu email: <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> lub poprzez odpowiedzenie na tę wiadomość emailową.
</p>
@stop

@section('footer')

@stop
