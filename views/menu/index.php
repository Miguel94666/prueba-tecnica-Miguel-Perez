<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Menús</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<!-- Modal de confirmación -->
<div id="modal-confirmar" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(44,62,80,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; padding:30px 20px; border-radius:8px; max-width:350px; margin:auto; text-align:center; box-shadow:0 2px 10px rgba(0,0,0,0.2);">
        <h3>¿Estás seguro?</h3>
        <p>Esta acción no se puede deshacer.</p>
        <button id="modal-cancelar" class="btn-cancelar">Cancelar</button>
        <button id="modal-confirmar-borrar" class="button btn-eliminar">Eliminar</button>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        let enlaceEliminar = null;
        const modal = document.getElementById('modal-confirmar');
        const btnCancelar = document.getElementById('modal-cancelar');
        const btnConfirmar = document.getElementById('modal-confirmar-borrar');

        document.querySelectorAll('.btn-confirmar-eliminar').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                enlaceEliminar = btn;
                modal.style.display = 'flex';
            });
        });

        btnCancelar.addEventListener('click', function() {
            modal.style.display = 'none';
            enlaceEliminar = null;
        });

        btnConfirmar.addEventListener('click', function() {
            if (enlaceEliminar) {
                window.location.href = enlaceEliminar.href;
            }
        });

        // Cerrar modal al hacer click fuera del cuadro
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
                enlaceEliminar = null;
            }
        });
    });
</script>

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
        <h2>Listado de Menús</h2>
        <a class="button" href="index.php?action=create">Agregar Nuevo</a>
        <br><br>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Padre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($menus as $menu): ?>
                <tr>
                    <td><?= $menu['id_menu'] ?></td>
                    <td><?= $menu['name'] ?></td>
                    <td>
                        <?php
                        if (!empty($menu['id_parent'])) {
                            // Buscar el nombre del menú padre en $allMenus
                            $parentName = '';
                            foreach ($allMenus as $item) {
                                if ($item['id_menu'] == $menu['id_parent']) {
                                    $parentName = $item['name'];
                                    break;
                                }
                            }
                            echo htmlspecialchars($parentName);
                        } else {
                            echo '-';
                        }
                        ?>
                    </td>
                    <!-- Mostrar el nombre del padre si existe -->
                    <td><?= $menu['description'] ?></td>
                    <td>
                        <a class="btn-editar" " href=" index.php?action=edit&id=<?= $menu['id_menu'] ?>">Editar</a>
                        <a class="btn-eliminar btn-confirmar-eliminar" href="index.php?action=delete&id=<?= $menu['id_menu'] ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Agrego un debug para verificar las variables -->
        <?php
        // Descomentar para depurar
        // echo "Página actual: " . (isset($pagina) ? $pagina : 'No definida') . "<br>";
        // echo "Total páginas: " . (isset($total_paginas) ? $total_paginas : 'No definida') . "<br>";
        ?>

        <!-- PAGINACIÓN -->
        <?php if (isset($total_paginas) && $total_paginas > 1): ?>
            <div style="margin-top: 20px; text-align: center;">
                <ul style="list-style: none; padding: 0; display: inline-flex;">
                    <!-- Botón anterior -->
                    <li>
                        <a href="index.php?pagina=<?= max(1, $pagina - 1) ?>" style="padding: 8px 12px; border: 1px solid #ccc; text-decoration: none; color: #333; display: inline-block; margin-right: -1px;">&laquo;</a>
                    </li>

                    <!-- Números de página -->
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <li>
                            <?php if ($i == $pagina): ?>
                                <span style="padding: 8px 12px; border: 1px solid #007bff; background-color: #007bff; color: white; display: inline-block; margin-right: -1px;"><?= $i ?></span>
                            <?php else: ?>
                                <a href="index.php?pagina=<?= $i ?>" style="padding: 8px 12px; border: 1px solid #ccc; text-decoration: none; color: #333; display: inline-block; margin-right: -1px;"><?= $i ?></a>
                            <?php endif; ?>
                        </li>
                    <?php endfor; ?>

                    <!-- Botón siguiente -->
                    <li>
                        <a href="index.php?pagina=<?= min($total_paginas, $pagina + 1) ?>" style="padding: 8px 12px; border: 1px solid #ccc; text-decoration: none; color: #333; display: inline-block; margin-right: -1px;">&raquo;</a>
                    </li>
                </ul>
            </div>
        <?php else: ?>
            <!-- Para depurar - si no hay paginación, muestra por qué -->
            <!-- <p>No se muestra paginación: <?= isset($total_paginas) ? "Total páginas: $total_paginas (≤1)" : "Variable total_paginas no definida" ?></p> -->
        <?php endif; ?>
    </div>
</body>

</html>