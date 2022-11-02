<?php

namespace App\Validation;

use App\Models\EventTypeModel;
use Exception;

class EventRules
{
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