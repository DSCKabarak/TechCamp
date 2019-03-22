@extends('en.Emails.Layouts.Master')

@section('message_content')
こんにちは {{$attendee->first_name}}、<br><br>

あなたはイベント<b>{{$attendee->order->event->title}}</b>に招待されました。<br/>
イベントのチケットはこのEメールに添付されています。

<br><br>
よろしく
@stop
