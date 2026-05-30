CREATE DATABASE base_datos;

USE base_datos;

CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    DNI CHAR(15) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    password_hash VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE especialidad ( 
    cod INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE medicos(
    cod INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    id_especialidad INT,
    franja_horaria ENUM('mañana', 'tarde') NOT NULL,
    FOREIGN KEY (id_especialidad) REFERENCES especialidad(cod)
);

CREATE TABLE turnos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT NOT NULL,
    id_medico INT NOT NULL,
    fecha_turno DATETIME NOT NULL,
    estado ENUM('pendiente', 'confirmado', 'cancelado') DEFAULT 'pendiente',

    FOREIGN KEY (id_paciente) REFERENCES pacientes(id),
    FOREIGN KEY (id_medico) REFERENCES medicos(cod)
);

-- administrador
CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);


/*Insertar especialidades*/
INSERT INTO `especialidad` (`nombre`) VALUES 
('Odontología General'),
('Ortodoncia'),
('Implantes'),
('Blanqueamiento');

/* Insertar Médicos */

/* Médicos para la Mañana (9:00 a 13:30) */
INSERT INTO medicos (nombre, apellido, id_especialidad, franja_horaria) VALUES 
('Carlos', 'Sánchez', 1, 'mañana'),
('Laura', 'Gómez', 2, 'mañana');

/* Médicos para la Tarde (13:30 a 18:00) */
INSERT INTO medicos (nombre, apellido, id_especialidad, franja_horaria) VALUES 
('Marta', 'Díaz', 3,  'tarde'),
('Roberto', 'Pérez', 4, 'tarde');

/* Medicos para probar por errores en calendario */
INSERT INTO medicos (nombre, apellido, id_especialidad, franja_horaria) VALUES 
('Ricardo', 'Tapia', 1, 'tarde'),
('Elena', 'Blanco', 2, 'tarde'),
('Mario', 'Bro', 3, 'mañana'),
('Lucía', 'Pérez', 4, 'mañana');

/* Agrego especialistas en odontoligia general */
-- Un segundo médico para la Mañana
INSERT INTO medicos (nombre, apellido, id_especialidad, franja_horaria) VALUES 
('Ricardo', 'Darin', 1, 'mañana'); 

-- Un segundo médico para la Tarde
INSERT INTO medicos (nombre, apellido, id_especialidad, franja_horaria) VALUES 
('Sofía', 'Rodríguez', 1, 'tarde');

-- poner usuarios para el 5