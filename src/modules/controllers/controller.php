<?php

require_once __DIR__ . '/../../lib/send.php';
require_once __DIR__ . '/../services/services.php';

class controller
{
    // USER
    public static function getAllUsers()
    {
        try {
            $data = service::getAllUsers();
            send($data, 200);
        } catch (Exception $e) {
            send(['error' => 'Failed to get all users', 'details' => $e->getMessage()], 500);
        }
    }

    public static function getUserById($id)
    {
        if (!is_numeric($id)) {
            send(['error' => 'Invalid user ID'], 400);
            return;
        }

        try {
            $data = service::getUserById($id);
            if (!$data) {
                send(['error' => 'User not found'], 404);
            } else {
                send($data, 200);
            }
        } catch (Exception $e) {
            send(['error' => 'Failed to get user', 'details' => $e->getMessage()], 500);
        }
    }

    public static function createUser()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        error_log('Input received for createUser: ' . json_encode($input));

        if (
            !$input || !isset($input['name']) || !isset($input['email'])
        ) {
            send(['error' => 'Name and Email are required'], 400);
            return;
        }

        if (isset($input['role_id']) && !is_numeric($input['role_id'])) {
            send(['error' => 'Invalid role_id'], 400);
            return;
        }

        try {
            $data = service::createUser($input);
            send(['success' => true, 'user' => $data], 201);
        } catch (Exception $e) {
            send(['error' => 'Failed to create user', 'details' => $e->getMessage()], 500);
        }
    }


    public static function updateUser($id)
    {
        if (!is_numeric($id)) {
            send(['error' => 'Invalid user ID'], 400);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input || empty($input)) {
            send(['error' => 'No data provided to update'], 400);
            return;
        }

        try {
            $data = service::updateUser($id, $input);
            if ($data === 0) {
                send(['message' => 'No changes made or user not found'], 200);
            } else {
                send(['success' => true], 200);
            }
        } catch (Exception $e) {
            send(['error' => 'Failed to update user', 'details' => $e->getMessage()], 500);
        }
    }

    public static function deleteUser($id)
    {
        if (!is_numeric($id)) {
            send(['error' => 'Invalid user ID'], 400);
            return;
        }

        try {
            $data = service::deleteUser($id);
            if ($data === 0) {
                send(['error' => 'User not found'], 404);
            } else {
                send(['success' => true, 'message' => 'User deleted'], 200);
            }
        } catch (Exception $e) {
            send(['error' => 'Failed to delete user', 'details' => $e->getMessage()], 500);
        }
    }

    // ROLE
    public static function getAllRoles()
    {
        try {
            $data = service::getAllRoles();
            send($data, 200);
        } catch (Exception $e) {
            send(['error' => 'Failed to get all roles', 'details' => $e->getMessage()], 500);
        }
    }

    public static function getRoleById($id)
    {
        if (!is_numeric($id)) {
            send(['error' => 'Invalid role ID'], 400);
            return;
        }

        try {
            $data = service::getRoleById($id);
            if (!$data) {
                send(['error' => 'Role not found'], 404);
            } else {
                send($data, 200);
            }
        } catch (Exception $e) {
            send(['error' => 'Failed to get role', 'details' => $e->getMessage()], 500);
        }
    }

    public static function createRole()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        error_log('Input received for createRole: ' . json_encode($input));

        if (
            !$input || !isset($input['name'])
        ) {
            send(['error' => 'Name is required'], 400);
            return;
        }

        try {
            $data = service::createRole($input);
            send(['success' => true, 'role' => $data], 201);
        } catch (Exception $e) {
            send(['error' => 'Failed to create role', 'details' => $e->getMessage()], 500);
        }
    }


    public static function updateRole($id)
    {
        if (!is_numeric($id)) {
            send(['error' => 'Invalid role ID'], 400);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input || empty($input)) {
            send(['error' => 'No data provided to update'], 400);
            return;
        }

        try {
            $data = service::updateRole($id, $input);
            if ($data === 0) {
                send(['message' => 'No changes made or role not found'], 200);
            } else {
                send(['success' => true], 200);
            }
        } catch (Exception $e) {
            send(['error' => 'Failed to update role', 'details' => $e->getMessage()], 500);
        }
    }

    public static function deleteRole($id)
    {
        if (!is_numeric($id)) {
            send(['error' => 'Invalid role ID'], 400);
            return;
        }

        try {
            $data = service::deleteRole($id);
            if ($data === 0) {
                send(['error' => 'Role not found'], 404);
            } else {
                send(['success' => true, 'message' => 'Role deleted'], 200);
            }
        } catch (Exception $e) {
            send(['error' => 'Failed to delete role', 'details' => $e->getMessage()], 500);
        }
    }
}
