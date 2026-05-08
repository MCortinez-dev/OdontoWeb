<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../views/login_admin.php");
    exit();
}

require_once('../includes/conexion.php');

if (isset($_GET['id'])) {
    $id_turno = $_GET['id'];

    $sql = "UPDATE turnos SET estado = 'confirmado' WHERE id = $id_turno";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../views/panel_admin.php?mensaje=exito");
    } else {
        echo "Error al actualizar el turno: " . $conn->error;
    }
} else {
    echo "No se especificó qué turno confirmar.";
}

$conn->close();
?>