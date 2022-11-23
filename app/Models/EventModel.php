<?php

namespace App\Models;

use Exception;

class EventModel extends \CodeIgniter\Model
{
    protected $table = 'event';
    protected $allowedFields = [
        'event_name',
        'event_start_date',
        'event_end_date',
        'short_description',
        'description',
        'img_url',
        'event_type_id',
    ];

    public function findEventById(string $eventId)
    {
        $event = $this
            ->asArray()
            ->where(['id' => $eventId])
            ->first();

        if (!$event)
            throw new Exception('Event does not exist for specified id');

        return $event;
    }

    public function isThereEventWithEventTypeId(string $eventTypeId): bool
    {
        $event = $this
            ->asArray()
            ->where(['event_type_id' => $eventTypeId])
            ->first();

        if (!$event)
            return false;
        else
            return true;
    }
}