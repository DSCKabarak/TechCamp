@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Ciao {{$first_name}}</p>
<p>
    Grazie per esserti registrato su {{ config('attendize.app_name') }}. Siamo felici di averti a bordo!
</p>

<p>
    Puoi creare il tuo primo evento e confermare la tua email usando il link in basso.
</p>

<div style="padding: 5px; border: 1px solid #ccc;">
   {{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}
</div>
<br><br>
<p>
    Se hai qualche domanda, feedback o suggerimenti, rispondi a questo messaggio.
</p>
<p>
    Grazie
</p>

@stop

@section('footer')


@stop
