<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

if (!isset($_SESSION['paciente_id'])) {
    die("Acceso denegado");
}
$id_paciente_sesion = $_SESSION['paciente_id'];

// Lei mal el csv se hacia de toda la base de datos - lo dejo igual por que me costo hacerlo
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

if(isset($_GET['id'])){
    $id_turno = $_GET['id'];

    // Consulta con validación de dueño
    $sql = "SELECT t.id, e.nombre, CONCAT(m.nombre, ' ', m.apellido), t.fecha_turno, t.estado 
            FROM turnos t
            JOIN medicos m ON t.id_medico = m.cod
            JOIN especialidad e ON m.id_especialidad = e.cod
            WHERE t.id = ? AND t.id_paciente = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_turno, $id_paciente_sesion);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($fila = $resultado->fetch_assoc()){

        // Para que lo descargue
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=turno_'.$id_turno.'.csv');

        // Necesario para abrir el archivo
        $output = fopen('php://output', 'w');

        // Excel
        fputcsv($output, ['Turno Nro', 'Especialidad', 'Doctor', 'Fecha y Hora', 'Estado']);

        fputcsv($output, $fila);

        fclose($output);
        exit;
        } else {
            die("No tienes permiso para descargar este turno.");
        }
    }
?>