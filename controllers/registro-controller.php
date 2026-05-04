<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

$nombre   = $_POST['nombre'];
$apellido = $_POST['apellido'];
$dni      = $_POST['dni'];
$email    = $_POST['email'];
$telefono = $_POST['telefono'];
$pass     = $_POST['password'];
$confirm  = $_POST['confirm_pass'];

if ($pass !== $confirm) {
    die("Las contraseñas no coinciden");}

$hash = password_hash($pass, PASSWORD_DEFAULT);

$sql = "INSERT INTO pacientes (nombre, apellido, DNI, email, telefono, password_hash) 
        VALUES ('$nombre','$apellido', '$dni', '$email', '$telefono', '$hash')";

if($conn->query($sql) === true){
    echo "Su cuenta fue creada con éxito. Usted será redirigido...";
    header("refresh:3;url=" . BASE_URL . "views/login.php");    
}else{
    echo "Error: " . $conn->error;
}
?>