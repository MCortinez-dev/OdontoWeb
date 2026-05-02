<?php
    include_once("config.php");

    require_once("./includes/conexion.php");

    $consulta = "SELECT * FROM medicos";
    $resultado = $conn->query($consulta);
?>