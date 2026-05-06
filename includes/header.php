<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php'); ?>

<header>
    <a href="<?php echo BASE_URL; ?>index.php">
        <img src="<?php echo BASE_URL; ?>public/img/logo.png" alt="Logo Empresa" style="width: 50px;height:50px;" id="logo">
    </a>

    <h1>ODONTO PLUS</h1>

    <nav>
        <ul>
            <li><a href="<?php echo BASE_URL; ?>index.php">INICIO</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php#nosotros">NOSOTROS</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php#servicios">SERVICIOS</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php#contacto">CONTACTO</a></li>
            <li><a href="<?php echo BASE_URL; ?>./views/login.php">LOGIN</a></li>
        </ul>
    </nav>

    <a href="<?php echo BASE_URL; ?>views/login.php">
        <button id="boton">RESERVE SU TURNO</button>
    </a>
</header>