Ciao {{{$attendee->first_name}}},<br><br>

Abbiamo allegato i biglietti a questa email.<br><br>

Puoi vedere tutte le informazioni relative al tuo ordine e scaricare i biglietti visitando {{route('showOrderDetails', ['order_reference' => $attendee->order->order_reference])}} in ogni momento.<br><br>

Il riferimento del tuo ordine è <b>{{$attendee->order->order_reference}}</b>.<br>

Grazie<br>

