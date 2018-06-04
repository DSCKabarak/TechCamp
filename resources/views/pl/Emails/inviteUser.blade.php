@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Witaj</p>
<p>
    Zostałeś dodany do konta {{ config('attendize.app_name') }} przez {{$inviter->first_name.' '.$inviter->last_name}}.
</p>

<p>
    Możesz skorzystać z następujących tymczasowych danych logowania:.<br><br>
    
    Login: <b>{{$user->email}}</b> <br>
    Hasło: <b>{{$temp_password}}</b>
</p>

<p>
    Możesz zmienić swoje tymczasowe hasło, kiedy już się zalogujesz.
</p>

<div style="padding: 5px; border: 1px solid #ccc;" >
   {{route('login')}}
</div>
<br><br>
<p>
    Jeżeli masz jakieś pytania, odpisz na ten adres email.
</p>
<p>
    Dziękujemy.
</p>

@stop

@section('footer')


@stop
