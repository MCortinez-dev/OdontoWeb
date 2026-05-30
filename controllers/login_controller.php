<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, nombre, password_hash FROM pacientes WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Verificar la contraseña con el hash de la DB
        if (password_verify($password, $row['password_hash'])) {
            
            // Variables de sesión
            $_SESSION['paciente_id'] = $row['id'];
            $_SESSION['paciente_nombre'] = $row['nombre'];
            $_SESSION['rol'] = 'paciente';

            // Redirigir al panel
            header("Location: " . BASE_URL . "views/user_panel.php");
            exit();
        } else {
            header("Location: " . BASE_URL . "views/login.php?error=password_incorrecta");
            exit();
        }
    } else {
        header("Location: " . BASE_URL . "views/login.php?error=usuario_no_encontrado");
        exit();
    }
}
?>