@extends('en.Emails.Layouts.Master')

@section('message_content')

<p>Bonjour</p>
<p>
    Vous avec été ajouté au compte de {{ config('attendize.app_name') }} par {{$inviter->first_name.' '.$inviter->last_name}}.
</p>

<p>
    Vous pouvez vous connecter avec les informations ci-dessous.<br><br>
    
    Utilisateur : <b>{{$user->email}}</b> <br>
    Mot de passe : <b>{{$temp_password}}</b>
</p>

<p>
    Vous pouvez changer votre mot de passe temporaire une fois connecté.
</p>

<div style="padding: 5px; border: 1px solid #ccc;" >
   {{route('login')}}
</div>
<br><br>
<p>
    Si vous avez la moindre question, merci de répondre à ce message.
</p>
<p>
    Merci
</p>

@stop

@section('footer')


@stop
