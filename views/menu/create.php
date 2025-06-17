<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Menú</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="sidebar">
        <h2>Menú</h2>
        <?php
        // Verificar si se ha seleccionado un menú activo
        // Si no se ha seleccionado, se mostrará el listado de menús
        $active_id_menu = isset($_GET['id_menu']) ? $_GET['id_menu'] : null;
        ?>
        <?php
        require_once(__DIR__ . '/../../models/Menu.php');
        $menuModel = new Menu();
        $allMenus = $menuModel->getAll();
        foreach ($allMenus as $item) {
            $is_active = ($active_id_menu !== null && $item['id_menu'] == $active_id_menu);
            echo "<a href='index.php?id_menu={$item['id_menu']}' " . ($is_active ? 'class="active-sidebar-item"' : '') . ">{$item['name']}</a>";
        }
        ?>
        <div class="admin-section">
            <h2>Administración</h2>
            <a href="index.php" <?php echo ($active_id_menu === null && !isset($_GET['action'])) ? 'class="active-sidebar-item"' : ''; ?>>Menus</a>
        </div>
    </div>

    <div class="main-content">
        <h2>Crear Nuevo Menú</h2>
        <form method="POST" action="index.php?action=store">
            <label>Nombre:</label><br>
            <input type="text" name="name" required><br><br>

            <label>Padre:</label><br>
            <select name="parent">
                <option value="">-- Ninguno --</option>
                <?php foreach ($allMenus as $item): ?>
                    <option value="<?= $item['id_menu'] ?>"><?= $item['name'] ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label>Descripción:</label><br>
            <textarea name="description" rows="4"></textarea><br><br>

            <button type="submit" class="button">Guardar</button>
            <a href="index.php" class="btn-eliminar">Cancelar</a>
        </form>
    </div>
</body>

</html>