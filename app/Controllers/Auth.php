<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Validation\AuthenticationRules;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Auth extends BaseController
{

    public function register()
    {
        $input = $this->getRequestInput($this->request);
        if (!$this->validateRequest($input, AuthenticationRules::getRegistrationRules())) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }

        $userModel = new UserModel();
        $userModel->save($input);

        return $this
            ->getJWTForUser(
                $input['username'],
                ResponseInterface::HTTP_CREATED
            );

    }

    public function login()
    {
        $input = $this->getRequestInput($this->request);


        if (!$this->validateRequest($input, AuthenticationRules::getLoginRules(), AuthenticationRules::getLoginValidationErrorMessages())) {
            return $this
                ->getResponse(
                    $this->validator->getErrors(),
                    ResponseInterface::HTTP_BAD_REQUEST
                );
        }
        return $this->getJWTForUser($input['username']);


    }

    private function getJWTForUser(
        string $username,
        int    $responseCode = ResponseInterface::HTTP_OK
    )
    {
        try {
            $model = new UserModel();
            $user = $model->findUserByUsername($username);
            unset($user['password']);

            helper('jwt');

            return $this
                ->getResponse(
                    [
                        'message' => 'User authenticated successfully',
                        'user' => $user,
                        'access_token' => getSignedJWTForUser($username)
                    ]
                );
        } catch (Exception $exception) {
            return $this
                ->getResponse(
                    [
                        'error' => $exception->getMessage(),
                    ],
                    $responseCode
                );
        }
    }
}