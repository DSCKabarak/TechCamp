@extends('es.Emails.Layouts.Master')

@section('message_content')
    Hola,<br><br>

    Ha recibido un nuevo pedido para el evento <b>{{$order->event->title}}</b>.<br><br>

    @if(!$order->is_payment_received)
        <b>Nota: Este pedido todavía no ha sido pagado.</b>
        <br><br>
    @endif

    Resumen del pedido:
    <br><br>
    Referencia de pedido: <b>{{$order->order_reference}}</b><br>
    Nombre del pedido: <b>{{$order->full_name}}</b><br>
    Fecha del pedido: <b>{{$order->created_at->format(config('attendize.default_datetime_format'))}}</b><br>
    Order Email: <b>{{$order->email}}</b><br>

    <h3>Artículos del pedido</h3>
    <div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
        <table style="width:100%; margin:10px;">
            <tr>
                <th>
                    Entrada
                </th>
                <th>
                    Cantidad
                </th>
                <th>
                    Precio
                </th>
                <th>
                    Gastos de Gestión
                </th>
                <th>
                    Total
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
                            GRATIS
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
                            GRATIS
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
                    <b>Sub Total</b>
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
        Puede gestionar este pedido
        en: {{route('showEventOrders', ['event_id' => $order->event->id, 'q'=>$order->order_reference])}}
        <br><br>
    </div>
    <br><br>
    Gracias
@stop
