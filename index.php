<?php include_once("config.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Clínica odontológica OdontoPlus">
    <meta name="keywords" content="odontologia, clinica dental, implantes">
    <meta name="author" content="Damian Dominguez & Cortinez Matias">
    <title>OdontoWeb</title>
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

                <a href="<?php echo BASE_URL; ?>turno.php">
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

            <div class="servicios-container">
                <article id="art_1">
                <h3>Odontología general</h3>
                <p>Arreglos de caries.</p>
                <img src="<?php echo BASE_URL; ?>public/img/art1.png" alt="Imagen Arreglo caries">
                </article>

                <article id="art_2">
                <h3>Ortodoncia</h3>
                <p>Corrección de la posición dental.</p>
                <img src="<?php echo BASE_URL; ?>public/img/art2.jpg" alt="Imagen Ortodoncia">
                </article>

                <article id="art_3">
                <h3>Implantes</h3>
                <p>Soluciones modernas para reemplazar piezas dentales.</p>
                <img src="<?php echo BASE_URL; ?>public/img/art3.jpg" alt="Imagen Implantes">
                </article>

                <article id="art_4">
                <h3>Blanqueamiento</h3>
                <p>Tratamientos estéticos para tu sonrisa.</p>
                <img src="<?php echo BASE_URL; ?>public/img/art4.png" alt="Imagen Blanqueamiento">
                </article>
            </div>
        </section>

<section id="equipo">
            <div class="equipo-container">
                <div style="border: 1px solid #ccc; padding: 10px; width: 300px;">
                    <img src="<?php echo BASE_URL; ?>public/img/doctora.jpg" alt="Imagen de Odontologa Julia Garrido" style="width: 100%; height: auto;">
                    <h3>Dra Julia Garrido</h3>
                    <p>Especialista Ortodoncia UBA.</p>
                    <a href="https://linkedin.com">LinkedIN</a>
                    <button>Reservar cita Dra Garrido</button>
                </div>

                <div style="border: 1px solid #ccc; padding: 10px; width: 300px;">
                    <img src="<?php echo BASE_URL; ?>public/img/doctor.jpg" alt="Imagen de Odontologo Juan Perez" style="width: 100%; height: auto;">
                    <h3>Dr Juan Perez</h3>
                    <p>Especialista Endodoncia UBA.</p>
                    <a href="https://linkedin.com">LinkedIN</a>
                    <button>Reservar cita con el Dr. Perez</button>
                </div>
            </div>
        </section>

<section id="reserva-turno">

            <h2>Reservar Turno</h2>

            <form>
                <label>Nombre</label>
                <input type="text">
                <label>Email</label>
                <input type="email">
                <label>Especialidad</label>
                
                <select name="especialidad">
                    <option value="">Seleccione una especialidad</option>
                    <option value="general">Odontología general</option>
                    <option value="ortodoncia">Ortodoncia</option>
                    <option value="implantes">Implantes</option>
                    <option value="blanqueamiento">Blanqueamiento</option>
                </select>
                    <label>Fecha del turno</label>
                    <input type="date" name="fecha">
                    <label>Hora del turno</label>
                    <input type="time" name="hora">
                    <button type="submit">Enviar</button>
            </form>
        </section>
    </main>

    <?php include("includes/footer.php"); ?>

</body>
</html>