<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

$id_paciente_logueado = $_SESSION['paciente_id'] ?? null;

if (!$id_paciente_logueado) {
    die("Acceso no autorizado");
}

$sql_reporte = "SELECT 
                t.id AS turno_nro,
                e.nombre AS especialidad,
                m.nombre AS doc_nombre, 
                m.apellido AS doc_apellido,
                t.fecha_turno AS fecha_hora,
                t.estado
                FROM turnos t
                JOIN pacientes p ON t.id_paciente = p.id
                JOIN medicos m ON t.id_medico = m.cod
                JOIN especialidad e ON m.id_especialidad = e.cod
                WHERE p.id = ? 
                ORDER BY t.fecha_turno DESC";

$stmt = $conn->prepare($sql_reporte);
$stmt->bind_param("i", $id_paciente_logueado);
$stmt->execute();
$misTurnos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

/* Borrar turno */
if (isset($_GET['accion']) && $_GET['accion'] == 'borrar') {
    $id_turno = $_GET['id'];
    // Solo borra si el id_paciente coincide con la sesión
    $sql = "DELETE FROM turnos WHERE id = $id_turno AND id_paciente = $id_paciente_logueado";
    $conn->query($sql);
    header("Location: user_panel.php");
    exit();
}

/* 3. Actualización/Eliminación de cuenta */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $nombre   = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni      = $_POST['dni'];
    $email    = $_POST['email'];
    $telefono = $_POST['telefono'];

    if ($action == 'actualizar') {
        if (!empty($_POST['password'])) {
            if ($_POST['password'] !== $_POST['confirm_pass']) { die("Las contraseñas no coinciden"); }
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql_update = "UPDATE pacientes SET nombre='$nombre', apellido='$apellido', email='$email', 
                        telefono='$telefono', password_hash='$hash' WHERE id=$id_paciente_logueado";
        } else {
            $sql_update = "UPDATE pacientes SET nombre='$nombre', apellido='$apellido', email='$email', 
                        telefono='$telefono' WHERE id=$id_paciente_logueado";
        }

        if($conn->query($sql_update)) {
            header("Location: " . BASE_URL . "views/user_panel.php?msg=updated");
            exit();
        }
    } 
    elseif ($action == 'eliminar') {
        $sql_delete = "DELETE FROM pacientes WHERE id = $id_paciente_logueado";
        if($conn->query($sql_delete)) {
            session_destroy();
            header("Location: " . BASE_URL . "index.php?msg=deleted");
            exit();
        }
    }
}