@extends('en.Emails.Layouts.Master')

@section('message_content')

    <p>Ciao,</p>
    <p>
        Hai ricevuto un rimborso per la cancellazione del tuo biglietto per <b>{{{$attendee->event->title}}}</b>.
        <b>{{{ $refund_amount }}} è stato rimborsato sul totale, il saldo dovrebbe essere aggiornato in alcuni giorni.</b>
    </p>

    <p>
        Puoi contattare <b>{{{ $attendee->event->organiser->name }}}</b> direttamente via <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a> o rispondendo a questa email, se desideri maggiori informazioni.
    </p>
@stop

@section('footer')

@stop