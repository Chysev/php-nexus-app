const fs = require('fs');
require('dotenv').config();
const schemaFile = './prisma/schema.prisma';
const outputFile = './src/lib/prisma.php';

const schemaContent = fs.readFileSync(schemaFile, 'utf-8');
const models = schemaContent
  .split('\n')
  .filter((line) => line.trim().startsWith('model'))
  .map((line) => line.split(' ')[1]);

const generateMethods = (model) => `
    public function findMany${model}($where = [], $select = [], $orderBy = null, $limit = null, $offset = null) {
        return $this->findMany("${model}", $where, $select, $orderBy, $limit, $offset);
    }

    public function findUnique${model}($where, $select = []) {
        return $this->findUnique("${model}", $where, $select);
    }

    public function findFirst${model}($where = [], $select = [], $orderBy = null) {
        return $this->findFirst("${model}", $where, $select, $orderBy);
    }

    public function count${model}($where = []) {
        return $this->count("${model}", $where);
    }

    public function create${model}($data) {
        return $this->create("${model}", $data);
    }

    public function update${model}($data, $where) {
        return $this->update("${model}", $data, $where);
    }

    public function delete${model}($where) {
        return $this->delete("${model}", $where);
    }
`;

const generatedClass = `
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

    ${models.map((model) => generateMethods(model)).join('\n')}
}
`;

fs.writeFileSync(outputFile, generatedClass);
console.log('Prisma.php generated successfully!');
