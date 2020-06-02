Hey {{{$attendee->first_name}}},<br><br>

wir haben Deine Tickets an diese E-Mail angehängt.<br><br>

Hier kannst Deine Bestellung ansehen und Deine Tickets herunterladen: {{route('showOrderDetails', ['order_reference' => $attendee->order->order_reference])}}<br><br>

Deine Bestellnummer ist <b>{{$attendee->order->order_reference}}</b>.<br>

Danke!<br>

