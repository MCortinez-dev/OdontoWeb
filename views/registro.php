<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo BASE_URL; ?>public/img/logo.png">
    <title>Registro</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>

<body>
    <?php include("../includes/header.php"); ?>
    
    <main class="m_registro">
    <section class="registro" id="regristro">
        <h2>REGISTRATE</h2>
        
        <form action="<?php echo BASE_URL; ?>controllers/registro-controller.php" method="post">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="text" name="dni" placeholder="DNI" required>
            <input type="text" name="telefono" placeholder="Teléfono">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="confirm_pass" placeholder="Confirme contraseña" required>
    
            <input type="submit" value="REGISTRARSE" id="boton_login">    
        </form>
    </section>
    </main>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>