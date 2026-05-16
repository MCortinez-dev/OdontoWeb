<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php'); 

// Por si tiene una sesión ya iniciada, lo envia al panel de usuario.
if (isset($_SESSION['paciente_id'])) {
    header("Location: " . BASE_URL . "views/user_panel.php");
    exit();
}
?>

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
        <form action="../controllers/login_controller.php" method="post">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            
            <!-- Debe dirigir al user panel -->
            <input type="submit" value="INICIAR SESIÓN" id="boton_login">
            
            <div class="registro-link">
                <p>¿No tiene cuenta?</p>
                <a href="<?php echo BASE_URL; ?>views/registro.php" class="btn-registro">REGÍSTRESE</a>
            </div>
            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.2); text-align: center;">
                <a href="<?php echo BASE_URL; ?>views/login_admin.php" style="color: #cbd5e1; font-size: 13px; text-decoration: none;">
                    🔒 Acceso personal del consultorio
                </a>
            </div>
        </form>
    </section>
    </main>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>