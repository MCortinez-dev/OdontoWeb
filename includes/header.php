<?php include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php'); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Caracteres con los que se va a trabajar -->
    <meta charset="UTF-8"> 
    <!-- En la ventana acomodar el contenido al ancho de la misma y con el zoom 1:1 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Optimización para SEO -->
    <meta name="description" content="Clínica odontológica OdontoPlus">
    <meta name="keywords" content="odontologia, clinica dental, implantes">
    <!-- Autores -->
    <meta name="author" content="Damian Dominguez & Cortinez Matias">

    <!-- Título en la pestaña de la ventana o la ventana -->
    <title>OdontoWeb</title>

    <!-- CSS Globales del Proyecto -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/head_style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">

    <!-- Tu CSS del Botón WhatsApp adaptado a la nueva arquitectura -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/whatsapp.css">
</head>

<body>

<header>
    <a href="<?php echo BASE_URL; ?>index.php">
        <img src="<?php echo BASE_URL; ?>public/img/logo.png" alt="Logo Empresa" style="width: 50px;height:50px;" id="logo">
    </a>

    <h1>ODONTO PLUS</h1>

    <input type="checkbox" id="menu-check">
    <label for="menu-check" class="menu-icono">
        <span></span>
        <span></span>
        <span></span>
    </label>

    <nav>
        <ul>
            <li><a href="<?php echo BASE_URL; ?>index.php">INICIO</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php#nosotros">NOSOTROS</a></li>
            <li><a href="<?php echo BASE_URL; ?>index.php#servicios">SERVICIOS</a></li>
            <li><a href="#modal-login">LOGIN</a></li>
        </ul>
    </nav>

    <a href="<?php echo BASE_URL; ?>views/turno.php">
        <button id="boton">RESERVE SU TURNO</button>
    </a>
    <div id="modal-login" class="modal-container">
    <div class="modal-content">
        <a href="#" class="modal-close">&times;</a>
        <h2>¿Cómo desea ingresar?</h2>
        <p>Seleccione su tipo de perfil para continuar</p>
        
        <div class="modal-buttons">
            <a href="<?php echo BASE_URL; ?>views/login.php" class="btn-perfil paciente">
                <span class="icon">👤</span> PACIENTE
            </a>
            <a href="<?php echo BASE_URL; ?>views/login_admin.php" class="btn-perfil admin">
                <span class="icon">🔐</span> ADMINISTRADOR
            </a>
        </div>
    </div>
    </div>
</header>