@extends('en.Emails.Layouts.Master')

@section('message_content')
Witaj {{$attendee->first_name}},<br><br>

Twój bilet na <b>{{$attendee->order->event->title}}</b> został dołączony do tego emaila.

<br><br>
Dziękujemy
@stop
