DROP TABLE IF EXISTS `menus`;

CREATE TABLE `menus` (
  `id_menu` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_parent` INT UNSIGNED DEFAULT NULL,
  `status` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT,
  PRIMARY KEY (`id_menu`),
  FOREIGN KEY (`id_parent`) REFERENCES `menus` (`id_menu`) ON DELETE SET NULL
);

-- =============================
-- Insertar MENÚS PRINCIPALES
-- =============================

-- Insertar "Catálogos" (padre)
INSERT INTO menus (id_parent, status, name, description)
VALUES (NULL, 1, 'Catálogos', 'Sección principal de catálogos');
SET @id_cat = LAST_INSERT_ID();

-- Insertar "Administración" (padre)
INSERT INTO menus (id_parent, status, name, description)
VALUES (NULL, 1, 'Administración', 'Sección para administración del sistema');
SET @id_admin = LAST_INSERT_ID();

-- =============================
-- Submenús bajo "Catálogos"
-- =============================
INSERT INTO menus (id_parent, status, name, description) VALUES
(@id_cat, 1, 'Países', 'Listado de países disponibles'),
(@id_cat, 1, 'Estados', 'Estados organizados por país'),
(@id_cat, 1, 'Ciudades', 'Catálogo de ciudades');

-- =============================
-- Submenús bajo "Administración"
-- =============================
INSERT INTO menus (id_parent, status, name, description) VALUES
(@id_admin, 1, 'Menús', 'Gestión de menús del sistema'),
(@id_admin, 1, 'Usuarios', 'Gestión de usuarios del sistema'),
(@id_admin, 1, 'Permisos', 'Asignación de permisos a roles');