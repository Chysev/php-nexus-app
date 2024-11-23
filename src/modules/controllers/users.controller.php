<?php

require_once __DIR__ . '/../../lib/send.php';
require_once __DIR__ . '/../services/users.services.php';

class UserController
{
    // USER
    public static function getAllUsers()
    {
        try {
            $data = UserService::getAllUsers();
            send($data);
        } catch (Exception $e) {
            send(['error' => 'Failed to get all users', 'details' => $e->getMessage()]);
        }
    }

    public static function getUserById($id)
    {
        if (!is_numeric($id)) {
            send(['error' => 'Invalid user ID']);
            return;
        }

        try {
            $data = UserService::getUserById($id);
            if (!$data) {
                send(['error' => 'User not found']);
            } else {
                send($data);
            }
        } catch (Exception $e) {
            send(['error' => 'Failed to get user', 'details' => $e->getMessage()]);
        }
    }


    public static function updateUser($id)
    {
        if (!is_numeric($id)) {
            send(['error' => 'Invalid user ID']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input || empty($input)) {
            send(['error' => 'No data provided to update']);
            return;
        }

        try {
            $data = UserService::updateUser($id, $input);
            if ($data === 0) {
                send(['message' => 'No changes made or user not found']);
            } else {
                send(['success' => true]);
            }
        } catch (Exception $e) {
            send(['error' => 'Failed to update user', 'details' => $e->getMessage()]);
        }
    }

    public static function deleteUser($id)
    {
        if (!is_numeric($id)) {
            send(['error' => 'Invalid user ID']);
            return;
        }

        try {
            $data = UserService::deleteUser($id);
            if ($data === 0) {
                send(['error' => 'User not found']);
            } else {
                send(['success' => true, 'message' => 'User deleted']);
            }
        } catch (Exception $e) {
            send(['error' => 'Failed to delete user', 'details' => $e->getMessage()]);
        }
    }

    // ROLE
    public static function getAllRoles()
    {
        try {
            $data = UserService::getAllRoles();
            send($data);
        } catch (Exception $e) {
            send(['error' => 'Failed to get all roles', 'details' => $e->getMessage()]);
        }
    }

    public static function getRoleById($id)
    {
        if (!is_numeric($id)) {
            send(['error' => 'Invalid role ID']);
            return;
        }

        try {
            $data = UserService::getRoleById($id);
            if (!$data) {
                send(['error' => 'Role not found']);
            } else {
                send($data);
            }
        } catch (Exception $e) {
            send(['error' => 'Failed to get role', 'details' => $e->getMessage()]);
        }
    }

    public static function createRole()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        error_log('Input received for createRole: ' . json_encode($input));

        if (
            !$input || !isset($input['name'])
        ) {
            send(['error' => 'Name is required']);
            return;
        }

        try {
            $data = UserService::createRole($input);
            send(['success' => true, 'role' => $data]);
        } catch (Exception $e) {
            send(['error' => 'Failed to create role', 'details' => $e->getMessage()]);
        }
    }


    public static function updateRole($id)
    {
        if (!is_numeric($id)) {
            send(['error' => 'Invalid role ID']);
            return;
        }

        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input || empty($input)) {
            send(['error' => 'No data provided to update']);
            return;
        }

        try {
            $data = UserService::updateRole($id, $input);
            if ($data === 0) {
                send(['message' => 'No changes made or role not found']);
            } else {
                send(['success' => true]);
            }
        } catch (Exception $e) {
            send(['error' => 'Failed to update role', 'details' => $e->getMessage()]);
        }
    }

    public static function deleteRole($id)
    {
        if (!is_numeric($id)) {
            send(['error' => 'Invalid role ID']);
            return;
        }

        try {
            $data = UserService::deleteRole($id);
            if ($data === 0) {
                send(['error' => 'Role not found']);
            } else {
                send(['success' => true, 'message' => 'Role deleted']);
            }
        } catch (Exception $e) {
            send(['error' => 'Failed to delete role', 'details' => $e->getMessage()]);
        }
    }
}
