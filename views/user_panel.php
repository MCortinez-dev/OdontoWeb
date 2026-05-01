<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo BASE_URL; ?>public/img/logo.png">
    <title>Turnos</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>

<body>
    <?php include("../includes/header.php"); ?>
    
    <main class="m_user-p">

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
    
    <section class="user-p" id="user-p">
        <h2>Actualizar Datos</h2>
        <form action="" method="post">
            <input type="Nombre" name="Nombre" placeholder="Nombre" required>
            <input type="Apellido" name="Apellido" placeholder="Apellido" required>
            <input type="DNI" name="DNI" placeholder="DNI" required>
            <input type="Telefono" name="Telefono" placeholder="Telefono" >
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="email" name="confirm_email" placeholder="Vuela ingresar e-mail" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="confirm_pass" placeholder="Vuelva a ingresar contraseña" required>
        </form>
        <input type="submit" value="ACTUALIZAR DATOS" id="boton_actualizar">  
    </section>


    </main>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>