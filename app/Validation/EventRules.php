<?php

namespace App\Validation;

use App\Models\EventTypeModel;
use Exception;

class EventRules
{
    public static function getEventRules() {
        return [
            'event_name' => 'required',
            'event_start_date' => 'required',
            'event_end_date' => 'required|validateEventEndDate[event_start_date, event_end_date]',
            'short_description' => 'required',
            'description' => 'required',
            'event_type_id' => 'required|validateEventType[event_type_id]',
        ];
    }

    public static function getEventValidationErrorMessages() {
        return [
            'event_end_date' => [
                'validateEventEndDate' => 'Event end date has to be later or equal to the event start date'
            ],
            'event_type_id' => [
                'validateEventType' => 'Event type with specified id does not exist'
            ]
        ];
    }

    public static function getEventTypeRules() {
        return [
            'event_type_name' => 'required|is_unique[event_type.event_type_name]',
            'color' => 'required|is_unique[event_type.color]',
        ];
    }

    public function validateEventEndDate(string $str, string $fields, array $data): bool
    {
        try {
            $eventStartDate = new \DateTime($data['event_start_date']);
            $eventEndDate = new \DateTime($data['event_end_date']);
            return $eventEndDate >= $eventStartDate;
        } catch (Exception $e) {
            return false;
        }
    }

    public function validateEventType(string $str, string $fields, array $data): bool
    {
        try {
            $model = new EventTypeModel;
            $eventType = $model->findEventTypeById($data['event_type_id']);
            return $eventType != null;
        } catch (Exception $e) {
            return false;
        }
    }

}