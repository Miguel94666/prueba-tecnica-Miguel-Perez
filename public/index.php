<?php
require_once(__DIR__ . "/../controllers/MenuController.php");

$controller = new MenuController();

$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;
$id_menu = $_GET['id_menu'] ?? null;

// Si se seleccionó un ítem del sidebar (mostrar solo descripción)
if ($id_menu) {
    $controller->mostrarDescripcion($id_menu);
}
// Si se pidió una acción (create, edit, delete, etc.)
elseif ($action && method_exists($controller, $action)) {
    if ($id) {
        $controller->{$action}($id);
    } else {
        $controller->{$action}();
    }
}
// Vista por defecto (listado de menús)
else {
    $controller->index();
}
