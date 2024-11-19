
<?php

class Prisma {
    private $pdo;

    public function __construct($dsn, $user, $password) {
        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    private function buildSelectClause($select) {
        if (empty($select)) {
            return '*';
        }
        return implode(", ", $select);
    }

    public function findMany($table, $where = [], $select = [], $orderBy = null, $limit = null, $offset = null) {
        $fields = $this->buildSelectClause($select);
        $query = "SELECT $fields FROM $table";
        $params = [];

        if (!empty($where)) {
            $whereClause = implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($where)));
            $query .= " WHERE $whereClause";
            $params = $where;
        }

        if ($orderBy) {
            $query .= " ORDER BY " . implode(", ", array_map(fn($key, $value) => "$key $value", array_keys($orderBy), $orderBy));
        }

        if ($limit !== null) {
            $query .= " LIMIT :limit";
            $params['limit'] = $limit;
        }

        if ($offset !== null) {
            $query .= " OFFSET :offset";
            $params['offset'] = $offset;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findUnique($table, $where, $select = []) {
        $fields = $this->buildSelectClause($select);
        $whereClause = implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($where)));
        $query = "SELECT $fields FROM $table WHERE $whereClause LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($where);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findFirst($table, $where = [], $select = [], $orderBy = null) {
        $fields = $this->buildSelectClause($select);
        $query = "SELECT $fields FROM $table";
        $params = [];

        if (!empty($where)) {
            $whereClause = implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($where)));
            $query .= " WHERE $whereClause";
            $params = $where;
        }

        if ($orderBy) {
            $query .= " ORDER BY " . implode(", ", array_map(fn($key, $value) => "$key $value", array_keys($orderBy), $orderBy));
        }

        $query .= " LIMIT 1";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function count($table, $where = []) {
        $query = "SELECT COUNT(*) AS count FROM $table";
        $params = [];

        if (!empty($where)) {
            $whereClause = implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($where)));
            $query .= " WHERE $whereClause";
            $params = $where;
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }

    public function create($table, $data) {
        $keys = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));

        $stmt = $this->pdo->prepare("INSERT INTO $table ($keys) VALUES ($values)");
        $stmt->execute($data);

        return $this->pdo->lastInsertId();
    }

    public function update($table, $data, $where) {
        $fields = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));
        $whereClause = implode(" AND ", array_map(fn($key) => "$key = :where_$key", array_keys($where)));
        $params = array_merge($data, array_combine(array_map(fn($key) => "where_$key", array_keys($where)), array_values($where)));

        $stmt = $this->pdo->prepare("UPDATE $table SET $fields WHERE $whereClause");
        $stmt->execute($params);

        return $stmt->rowCount();
    }

    public function delete($table, $where) {
        $whereClause = implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($where)));
        $stmt = $this->pdo->prepare("DELETE FROM $table WHERE $whereClause");
        $stmt->execute($where);

        return $stmt->rowCount();
    }

    
    public function findManyUser($where = [], $select = [], $orderBy = null, $limit = null, $offset = null) {
        return $this->findMany("User", $where, $select, $orderBy, $limit, $offset);
    }

    public function findUniqueUser($where, $select = []) {
        return $this->findUnique("User", $where, $select);
    }

    public function findFirstUser($where = [], $select = [], $orderBy = null) {
        return $this->findFirst("User", $where, $select, $orderBy);
    }

    public function countUser($where = []) {
        return $this->count("User", $where);
    }

    public function createUser($data) {
        return $this->create("User", $data);
    }

    public function updateUser($data, $where) {
        return $this->update("User", $data, $where);
    }

    public function deleteUser($where) {
        return $this->delete("User", $where);
    }


    public function findManyRole($where = [], $select = [], $orderBy = null, $limit = null, $offset = null) {
        return $this->findMany("Role", $where, $select, $orderBy, $limit, $offset);
    }

    public function findUniqueRole($where, $select = []) {
        return $this->findUnique("Role", $where, $select);
    }

    public function findFirstRole($where = [], $select = [], $orderBy = null) {
        return $this->findFirst("Role", $where, $select, $orderBy);
    }

    public function countRole($where = []) {
        return $this->count("Role", $where);
    }

    public function createRole($data) {
        return $this->create("Role", $data);
    }

    public function updateRole($data, $where) {
        return $this->update("Role", $data, $where);
    }

    public function deleteRole($where) {
        return $this->delete("Role", $where);
    }

}
