<!-- Llamo al header -->
<?php include("includes/header.php"); ?>

<main>

<section id="hero">

<h2>Tu sonrisa, nuestra mision</h2>

<p>Atención odontológica integral con tecnología de punta</p>

<button>Reservar cita</button>

</section>


<section id="nosotros">

<h2>Nosotros</h2>

<p>Nuestra clínica cuenta con más de 25 años en Argentina, renovandonos continuamente en tecnología y conocimientos</p>

<div style="width: 500px; height: 300px; overflow: auto; display: flex; scroll-snap-type: x mandatory;">
    <img src="imagen1.jpg" style="flex: 0 0 100%; scroll-snap-align: start;" alt="Descripción 1">
    <img src="imagen2.jpg" style="flex: 0 0 100%; scroll-snap-align: start;" alt="Descripción 2">
    <img src="imagen3.jpg" style="flex: 0 0 100%; scroll-snap-align: start;" alt="Descripción 3">
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