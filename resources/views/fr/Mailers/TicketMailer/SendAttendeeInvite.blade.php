@extends('en.Emails.Layouts.Master')

@section('message_content')
Bonjour {{$attendee->first_name}},<br><br>

Vous avez été invité à l'événement <b>{{$attendee->order->event->title}}</b>.<br/>
Votre billet pour l'événement est joint à ce message.

<br><br>
Sincèrement
@stop
