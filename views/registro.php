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
        <h2>Registrarse</h2>
        
        <form id="form_registro" action="<?php echo BASE_URL; ?>controllers/registro-controller.php" method="post">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellido" placeholder="Apellido" required>
            <input type="text" name="dni" placeholder="DNI" required>
            <input type="text" name="telefono" placeholder="Teléfono">
            <input type="email" name="email" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="confirm_pass" placeholder="Confirme contraseña" required>
    
            <input type="submit" value="REGISTRARSE" id="boton_login">

            <script src="<?php echo BASE_URL; ?>includes/funcion.js"></script>

            <script>
                // 1. VALIDACIÓN PREVIA EN EL CLIENTE (Antes del envío)
                const form = document.getElementById('form_registro');
                form.addEventListener('submit', function(event) {
                    const pass = form.querySelector('input[name="password"]').value;
                    const confirmPass = form.querySelector('input[name="confirm_pass"]').value;

                    if (pass !== confirmPass) {
                        event.preventDefault(); // Frena el envío al servidor
                        mostrarAlerta("⚠️ Las contraseñas ingresadas no coinciden. Verificalas.");
                    }
                });

                // 2. CAPTURA DE ERRORES DESDE EL SERVIDOR (URL)
                const urlParams = new URLSearchParams(window.location.search);
                const error = urlParams.get('error');

                if (error === 'email_existe') {
                    mostrarAlerta("❌ El correo electrónico ya se encuentra registrado por otro paciente.");
                } else if (error === 'dni_existe') {
                    mostrarAlerta("❌ El DNI ingresado ya corresponde a una cuenta existente.");
                } else if (error === 'db_error') {
                    mostrarAlerta("❌ Tuvimos unos inconvenientes, intente mas tarde.");
                }
            </script>
        </form>
    </section>
    </main>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>