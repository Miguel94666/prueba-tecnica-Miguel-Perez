<?php
require_once(__DIR__ . "/../config/Database.php");

class Menu {
    private $conn;
    private $table = "menus";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE status = 1");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id_menu = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name, $parent, $desc)
    {
        // Convertir string vacío a NULL
        $parent = $parent !== '' ? $parent : null; //

        $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " (name, id_parent, description, status) VALUES (:name, :parent, :description, 1)");

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":parent", $parent, PDO::PARAM_INT); 
        $stmt->bindParam(":description", $desc);

        return $stmt->execute();
    }


    public function update($id, $name, $parent, $desc) {
        $parent = $parent !== '' ? $parent : null; //
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET name = :name, id_parent = :parent, description = :description WHERE id_menu = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":parent", $parent);
        $stmt->bindParam(":description", $desc);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET status = 0 WHERE id_menu = :id");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }



    public function getPaginated($inicio, $limite)
    {
        // Agregar WHERE status = 1 para mostrar solo registros activos
        $stmt = $this->conn->prepare("SELECT * FROM menus WHERE status = 1 LIMIT :inicio, :limite");
        $stmt->bindValue(':inicio', (int)$inicio, PDO::PARAM_INT);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalCount()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM menus WHERE status = 1");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
?>