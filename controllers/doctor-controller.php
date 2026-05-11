<?php
    include_once("config.php");

    require_once("./includes/conexion.php");

    $consulta = "SELECT m.cod, m.nombre, m.apellido, e.nombre AS especialidad, m.franja_horaria 
                FROM medicos m
                JOIN especialidad e ON m.id_especialidad = e.cod";

    $resultado = $conn->query($consulta);
?>