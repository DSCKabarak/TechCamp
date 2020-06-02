@extends('en.Emails.Layouts.Master')

@section('message_content')
Hello,<br><br>

Es ging eine neue Bestllung für die Veranstaltung <b>{{$order->event->title}}</b> ein.<br><br>

@if(!$order->is_payment_received)
    <b>Achtung: Bezahlung ausstehend.</b>
    <br><br>
@endif


Bestellungsdetails
<br><br>
Bestellnummer: <b>{{$order->order_reference}}</b><br>
Name: <b>{{$order->full_name}}</b><br>
Datum: <b>{{$order->created_at->toDayDateTimeString()}}</b><br>
E-Mail Adresse: <b>{{$order->email}}</b><br>


<h3>Bestellübersicht</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">

    <table style="width:100%; margin:10px;">
        <tr>
            <th>
                Ticket
            </th>
            <th>
                Anzahl
            </th>
            <th>
                Preis
            </th>
            <th>
                Gebühr
            </th>
            <th>
                Gesamt
            </th>
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
                Kostenlos
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
                Kostenlos
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
                <b>Zwischensumme</b>
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
                <b>Gesamt</b>
            </td>
            <td colspan="2">
                {{$orderService->getGrandTotal(true)}}
            </td>
        </tr>
    </table>


    <br><br>
    Du kannst die Bestellung hier verwalten: {{route('showEventOrders', ['event_id' => $order->event->id, 'q'=>$order->order_reference])}}
    <br><br>
</div>
<br><br>
Danke
@stop
