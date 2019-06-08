@extends('en.Emails.Layouts.Master')

@section('message_content')
Hello,<br><br>

Your order for the event <strong>{{$order->event->title}}</strong> was successful.<br><br>

Your tickets are attached to this email. You can also view you order details and download your tickets
at: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}

@if(!$order->is_payment_received)
<br><br>
<strong>Please note: This order still requires payment. Instructions on how to make payment can be found on your
    order page: {{route('showOrderDetails', ['order_reference' => $order->order_reference])}}</strong>
<br><br>
@endif
<h3>Order Details</h3>
Order Reference: <strong>{{$order->order_reference}}</strong><br>
Order Name: <strong>{{$order->full_name}}</strong><br>
Order Date: <strong>{{$order->created_at->format(config('attendize.default_datetime_format'))}}</strong><br>
Order Email: <strong>{{$order->email}}</strong><br>
@if ($order->is_business)
Business: <strong>{{$order->business_name}}</strong><br>
Tax number: <strong>{{$order->business_tax_number}}</strong><br>
Business Address: <strong>{{$order->business_address}}</strong><br>
@endif

<a href="{!! route('downloadCalendarIcs', ['event_id' => $order->event->id]) !!}">Add To Calendar</a>
<h3>Order Items</h3>
<div style="padding:10px; background: #F9F9F9; border: 1px solid #f1f1f1;">
    <table style="width:100%; margin:10px;">
        <tr>
            <td>
                <strong>Ticket</strong>
            </td>
            <td>
                <strong>Qty.</strong>
            </td>
            <td>
                <strong>Price</strong>
            </td>
            <td>
                <strong>Fee</strong>
            </td>
            <td>
                <strong>Total</strong>
            </td>
        </tr>
        @foreach($order->orderItems as $order_item)
        <tr>
            <td>{{$order_item->title}}</td>
            <td>{{$order_item->quantity}}</td>
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
            <td colspan="3"></td>
            <td><strong>Sub Total</strong></td>
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
            <td><strong>Total</strong></td>
            <td colspan="2">
                {{$orderService->getGrandTotal(true)}}
            </td>
        </tr>
    </table>
    <br><br>
</div>
<br><br>
Thank you
@stop
