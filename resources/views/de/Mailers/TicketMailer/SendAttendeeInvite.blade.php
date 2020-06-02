@extends('en.Emails.Layouts.Master')

@section('message_content')
Hallo {{$attendee->first_name}},<br><br>

Sie wurden zum Event  <b>{{$attendee->order->event->title}} eingeladen</b>.<br/>
Sie finden Ihr Ticket für dieses Event im Anhang.

<br><br>
Mit freundlichen Grüßen
@stop
