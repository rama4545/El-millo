<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "tu_clave";
    private $dbname = "el_millo";
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        try {
            $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
            if ($this->connection->connect_error) {
                throw new Exception("Error de conexión: " . $this->connection->connect_error);
            }
            $this->connection->set_charset("utf8mb4");
        } catch (Exception $e) {
            die("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }

    public function executeQuery($sql, $params = [], $types = "") {
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->connection->error);
        }
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt;
    }
}

$db = new Database();
$conn = $db->getConnection();
?>
