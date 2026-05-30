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

/* 3. Actualización/Eliminación de cuenta */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = strtolower($_POST['action']); 
    $nombre   = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni      = $_POST['dni'];
    $email    = $_POST['email'];
    $telefono = $_POST['telefono'];

    if ($action == 'actualizar') {
        
        // CASO A: El usuario SÍ quiere cambiar la contraseña
        if (!empty($_POST['password'])) {
            if ($_POST['password'] !== $_POST['confirm_pass']) { 
                header("Location: " . BASE_URL . "views/user_panel.php?error=pass_no_coinciden");
                exit();
            }
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            // Mayor seguridad
            $stmt_update = $conn->prepare("UPDATE pacientes SET nombre=?, apellido=?, email=?, telefono=?, password_hash=? WHERE id=?");
            $stmt_update->bind_param("sssssi", $nombre, $apellido, $email, $telefono, $hash, $id_paciente_logueado);
        
        // CASO B: El usuario NO cambia la contraseña
        } else {
            $stmt_update = $conn->prepare("UPDATE pacientes SET nombre=?, apellido=?, email=?, telefono=? WHERE id=?");
            $stmt_update->bind_param("ssssi", $nombre, $apellido, $email, $telefono, $id_paciente_logueado);
        }

        if($stmt_update->execute()) {
            header("Location: " . BASE_URL . "views/user_panel.php?msg=updated");
            exit();
        } else {

            header("Location: " . BASE_URL . "views/user_panel.php?error=db_error");
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
?>