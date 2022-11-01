<?php

namespace App\Models;

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

    public function findEventTypeByEventTypeName(string $eventTypeName)
    {
        $eventType = $this
            ->asArray()
            ->where(['event_type_name' => $eventTypeName])
            ->first();

        if (!$eventType)
            throw new Exception('Event type does not exist for specified event type name');

        return $eventType;
    }
}