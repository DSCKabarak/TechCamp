@extends('en.Emails.Layouts.Master')

@section('message_content')
Ciao {{$attendee->first_name}},<br><br>

Il tuo biglietto per l'evento <b>{{$attendee->order->event->title}}</b> è allegato a questa email.

<br><br>
Grazie
@stop
