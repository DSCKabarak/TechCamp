@extends('en.Emails.Layouts.Master')

@section('message_content')

    <p>こんにちは、</p>
    <p>
        キャンセルされた<b>{{{$attendee->event->title}}}</b>チケットの代わりに払い戻しを受けました。
        <b>元の受取人に{{{ $refund_amount }}}払い戻されました、あなたは数日で支払いを見るべきです。</b>
    </p>

    <p>
        <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a>で直接<b>{{{$attendee->event->organiser->name}}}</b>に連絡することができます。またはこのメールに返信してください。
    </p>
@stop

@section('footer')

@stop