<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/controllers/calendar-controller.php');

if (!isset($_SESSION['paciente_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva de Turnos</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
    <link rel="icon" href="<?php echo BASE_URL; ?>public/img/logo.png">
</head>

<body>
    <?php include("../includes/header.php"); ?>

    <main class="m_turno">
        <h2 class="titulo-seccion">Reserva de Turnos</h2>
        
        <!-- Formulario de Selección Mejorado -->
        <div class="contenedor-filtros">
            <form action="" method="POST" class="form-seleccion">
                <div class="grupo-input">
                    <label>Año</label>
                    <input type="number" name="anioSeleccionado" value="<?php echo $anioSeleccionado; ?>" min="<?php echo $anioMin; ?>" max="<?php echo $anioMax; ?>">
                </div>
                <div class="grupo-input">
                    <label>Mes</label>
                    <select name="mesSeleccionado">
                        <?php
                        $meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                        foreach ($meses as $i => $m) {
                            $val = $i + 1;
                            $sel = ($val == $mesSeleccionado) ? "selected" : "";
                            echo "<option value='$val' $sel>$m</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="grupo-input">
                    <label>Especialidad</label>
                    <select name="especialidad" required>
                        <option value="1" <?php echo ($especialidadSeleccionada == 1) ? 'selected' : ''; ?>>Odontología General</option>
                        <option value="2" <?php echo ($especialidadSeleccionada == 2) ? 'selected' : ''; ?>>Ortodoncia</option>
                        <option value="3" <?php echo ($especialidadSeleccionada == 3) ? 'selected' : ''; ?>>Implantes</option>
                        <option value="4" <?php echo ($especialidadSeleccionada == 4) ? 'selected' : ''; ?>>Blanqueamiento</option>
                    </select>
                </div>
                <button type="submit" class="btn-buscar">VER DISPONIBILIDAD</button>
            </form>
        </div>

        <section class="calendario-container">
            <div class="dias-semana">
                <div>Lun</div>
                <div>Mar</div>
                <div>Mié</div>
                <div>Jue</div>
                <div>Vie</div>
                <div class="dia-finde">Sáb</div>
                <div class="dia-finde">Dom</div>
            </div>

            <div class="cuadrado-dias">
                <?php 
                // 1. Espacios vacíos iniciales
                for ($i = 0; $i < ($primerDiaSemana - 1); $i++) {
                    echo '<div class="dia-vacio"></div>';
                }

                // 2. El bucle de los días
                for ($dia = 1; $dia <= $cantidadDias; $dia++) {
                    
                    // Armamos la fecha de la celda actual. Necesario para usar los datos entre los archivos
                    $fechaCeld = "$anioSeleccionado-" . str_pad($mesSeleccionado, 2, "0", STR_PAD_LEFT) . "-" . str_pad($dia, 2, "0", STR_PAD_LEFT);
                    
                    // Lógica de Fin de Semana
                    $diaSemana = date('N', strtotime($fechaCeld));
                    $esFinde = ($diaSemana >= 6);

                    // Lógica de Fecha Pasada
                    $esPasado = ($fechaCeld < $hoyReferencia);

                    // Agrego la clase 'dia-pasado' si corresponde para el CSS
                    echo "<div class='dia-numero " . ($esFinde ? "dia-finde" : "") . " " . ($esPasado ? "dia-pasado" : "") . "'>"; // Concatenación dinámica
                    echo "<span class='nro'>$dia</span>";
                    
                    echo "<div class='lista-horas'>";
                    
                    if ($esFinde) {
                        echo "<span class='cerrado'>CERRADO</span>";
                    } 
                    elseif ($esPasado) {
                        // Si el día ya pasó, muestra un guion o lo deja vacío
                        echo "<span class='no-disponible'>-</span>";
                    } 
                    else {
                        // Si es un día válido (hoy o futuro), muestra los botones de horas
                        foreach (array_merge($horariosMañana, $horariosTarde) as $h) {
                            $full = "$fechaCeld $h:00";
                            
                            if (!in_array($full, $turnosOcupados)) {
                                echo "<form method='POST' style='display:inline;'>
                                        <input type='hidden' name='fecha_seleccionada' value='$fechaCeld'>
                                        <input type='hidden' name='hora_seleccionada' value='$h'>
                                        <input type='hidden' name='mesSeleccionado' value='$mesSeleccionado'>
                                        <input type='hidden' name='anioSeleccionado' value='$anioSeleccionado'>
                                        <input type='hidden' name='especialidad' value='$especialidadSeleccionada'>
                                        <button type='submit' class='hora-link'>$h</button>
                                    </form>";
                            }
                        }
                    }
                    echo "</div></div>"; // Cierra dia-numero y lista-horas
                }
                ?>
            </div>
        </section>

        <!-- Selección de Profesional -->
        <?php if ($fechaSeleccionada): ?>
        <section class="seleccion-doctor">
            <div class="alerta-seleccion">
                <h3>Has seleccionado: <span><?php echo date("d/m/Y", strtotime($fechaSeleccionada)); ?> a las <?php echo $horaSeleccionada; ?> hs</span></h3>
            </div>
            
            <?php if (count($medicosDisponibles) > 0): ?>
                <form action="" method="POST" class="form-doctor"  id="form-confirmar">
                    <label>Elegí a tu profesional:</label>
                    <select name="id_medico" required>
                        <?php foreach ($medicosDisponibles as $med): ?>
                            <option value="<?php echo $med['cod']; ?>">Dr. <?php echo $med['nombre'] . " " . $med['apellido']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="fecha_final" value="<?php echo $fechaSeleccionada . ' ' . $horaSeleccionada; ?>">
                    <input type="hidden" name="confirmar_turno" value="1">
                    <button type="submit" class="btn-confirmar">CONFIRMAR TURNO AHORA</button>
                </form>
            <?php else: ?>
                <p class="error-msg">Lo sentimos, no hay especialistas de esta categoría disponibles en este horario.</p>
            <?php endif; ?>
        </section>
        <?php endif; ?>

        <div>
            <a href="user_panel.php" class="boton_panel">
                VOLVER AL PANEL DE USUARIO
            </a>
        </div>

    </main>

    <?php include("../includes/footer.php"); ?>

    
    <script src="<?php echo BASE_URL; ?>includes/funcion.js"></script>

    <script>
        // 1. CONTROL DE DOBLE CLICK EN RESERVAS
        const formConfirmar = document.getElementById('form-confirmar');
        if (formConfirmar) {
            formConfirmar.addEventListener('submit', function() {
                const btn = this.querySelector('.btn-confirmar');
                if (btn) {
                    btn.innerText = "⏳ RESERVANDO TURNO...";
                    btn.disabled = true; // Deshabilita el botón inmediatamente
                    btn.style.opacity = "0.6";
                    btn.style.cursor = "not-allowed";
                }
            });
        }

        // 2. DETECCIÓN DE ERRORES DEL BACKEND
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('error') === 'db_insert_error') {
            mostrarAlerta("❌ No pudimos procesar tu reserva. Por favor, selecciona el horario e intenta nuevamente.");
        }
    </script>
</body>
</html>