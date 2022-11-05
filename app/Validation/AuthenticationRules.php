<?php

namespace App\Validation;

use App\Models\UserModel;
use Exception;

class AuthenticationRules
{
    public static function getRegistrationRules() {
        return [
            'username' => 'required|min_length[6]|max_length[50]|is_unique[user.username]',
            'password' => 'required|min_length[8]|max_length[255]'
        ];
    }

    public static function getLoginRules() {
        return [
            'username' => 'required|min_length[6]|max_length[50]',
            'password' => 'required|min_length[8]|max_length[255]|validateUser[username, password]'
        ];
    }

    public static function getLoginValidationErrorMessages() {
        return [
            'password' => [
                'validateUser' => 'Invalid login credentials provided'
            ]
        ];
    }

    public function validateUser(string $str, string $fields, array $data): bool
    {
        try {
            $model = new UserModel();
            $user = $model->findUserByUsername($data['username']);
            return password_verify($data['password'], $user['password']);
        } catch (Exception $e) {
            return false;
        }
    }
}