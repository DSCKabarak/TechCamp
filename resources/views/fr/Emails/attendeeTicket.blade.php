Bonjour {{{$attendee->first_name}}},<br><br>

Nous avons joint vos billets à ce courriel.<br><br>

Vous pouvez voir les détails de votre commande et télécharger vos tickets sur {{route('showOrderDetails', ['order_reference' => $attendee->order->order_reference])}} à tout moment.<br><br>

Votre référence de commande est <b>{{$attendee->order->order_reference}}</b>.<br>

Merci<br>

