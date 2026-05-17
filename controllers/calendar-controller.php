<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

$id_paciente_logueado = $_SESSION['paciente_id'] ?? null;

if (!$id_paciente_logueado) {
    header("Location: login.php");
    exit();
}

// 1. Procesamiento de la reserva
if (isset($_POST['confirmar_turno'])) {
    $id_medico = $_POST['id_medico'];
    $fecha_final = $_POST['fecha_final'] . ":00"; 
    $estado = "pendiente";

    $sql_insert = "INSERT INTO turnos (id_paciente, id_medico, fecha_turno, estado) VALUES (?, ?, ?, ?)";
    $stmt_ins = $conn->prepare($sql_insert);
    $stmt_ins->bind_param("iiss", $id_paciente_logueado, $id_medico, $fecha_final, $estado);
    
    if ($stmt_ins->execute()) {
        $nuevo_id = $conn->insert_id;
        header("Location: " . BASE_URL . "views/print-turno.php?id=" . $nuevo_id);
        exit();
    } else {
        echo "<p class='error-msg'>Error al reservar: " . $conn->error . "</p>";
    }
}

// 2. Variables de control de tiempo
$anioActual = (int)date("Y");
$mesActual = (int)date("n");
$diaActual = (int)date("j");
$hoyReferencia = date("Y-m-d");

$anioMin = $anioActual;
$anioMax = $anioActual + 2;

$anioSeleccionado = isset($_POST["anioSeleccionado"]) ? (int)$_POST["anioSeleccionado"] : $anioActual;
$mesSeleccionado = isset($_POST["mesSeleccionado"]) ? (int)$_POST["mesSeleccionado"] : $mesActual;
$especialidadSeleccionada = $_POST["especialidad"] ?? 1;

// Validación de fechas pasadas
if ($anioSeleccionado < $anioActual || ($anioSeleccionado == $anioActual && $mesSeleccionado < $mesActual)) {
    $anioSeleccionado = $anioActual;
    $mesSeleccionado = $mesActual;
}

// 3. LÓGICA DE DISPONIBILIDAD
$turnosOcupados = [];
$mesBusqueda = "$anioSeleccionado-" . str_pad($mesSeleccionado, 2, "0", STR_PAD_LEFT);

// Agrupa por fecha para saber cuántos turnos hay por cada horario en la especialidad elegida
$sql_ocupados = "SELECT t.fecha_turno, COUNT(t.id) as cantidad_reservas
                FROM turnos t
                JOIN medicos m ON t.id_medico = m.cod
                WHERE t.fecha_turno LIKE ? 
                AND m.id_especialidad = ? 
                AND t.estado != 'cancelado'
                GROUP BY t.fecha_turno";

$stmt_oc = $conn->prepare($sql_ocupados);
$busqueda_like = $mesBusqueda . "%";
$stmt_oc->bind_param("si", $busqueda_like, $especialidadSeleccionada);
$stmt_oc->execute();
$res_ocupados = $stmt_oc->get_result();

while ($row = $res_ocupados->fetch_assoc()) {
    $fecha_hora = $row['fecha_turno'];
    $hora_string = explode(' ', $fecha_hora)[1];
    $hora_entera = intval(substr($hora_string, 0, 2));
    $franja_turno = ($hora_entera < 13) ? 'mañana' : 'tarde';

    // Consulta cuántos médicos hay realmente para esta especialidad y franja
    $sql_contar = "SELECT COUNT(*) as total FROM medicos WHERE id_especialidad = ? AND franja_horaria = ?";
    $stmt_cnt = $conn->prepare($sql_contar);
    $stmt_cnt->bind_param("is", $especialidadSeleccionada, $franja_turno);
    $stmt_cnt->execute();
    $total_medicos = $stmt_cnt->get_result()->fetch_assoc()['total'];

    // Si la cantidad de reservas iguala o supera la cantidad de médicos, se bloquea el horario
    if ($row['cantidad_reservas'] >= $total_medicos) {
        $turnosOcupados[] = $fecha_hora;
    }
}

// 4. Búsqueda de Médicos Disponibles (Cuando el usuario clickea una hora)
$fechaSeleccionada = $_POST["fecha_seleccionada"] ?? null;
$horaSeleccionada  = $_POST["hora_seleccionada"]  ?? null;
$medicosDisponibles = [];

if ($fechaSeleccionada && $horaSeleccionada) {
    $fullDateTime = "$fechaSeleccionada $horaSeleccionada:00";
    $horaEntera = intval(substr($horaSeleccionada, 0, 2));
    $franja = ($horaEntera < 13) ? 'mañana' : 'tarde';

    $sql_medicos = "SELECT m.cod, m.nombre, m.apellido 
                    FROM medicos m 
                    WHERE m.id_especialidad = ? 
                    AND m.franja_horaria = ?
                    AND m.cod NOT IN (
                        SELECT id_medico FROM turnos 
                        WHERE fecha_turno = ? 
                        AND estado != 'cancelado'
                    )";
    $stmt_m = $conn->prepare($sql_medicos);
    $stmt_m->bind_param("iss", $especialidadSeleccionada, $franja, $fullDateTime);
    $stmt_m->execute();
    $medicosDisponibles = $stmt_m->get_result()->fetch_all(MYSQLI_ASSOC);
}

// 5. Configuración del Calendario Visual
$cantidadDias = cal_days_in_month(CAL_GREGORIAN, $mesSeleccionado, $anioSeleccionado);
$primerDiaSemana = date('N', strtotime("$anioSeleccionado-$mesSeleccionado-01"));

$horariosMañana = ["09:00", "09:45", "10:30", "11:15", "12:00", "12:45"];
$horariosTarde  = ["14:00", "14:45", "15:30", "16:15", "17:00", "17:45"];
?>