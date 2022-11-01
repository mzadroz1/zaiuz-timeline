<?php

namespace App\Models;

use Exception;

class UserModel extends \CodeIgniter\Model
{
    protected $table = 'user';
    protected $allowedFields = [
        'username',
        'password',
    ];

    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data): array
    {
        return $this->updateDataWithHashedPassword($data);
    }

    protected function beforeUpdate(array $data): array
    {
        return $this->updateDataWithHashedPassword($data);
    }

    private function updateDataWithHashedPassword(array $data): array
    {
        if (isset($data['data']['password'])) {
            $plaintextPassword = $data['data']['password'];
            $data['data']['password'] = $this->hashPassword($plaintextPassword);
        }
        return $data;
    }

    private function hashPassword(string $plaintextPassword): string
    {
        return password_hash($plaintextPassword, PASSWORD_BCRYPT);
    }

    public function findUserByUsername(string $username)
    {
        $user = $this
            ->asArray()
            ->where(['username' => $username])
            ->first();

        if (!$user)
            throw new Exception('User does not exist for specified username');

        return $user;
    }
}