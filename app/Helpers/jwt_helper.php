<?php

use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

const JWT_TIME_TO_LIVE = 3600;
const JWT_SECRET_KEY = 'kzUf4sxss4AeG5uHkNZAqT1Nyi1zVfpz';

function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader)) { //JWT is absent
        throw new Exception('Missing or invalid JWT in request');
    }
    //JWT is sent from client in the format Bearer XXXXXXXXX
    return explode(' ', $authenticationHeader)[1];
}

function validateJWTFromRequest(string $encodedToken)
{
    $key = getSecretKey();
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));
    $userModel = new UserModel();
    $userModel->findUserByUsername($decodedToken->username);
}

function getSignedJWTForUser(string $username)
{
    $issuedAtTime = time();
    $tokenTimeToLive = getJwtTimeToLive();
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
    $payload = [
        'username' => $username,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration,
    ];

    return JWT::encode($payload, getSecretKey(), 'HS256');
}

function getJwtTimeToLive()
{
    return JWT_TIME_TO_LIVE;
}

function getSecretKey(){
    return JWT_SECRET_KEY;
}