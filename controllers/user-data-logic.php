<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

$id_paciente_logueado = 1; // reemplazar cuando se implemente sesion

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
    $id = $_GET['id'];
    
    $sql = "DELETE FROM turnos WHERE id = $id";
    $conn->query($sql);
    
    header("Location: user_panel.php");
}

/* Actualización datos */
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