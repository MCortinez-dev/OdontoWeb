<?php 
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php');
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

    <main class="m_print"style="padding: 40px 0;">
        <section class="seccion-impresion">
            <?php if(isset($_GET['id'])): ?>
                <h2>Turno Confirmado</h2>
                <p>Descargue o imprima su comprobante</p>
                
                <div class="contenedor-botones-descarga">
                    <a href="<?php echo BASE_URL; ?>controllers/exportar-csv.php?id=<?php echo $_GET['id']; ?>" class="btn-descarga-csv">
                        DESCARGAR COMPROBANTE (Excel/CSV)
                    </a>

                    <a href="user_panel.php" class="btn-volver-panel">
                        VOLVER AL PANEL DE USUARIO
                    </a>
                </div>
            <?php else: ?>
                <p>Error: No se encontró el ID del turno.</p>
                <a href="user_panel.php">Volver</a>
            <?php endif; ?>
        </section>
    </main>

    <?php include("../includes/footer.php"); ?>
</body>
</html>