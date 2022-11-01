<?php

namespace App\Controllers;

use App\Models\EventModel;
use CodeIgniter\HTTP\ResponseInterface;

class Events extends BaseController
{
    public function findAll()
    {
        $model = new EventModel;
        $data = $model->findAll();
        return $this->getResponse(
            $data
        );
    }

    public function store()
    {
        $rules = [
            'event_name' => 'required',
            'event_start_date' => 'required',
            'event_end_date' => 'required|validateEventEndDate[event_start_date, event_end_date]',
            'short_description' => 'required',
            'description' => 'required',
            'event_type_id' => 'required',
        ];

        $errors = [
            'event_end_date' => [
                'validateEventEndDate' => 'Event end date has to be later or equal to the event start date'
            ]
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules, $errors)) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }

        $event_name = $input['event_name'];

        $model = new EventModel;
        $model->save($input);

        $event = $model->findEventByEventName($event_name);

        return $this->getResponse(
            [
                'message' => 'Event added successfully',
                'event' => $event
            ]
        );
    }

    public function show($id)
    {
        try {

            $model = new EventModel;
            $event = $model->findEventById($id);

            return $this->getResponse(
                [
                    'message' => 'Event retrieved successfully',
                    'event' => $event
                ]
            );

        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Could not find Event for specified ID'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function update($id)
    {
        try {
            $model = new EventModel;
            $model->findEventById($id);

            $input = $this->getRequestInput($this->request);

            $model->update($id, $input);
            $event = $model->findEventById($id);

            return $this->getResponse(
                [
                    'message' => 'Event updated successfully',
                    'event' => $event
                ]
            );

        } catch (Exception $exception) {

            return $this->getResponse(
                [
                    'message' => $exception->getMessage()
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function destroy($id)
    {
        try {

            $model = new EventModel;
            $event = $model->findEventById($id);
            $model->delete($event);

            return $this
                ->getResponse(
                    [
                        'message' => 'Event deleted successfully',
                    ]
                );

        } catch (Exception $exception) {
            return $this->getResponse(
                [
                    'message' => $exception->getMessage()
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }
}
