@extends('en.Emails.Layouts.Master')

@section('message_content')
Hallo {{$attendee->first_name}},<br><br>

Ihr Ticket für das Event <b>{{$attendee->order->event->title}}</b> ist an diese Email angehängt.

<br><br>
Vielen Dank
@stop
