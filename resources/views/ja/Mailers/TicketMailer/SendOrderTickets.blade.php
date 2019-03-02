@extends('en.Emails.Layouts.Master')

@section('message_content')
    こんにちは、<br><br>

    イベント<b>{{$order->event->title}}</b>の注文は成功しました。<br><br>

    あなたのチケットはこのメールに添付されています。注文の詳細を表示して、チケットをダウンロードすることもできます。{{route('showOrderDetails', ['order_reference' => $order->order_reference])}}

    @if(!$order->is_payment_received)
        <br><br>
        <b>ご注意：この注文にはまだ支払いが必要です。
            支払い方法についての説明は注文ページにあります。{{route('showOrderDetails', ['order_reference' => $order->order_reference])}}</b>
        <br><br>
    @endif
    <h3>注文詳細</h3>
    注文照合: <b>{{$order->order_reference}}</b><br>
    注文名: <b>{{$order->full_name}}</b><br>
    注文日: <b>{{$order->created_at->format(config('attendize.default_datetime_format'))}}</b><br>
    注文メール: <b>{{$order->email}}</b><br>
    <a href="{!! route('downloadCalendarIcs', ['event_id' => $order->event->id]) !!}">カレンダーに追加</a>
    <h3>注文商品</h3>
    <div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
        <table style="width:100%; margin:10px;">
            <tr>
                <td>
                    <b>チケット</b>
                </td>
                <td>
                    <b>個数</b>
                </td>
                <td>
                    <b>価格</b>
                </td>
                <td>
                    <b>料金</b>
                </td>
                <td>
                    <b>合計</b>
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
    </div>
    <br><br>
    ありがとう
@stop
