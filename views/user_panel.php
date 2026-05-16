<?php
session_start();
if (!isset($_SESSION['paciente_id'])) {
    header("Location: login.php");
    exit();
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/controllers/user-data-logic.php');

$paciente_id = $_SESSION['paciente_id'];
$sql_usuario = "SELECT * FROM pacientes WHERE id = '$paciente_id' ";
$resultado = $conn->query($sql_usuario);

if($resultado && $resultado->num_rows > 0){
    $fila = $resultado->fetch_assoc();
    $nombre_actual = $fila['nombre'];
    $apellido_actual = $fila['apellido'];
    $dni_actual = $fila['DNI'];
    $email_actual = $fila['email'];
    $telefono_actual = $fila['telefono'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo BASE_URL; ?>public/img/logo.png">
    <title>Usuario</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>

<body>
    <?php include("../includes/header.php"); ?>
    
    <main class="m_user-p">

    <!-- Sección muestra turnos -->
    <section class="tus-turnos">
        <h2>Tus turnos</h2>
        
        <?php if (!empty($misTurnos)): ?>
            <div class="contenedor-lista-turnos">
                <?php foreach ($misTurnos as $element): ?>
                    <article class="turno-card">
                        <div class="info-principal">
                            <strong><?php echo $element['especialidad']; ?></strong>
                        </div>
                        
                        <div class="detalles">
                            <p>Médico: <?php echo $element['doc_nombre'] . " " . $element['doc_apellido']; ?></p>
                            <p>Fecha: <?php echo date("d/m/Y H:i", strtotime($element['fecha_hora'])); ?> hs</p>
                        </div>

                        <div class="estado-turno <?php echo $element['estado']; ?>">
                            <?php echo ucfirst($element['estado']); ?>
                        </div>

                        <div class="boton-borrar">
                            <a href="user_panel.php?accion=borrar&id=<?php echo $element['turno_nro']; ?>" 
                            onclick="return confirm('¿Borrar turno?');">
                            Eliminar
                            </a>
                        </div>

                        <div class="boton-imprimir">
                            <a href="<?php echo BASE_URL; ?>views/print-turno.php?id=<?php echo $element['turno_nro']; ?>" class="btn-print">
                                Imprimir
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="alerta-sin-turnos">Todavía no tenés turnos programados.</p>
        <?php endif; ?>
    </section>
    
    <!-- Sección actualización datos -->
    <section class="user-p" id="user-p">
        <h2>Actualizar Datos</h2>
        <form action="<?php echo BASE_URL; ?>controllers/user-data-logic.php" method="post">
            <input type="text" name="nombre" value="<?php echo $nombre_actual; ?>" required>
            <input type="text" name="apellido" value="<?php echo $apellido_actual; ?>" required>
            <input type="text" name="dni" value="<?php echo $dni_actual; ?>" required>
            <input type="text" name="telefono" value="<?php echo $telefono_actual; ?>">
            <input type="email" name="email" value="<?php echo $email_actual; ?>" required>
            <input type="password" name="password" placeholder="Contraseña">
            <input type="password" name="confirm_pass" placeholder="Vuelva a ingresar contraseña">
            
            <input type="submit" name="action" value="ACTUALIZAR" id="boton_actualizar">  
            <input type="submit" name="action" value="ELIMINAR" id="boton_eliminar">
            <!-- Advertencia !! Falta verificar la contraseña del usuario para eliminar o quizas no (preguntar) -->
        </form>
    </section>

    <div style="margin-top: 30px;">
        <a href="<?php echo BASE_URL; ?>controllers/logout.php" id="boton_cerrar" style="text-decoration: none; display: inline-block; text-align: center;">
            CERRAR SESIÓN
        </a>
    </div>

    </main>

    <?php include("../includes/footer.php"); ?>
    
</body>
</html>