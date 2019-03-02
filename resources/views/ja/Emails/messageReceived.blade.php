@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>こんにちは、</p>
<p><b>{{ $event->title }}</b>に関して<b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b>からメッセージを受け取りました。</p>
<p style="padding: 10px; margin:10px; border: 1px solid #f3f3f3;">
    {{nl2br($message_content)}}
</p>

<p>
    <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b>に連絡するには<a href='mailto:{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}'>{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}</a>、またはこのメールに返信してください。
</p>
@stop

@section('footer')


@stop
