@extends('en.Emails.Layouts.Master')

@section('message_content')
Hallo,<br><br>

Ihre bestellung für das Event <b>{{$order->event->title}}</b> war erfolgreich.<br><br>

Ihr Ticket ist an diese Email angehängt. Sie können Ihre Bestelldetails nochmals unter: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}} ansehen und dort auch Ihr Ticket Herunterladen

@if(!$order->is_payment_received)
<br><br>
<b>Bitte beachten: Ihre Bestellung ist noch nicht bezahlt. Die Anleitung für die Bezahlung können Sie folgender Seite entnehmen: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}</b>
<br><br>
@endif
<h3>Order Details</h3>
Bestellreferenznummer: <b>{{$order->order_reference}}</b><br>
Besteller Name: <b>{{$order->full_name}}</b><br>
Bestelldatum: <b>{{$order->created_at->toDayDateTimeString()}}</b><br>
Bestell Email: <b>{{$order->email}}</b><br>
<a href="{!! route('downloadCalendarIcs', ['event_id' => $order->event->id]) !!}">Add To Calendar</a>
<h3>Bestellung</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
    <table style="width:100%; margin:10px;">
        <tr>
            <td>
                <b>Ticket</b>
            </td>
            <td>
                <b>Menge.</b>
            </td>
            <td>
                <b>Preis</b>
            </td>
            <td>
                <b>Gebühren</b>
            </td>
            <td>
                <b>Gesamt</b>
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
                <b>Gesamtpreis</b>
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
</div>
<br><br>
Vielen Dank
@stop
