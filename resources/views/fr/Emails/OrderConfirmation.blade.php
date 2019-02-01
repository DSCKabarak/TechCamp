@extends('en.Emails.Layouts.Master')

@section('message_content')
Bonjour,<br><br>

Votre commande pour l'événement <b>{{$order->event->title}}</b> a été prise en compte.<br><br>

Vos billets sont joints à ce message. Vous pouvez aussi voir les détails de votre commande et télécharger vos billets sur : {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}


<h3>Détails de la commande</h3>
Référence de la commande : <b>{{$order->order_reference}}</b><br>
Nom de la commande : <b>{{$order->full_name}}</b><br>
Date de la commande : <b>{{$order->created_at->format(config('attendize.default_datetime_format'))}}</b><br>
Courriel de la commande : <b>{{$order->email}}</b><br>

<h3>Éléments de la commande</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
    <table style="width:100%; margin:10px;">
        <tr>
            <td>
                <b>Billet</b>
            </td>
            <td>
                <b>Qté.</b>
            </td>
            <td>
                <b>Prix</b>
            </td>
            <td>
                <b>Frais</b>
            </td>
            <td>
                <b>Total</b>
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
                                        GRATUIT
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
                                        GRATUIT
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
                <b>Sous-total</b>
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
                <b>Total</b>
            </td>
            <td colspan="2">
                {{$orderService->getGrandTotal(true)}}
            </td>
        </tr>
    </table>

    <br><br>
</div>
<br><br>
Merci
@stop
