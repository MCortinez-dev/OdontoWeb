CREATE DATABASE IF NOT EXISTS `odontoweb`;
USE `odontoweb`;

-- --------------------------------------------------------
-- 1. ESTRUCTURA DE LA TABLA: `administradores`
-- --------------------------------------------------------
CREATE TABLE `administradores` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `usuario` varchar(50) NOT NULL,
    `password_hash` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos (Usuario: admin | Contraseña: admin123)
INSERT INTO `administradores` (`id`, `usuario`, `password_hash`) VALUES
(1, 'admin', '$2y$10$IwjNFFVUk8SnHO.jORhN0OyhO15nJM7947BbOyxM6GSa5C/sKN1FK');


-- --------------------------------------------------------
-- 2. ESTRUCTURA DE LA TABLA: `especialidad`
-- --------------------------------------------------------
CREATE TABLE `especialidad` (
    `cod` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(50) NOT NULL,
    PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos de especialidades
INSERT INTO `especialidad` (`cod`, `nombre`) VALUES
(1, 'Odontología General'),
(2, 'Ortodoncia'),
(3, 'Implantes'),
(4, 'Blanqueamiento');


-- --------------------------------------------------------
-- 3. ESTRUCTURA DE LA TABLA: `medicos`
-- --------------------------------------------------------
CREATE TABLE `medicos` (
    `cod` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(50) NOT NULL,
    `apellido` varchar(50) NOT NULL,
    `id_especialidad` int(11) DEFAULT NULL,
    `franja_horaria` enum('mañana','tarde') NOT NULL,
    PRIMARY KEY (`cod`),
    KEY `id_especialidad` (`id_especialidad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos de los 10 médicos (Manteniendo a Darín y Sofía)
INSERT INTO `medicos` (`cod`, `nombre`, `apellido`, `id_especialidad`, `franja_horaria`) VALUES
(1, 'Carlos', 'Sánchez', 1, 'mañana'),
(2, 'Laura', 'Gómez', 2, 'mañana'),
(3, 'Marta', 'Díaz', 3, 'tarde'),
(4, 'Roberto', 'Pérez', 4, 'tarde'),
(5, 'Ricardo', 'Tapia', 1, 'tarde'),
(6, 'Elena', 'Blanco', 2, 'tarde'),
(7, 'Mario', 'Bro', 3, 'mañana'),
(8, 'Lucía', 'Pérez', 4, 'mañana'),
(9, 'Sofía', 'Rodríguez', 1, 'tarde'),
(10, 'Ricardo', 'Darin', 1, 'mañana');


-- --------------------------------------------------------
-- 4. ESTRUCTURA DE LA TABLA: `pacientes`
-- --------------------------------------------------------
CREATE TABLE `pacientes` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(50) NOT NULL,
    `apellido` varchar(50) NOT NULL,
    `DNI` char(15) NOT NULL,
    `email` varchar(100) NOT NULL,
    `telefono` varchar(20) DEFAULT NULL,
    `password_hash` varchar(255) NOT NULL,
    `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`),
    UNIQUE KEY `DNI` (`DNI`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de datos (TODOS creados prolijamente con la contraseña: admin123)
INSERT INTO `pacientes` (`id`, `nombre`, `apellido`, `DNI`, `email`, `telefono`, `password_hash`, `fecha_registro`) VALUES
(1, 'Domingo', 'Fausto', '32444555', 'fudomyosama@hotmail.com', '1144556677', '$2y$10$IwjNFFVUk8SnHO.jORhN0OyhO15nJM7947BbOyxM6GSa5C/sKN1FK', '2026-05-02 20:04:41'),
(2, 'Julia', 'Garrido', '28999111', 'julia.g@odontomail.com', '1122334455', '$2y$10$IwjNFFVUk8SnHO.jORhN0OyhO15nJM7947BbOyxM6GSa5C/sKN1FK', '2026-05-02 20:13:58'),
(3, 'Roberto', 'Pérez', '18333444', 'rperez@yahoo.com', '1166778899', '$2y$10$IwjNFFVUk8SnHO.jORhN0OyhO15nJM7947BbOyxM6GSa5C/sKN1FK', '2026-05-02 20:26:09'),
(4, 'Rosa', 'Del Campo', '30999435', 'delcampo@gmail.com', '1156984750', '$2y$10$IwjNFFVUk8SnHO.jORhN0OyhO15nJM7947BbOyxM6GSa5C/sKN1FK', '2026-05-02 20:32:07'),
(5, 'María', 'Acri', '24556441', 'm.acri@bue.edu.ar', '1100339988', '$2y$10$IwjNFFVUk8SnHO.jORhN0OyhO15nJM7947BbOyxM6GSa5C/sKN1FK', '2026-06-04 22:20:08');


-- --------------------------------------------------------
-- 5. ESTRUCTURA DE LA TABLA: `turnos`
-- --------------------------------------------------------
CREATE TABLE `turnos` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_paciente` int(11) NOT NULL,
    `id_medico` int(11) NOT NULL,
    `fecha_turno` datetime NOT NULL,
    `estado` enum('pendiente','confirmado','cancelado') DEFAULT 'pendiente',
    PRIMARY KEY (`id`),
    KEY `id_paciente` (`id_paciente`),
    KEY `id_medico` (`id_medico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcado de turnos de prueba (Domingo y los nuevos de María Acri)
INSERT INTO `turnos` (`id`, `id_paciente`, `id_medico`, `fecha_turno`, `estado`) VALUES
(1, 1, 10, '2026-05-06 11:15:00', 'confirmado'),
(2, 1, 8, '2026-05-29 12:00:00', 'pendiente'),
(3, 1, 6, '2026-05-12 15:30:00', 'pendiente'),
(4, 1, 4, '2026-06-12 14:00:00', 'pendiente'),
-- Turnos específicos de María Acri (ID: 5) para mostrar filtros en la corrección
(5, 5, 1, '2026-06-08 10:30:00', 'confirmado'), 
(6, 5, 2, '2026-06-15 11:15:00', 'pendiente'),  
(7, 5, 3, '2026-06-19 15:00:00', 'pendiente');  


-- --------------------------------------------------------
-- 6. RESTRICCIONES DE INTEGRIDAD RELACIONAL (Llaves Foráneas)
-- --------------------------------------------------------
ALTER TABLE `medicos`
ADD CONSTRAINT `medicos_ibfk_1` FOREIGN KEY (`id_especialidad`) REFERENCES `especialidad` (`cod`);

ALTER TABLE `turnos`
ADD CONSTRAINT `turnos_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id`),
ADD CONSTRAINT `turnos_ibfk_2` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`cod`);

COMMIT;