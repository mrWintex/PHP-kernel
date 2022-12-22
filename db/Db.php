<?php
namespace App\Src\Core\Db;

use PDO;

class Db
{
    private PDO $db_connection;
    private array $settings = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    public function connect(array $dbConfig) : void
    {
        if(!isset($this->db_connection)) {
            $dsn = sprintf("mysql:host=%s;dbname=%s", $dbConfig["host"] ?? "", $dbConfig["database"]);
            $username = $dbConfig["user"];
            $password = $dbConfig["password"];

            $this->db_connection = new PDO($dsn, $username, $password, $this->settings);
        }
    }

    public function getResult($query, $params = [])
    {
        $result = $this->db_connection->prepare($query);
        $result->execute($params);
        return $result;
    }

    public function getOneColumn($query, $params = [])
    {
        $result = $this->GetResult($query, $params);
        return $result->fetchColumn();
    }

    public function getOneRow($query, $params = [])
    {
        return $this->GetResult($query, $params)->fetch();
    }

    public function getAllRows($query, $params = [])
    {
        return $this->GetResult($query, $params)->fetchAll();
    }

    public function exists($table, $column, $item)
    {
        $query = "SELECT * FROM $table WHERE $column = ?";
        $exists = ($this->GetAllRows($query, [$item])) ? true : false;
        return $exists;
    }

    public function executeQuery($query, $params = [])
    {
        $queryResult = $this->db_connection->prepare($query);
        $queryResult->execute($params);
        return ($queryResult) ? true : false;
    }
}
