こんにちは {{{$attendee->first_name}}}、<br><br>

このメールにチケットを添付しました。<br><br>

あなたはいつでも注文情報を見て、チケットをダウンロードすることができます。 {{route('showOrderDetails', ['order_reference' => $attendee->order->order_reference])}}<br><br>

ご注文の照合コードは <b>{{$attendee->order->order_reference}}</b>。<br>

ありがとう<br>