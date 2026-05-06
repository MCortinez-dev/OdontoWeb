<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

if(isset($_GET['id'])){
    $id_turno = $_GET['id'];

    // Para que lo descargue
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=turno_'.$id_turno.'.csv');

    // Necesario para abrir el archivo
    $output = fopen('php://output', 'w');

    // Excel
    fputcsv($output, ['Turno Nro', 'Especialidad', 'Doctor', 'Fecha y Hora', 'Estado']);

    // Uso el ID que viene por la URL
    $sql = "SELECT t.id, e.nombre, CONCAT(m.nombre, ' ', m.apellido), t.fecha_turno, t.estado 
            FROM turnos t
            JOIN medicos m ON t.id_medico = m.cod
            JOIN especialidad e ON m.id_especialidad = e.cod
            WHERE t.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_turno);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($fila = $resultado->fetch_assoc()){
        fputcsv($output, $fila);
    }

    fclose($output);
    exit;
}
?>