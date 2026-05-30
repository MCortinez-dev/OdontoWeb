<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit();
}

include_once('../config.php');
require_once('../includes/conexion.php');

$busqueda = "";
$filtro_sql = "";

if (isset($_GET['busqueda']) && $_GET['busqueda'] != '') {
    $busqueda = $_GET['busqueda'];
    
    $filtro_sql = " WHERE p.nombre LIKE '%$busqueda%' 
                       OR p.apellido LIKE '%$busqueda%' 
                       OR p.DNI LIKE '%$busqueda%' ";
}

$sql = "SELECT t.id, t.fecha_turno, t.estado, 
               p.nombre AS pac_nombre, p.apellido AS pac_apellido, p.DNI, 
               m.nombre AS med_nombre, m.apellido AS med_apellido 
        FROM turnos t
        INNER JOIN pacientes p ON t.id_paciente = p.id
        INNER JOIN medicos m ON t.id_medico = m.cod
        $filtro_sql
        ORDER BY t.fecha_turno ASC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - OdontoWeb</title>
    <link rel="icon" href="<?php echo BASE_URL; ?>public/img/logo.png">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
    <style>
        .tabla-admin { width: 95%; margin: 30px auto; border-collapse: collapse; background: white; }
        .tabla-admin th, .tabla-admin td { padding: 12px; border: 1px solid #ddd; text-align: center; color: black; }
        .tabla-admin th { background-color: #F43F5E; color: white; }
        .estado-pendiente { color: #d97706; font-weight: bold; }
        .estado-confirmado { color: #10B981; font-weight: bold; }
        .estado-cancelado { color: #EF4444; font-weight: bold; }
        .btn-confirmar { background: #10B981; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>
    <?php include("../includes/header.php"); ?>

    <main style="padding: 40px 0; background-color: #f8f9fa;">
        <h2 style="text-align: center; color: #333;">Bienvenido al Panel, <?php echo $_SESSION['admin_usuario']; ?></h2>
        
        <div style="text-align: center; margin-bottom: 20px; display: flex; justify-content: center; gap: 20px; align-items: center;">
            
            <form action="" method="GET" style="background: white; padding: 10px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <input type="text" name="busqueda" placeholder="Buscar por DNI o Apellido..." 
                       value="<?php echo $busqueda; ?>" 
                       style="padding: 8px; width: 250px; border: 1px solid #ccc; border-radius: 4px;">
                
                <button type="submit" style="padding: 8px 15px; background: #9F7AEA; color: white; border: none; border-radius: 4px; cursor: pointer;">Buscar</button>
                
                <a href="panel_admin.php" style="margin-left: 10px; color: #EF4444; text-decoration: none; font-size: 14px;">Limpiar filtro</a>
            </form>

            <a href="../controllers/exportar_excel.php?busqueda=<?php echo $busqueda; ?>" 
   style="padding: 10px 15px; background: #10B981; color: white; text-decoration: none; border-radius: 4px;">
   📥 Exportar a Excel
</a>
            
            <a href="../controllers/logout_admin.php" style="color: #555; text-decoration: underline;">Cerrar Sesión</a>
        </div>

        <table class="tabla-admin">
            <thead>
                <tr>
                    <th>Fecha y Hora</th>
                    <th>Paciente</th>
                    <th>DNI</th>
                    <th>Médico</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado && $resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        
                        $clase_estado = "estado-" . $fila['estado'];

                        echo "<tr>";
                        echo "<td>" . $fila['fecha_turno'] . "</td>";
                        echo "<td>" . $fila['pac_nombre'] . " " . $fila['pac_apellido'] . "</td>";
                        echo "<td>" . $fila['DNI'] . "</td>";
                        echo "<td>Dr. " . $fila['med_nombre'] . " " . $fila['med_apellido'] . "</td>";
                        echo "<td class='$clase_estado'>" . strtoupper($fila['estado']) . "</td>";
                        
                        echo "<td>";
                        if ($fila['estado'] == 'pendiente') {
                            echo "<a href='../controllers/confirmar_turno.php?id=" . $fila['id'] . "' class='btn-confirmar'>Confirmar</a>";
                        } else {
                            echo "---";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay turnos registrados en la base de datos.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <?php include("../includes/footer.php"); ?>
</body>
</html>