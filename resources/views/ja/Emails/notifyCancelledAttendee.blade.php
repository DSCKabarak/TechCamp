@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>こんにちは、</p>
<p>
    イベント：<b>{{{$attendee->event->title}}}</b>のチケットはキャンセルされました。.
</p>

<p>
    <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a>で直接<b>{{{$attendee->event->organiser->name}}}</b>に連絡することができます。またはこのメールに返信してください。
</p>
@stop

@section('footer')

@stop
