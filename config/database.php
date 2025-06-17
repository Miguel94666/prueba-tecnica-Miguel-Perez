<?php
class Database {
    private $host = "localhost";
    private $db_name = "menu_system";
    private $username = "root";
    private $password = "Miguelon123=)";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, //el mysql:host sirve para establecer el host de la base de datos
            $this->username, $this->password); // esta línea establece la conexión a la base de datos
            $this->conn->exec("set names utf8"); //esta linea sirve para establecer la codificación de caracteres
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>