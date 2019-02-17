@extends('es.Emails.Layouts.Master')

@section('message_content')
    Hola,<br><br>

    Se ha procesado el pedido para el evento <b>{{$order->event->title}}</b> correctamente.<br><br>

    Sus entradas se adjuntan a este correo electrónico. También puede ver los detalles de su pedido y descargar sus entradas en: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}

    <h3>Resumen del pedido</h3>
    Referencia de pedido: <b>{{$order->order_reference}}</b><br>
    Nombre del pedido: <b>{{$order->full_name}}</b><br>
    Fecha del pedido: <b>{{$order->created_at->format(config('attendize.default_datetime_format'))}}</b><br>
    Correo electrónico del pedido: <b>{{$order->email}}</b><br>

    <h3>Artículos del pedido</h3>
    <div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
        <table style="width:100%; margin:10px;">
            <tr>
                <td>
                    <b>Entrada</b>
                </td>
                <td>
                    <b>Cantidad</b>
                </td>
                <td>
                    <b>Precio</b>
                </td>
                <td>
                    <b>Gastos de Gestión</b>
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
    </div>
    <br><br>
    Gracias
@stop
