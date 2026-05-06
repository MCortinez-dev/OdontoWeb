<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

$dni = "32444555"; 

// Variables de control de tiempo real
$anioActual = (int)date("Y");
$mesActual = (int)date("n");
$diaActual = (int)date("j");
$hoyReferencia = date("Y-m-d"); // Para comparar fechas completas

// Ajuste de años dinámico
$anioMin = $anioActual;
$anioMax = $anioActual + 2;

$anioSeleccionado = isset($_POST["anioSeleccionado"]) ? (int)$_POST["anioSeleccionado"] : $anioActual;
$mesSeleccionado = isset($_POST["mesSeleccionado"]) ? (int)$_POST["mesSeleccionado"] : $mesActual;

// Validación de seguridad: si el usuario intenta entrar a un año/mes pasado por URL o POST, lo resetea al actual
if ($anioSeleccionado < $anioActual || ($anioSeleccionado == $anioActual && $mesSeleccionado < $mesActual)) {
    $anioSeleccionado = $anioActual;
    $mesSeleccionado = $mesActual;
}

$especialidadSeleccionada = $_POST["especialidad"] ?? 1;

$fechaSeleccionada = $_POST["fecha_seleccionada"] ?? null;
$horaSeleccionada  = $_POST["hora_seleccionada"]  ?? null;
$medicosDisponibles = [];

if ($fechaSeleccionada && $horaSeleccionada) {
    $fullDateTime = "$fechaSeleccionada $horaSeleccionada:00"; // agrego :00 para que no falten los segundos al guardar
    
    // Extraigo la hora para decidir la franja - se extraen datos para que se pueda operar matemáticamente
    $horaEntera = intval(substr($horaSeleccionada, 0, 2));
    
    $franja = ($horaEntera < 13) ? 'mañana' : 'tarde';

    // El =? evita sql inyection y además prepara los datos para que sea más facil ingresarlos
    $sql_medicos = "SELECT m.cod, m.nombre, m.apellido 
                    FROM medicos m 
                    WHERE m.id_especialidad = ? 
                    AND m.franja_horaria = ?
                    AND m.cod NOT IN (
                        SELECT id_medico FROM turnos 
                        WHERE fecha_turno = ? 
                        AND estado != 'cancelado'
                    )";
    // Tratamientos de datos incluye preparación, securización, transformación y tratamiento para posterior uso. 
    $stmt = $conn->prepare($sql_medicos);
    $stmt->bind_param("iss", $especialidadSeleccionada, $franja, $fullDateTime);
    $stmt->execute();
    $result = $stmt->get_result();
    $medicosDisponibles = $result->fetch_all(MYSQLI_ASSOC); // lo acomoda como array asociativo
}

// Corrección error al eliminar un turno 
if ($fechaSeleccionada) {
    echo "<!-- Buscando para: $fullDateTime en franja $franja -->";
    if (empty($medicosDisponibles)) {
        echo "<!-- No se encontraron médicos. Especialidad: $especialidadSeleccionada -->";
    }
}

// Uso función nativa calendar de PHP (mágica)
$cantidadDias = cal_days_in_month(CAL_GREGORIAN, $mesSeleccionado, $anioSeleccionado); //Me trae cuantos días tiene el mes segun el calendario gregoriano
$primerDiaSemana = date('N', strtotime("$anioSeleccionado-$mesSeleccionado-01")); // semana empieza lunes

$horariosMañana = ["09:00", "09:45", "10:30", "11:15", "12:00", "12:45"];
$horariosTarde  = ["14:00", "14:45", "15:30", "16:15", "17:00", "17:45"];

$turnosOcupados = [];
$mesBusqueda = "$anioSeleccionado-" . str_pad($mesSeleccionado, 2, "0", STR_PAD_LEFT);
$sql_ocupados = "SELECT fecha_turno FROM turnos WHERE fecha_turno LIKE '$mesBusqueda%' AND estado != 'cancelado'";
$res_ocupados = $conn->query($sql_ocupados);
if($res_ocupados){
    while ($row = $res_ocupados->fetch_assoc()) {
        $turnosOcupados[] = $row['fecha_turno'];
    }
}
// fetch_assoc - permite que los datos sean usables.

if (isset($_POST['confirmar_turno'])) {
    $id_medico = $_POST['id_medico'];
    $fecha_final = $_POST['fecha_final'] . ":00"; // Agrega los segundos para MySQL
    // $dni_paciente = "32444555"; // DNI de prueba
    $id_paciente = 1; // id preueba
    $estado = "pendiente";

    $sql_insert = "INSERT INTO turnos (id_paciente, id_medico, fecha_turno, estado) VALUES (?, ?, ?, ?)";
    $stmt_ins = $conn->prepare($sql_insert);
    
    $stmt_ins->bind_param("iiss", $id_paciente, $id_medico, $fecha_final, $estado);
    
    if ($stmt_ins->execute()) {
        $nuevo_id = $conn->insert_id;
        header("Location: " . BASE_URL . "views/print-turno.php?id=" . $nuevo_id);
        exit();
    } else {
        echo "<p class='error-msg'>Error al reservar: " . $conn->error . "</p>";
    }
}

?>

<!-- /---------------------------------------------------------------------------------------/ -->

<!-- Consulta final luego de obtener datos

Intento con bucles antes de leer sobre función calendar de PHP

$añoseleccionado = isset($_POST["anioseleccionado"]) ? $_POST["anioseleccionado"] : 2024;

$meses30 = ["Abril", "Junio", "Septiembre", "Noviembre"];
$meses31 = ["Enero", "Marzo", "Mayo", "Julio", "Agosto", "Octubre", "Diciembre"];

function bisiesto($año) {
    if ($año % 4 == 0) {
        if ($año % 100 == 0) {
            if ($año % 400 == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    } else {
        return false;
    }
}

$febrero = "Febrero";
$dias_febrero = 0;

if (bisiesto($añoseleccionado)) {
    $dias_febrero = 29;
} else {
    $dias_febrero = 28;
}

NO siguí con este intento, se iba a complicar con el dia de la semana donde comienza el mes.
-->