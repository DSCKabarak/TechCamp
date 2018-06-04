Witaj {{{$attendee->first_name}}},<br><br>

Załączyliśmy bilety do tego emaila.<br><br>

Możesz przejrzeć szczegóły zamówienia i pobrać bilety {{route('showOrderDetails', ['order_reference' => $attendee->order->order_reference])}} kiedykolwiek zechcesz.<br><br>

Twój identyfikator zamówienia to <b>{{$attendee->order->order_reference}}</b>.<br>

Dziękujemy<br>

