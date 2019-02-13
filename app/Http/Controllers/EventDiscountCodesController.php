<?php

namespace App\Http\Controllers;

use App\Models\Event;

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
}
