@extends('en.Emails.Layouts.Master')

@section('message_content')
Ciao,<br><br>

Il tuo ordine per l'evento <b>{{$order->event->title}}</b> è confermato.<br><br>

I tuoi biglietti sono allegati a questa mail. Puoi vedere tutte le informazioni relative al tuo ordine e scaricare i biglietti visitando: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}


<h3>Dettaglio Ordine</h3>
Riferimento: <b>{{$order->order_reference}}</b><br>
Nome: <b>{{$order->full_name}}</b><br>
Data: <b>{{$order->created_at->format(config('attendize.default_datetime_format'))}}</b><br>
Email: <b>{{$order->email}}</b><br>

<h3>Articoli</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
    <table style="width:100%; margin:10px;">
        <tr>
            <td>
                <b>Biglietto</b>
            </td>
            <td>
                <b>Qtà</b>
            </td>
            <td>
                <b>Prezzo</b>
            </td>
            <td>
                <b>Commissione</b>
            </td>
            <td>
                <b>Totale</b>
            </td>
        </tr>
        @foreach($order->orderItems as $order_item)
                                <tr>
                                    <td>
                                        {{$order_item->title}}
                                    </td>
                                    <td>
                                        {{$order_item->quantity}}
                                    </td>
                                    <td>
                                        @if((int)ceil($order_item->unit_price) == 0)
                                        GRATUITO
                                        @else
                                       {{money($order_item->unit_price, $order->event->currency)}}
                                        @endif

                                    </td>
                                    <td>
                                        @if((int)ceil($order_item->unit_price) == 0)
                                        -
                                        @else
                                        {{money($order_item->unit_booking_fee, $order->event->currency)}}
                                        @endif

                                    </td>
                                    <td>
                                        @if((int)ceil($order_item->unit_price) == 0)
                                        GRATUITO
                                        @else
                                        {{money(($order_item->unit_price + $order_item->unit_booking_fee) * ($order_item->quantity), $order->event->currency)}}
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                <b>Totale parziale</b>
            </td>
            <td colspan="2">
                {{$orderService->getOrderTotalWithBookingFee(true)}}
            </td>
        </tr>
        @if($order->event->organiser->charge_tax == 1)
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                <b>{{$order->event->organiser->tax_name}}</b>
            </td>
            <td colspan="2">
                {{$orderService->getTaxAmount(true)}}
            </td>
        </tr>
        @endif
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                <b>Totale</b>
            </td>
            <td colspan="2">
                {{$orderService->getGrandTotal(true)}}
            </td>
        </tr>
    </table>

    <br><br>
</div>
<br><br>
Grazie
@stop
