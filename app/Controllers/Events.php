<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Validation\EventRules;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

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
        $input = $this->getRequestInput($this->request);

        if (!$this->validateRequest($input, EventRules::getEventRules(), EventRules::getEventValidationErrorMessages())) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }

        $model = new EventModel;
        $model->save($input);

        $event = $model->findEventById($model->getInsertID());

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

            if (!$this->validateRequest($input, EventRules::getEventRules(), EventRules::getEventValidationErrorMessages())) {
                return $this
                    ->getResponse(
                        $this->validator->getErrors(),
                        ResponseInterface::HTTP_BAD_REQUEST
                    );
            }

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
            $model->findEventById($id);
            $model->delete($id);

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
