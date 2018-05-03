@extends('en.Emails.Layouts.Master')

@section('message_content')
    Witaj {{$attendee->first_name}},<br><br>

    Zostałeś zaproszony na <b>{{$attendee->order->event->title}}</b>.<br/>
    Twój bilet został dołączony do tej wiadomości.

    <br><br>
    Pozdrawiamy
@stop
