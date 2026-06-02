<?php 
session_start(); 
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php'); 

if (isset($_SESSION['rol'])) {
    if ($_SESSION['rol'] === 'admin') {
        header("Location: " . BASE_URL . "views/panel_admin.php");
        exit();
    } elseif ($_SESSION['rol'] === 'paciente') {
        header("Location: " . BASE_URL . "views/user_panel.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo BASE_URL; ?>public/img/logo.png">
    <title>Inicio de Sesión - OdontoWeb</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>

<body>
    <?php include("../includes/header.php"); ?>
    
    <main class="m_login">
    <section class="login" id="login">
        <h2>Iniciar Sesión</h2>

        <form action="../controllers/login_controller.php" method="post">
            <input type="text" name="identificador" placeholder="Correo electrónico o Usuario" required>
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

    <script src="<?php echo BASE_URL; ?>/includes/funcion.js"></script>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get('error');

        // Alerts JS
        if (error === 'credenciales_incorrectas') {
            mostrarAlerta("❌ El usuario o la contraseña no son válidos. Intentá nuevamente.");
        } else if (error === 'acceso_denegado') {
            mostrarAlerta("🔒 Debe iniciar sesión con los permisos correctos para acceder.");
        }
    </script>
</body>
</html>