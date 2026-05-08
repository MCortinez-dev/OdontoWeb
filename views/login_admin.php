<?php include_once('../config.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrativo - OdontoWeb</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>
<body>
    <?php include("../includes/header.php"); ?>

    <main class="m_login">
        <section class="login">
            <h2>Panel Administrativo</h2>
            
            <form action="<?php echo BASE_URL; ?>controllers/verif_admin.php" method="POST">
                
                <label for="usuario" style="color: white; font-weight: bold;">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required placeholder="Tu usuario de admin">

                <label for="password" style="color: white; font-weight: bold;">Contraseña:</label>
                <input type="password" id="password" name="password" required placeholder="Tu clave secreta">

                <button type="submit" id="boton_login">ENTRAR AL PANEL</button>
            </form>
            
            <p style="text-align: center; margin-top: 15px;">
                <a href="<?php echo BASE_URL; ?>index.php" style="color: #2c3e50; text-decoration: none;">← Volver al inicio</a>
            </p>
        </section>
    </main>

    <?php include("../includes/footer.php"); ?>
</body>
</html>