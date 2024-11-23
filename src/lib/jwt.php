<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHandler
{
    private static $key = 'kqnwdyqgdbvdbsbgvs';
    private static $algorithm = 'HS256';

    public static function generateToken($payload)
    {
        $payload['iat'] = time();
        $payload['exp'] = time() + (60 * 60 * 24);
        return JWT::encode($payload, self::$key, self::$algorithm);
    }

    public static function validateToken($token)
    {
        try {
            return (array)JWT::decode($token, new Key(self::$key, self::$algorithm));
        } catch (Exception $e) {
            return null; 
        }
    }
}
