<?php

namespace App\Models;

use Exception;

class EventTypeModel extends \CodeIgniter\Model
{
    protected $table = 'event_type';
    protected $allowedFields = [
        'event_type_name',
        'color',
    ];

    public function findEventTypeById(string $eventTypeId)
    {
        $eventType = $this
            ->asArray()
            ->where(['id' => $eventTypeId])
            ->first();

        if (!$eventType)
            throw new Exception('Event type does not exist for specified id');

        return $eventType;
    }
}