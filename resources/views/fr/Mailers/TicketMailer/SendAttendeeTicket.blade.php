@extends('en.Emails.Layouts.Master')

@section('message_content')
Bonjour {{$attendee->first_name}},<br><br>

Votre billet pour l'événement <b>{{$attendee->order->event->title}}</b> est joint à ce message.

<br><br>
Merci
@stop
