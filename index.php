<!-- Llamo al header -->
<?php include("includes/header.php"); ?>
<link rel="stylesheet" href="css/style.css">

<main>

<!-- Hero section -->
<section class="hero">

<div class="carousel">
<img src="./img/carrousel-1.jpg" alt="Imagen Consultorio">
<img src="./img/carrousel-2.jpeg" alt="Imagen doctora y ninña">
<img src="./img/carrousel-3.jpg" alt="Imagen doctor">
<img src="./img/carrousel-4.jpg" alt="Imagen dientes y doctora">
</div>

<div class="hero-content">
<h2>Tu sonrisa, nuestra misión</h2>
<p>Atención odontológica integral con tecnología de punta</p>

<a href="turno.php">
<button id="boton_hero">RESERVE SU TURNO</button>
</a>
</div>

</section>

<!-- Nosotros section -->
<section class="nosotros">

<h2>Nosotros</h2>

<p class="nosotros-texto">
Nuestra clínica cuenta con más de 25 años en Argentina,
renovándonos continuamente en tecnología y conocimientos
</p>

<div class="nosotros-slider">

<img src="./img/nosotros1.png" alt="RX Odontológica">
<img src="./img/nosotros2.jpg" alt="Equipo odontológico">
<img src="./img/nosotros3.jpg" alt="Implantes maqueta">

</div>

</section>


<section id="servicios">

<h2>Nuestros servicios</h2>

<div class="servicios-container">

<article>
<h3>Odontología general</h3>
<p>Arreglos de caries.</p>
</article>

<article>
<h3>Ortodoncia</h3>
<p>Corrección de la posición dental.</p>
</article>

<article>
<h3>Implantes</h3>
<p>Soluciones modernas para reemplazar piezas dentales.</p>
</article>

<article>
<h3>Blanqueamiento</h3>
<p>Tratamientos estéticos para tu sonrisa.</p>
</article>

</div>

</section>

<section id="equipo">
<div class="equipo-container">


<div style="border: 1px solid #ccc; padding: 10px; width: 300px;">
    <img src="ruta/imagen.jpg" alt="Imagen de Odontologa Julia Garrido" style="width: 100%; height: auto;">
    <h3>Dra Julia Garrido</h3>
    <p>Especialista Ortodoncia UBA.</p>
    <a href="https://linkedin.com">LinkedIN</a>
    <button>Reservar cita Dra Garrido</button>
</div>

<div style="border: 1px solid #ccc; padding: 10px; width: 300px;">
    <img src="ruta/imagen.jpg" alt="Imagen de Odontologo Juan Perez" style="width: 100%; height: auto;">
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

</select>

<button type="submit">Enviar</button>

</form>

</section>

</main>

<?php include("includes/footer.php"); ?>