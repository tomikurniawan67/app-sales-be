<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'vendor/firebase/php-jwt/src/JWT.php';
require_once 'vendor/firebase/php-jwt/src/JWTExceptionWithPayloadInterface.php';
require_once 'vendor/firebase/php-jwt/src/BeforeValidException.php';
require_once 'vendor/firebase/php-jwt/src/SignatureInvalidException.php';
require_once 'vendor/firebase/php-jwt/src/ExpiredException.php';
require_once 'vendor/firebase/php-jwt/src/Key.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \Firebase\JWT\JWTExceptionWithPayloadInterface;

function generate_jwt($payload) {
    $secret_key = 'test';
    $issued_at = time();
    $expiration_time = $issued_at + (60 * 60);

    $token_data = [
        'iat'  => $issued_at,
        'exp'  => $expiration_time,
        'data' => $payload
    ];

    return JWT::encode($token_data, $secret_key, 'HS256');
}

function validate_jwt($token) {
    $secret_key = 'test';
    try {
        $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
        return (array) $decoded;
    } catch (Exception $e) {
        return false;
    }
}