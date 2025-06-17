<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Descripción del Menú</title>
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
        <h2>Descripción del Menú</h2>
        <?php if ($menu): ?>
            <p><strong>Nombre:</strong> <?= htmlspecialchars($menu['name']) ?></p>
            <p><strong>Descripción:</strong> <?= htmlspecialchars($menu['description']) ?></p>
        <?php else: ?>
            <p>Menú no encontrado.</p>
        <?php endif; ?>
    </div>
</body>

</html>