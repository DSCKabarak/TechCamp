@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Ciao</p>
<p>
    Sei stato aggiunto su {{ config('attendize.app_name') }} da {{$inviter->first_name.' '.$inviter->last_name}}.
</p>

<p>
    Puoi accedere usando i seguenti dati.<br><br>
    
    Username: <b>{{$user->email}}</b> <br>
    Password: <b>{{$temp_password}}</b>
</p>

<p>
    Potrai cambiare la tua password al primo accesso.
</p>

<div style="padding: 5px; border: 1px solid #ccc;" >
   {{route('login')}}
</div>
<br><br>
<p>
    Se hai dubbi o domande non esitare a rispondere a questa mail.
</p>
<p>
    Grazie
</p>

@stop

@section('footer')


@stop
