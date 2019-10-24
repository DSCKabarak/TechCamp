<?php namespace App\Http\Controllers;

use App\Jobs\SendOrderTickets;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\EventStats;
use App\Models\Order;
use App\Models\PaymentGateway;
use App\Services\Order as OrderService;
use Services\PaymentGateway\Factory as PaymentGatewayFactory;
use DB;
use Excel;
use Exeption;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Log;
use Mail;
use Omnipay;
use Session;
use Superbalist\Money\Money;
use Validator;

class EventOrdersController extends MyBaseController
{
    /**
     * Show event orders page
     *
     * @param Request $request
     * @param string $event_id
     * @return mixed
     */
    public function showOrders(Request $request, $event_id = '')
    {
        $allowed_sorts = ['first_name', 'email', 'order_reference', 'order_status_id', 'created_at'];

        $searchQuery = $request->get('q');
        $sort_by = (in_array($request->get('sort_by'), $allowed_sorts) ? $request->get('sort_by') : 'created_at');
        $sort_order = $request->get('sort_order') == 'asc' ? 'asc' : 'desc';

        $event = Event::scope()->find($event_id);

        if ($searchQuery) {
            /*
             * Strip the hash from the start of the search term in case people search for
             * order references like '#EDGC67'
             */
            if ($searchQuery[0] === '#') {
                $searchQuery = str_replace('#', '', $searchQuery);
            }

            $orders = $event->orders()
                ->where(function ($query) use ($searchQuery) {
                    $query->where('order_reference', 'like', $searchQuery . '%')
                        ->orWhere('first_name', 'like', $searchQuery . '%')
                        ->orWhere('email', 'like', $searchQuery . '%')
                        ->orWhere('last_name', 'like', $searchQuery . '%');
                })
                ->orderBy($sort_by, $sort_order)
                ->paginate();
        } else {
            $orders = $event->orders()->orderBy($sort_by, $sort_order)->paginate();
        }

        $data = [
            'orders'     => $orders,
            'event'      => $event,
            'sort_by'    => $sort_by,
            'sort_order' => $sort_order,
            'q'          => $searchQuery ? $searchQuery : '',
        ];

        return view('ManageEvent.Orders', $data);
    }

    /**
     * Shows  'Manage Order' modal
     *
     * @param Request $request
     * @param $order_id
     * @return mixed
     */
    public function manageOrder(Request $request, $order_id)
    {
        $order = Order::scope()->find($order_id);

        $orderService = new OrderService($order->amount, $order->booking_fee, $order->event);
        $orderService->calculateFinalCosts();

        $data = [
            'order' => $order,
            'orderService' => $orderService
        ];

        return view('ManageEvent.Modals.ManageOrder', $data);
    }

    /**
     * Shows 'Edit Order' modal
     *
     * @param Request $request
     * @param $order_id
     * @return mixed
     */
    public function showEditOrder(Request $request, $order_id)
    {
        $order = Order::scope()->find($order_id);

        $data = [
            'order'     => $order,
            'event'     => $order->event(),
            'attendees' => $order->attendees()->withoutCancelled()->get(),
            'modal_id'  => $request->get('modal_id'),
        ];

        return view('ManageEvent.Modals.EditOrder', $data);
    }

    /**
     * Shows 'Cancel Order' modal
     *
     * @param Request $request
     * @param $order_id
     * @return mixed
     */
    public function showCancelOrder(Request $request, $order_id)
    {
        $order = Order::scope()->find($order_id);

        $data = [
            'order'     => $order,
            'event'     => $order->event(),
            'attendees' => $order->attendees()->withoutCancelled()->get(),
            'modal_id'  => $request->get('modal_id'),
        ];

        return view('ManageEvent.Modals.CancelOrder', $data);
    }

    /**
     * Resend an entire order
     *
     * @param $order_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendOrder($order_id)
    {
        $order = Order::scope()->find($order_id);

        $this->dispatch(new SendOrderTickets($order));

        return response()->json([
            'status'      => 'success',
            'redirectUrl' => '',
        ]);
    }

    /**
     * Cancels an order
     *
     * @param Request $request
     * @param $order_id
     * @return mixed
     */
    public function postEditOrder(Request $request, $order_id)
    {
        $rules = [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $order = Order::scope()->findOrFail($order_id);

        $order->first_name = $request->get('first_name');
        $order->last_name = $request->get('last_name');
        $order->email = $request->get('email');

        $order->update();


        Session::flash('message', trans("Controllers.the_order_has_been_updated"));

        return response()->json([
            'status'      => 'success',
            'redirectUrl' => '',
        ]);
    }

    /**
     * Cancels attendees in an order
     * @param Request $request
     * @param $order_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function postCancelOrder(Request $request, $order_id)
    {
        $validator = Validator::make(
            $request->all(),
            ['attendees' => 'required'],
            ['attendees.required' => trans('Controllers.attendees_required')]
        );

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        /** @var Order $order */
        $order = Order::scope()->findOrFail($order_id);
        /** @var Collection $attendees */
        $attendees = Attendee::findFromSelection($request->get('attendees'));
        $nonCancelledOrderAttendees = $order->getAllNonCancelledAttendees();

        // Get the full order amount, tax and booking fees included
        $organiserAmount = new Money($order->organiser_amount, $order->getEventCurrency());
        Log::debug(sprintf("Total Order Value: %s", $organiserAmount->display()));
        $refundedAmount = new Money($order->amount_refunded, $order->getEventCurrency());
        Log::debug(sprintf("Already refunded amount: %s", $refundedAmount->display()));
        $maximumRefundableAmount = $organiserAmount->subtract($refundedAmount);
        Log::debug(sprintf("Maxmimum refundable amount: %s", $maximumRefundableAmount->display()));
        /*
         * NOTE: Calculates the refund amount by using the order total (tax incl) and dividing it by the amount of
         * attendees the user has selected. This will evenly spread the tax refund per attendee.
         *
         * If only one attendee lives in an order then its safe to assume a full refund can be made.
         */

        $refundAmount = $maximumRefundableAmount->multiply($attendees->count())
            ->divide($nonCancelledOrderAttendees->count())->floor();

        Log::debug(sprintf("Requested Refund should include Tax: %s", $refundAmount->display()));

        $errorMessage = false;
        // Check refunds are valid
        if ($order->canRefund()) {
            if (!$order->transaction_id) {
                $errorMessage = trans("Controllers.order_cant_be_refunded");
            }
            if ($order->is_refunded) {
                $errorMessage = trans('Controllers.order_already_refunded');
            } elseif ($maximumRefundableAmount->isZero()) {
                $errorMessage = trans('Controllers.nothing_to_refund');
            } elseif ($refundAmount->isGreaterThan($maximumRefundableAmount)) {
                // Error if the partial refund tries to refund more than allowed
                $errorMessage = trans('Controllers.maximum_refund_amount', [
                    'money' => $maximumRefundableAmount->display(),
                ]);
            }
        }

        // Stop before refunding anything or updating stats
        if ($errorMessage) {
            return response()->json([
                'status'  => 'error',
                'message' => $errorMessage,
            ]);
        }

        // Do refund with the amount calculated
        try {
            $gateway = Omnipay::create($order->payment_gateway->name);
            $gateway->initialize($order->account->getGateway($order->payment_gateway->id)->config);

            $request = $gateway->refund([
                'transactionReference' => $order->transaction_id,
                'amount' => $refundAmount->toFloat(),
                'refundApplicationFee' => floatval($order->booking_fee) > 0 ? true : false,
            ]);

            Log::debug(strtoupper($order->payment_gateway->name), [
                'transactionReference' => $order->transaction_id,
                'amount' => $refundAmount->toFloat(),
                'refundApplicationFee' => floatval($order->booking_fee) > 0 ? true : false,
            ]);

            $response = $request->send();

            if ($response->isSuccessful()) {
                // New refunded amount needs to be saved on the order
                $updatedRefundedAmount = $refundedAmount->add($refundAmount);

                // Update the amount refunded on the order
                $order->amount_refunded = $updatedRefundedAmount->toFloat();

                if ($organiserAmount->subtract($updatedRefundedAmount)->isZero()) {
                    $order->is_refunded = true;
                    // Order can't be both partially and fully refunded at the same time
                    $order->is_partially_refunded = false;
                    $order->order_status_id = config('attendize.order_refunded');
                } else {
                    $order->is_partially_refunded = true;
                    $order->order_status_id = config('attendize.order_partially_refunded');
                }
            } else {
                return response()->json([
                    'status'  => 'error',
                    'message' => $response->getMessage(),
                ]);
            }

            $order->save();
        } catch (Exeption $e) {
            Log::error($e);
            return response()->json([
                'status'  => 'error',
                'message' => trans("Controllers.refund_exception"),
            ]);

        }

        // With the refunds done, we can mark the attendees as cancelled and refunded as well
        $attendees->map(function(Attendee $attendee) {
            $attendee->ticket->decrement('quantity_sold');
            $attendee->ticket->decrement('sales_volume', $attendee->ticket->price);
            $attendee->is_cancelled = true;
            $attendee->is_refunded = true;
            $attendee->save();

            /** @var EventStats $eventStats */ // TODO move this to the EventStats Model
            $eventStats = EventStats::where('event_id', $attendee->event_id)
                ->where('date', $attendee->created_at->format('Y-m-d'))->first();
            if ($eventStats) {
                $eventStats->decrement('tickets_sold',  1);
                $eventStats->decrement('sales_volume',  $attendee->ticket->price);
            }
        });

        // Done
        Session::flash('message', trans("Controllers.successfully_refunded_and_cancelled"));

        return response()->json([
            'status' => 'success',
            'redirectUrl' => '',
        ]);
    }

    /**
     * Exports order to popular file types
     *
     * @param $event_id
     * @param string $export_as Accepted: xls, xlsx, csv, pdf, html
     */
    public function showExportOrders($event_id, $export_as = 'xls')
    {
        $event = Event::scope()->findOrFail($event_id);

        Excel::create('orders-as-of-' . date('d-m-Y-g.i.a'), function ($excel) use ($event) {

            $excel->setTitle('Orders For Event: ' . $event->title);

            // Chain the setters
            $excel->setCreator(config('attendize.app_name'))
                ->setCompany(config('attendize.app_name'));

            $excel->sheet('orders_sheet_1', function ($sheet) use ($event) {

                $yes = strtoupper(trans("basic.yes"));
                $no = strtoupper(trans("basic.no"));
                $orderRows = DB::table('orders')
                    ->where('orders.event_id', '=', $event->id)
                    ->where('orders.event_id', '=', $event->id)
                    ->select([
                        'orders.first_name',
                        'orders.last_name',
                        'orders.email',
                        'orders.order_reference',
                        'orders.amount',
                        \DB::raw("(CASE WHEN orders.is_refunded = 1 THEN '$yes' ELSE '$no' END) AS `orders.is_refunded`"),
                        \DB::raw("(CASE WHEN orders.is_partially_refunded = 1 THEN '$yes' ELSE '$no' END) AS `orders.is_partially_refunded`"),
                        'orders.amount_refunded',
                        'orders.created_at',
                    ])->get();

                $exportedOrders = $orderRows->toArray();

                array_walk($exportedOrders, function(&$value) {
                    $value = (array)$value;
                });

                $sheet->fromArray($exportedOrders);

                // Add headings to first row
                $sheet->row(1, [
                    trans("Attendee.first_name"),
                    trans("Attendee.last_name"),
                    trans("Attendee.email"),
                    trans("Order.order_ref"),
                    trans("Order.amount"),
                    trans("Order.fully_refunded"),
                    trans("Order.partially_refunded"),
                    trans("Order.amount_refunded"),
                    trans("Order.order_date"),
                ]);

                // Set gray background on first row
                $sheet->row(1, function ($row) {
                    $row->setBackground('#f5f5f5');
                });
            });
        })->export($export_as);
    }

    /**
     * shows 'Message Order Creator' modal
     *
     * @param Request $request
     * @param $order_id
     * @return mixed
     */
    public function showMessageOrder(Request $request, $order_id)
    {
        $order = Order::scope()->findOrFail($order_id);

        $data = [
            'order' => $order,
            'event' => $order->event,
        ];

        return view('ManageEvent.Modals.MessageOrder', $data);
    }

    /**
     * Sends message to order creator
     *
     * @param Request $request
     * @param $order_id
     * @return mixed
     */
    public function postMessageOrder(Request $request, $order_id)
    {
        $rules = [
            'subject' => 'required|max:250',
            'message' => 'required|max:5000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => 'error',
                'messages' => $validator->messages()->toArray(),
            ]);
        }

        $order = Order::scope()->findOrFail($order_id);

        $data = [
            'order'           => $order,
            'message_content' => $request->get('message'),
            'subject'         => $request->get('subject'),
            'event'           => $order->event,
            'email_logo'      => $order->event->organiser->full_logo_path,
        ];

        Mail::send('Emails.messageReceived', $data, function ($message) use ($order, $data) {
            $message->to($order->email, $order->full_name)
                ->from(config('attendize.outgoing_email_noreply'), $order->event->organiser->name)
                ->replyTo($order->event->organiser->email, $order->event->organiser->name)
                ->subject($data['subject']);
        });

        /* Send a copy to the Organiser with a different subject */
        if ($request->get('send_copy') == '1') {
            Mail::send('Emails.messageReceived', $data, function ($message) use ($order, $data) {
                $message->to($order->event->organiser->email)
                    ->from(config('attendize.outgoing_email_noreply'), $order->event->organiser->name)
                    ->replyTo($order->event->organiser->email, $order->event->organiser->name)
                    ->subject($data['subject'] . trans("Email.organiser_copy"));
            });
        }

        return response()->json([
            'status'  => 'success',
            'message' => trans("Controllers.message_successfully_sent"),
        ]);
    }

    /**
     * Mark an order as payment received
     *
     * @param Request $request
     * @param $order_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMarkPaymentReceived(Request $request, $order_id)
    {
        $order = Order::scope()->findOrFail($order_id);

        $order->is_payment_received = 1;
        $order->order_status_id = 1;

        $order->save();

        session()->flash('message', trans("Controllers.order_payment_status_successfully_updated"));

        return response()->json([
            'status' => 'success',
        ]);
    }
}
