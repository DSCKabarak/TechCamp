<?php

namespace App\Mailers;

use App\Models\Order;
use App\Services\Order as OrderService;
use Log;
use Mail;

class OrderMailer
{
    public function sendOrderNotification(Order $order)
    {
        $orderService = new OrderService($order->amount, $order->organiser_booking_fee, $order->event);
        $orderService->calculateFinalCosts();

        $data = [
            'order' => $order,
            'orderService' => $orderService
        ];

        Mail::send('Emails.OrderNotification', $data, function ($message) use ($order) {
            $message->to($order->account->email);
            $message->subject('New order received on the event ' . $order->event->title . ' [' . $order->order_reference . ']');
        });

    }

    public function sendOrderTickets(Order $order)
    {
        $orderService = new OrderService($order->amount, $order->organiser_booking_fee, $order->event);
        $orderService->calculateFinalCosts();

        Log::info("Sending ticket to: " . $order->email);
        $data = [
            'order' => $order,
            'orderService' => $orderService
        ];

        Mail::send('Mailers.TicketMailer.SendOrderTickets', $data, function ($message) use ($order) {
            $message->to($order->email);
            $message->subject(trans("Controllers.tickets_for_event", ["event"=>$order->event->title]));

            $file_name = $order->order_reference;
            $file_path = public_path(config('attendize.event_pdf_tickets_path')) . '/' . $file_name . '.pdf';

            $message->attach($file_path);
        });

    }

}
