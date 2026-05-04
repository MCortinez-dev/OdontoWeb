<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php'); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo BASE_URL; ?>public/img/logo.png">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>

<body>
    <?php include("../includes/header.php"); ?>
    
    <main class="m_login">
    <section class="login" id="login">
        <h2>Iniciar Sesión</h2>
        <form action="" method="post">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            
            <input type="submit" value="INICIAR SESIÓN" id="boton_login">
            
            <div class="registro-link">
                <p>¿No tiene cuenta?</p>
                <a href="<?php echo BASE_URL; ?>views/registro.php" class="btn-registro">REGÍSTRESE</a>
            </div>
        </form>
    </section>
    </main>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>