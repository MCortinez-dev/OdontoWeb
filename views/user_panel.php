<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/controllers/user-data-logic.php');

/*Sin usar SESION debo harcodear el DNI, sino lo transmitiria por sesión */
$dni_prueba = "20895437";

$sql_usuario = "SELECT * FROM pacientes WHERE dni = '$dni_prueba' ";
$resultado = $conn->query($sql_usuario);

if($resultado->num_rows > 0){
    $fila = mysqli_fetch_array($resultado);
    $nombre_actual = $fila[1];
    $apellido_actual = $fila[2];
    $dni_actual = $fila[3];
    $email_actual = $fila[4];
    $telefono_actual = $fila[5];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo BASE_URL; ?>public/img/logo.png">
    <title>Usuario</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>

<body>
    <?php include("../includes/header.php"); ?>
    
    <main class="m_user-p">
    
    <!-- Sección actualización datos -->
    <section class="user-p" id="user-p">
        <h2>Actualizar Datos</h2>
        <form action="<?php echo BASE_URL; ?>controllers/user-data-logic.php" method="post">
            <input type="text" name="nombre" value="<?php echo $nombre_actual; ?>" required>
            <input type="text" name="apellido" value="<?php echo $apellido_actual; ?>" required>
            <input type="text" name="dni" value="<?php echo $dni_actual; ?>" required>
            <input type="text" name="telefono" value="<?php echo $telefono_actual; ?>">
            <input type="email" name="email" value="<?php echo $email_actual; ?>" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="confirm_pass" placeholder="Vuelva a ingresar contraseña" required>
            
            <input type="submit" name="action" value="actualizar" id="boton_actualizar">  
            <input type="submit" name="action" value="eliminar" id="boton_eliminar">
            <!-- Advertencia !! Falta verificar la contraseña del usuario para eliminar o quizas no (preguntar) -->
        </form>
    </section>

    </main>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>

<!-- No borrar. Lo dejo por las dudas
Sección reserva turno 
<section id="reserva-turno">
    <h2>Reservar Turno</h2>
    <form action="procesar_turno.php" method="POST">
        <label>Especialidad</label>
        <select name="especialidad" required>
            <option value="">Seleccione una especialidad</option>
            <option value="general">Odontología general</option>
            <option value="ortodoncia">Ortodoncia</option>
            <option value="implantes">Implantes</option>
            <option value="blanqueamiento">Blanqueamiento</option>
        </select>
            <label>Fecha del turno</label>
            <input type="date" name="fecha" id="fecha" required>
            <label>Hora del turno</label>
            <input type="time" name="hora" id="horario" required>
            <button type="submit" id="boton_turno">SOLICITAR TURNO</button>
    </form>
</section>
-->