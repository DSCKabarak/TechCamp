@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Hey {{$first_name}}</p>
<p>
    Danke für Deine Registrierung bei {{ config('attendize.app_name') }}. Wir sind begeistert Dich dabei zu haben!
</p>

<p>
    Mit dem folgenden Link kannst Du Deine erste Veranstaltung erstellen und Deine E-Mail Adresse bestätigen.
</p>

<div style="padding: 5px; border: 1px solid #ccc;">
   {{route('confirmEmail', ['confirmation_code' => $confirmation_code])}}
</div>
<br><br>
<p>
    Wenn Du irgendwelche Fragen, Feedback oder Anregungen hast, kannst du einfach eine Antwort an diese E-Mail schreiben.
</p>
<p>
    Danke!
</p>

@stop

@section('footer')


@stop
