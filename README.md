# 🦷 OdontoWeb - Sistema de Gestión Odontológica

OdontoWeb es una plataforma integral desarrollada en PHP para la gestión de turnos, profesionales y pacientes en clínicas dentales. El sistema permite digitalizar el flujo de atención, desde la solicitud del turno hasta la generación del comprobante profesional en PDF.

## 🚀 Características Principales
- Gestión de Turnos: Interfaz dinámica para la asignación y visualización de citas.
- Exportación de Comprobantes: Generación automática de comprobantes de turno en formato PDF (utilizando la librería TCPDF).
- Panel de Administración: Gestión de base de datos para médicos, especialidades y pacientes.
- Seguridad: Implementación de hashing de contraseñas y validación de sesiones.
- Reportes en CSV: Funcionalidad para exportar listados de turnos a formatos compatibles con hojas de cálculo.

## 🛠️ Stack Tecnológico
- Backend: PHP 8.x
- Base de Datos: MySQL / MariaDB
- Frontend: HTML5, CSS3, JavaScript
- Dependencias: * Composer (Gestor de dependencias)
- TCPDF (Generación de PDF)
- Servidor Local: XAMPP

## 📋 Requisitos e Instalación
Para replicar este entorno en tu máquina local:
1. Clonar el repositorio:
   - ```git clone https://github.com/MCortinez-dev/OdontoWeb.git```
2. Configurar el Servidor:
   - Mover la carpeta del proyecto a C:\xampp\htdocs\.
3. Instalar Dependencias:
Desde la terminal en la raíz del proyecto:
   - ```composer install```
4. Base de Datos:
   - Crear una base de datos llamada odontoweb.
   - Importar el archivo SQL (ubicado en /db/odontoweb.sql o similar).
5. Habilitar Extensiones en PHP:
   - Asegurarse de tener habilitadas las extensiones gd y zip en el archivo php.ini de XAMPP.

## 📁 Estructura del Proyecto
```
ODONTOWEB/
├── controllers/    # Lógica de negocio (Exportar PDF, Login, etc.)
├── includes/       # Conexión a DB y funciones globales
├── public/         # Imágenes, estilos CSS y scripts JS
├── vendor/         # Librerías de Composer (TCPDF, etc.)
├── views/          # Archivos PHP de la interfaz de usuario
└── index.php       # Punto de entrada al sistema
```
## ✒️ Autores
   - Matias Roberto Cortinez - Desarrollador y Técnico Electrónico - MCortinez-dev
   - Damian Dominguez - Desarrollador - Damianmdominguez

## 📸 Screenshots

![Main](public/img/screenshots/main.png)

![Turnos](public/img/screenshots/turnos.png)

![Login](public/img/screenshots/login.png)

![User_Panel](public/img/screenshots/user_panel.png)

![Imprimir Turnos](public/img/screenshots/turnos_print.png)

