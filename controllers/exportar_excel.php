<?php
ob_start(); 

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../views/login_admin.php");
    exit();
}

require_once('../includes/conexion.php');

$filtro_sql = "";
if (isset($_GET['busqueda']) && $_GET['busqueda'] != '') {
    $busqueda = $_GET['busqueda'];
    $filtro_sql = " WHERE p.nombre LIKE '%$busqueda%' 
                       OR p.apellido LIKE '%$busqueda%' 
                       OR p.DNI LIKE '%$busqueda%' ";
}

$sql = "SELECT t.fecha_turno, t.estado, 
               p.nombre AS pac_nombre, p.apellido AS pac_apellido, p.DNI, 
               m.nombre AS med_nombre, m.apellido AS med_apellido 
        FROM turnos t
        INNER JOIN pacientes p ON t.id_paciente = p.id
        INNER JOIN medicos m ON t.id_medico = m.cod
        $filtro_sql
        ORDER BY t.fecha_turno ASC";

$resultado = $conn->query($sql);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Reporte_OdontoWeb_" . date('Y-m-d') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<meta charset="utf-8">
<table border="1">
    <tr style="background-color: #2c3e50; color: white;">
        <th>FECHA</th>
        <th>PACIENTE</th>
        <th>DNI</th>
        <th>MEDICO</th>
        <th>ESTADO</th>
    </tr>
    <?php
    if ($resultado && $resultado->num_rows > 0) {
        while ($f = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $f['fecha_turno'] . "</td>";
            echo "<td>" . ($f['pac_nombre'] . " " . $f['pac_apellido']) . "</td>";
            echo "<td>" . $f['DNI'] . "</td>";
            echo "<td>" . ("Dr. " . $f['med_nombre'] . " " . $f['med_apellido']) . "</td>";
            echo "<td>" . strtoupper($f['estado']) . "</td>";
            echo "</tr>";
        }
    }
    ?>
</table>
<?php
$conn->close();
ob_end_flush();
?>