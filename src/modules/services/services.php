<?php

require_once __DIR__ . '/../../lib/prisma.php';

class service
{
    private static $prisma;

    public static function init($prismaInstance)
    {
        self::$prisma = $prismaInstance;
    }

    // USER
    public static function getAllUsers()
    {
        return self::$prisma->findManyUser();
    }

    public static function getUserById($id)
    {
        return self::$prisma->findUniqueUser(['id' => $id]);
    }

    public static function createUser($data)
    {
        $body = [
            'name' => $data['name'],
            'email' => $data['email']
        ];

        if (isset($data['role_id'])) {
            $body['role_id'] = $data['role_id'];
        }

        error_log('Body for createUser: ' . json_encode($body));

        return self::$prisma->createUser($body);
    }


    public static function updateUser($id, $data)
    {
        return self::$prisma->updateUser($data, ['id' => $id]);
    }

    public static function deleteUser($id)
    {
        return self::$prisma->deleteUser(['id' => $id]);
    }

    public static function getAllRoles()
    {
        return self::$prisma->findManyRole();
    }

    public static function getRoleById($id)
    {
        return self::$prisma->findUniqueRole(['id' => $id]);
    }


    // ROLE
    public static function createRole($data)
    {
        $body = [
            'name' => $data['name']
        ];

        error_log('Body for createRole: ' . json_encode($body));

        return self::$prisma->createRole($body);
    }


    public static function updateRole($id, $data)
    {
        return self::$prisma->updateRole($data, ['id' => $id]);
    }

    public static function deleteRole($id)
    {
        return self::$prisma->deleteRole(['id' => $id]);
    }
}
