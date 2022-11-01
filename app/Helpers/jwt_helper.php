<?php

use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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

    $jwt = JWT::encode($payload, getSecretKey(), 'HS256');
    return $jwt;
}

function getJwtTimeToLive()
{
    return getenv('JWT_TIME_TO_LIVE');
}

function getSecretKey(){
    return getenv('JWT_SECRET_KEY');
}