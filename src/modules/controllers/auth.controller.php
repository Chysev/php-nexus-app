<?php

require_once __DIR__ . '/../../lib/send.php';
require_once __DIR__ . '/../services/auth.services.php';
require_once __DIR__ . '/../../lib/jwt.php';

class AuthController
{
    public static function login()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);

            if (empty($input['email']) || empty($input['password'])) {
                send(['error' => 'Email and Password are required'], 400);
                return;
            }

            $user = AuthService::login($input['email'], $input['password']);

            if (!$user) {
                send(['error' => 'Invalid credentials'], 401);
                return;
            }

            $token = JWTHandler::generateToken([
                'id' => $user['id']
            ]);

            send(['success' => true, 'message' => 'Login successful', 'token' => $token], 200);
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            send(['error' => 'Login failed', 'details' => $e->getMessage()], 500);
        }
    }

    public static function register()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);

            if (empty($input['name']) || empty($input['email']) || empty($input['password'])) {
                send(['error' => 'Name, Email, and Password are required'], 400);
                return;
            }

            if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
                send(['error' => 'Invalid email format'], 400);
                return;
            }

            $input['password'] = password_hash($input['password'], PASSWORD_BCRYPT);

            $result = AuthService::register($input);

            if (isset($result['error']) && $result['error']) {
                send(['error' => $result['message']], 400);
                return;
            }

            send(['success' => true, 'message' => 'User registered successfully', 'user' => $result['user']], 201);
        } catch (Exception $e) {
            error_log("Registration error: " . $e->getMessage());
            send(['error' => 'Registration failed', 'details' => $e->getMessage()], 500);
        }
    }

    public static function session()
    {
        try {
            $token = $_COOKIE['auth_token'] ?? null;

            if (!$token) {
                send(['authenticated' => false, 'message' => 'Token not found'], 401);
                return;
            }

            $sessionResponse = AuthService::session($token);

            if ($sessionResponse['authenticated']) {
                send(['authenticated' => true, 'user' => $sessionResponse['user']], 200);
            } else {
                send(['authenticated' => false, 'message' => $sessionResponse['message']], 401);
            }
        } catch (Exception $e) {
            error_log("Session validation error: " . $e->getMessage());
            send(['authenticated' => false, 'message' => 'Session validation failed'], 500);
        }
    }
}
