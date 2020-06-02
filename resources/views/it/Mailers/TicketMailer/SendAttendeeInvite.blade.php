@extends('en.Emails.Layouts.Master')

@section('message_content')
Ciao {{$attendee->first_name}},<br><br>

Sei stato invitato/a all'evento <b>{{$attendee->order->event->title}}</b>.<br/>
Il biglietto è allegato a questa email.

<br><br>
A presto,
@stop
