<?php

namespace App\Controllers;

use App\Models\EventTypeModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class EventTypes extends BaseController
{
    public function findAll()
    {
        $model = new EventTypeModel;
        $data = $model->findAll();
        return $this->getResponse(
            $data
        );
    }

    public function store()
    {
        $rules = [
            'event_type_name' => 'required|is_unique[event_type.event_type_name]',
            'color' => 'required|is_unique[event_type.color]',
        ];

        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, $rules)) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }

        $eventTypeName = $input['event_type_name'];

        $model = new EventTypeModel;
        $model->save($input);

        $eventType = $model->findEventTypeByEventTypeName($eventTypeName);

        return $this->getResponse(
            [
                'message' => 'Event type added successfully',
                'eventType' => $eventType
            ]
        );
    }

    public function show($id)
    {
        try {

            $model = new EventTypeModel;
            $eventType = $model->findEventTypeById($id);

            return $this->getResponse(
                [
                    'message' => 'Event type retrieved successfully',
                    'eventType' => $eventType
                ]
            );

        } catch (Exception $e) {
            return $this->getResponse(
                [
                    'message' => 'Could not find Event type for specified ID'
                ],
                ResponseInterface::HTTP_NOT_FOUND
            );
        }
    }

    public function update($id)
    {
        try {
            $model = new EventTypeModel;
            $model->findEventTypeById($id);

            $input = $this->getRequestInput($this->request);

            $model->update($id, $input);
            $eventType = $model->findEventTypeById($id);

            return $this->getResponse(
                [
                    'message' => 'Event type updated successfully',
                    'eventType' => $eventType
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

            $model = new EventTypeModel;
            $model->findEventTypeById($id);
            $model->delete($id);

            return $this
                ->getResponse(
                    [
                        'message' => 'Event type deleted successfully',
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