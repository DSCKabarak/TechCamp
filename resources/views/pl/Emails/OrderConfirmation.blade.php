@extends('en.Emails.Layouts.Master')

@section('message_content')
Witaj,<br><br>

Twoje zamówienie w związku z wydarzeniem <b>{{$order->event->title}}</b> zostało zakończone pomyślnie.<br><br>

Twoje bilety są dołączone do tego emaila. Możesz przejrzeć szczegóły dot. zamówienia i pobrać bilety tu: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}


<h3>Podsumowanie zamówienia</h3>
Identyfikator zamówienia: <b>{{$order->order_reference}}</b><br>
Imię i Nazwisko: <b>{{$order->full_name}}</b><br>
Data: <b>{{$order->created_at->toDayDateTimeString()}}</b><br>
Email: <b>{{$order->email}}</b><br>

<h3>Przedmioty zamówienia</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
    <table style="width:100%; margin:10px;">
        <tr>
            <td>
                <b>Bilet</b>
            </td>
            <td>
                <b>Licz.</b>
            </td>
            <td>
                <b>Cena</b>
            </td>
            <td>
                <b>Opłata</b>
            </td>
            <td>
                <b>Razem</b>
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
                                        FREE
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
                                        FREE
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
                <b>Suma</b>
            </td>
            <td colspan="2">
               {{money($order->amount + $order->order_fee, $order->event->currency)}}
            </td>
        </tr>
    </table>

    <br><br>
</div>
<br><br>
Dziękujemy.
@stop
