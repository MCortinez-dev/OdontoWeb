# 🦷 ODONTOWEB - Sistema de Gestión Odontológica

**ODONTOWEB** es una solución integral para la gestión de clínicas dentales, diseñada para optimizar la interacción entre pacientes y profesionales. El sistema permite una reserva de turnos fluida, administración de especialistas y exportación de datos críticos para la gestión administrativa.

## 🚀 Funcionalidades Clave

- **Calendario Dinámico:** Interfaz visual para la selección de turnos con validación de disponibilidad en tiempo real.
- **Gestión de Especialidades:** Filtros inteligentes por Odontología General, Ortodoncia, Implantes y Blanqueamiento.
- **Panel de Usuario:** Los pacientes pueden gestionar sus perfiles y visualizar sus citas programadas.
- **Exportación de Datos:** Herramienta integrada para exportar confirmaciones y listados de turnos en formato **CSV** y **PDF**.
- **Seguridad:** Sistema de login con validación de sesiones, roles diferenciados y hashing de contraseñas.
- **Comunicación:** Integración con PHPMailer para notificaciones y botones de contacto directo.

## 🛠️ Stack Tecnológico

- **Backend:** PHP 8.x
- **Base de Datos:** MySQL
- **Frontend:** HTML5, CSS3 (Diseño responsivo y modular)
- **Lógica de Negocio:** Arquitectura basada en Controladores y Vistas (MVC-ish).

## 📋 Requisitos e Instalación
1. Clonar el repositorio: `git clone https://github.com/tu-usuario/ODONTOWEB.git`
2. Importar la base de datos `odontoweb.sql` en tu servidor local (XAMPP/WAMP).
3. Configurar las credenciales en `config.php`.
4. Acceder a `localhost/ODONTOWEB/views/login.php`.

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

![Modal](public/img/screenshots/modal.png)

![Login](public/img/screenshots/login.png)

![Registro](public/img/screenshots/registro.png)

![User_Panel](public/img/screenshots/user_panel.png)

![Turnos](public/img/screenshots/turnos.png)

![Imprimir Turnos](public/img/screenshots/print_turno.png)

