<?php
session_start();
if (!isset($_SESSION['paciente_id'])) {
    header("Location: login.php");
    exit();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

// Como el Id de turno se ve en la URL debo verificar si es el dueño del mimsmo
$es_dueno = false;
if (isset($_GET['id'])) {
    $id_turno = $_GET['id'];
    $id_paciente = $_SESSION['paciente_id'];

    $sql_check = "SELECT id FROM turnos WHERE id = ? AND id_paciente = ?";
    $stmt = $conn->prepare($sql_check);
    $stmt->bind_param("ii", $id_turno, $id_paciente);
    $stmt->execute();
    $res = $stmt->get_result();
    
    if ($res && $res->num_rows > 0) {
        $es_dueno = true;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Descargar turno</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
	<link rel="icon" href="<?php echo BASE_URL; ?>public/img/logo.png">
</head>

<body>
    <?php include("../includes/header.php"); ?>

    <main class="m_print" style="padding: 40px 0;">
        <section class="seccion-impresion">
            
            <?php if($es_dueno): ?>
                <h2>TURNO CONFIRMADO</h2>
                <p>Descargue o imprima su comprobante</p>
                
                <div class="contenedor-botones-descarga">
                    <a href="<?php echo BASE_URL; ?>controllers/exportar-csv.php?id=<?php echo $_GET['id']; ?>" class="btn-descarga-csv">
                        DESCARGAR EN CSV
                    </a>

                    <a href="<?php echo BASE_URL; ?>controllers/exportar-pdf.php?id=<?php echo $_GET['id']; ?>" class="btn-descarga-pdf">
                        DESCARGAR EN PDF
                    </a>

                    <a href="<?php echo BASE_URL; ?>controllers/enviar-email-turno.php?id=<?php echo $_GET['id']; ?>" class="btn-enviar">
                        ENVIAR PDF POR EMAIL
                    </a>

                    <a href="user_panel.php" class="btn-volver-panel">
                        VOLVER AL PANEL DE USUARIO
                    </a>
                </div>

            <?php else: ?>
                <div class="alerta-error">
                    <h2>Acceso Denegado</h2>
                    <p>No se encontró el comprobante o no tienes permisos para verlo.</p>
                    <a href="user_panel.php" class="btn-volver-panel">Volver al panel</a>
                </div>
            <?php endif; ?>

        </section>
    </main>

    <?php include("../includes/footer.php"); ?>

    <script src="<?php echo BASE_URL; ?>includes/funcion.js"></script>

    <script>
        // 1. CONTROL DEL BOTÓN DE ENVÍO - Prevenir doble clic
        const btnEmail = document.querySelector('.btn-enviar-email');
        if (btnEmail) {
            btnEmail.addEventListener('click', function(event) {
                if (this.classList.contains('enviando')) {
                    event.preventDefault();
                    return;
                }
                // Añade una clase de control y cambiamos el texto visual
                this.classList.add('enviando');
                this.innerText = "⏳ ENVIANDO EMAIL...";
                this.style.opacity = "0.6";
                this.style.cursor = "not-allowed";
            });
        }

        // 2. CAPTURA DE ÉXITO DESDE LA URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('msg') === 'email_sent') {
            mostrarAlerta("📧 El comprobante ha sido enviado a su casilla de correo.");
        }
    </script>

</body>
</html>