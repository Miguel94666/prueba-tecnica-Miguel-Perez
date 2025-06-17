<?php
require_once(__DIR__ . "/../models/Menu.php");

class MenuController
{
    private $model;
    private $menuModel;

    public function __construct()
    {
        $this->model = new Menu(); // esta es la instancia del modelo que se usará para las operaciones CRUD
        $this->menuModel = new Menu(); // esta es la instancia del modelo que se usará para las operaciones de menú
    }

    public function create()
    {
        // Obtener todos los menús para el selector de padre
        $allMenus = $this->model->getAll();

        // Incluir la vista con el formulario
        include(__DIR__ . "/../views/menu/create.php");
    }

    public function index()
    {
        require_once(__DIR__ . '/../models/Menu.php');
        $this->menuModel = new Menu();

        // Lógica de paginación
        $por_pagina = 5;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1; //isset verifica si la variable existe, si no, se asigna 1
        $inicio = ($pagina - 1) * $por_pagina;

        $menus = $this->menuModel->getPaginated($inicio, $por_pagina);
        $total_registros = $this->menuModel->getTotalCount();
        $total_paginas = ceil($total_registros / $por_pagina);

        require_once(__DIR__ . '/../views/menu/index.php');
    }

    

    public function store()
    {
        $this->model->create($_POST['name'], $_POST['parent'], $_POST['description']);
        header("Location: index.php");
    }

    public function edit($id)
    {
        $menu = $this->model->getById($id);
        include(__DIR__ . "/../views/menu/edit.php");
    }

    public function update($id)
    {
        $this->model->update($id, $_POST['name'], $_POST['parent'], $_POST['description']); // el método update recibe el id del menú y los nuevos datos, el _POST es un array que contiene los datos del formulario
        header("Location: index.php"); // el header redirige a la página de índice después de actualizar
    }

    public function delete($id)
    {
        $this->model->delete($id);
        header("Location: index.php");
    }

    public function mostrarDescripcion($id_menu)
    {
        $menu = $this->menuModel->getById($id_menu);
        include __DIR__ . '/../views/menu/descripcion.php';
    }
}
