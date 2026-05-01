<?php
$usuario = $_POST["pacientes"];
$pasword = $_POST["pasword_hash"];

require_once("conexion.php");

$sql = "SELECT nombre and password_hash FROM pacientes WHERE ('$usuario','$password') === (nombre,password_hash)";

if($conn->query($sql) === true){
    echo "Inicio de sección correcto";
    echo "<br><button><a href='f_insert.php'>Volver</a></button>";
}else{
    echo "Error: " . $sql . $conn->error;
}
?>