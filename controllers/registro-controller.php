<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre   = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni      = $_POST['dni'];
    $email    = $_POST['email'];
    $telefono = $_POST['telefono'];
    $pass     = $_POST['password'];
    $confirm  = $_POST['confirm_pass'];

// Validación de seguridad por si se saltean el JS
    if ($pass !== $confirm) {
        header("Location: " . BASE_URL . "views/registro.php?error=pass_no_coinciden");
        exit();
    }

    // 1. Verificar si el EMAIL ya existe
    $check_email = $conn->prepare("SELECT id FROM pacientes WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    if ($check_email->get_result()->num_rows > 0) {
        header("Location: " . BASE_URL . "views/registro.php?error=email_existe");
        exit();
    }

    // 2. Verificar si el DNI ya existe
    $check_dni = $conn->prepare("SELECT id FROM pacientes WHERE DNI = ?");
    $check_dni->bind_param("s", $dni);
    $check_dni->execute();
    if ($check_dni->get_result()->num_rows > 0) {
        header("Location: " . BASE_URL . "views/registro.php?error=dni_existe");
        exit();
    }

    // 3. Si todo está limpio, encriptamos e insertamos de forma segura
    $hash = password_hash($pass, PASSWORD_DEFAULT);

    $sql = $conn->prepare("INSERT INTO pacientes (nombre, apellido, DNI, email, telefono, password_hash) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->bind_param("ssssss", $nombre, $apellido, $dni, $email, $telefono, $hash);

    if ($sql->execute()) {
        header("Location: " . BASE_URL . "views/login.php?status=registrado_ok");
        exit();
    } else {
        header("Location: " . BASE_URL . "views/registro.php?error=db_error");
        exit();
    }
}
?>