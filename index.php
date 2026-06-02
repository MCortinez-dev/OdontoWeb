<?php
    include_once("config.php");
    include("./controllers/doctor-controller.php");
    
            $imagenes = [
    "https://fastly.picsum.photos/id/237/536/354.jpg?hmac=i0yVXW1ORpyCZpQ-CknuyV-jbtU7_x9EBQVhvT5aRr0",
    "https://fastly.picsum.photos/id/1084/536/354.jpg?grayscale&hmac=Ux7nzg19e1q35mlUVZjhCLxqkR30cC-CarVg-nlIf60",
    "https://fastly.picsum.photos/id/870/536/354.jpg?blur=2&grayscale&hmac=A5T7lnprlMMlQ18KQcVMi3b7Bwa1Qq5YJFp8LSudZ84"
];
$total_imagenes = count($imagenes);
?>
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Clínica odontológica OdontoPlus">
    <meta name="keywords" content="odontologia, clinica dental, implantes">
    <meta name="author" content="Damian Dominguez & Cortinez Matias">
    <title>Odonto➕PLUS🦷</title>
    <link rel="icon" href="<?php echo BASE_URL; ?>public/img/logo.png">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>


<body>
    <!-- Llamo al header -->
    <?php include("includes/header.php"); ?>

    <main>
        <!-- Hero section -->
        <section class="hero">
            <div class="carousel">
                <img src="<?php echo BASE_URL; ?>public/img/carrousel-1.jpg" alt="Imagen Consultorio">
                <img src="<?php echo BASE_URL; ?>public/img/carrousel-2.jpeg" alt="Imagen doctora y ninña">
                <img src="<?php echo BASE_URL; ?>public/img/carrousel-3.jpg" alt="Imagen doctor">
                <img src="<?php echo BASE_URL; ?>public/img/carrousel-4.jpg" alt="Imagen dientes y doctora">
            </div>

            <div class="hero-content">
                <h2>Tu sonrisa, nuestra misión</h2>
                <p>Atención odontológica integral con tecnología de punta</p>

                <a href="<?php echo BASE_URL; ?>views/turno.php">
                    <button id="boton_hero">RESERVE SU TURNO</button>
                </a>
            </div>
        </section>

        <!-- Nosotros section -->
        <section class="nosotros" id="nosotros">

            <h2>Nosotros</h2>
            
            <p class="nosotros-texto">
                Nuestra clínica cuenta con más de 25 años en Argentina,
                renovándonos continuamente en tecnología y conocimientos
            </p>

            <div class="nosotros-slider">
                <img src="<?php echo BASE_URL; ?>public/img/nosotros1.png" alt="RX Odontológica">
                <img src="<?php echo BASE_URL; ?>public/img/nosotros2.jpg" alt="Equipo odontológico">
                <img src="<?php echo BASE_URL; ?>public/img/nosotros3.jpg" alt="Implantes maqueta">
            </div>
        </section>

        <!-- Servicios section -->
        <section class="servicios" id="servicios">
            <h2>Nuestros servicios</h2>

            <div class="banner-3d">
                <div class="slider" style="--quantity: 4">
                    
                    <div class="item card-servicio" style="--position: 1">
                        <h3>Odontología general</h3>
                        <p>Arreglos de caries.</p>
                        <img src="<?php echo BASE_URL; ?>public/img/art1.png" alt="Caries">
                    </div>
                    <div class="item card-servicio" style="--position: 2">
                        <h3>Ortodoncia</h3>
                        <p>Corrección de la posición.</p>
                        <img src="<?php echo BASE_URL; ?>public/img/art2.jpg" alt="Ortodoncia">
                    </div>
                    <div class="item card-servicio" style="--position: 3">
                        <h3>Implantes</h3>
                        <p>Soluciones modernas.</p>
                        <img src="<?php echo BASE_URL; ?>public/img/art3.jpg" alt="Implantes">
                    </div>
                    <div class="item card-servicio" style="--position: 4">
                        <h3>Blanqueamiento</h3>
                        <p>Tratamientos estéticos.</p>
                        <img src="<?php echo BASE_URL; ?>public/img/art4.png" alt="Blanqueamiento">
                    </div>

                    <div class="centro-3d-fijo">
                        <img src="<?php echo BASE_URL; ?>public/img/logo.png" alt="Centro" class="modelo-central">
                    </div>

                </div>
            </div>
        </section>

        <!-- Servicios doctores -->
        <section class="equipo" id="equipo">
            <h2>Nuestro equipo</h2>

            <?php
            // 1. Extraer todos los doctores de la base de datos a un arreglo
            $doctores = [];
            if ($resultado && $resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    $doctores[] = $fila;
                }
            }
            $total_doctores = count($doctores);
            ?>

            <?php if ($total_doctores > 0): ?>
                
                <style>
                    <?php for ($i = 0; $i < $total_doctores; $i++): ?>
                        #slide-<?php echo $i; ?>:checked ~ .carrusel-slides {
                            transform: translateX(-<?php echo ($i * (100 / $total_doctores)); ?>%);
                        }
                        #slide-<?php echo $i; ?>:checked ~ .carrusel-nav label[for="slide-<?php echo $i; ?>"] {
                            background-color: #F43F5E; /* Un color para que se note qué puntito está activo */
                        }
                    <?php endfor; ?>
                </style>

                <div class="carrusel-contenedor">
                    
                    <?php foreach ($doctores as $index => $doc): ?>
                        <input type="radio" name="carrusel" id="slide-<?php echo $index; ?>" <?php echo $index === 0 ? 'checked' : ''; ?>>
                    <?php endforeach; ?>

                    <div class="carrusel-slides" style="width: <?php echo $total_doctores * 100; ?>%;">
                        
                        <?php foreach ($doctores as $index => $doc): ?>
                            <div class="slide" style="width: <?php echo 100 / $total_doctores; ?>%;">
                                
                                <article class="doctor-detalle" style="text-align: center; margin: 0 auto; padding: 20px;">
                                    <h3>Dr. <?php echo $doc['nombre'] . " " . $doc['apellido']; ?></h3>
                                    
                                    <img src="./public/img/doc-<?php echo $doc['cod']; ?>.png" 
                                         alt="Doctor <?php echo $doc['nombre']; ?>" 
                                         style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover; margin: 15px auto;">
                                    
                                    <p><strong>Especialidad:</strong> <?php echo $doc['especialidad']; ?></p>
                                    <p>Horario: <?php echo ucfirst($doc['franja_horaria']); ?></p>
                                </article>
                                
                                <?php 
                                    $prev = ($index === 0) ? $total_doctores - 1 : $index - 1;
                                    $next = ($index === $total_doctores - 1) ? 0 : $index + 1;
                                ?>
                                
                                <div class="carrusel-flechas">
                                    <label for="slide-<?php echo $prev; ?>" class="flecha prev">&#10094;</label>
                                    <label for="slide-<?php echo $next; ?>" class="flecha next">&#10095;</label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="carrusel-nav">
                        <?php foreach ($doctores as $index => $doc): ?>
                            <label for="slide-<?php echo $index; ?>"></label>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php else: ?>
                <div style="text-align: center; padding: 40px;">
                    <p>Sección en construcción o no hay médicos disponibles en este momento.</p>
                </div>
            <?php endif; ?>
        </section>

    </main>

    <?php include("includes/footer.php"); ?>

</body>
</html>