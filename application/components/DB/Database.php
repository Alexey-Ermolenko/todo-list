<?php

namespace Application\components\DB;

use Exception;
use PDO;

class Database
{
    private PDO $db;

    public function __construct() {
        $db = new PDO('sqlite:data.sqlite', '', '', array(
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ));


        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db = $db;

        return $this;
    }

    /**
     * @param $query
     * @param null $params
     * @return void|null
     */
    public function queryValue($query, $params = null) {
        try {
            $result = null;
            $stmt = $this->db->prepare($query);

            if ($stmt->execute($params)) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $stmt->closeCursor();
            }

            return $result;
        } catch(Exception $e) {
            $this->report($e);
        }
    }

    /**
     * @param $query
     * @param null $params
     * @return array|void
     */
    public function queryValues($query, $params = null) {
        try {
            $result = null;
            $stmt = $this->db->prepare($query);

            if ($stmt->execute($params)) {
                $result = array();
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result[] = $row;
                }
            }

            return $result;
        } catch(Exception $e) {
            $this->report($e);
        }
    }

    /**
     * @param string$table
     * @param int $id
     * @return bool|void
     */
    public function deleteById(string $table, int $id)
    {
        try {
            $rs = $this->db->prepare('DELETE FROM ' . $table . ' WHERE id = :id;');
            $result = $rs->execute(['id' => (int)$id]);

            return $result;
        } catch (Exception $e) {
            $this->report($e);
        }
    }

    /**
     * @param string $table
     * @param array $fields
     * @param string $where
     * @param null $params
     * @return bool|void
     */
    public function update(string $table, array $fields, string $where, $params = null) {
        try {
            $sql = 'UPDATE ' . $table . ' SET ';
            $first = true;
            foreach (array_keys($fields) as $name) {
                if (!$first) {
                    $first = false;
                    $sql .= ', ';
                }
                $first = false;
                $sql .= $name . ' = :_' . $name;
            }
            if (!is_array($params)) {
                $params = [];
            }
            $sql .= ' WHERE ' . $where;
            $rs = $this->db->prepare($sql);
            $p = [];
            foreach ($params as $name => $val) {
                $p[':_' . $name] = $val;
            }
            $result = $rs->execute($p);
            return $result;
        } catch(Exception $e) {
            $this->report($e);
        }
    }

    /**
     * @param $table
     * @param $fields
     * @return string|null
     */
    public function insert($table, $fields): ?string
    {
        try {
            $result = null;
            $names = '';
            $vals = '';
            foreach ($fields as $name => $val) {
                if (isset($names[0])) {
                    $names .= ', ';
                    $vals .= ', ';
                }
                $names .= $name;
                $vals .= ':' . $name;
            }

            $sql = "INSERT INTO " . $table . ' (' . $names . ') VALUES (' . $vals . ')';
            $rs = $this->db->prepare($sql);

            foreach ($fields as $name => $val) {
                $rs->bindValue(':' . $name, $val);
            }

            if ($rs->execute()) {
                $result = $this->db->lastInsertId(null);
            }

            return $result;
        } catch (Exception $e) {
            $this->report($e);
        }
    }

    /**
     * @param $query
     * @param null $params
     * @return bool|void
     */
    public function sql($query, $params = null) {
        try {
            $result = null;
            $stmt = $this->db->prepare($query);
            return $stmt->execute($params);
        } catch(Exception $e) {
            $this->report($e);
        }
    }

    /**
     * @param $e
     */
    private function report($e) {
        throw $e;
    }
}
