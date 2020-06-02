@extends('en.Emails.Layouts.Master')

@section('message_content')
Ciao,<br><br>

Il tuo ordine per l'evento <strong>{{$order->event->title}}</strong> è stato completato con successo.<br><br>

I biglietti sono allegati a questa mail. Puoi vedere tutte le informazioni relative al tuo ordine e scaricare i biglietti visitando: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}

@if(!$order->is_payment_received)
<br><br>
<strong>Nota: il pagamento per questo ordine deve ancora essere processato. Le istruzioni per procedere con il saldo sono disponibili qui: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}</strong>
<br><br>
@endif
<h3>Dettaglio Ordine</h3>
Riferimento: <strong>{{$order->order_reference}}</strong><br>
Nome: <strong>{{$order->full_name}}</strong><br>
Data: <strong>{{$order->created_at->format(config('attendize.default_datetime_format'))}}</strong><br>
Email: <strong>{{$order->email}}</strong><br>
<a href="{!! route('downloadCalendarIcs', ['event_id' => $order->event->id]) !!}">Add To Calendar</a>

@if ($order->is_business)
<h3>Dettagli Azienda</h3>
@if ($order->business_name) @lang("Public_ViewEvent.business_name"): <strong>{{$order->business_name}}</strong><br>@endif
@if ($order->business_tax_number) @lang("Public_ViewEvent.business_tax_number"): <strong>{{$order->business_tax_number}}</strong><br>@endif
@if ($order->business_address_line_one) @lang("Public_ViewEvent.business_address_line1"): <strong>{{$order->business_address_line_one}}</strong><br>@endif
@if ($order->business_address_line_two) @lang("Public_ViewEvent.business_address_line2"): <strong>{{$order->business_address_line_two}}</strong><br>@endif
@if ($order->business_address_state_province) @lang("Public_ViewEvent.business_address_state_province"): <strong>{{$order->business_address_state_province}}</strong><br>@endif
@if ($order->business_address_city) @lang("Public_ViewEvent.business_address_city"): <strong>{{$order->business_address_city}}</strong><br>@endif
@if ($order->business_address_code) @lang("Public_ViewEvent.business_address_code"): <strong>{{$order->business_address_code}}</strong><br>@endif
@endif

<h3>Order Items</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
    <table style="width:100%; margin:10px;">
        <tr>
            <td>
                <strong>Biglietto</strong>
            </td>
            <td>
                <strong>Qtà</strong>
            </td>
            <td>
                <strong>Prezzo</strong>
            </td>
            <td>
                <strong>Commissione</strong>
            </td>
            <td>
                <strong>Totale</strong>
            </td>
        </tr>
        @foreach($order->orderItems as $order_item)
        <tr>
            <td>{{$order_item->title}}</td>
            <td>{{$order_item->quantity}}</td>
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
                {{money(($order_item->unit_price + $order_item->unit_booking_fee) * ($order_item->quantity),
                $order->event->currency)}}
                @endif
            </td>
        </tr>
        @endforeach
        <tr>
            <td colspan="3"></td>
            <td><strong>Totale parziale</strong></td>
            <td colspan="2">
                {{$orderService->getOrderTotalWithBookingFee(true)}}
            </td>
        </tr>
        @if($order->event->organiser->charge_tax == 1)
        <tr>
            <td colspan="3"></td>
            <td>
                <strong>{{$order->event->organiser->tax_name}}</strong><em>({{$order->event->organiser->tax_value}}%)</em>
            </td>
            <td colspan="2">
                {{$orderService->getTaxAmount(true)}}
            </td>
        </tr>
        @endif
        <tr>
            <td colspan="3"></td>
            <td><strong>Totale</strong></td>
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
