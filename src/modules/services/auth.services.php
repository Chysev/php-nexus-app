<?php

require_once __DIR__ . '/../../lib/prisma.php';

class AuthService
{
    private static $prisma;

    public static function init($prismaInstance)
    {
        self::$prisma = $prismaInstance;
    }

    public static function login($email, $password)
    {
        $data = self::$prisma->findUniqueUser(['email' => $email]);

        if (!$data || !password_verify($password, $data['password'])) {
            return null;
        }

        unset($data['password']);
        return $data;
    }

    public static function register($data)
    {
        $account = self::$prisma->findUniqueUser(['email' => $data['email']]);
        if ($account) {
            return [
                'error' => true,
                'message' => 'Account is already taken'
            ];
        }

        $body = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ];

        if (isset($data['role_id'])) {
            $body['role_id'] = $data['role_id'];
        }

        $newAccount = self::$prisma->createUser($body);

        unset($newAccount['password']);
        return [
            'success' => true,
            'user' => $newAccount
        ];
    }

    public static function session($token)
    {
        $payload = JWTHandler::validateToken($token);

        if (!$payload || !isset($payload['id'])) {
            return ['authenticated' => false, 'message' => 'Invalid or expired token'];
        }

        $user = self::$prisma->findUniqueUser(['id' => $payload['id']]);

        if (!$user) {
            return ['authenticated' => false, 'message' => 'User not found'];
        }

        unset($user['password']);
        return ['authenticated' => true, 'user' => $user];
    }
}
