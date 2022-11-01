<?php

namespace App\Validation;

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

}