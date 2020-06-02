@extends('en.Emails.Layouts.Master')

@section('message_content')
Ciao,<br><br>

Hai ricevuto un nuovo ordine per l'evento <b>{{$order->event->title}}</b>.<br><br>

@if(!$order->is_payment_received)
    <b>Nota: il pagamento per questo ordine deve ancora essere processato.</b>
    <br><br>
@endif


<h3>Dettaglio Ordine</h3>
Riferimento: <b>{{$order->order_reference}}</b><br>
Nome: <b>{{$order->full_name}}</b><br>
Data: <b>{{$order->created_at->format(config('attendize.default_datetime_format'))}}</b><br>
Email: <b>{{$order->email}}</b><br>
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
            <th>
                Biglietto
            </th>
            <th>
                Quantità
            </th>
            <th>
                Prezzo
            </th>
            <th>
                Commissione
            </th>
            <th>
                Totale
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
                GRATUITO
                @else
                {{money($order_item->unit_price, $order->event->currency)}}
                @endif
            </td>
            <td>
                @if ((int)ceil($order_item->unit_booking_fee) > 0)
                    @if((int)ceil($order_item->unit_price) == 0)
                    -
                    @else
                    {{money($order_item->unit_booking_fee, $order->event->currency)}}
                    @endif
                @else
                    -
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
                <strong>{{$order->event->organiser->tax_name}}</strong><em>({{$order->event->organiser->tax_value}}%)</em>
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
    Puoi gestire questo ordine visitando: {{route('showEventOrders', ['event_id' => $order->event->id, 'q'=>$order->order_reference])}}
    <br><br>
</div>
<br><br>
Grazie
@stop
