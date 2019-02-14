<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EventAccessCodes extends MyBaseModel
{
    use SoftDeletes;

    /**
     * @param integer $event_id
     * @param string $accessCode
     * @return void
     */
    public static function logUsage($event_id, $accessCode)
    {
        (new static)::where('event_id', $event_id)
            ->where('code', $accessCode)
            ->increment('usage_count');
    }

    /**
     * The validation rules.
     *
     * @return array $rules
     */
    public function rules()
    {
        return [
            'code' => 'required|string',
        ];
    }

    /**
     * The Event associated with the event access code.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class, 'event_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    function tickets()
    {
        return $this->belongsToMany(
            Ticket::class,
            'ticket_event_access_code',
            'event_access_code_id',
            'ticket_id'
        )->withTimestamps();
    }
}