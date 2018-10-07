@extends('en.Emails.Layouts.Master')

@section('message_content')

    <p>Bonjour,</p>
    <p>
        Vous avez reçu un remboursement pour l'annulation du billet pour <b>{{{$attendee->event->title}}}</b>.
        <b>{{{ $refund_amount }}} ont été remboursés au bénéficiaire initial, vous devriez voir le paiement dans quelques jours.</b>
    </p>

    <p>
        Vous pouvez contacter <b>{{{ $attendee->event->organiser->name }}}</b> directement à <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> ou en répondant à ce message, si vous avez besoin de plus d'informations.
    </p>
@stop

@section('footer')

@stop
