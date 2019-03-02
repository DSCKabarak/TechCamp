@extends('en.Emails.Layouts.Master')

@section('message_content')
こんにちは {{$attendee->first_name}}、<br><br>

イベント<b>{{$attendee->order->event->title}}</b>のチケットがこのメールに添付されています。

<br><br>
ありがとう
@stop
