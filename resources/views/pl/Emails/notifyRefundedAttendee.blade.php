@extends('en.Emails.Layouts.Master')

@section('message_content')

    <p>Witaj,</p>
    <p>
        Otrzymałeś zwrot za odwołane bilety na <b>{{{$attendee->event->title}}}</b>.
        <b>Kwota {{{ $refund_amount }}} została zwrócona osobie, która płaciła. Transakcja powinna zostać sfinalizowana w ciągu najbliższych kilku dni.</b>
    </p>

    <p>
        Możesz się skontaktować z <b>{{{ $attendee->event->organiser->name }}}</b> korzystając z adresu email: <a href='mailto:{{{$attendee->event->organiser->email}}}'>{{{$attendee->event->organiser->email}}}</a>, lub odpowiadając na tego maila, jeżeli chcesz otrzymać szczegółowe informacje.
    </p>
@stop

@section('footer')

@stop