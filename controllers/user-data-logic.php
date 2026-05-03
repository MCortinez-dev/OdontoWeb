<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action']; // ¿Que botón tocó?

    $nombre   = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni      = $_POST['dni'];
    $email    = $_POST['email'];
    $telefono = $_POST['telefono'];
    $pass     = $_POST['password'];
    $confirm  = $_POST['confirm_pass'];

    if ($action == 'actualizar') {
        if ($pass !== $confirm) { die("Las contraseñas no coinciden"); }
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $sql1 = "UPDATE pacientes SET 
                nombre = '$nombre', 
                apellido = '$apellido', 
                email = '$email', 
                telefono = '$telefono', 
                password_hash = '$hash' 
                WHERE DNI = '$dni'";

        if($conn->query($sql1) === true) {
            echo "Datos modificados con éxito.";
            header("refresh:3;url=" . BASE_URL . "views/user_panel.php");
        }
    }
    elseif ($action == 'eliminar') {
        $sql2 = "DELETE FROM pacientes WHERE DNI = '$dni'";
        
        if($conn->query($sql2) === true) {
            echo "Cuenta eliminada correctamente.";
            header("refresh:3;url=" . BASE_URL . "views/user_panel.php");
        }
    }
}
?>