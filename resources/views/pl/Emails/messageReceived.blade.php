@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Witaj,</p>
<p>Otrzymałeś wiadomość od <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> w związku z wydarzeniem <b>{{ $event->title }}</b>.</p>
<p style="padding: 10px; margin:10px; border: 1px solid #f3f3f3;">
    {{nl2br($message_content)}}
</p>

<p>
    Możesz się skontaktować z <b>{{ (isset($sender_name) ? $sender_name : $event->organiser->name) }}</b> bezpośrednio, korzystając z adresu email: <a href='mailto:{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}'>{{ (isset($sender_email) ? $sender_email : $event->organiser->email) }}</a>, lub odpowiadając na tego emaila.
</p>
@stop

@section('footer')


@stop
