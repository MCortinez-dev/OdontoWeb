<<<<<<< HEAD
<?php 
// INICIAR SESIÓN:
session_start(); 

=======
<?php
session_start();
>>>>>>> d32cf7d34ab90c12876ae73b6a3aca73f9af6881
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
    <style>
        .alerta-error {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            border: 1px solid #fca5a5;
            text-align: center;
        }
    </style>
</head>

<body>
    <?php include("../includes/header.php"); ?>
    
    <main class="m_login">
    <section class="login" id="login">
        <h2>Iniciar Sesión</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="alerta-error">
                <?php 
                    if ($_GET['error'] === 'credenciales_incorrectas') {
                        echo "⚠️ El usuario o la contraseña son incorrectos.";
                    } elseif ($_GET['error'] === 'acceso_denegado') {
                        echo "🔒 Debe iniciar sesión como Administrador para acceder.";
                    } else {
                        echo "⚠️ Ocurrió un error al intentar ingresar.";
                    }
                ?>
            </div>
        <?php endif; ?>

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
<<<<<<< HEAD
=======

    <script src="<?php echo BASE_URL; ?>/includes/funcion.js"></script>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const error = urlParams.get('error');

        if (error === 'password_incorrecta') {
            mostrarAlerta("❌ La contraseña ingresada no es válida. Intentá nuevamente.");
        } else if (error === 'usuario_no_encontrado') {
            mostrarAlerta("❌ El correo electrónico no corresponde a ningún paciente registrado.");
        }
    </script>

>>>>>>> d32cf7d34ab90c12876ae73b6a3aca73f9af6881
</body>
</html>