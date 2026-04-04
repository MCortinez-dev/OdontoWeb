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

<p>NO LLEGO A LEER LO QUE DICE EN LA IMAGEN</p>

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

<article>
<h3>Doctor 1</h3>
<p>NO SE QUE VA ABAJO DEL NOMBRE.</p>
<a href="https://linkedin.com">LinkedIN</a>
<button>Reservar cita Doctor 1</button>
<p>NOSE QUE DICE</P>
</article>

<article>
<h3>Doctor 2</h3>
<p>NOSE QUE VA ABAJO DEL NOMBRE.</p>
<a href="https://linkedin.com">LinkedIN</a>
<button>Reservar cita Doctor 2</button>
<p>NOSE QUE DICE</P>
</article>

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