@extends('en.Emails.Layouts.Master')

@section('message_content')
    こんにちは、<br><br>

    イベント：<b>{{$order->event->title}}</b>の新しい注文を受けました。<br><br>

    @if(!$order->is_payment_received)
        <b>ご注意：この注文にはまだ支払いが必要です。</b>
        <br><br>
    @endif


    注文の概要：
    <br><br>
    注文照合：<b>{{$order->order_reference}}</b><br>
    注文名：<b>{{$order->full_name}}</b><br>
    注文日：<b>{{$order->created_at->format(config('attendize.default_datetime_format'))}}</b><br>
    注文メール：<b>{{$order->email}}</b><br>


    <h3>Order Items</h3>
    <div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">

        <table style="width:100%; margin:10px;">
            <tr>
                <th>
                    チケット
                </th>
                <th>
                    個数
                </th>
                <th>
                    価格
                </th>
                <th>
                    予約料金
                </th>
                <th>
                    合計
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
                            無料
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
                            無料
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
                    <b>小計</b>
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
                    <b>合計</b>
                </td>
                <td colspan="2">
                    {{$orderService->getGrandTotal(true)}}
                </td>
            </tr>
        </table>


        <br><br>
        この注文を管理できます。{{route('showEventOrders', ['event_id' => $order->event->id, 'q'=>$order->order_reference])}}
        <br><br>
    </div>
    <br><br>
    ありがとう
@stop
