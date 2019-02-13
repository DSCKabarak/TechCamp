<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventAccessCodes;
use Illuminate\Http\Request;

/*
  Attendize.com   - Event Management & Ticketing
 */

class EventDiscountCodesController extends MyBaseController
{

    /**
     * @param $event_id
     * @return mixed
     */
    public function show($event_id)
    {
        $event = Event::scope()->findOrFail($event_id);
        return view('ManageEvent.DiscountCodes', [
            'event' => $event,
        ]);
    }

    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCreate($event_id)
    {
        return view('ManageEvent.Modals.CreateAccessCode', [
            'event' => Event::scope()->find($event_id),
        ]);
    }

    /**
     * Creates a ticket
     *
     * @param Request $request
     * @param $event_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreate(Request $request, $event_id)
    {
        $eventAccessCode = new EventAccessCodes();

        if (!$eventAccessCode->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $eventAccessCode->errors(),
            ]);
        }

        $eventAccessCode->event_id = $event_id;
        $eventAccessCode->code = strtoupper(strip_tags($request->get('code')));
        $eventAccessCode->save();

        session()->flash('message', trans('DiscountCodes.success_message'));

        return response()->json([
            'status' => 'success',
            'id' => $eventAccessCode->id,
            'message' => trans("Controllers.refreshing"),
            'redirectUrl' => route('showEventDiscountCodes', [ 'event_id' => $event_id ]),
        ]);
    }

    /**
     * @param integer $event_id
     * @param integer $access_code_id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function postDelete($event_id, $access_code_id)
    {
        /** @var Event $event */
        $event = Event::scope()->findOrFail($event_id);

        if ($event->hasAccessCode($access_code_id)) {
            /** @var EventAccessCodes $accessCode */
            $accessCode = EventAccessCodes::find($access_code_id);
            if ($accessCode->usage_count > 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => trans('DiscountCodes.cannot_delete_used_code'),
                ]);
            }
            $accessCode->delete();
        }

        session()->flash('message', trans('DiscountCodes.delete_message'));

        return response()->json([
            'status' => 'success',
            'message' => trans("Controllers.refreshing"),
            'redirectUrl' => route('showEventDiscountCodes', [ 'event_id' => $event_id ]),
        ]);
    }
}
