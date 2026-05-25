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

## 🔩 Diagrama de Arquitectura y Relaciones Completo

```text
<div align="center" style="background-color: white; padding: 20px; border-radius: 10px;">

```mermaid
graph TD
    %% Estilos de diseño
    classDef config fill:#fcf8e3,stroke:#8a6d3b,stroke-width:2px;
    classDef paciente fill:#d9edf7,stroke:#31708f,stroke-width:2px;
    classDef admin fill:#f2dede,stroke:#a94442,stroke-width:2px;
    classDef controller fill:#dff0d8,stroke:#3c763d,stroke-width:2px;
    classDef db fill:#eceff1,stroke:#37474f,stroke-width:3px;
    classDef libreria fill:#f3e5f5,stroke:#8e24aa,stroke-width:2px;

    %% Archivos de Configuración y Base de Datos
    DB[(Base de Datos:<br>odontoweb)]:::db
    CFG_L[config.local.php<br>Credenciales SMTP]:::config
    CFG[config.php<br>BASE_URL]:::config
    CONEX[includes/conexion.php<br>Port: 3307]:::config

    %% Vistas y Controladores del PACIENTE
    REG_V[views/registro.php]:::paciente
    REG_C[controllers/registro-controller.php]:::controller
    LOG_V[views/login.php]:::paciente
    LOG_C[controllers/login_controller.php]:::controller
    PAN_V[views/user_panel.php<br>Panel Usuario]:::paciente
    UD_C[controllers/user-data-logic.php<br>Ver, Borrar y Act. Cuenta]:::controller
    
    %% Calendario y Reservas
    CAL_C[controllers/calendar-controller.php<br>Lógica Disponibilidad]:::controller
    PRINT_V[views/print-turno.php<br>Ver e Imprimir]:::paciente

    %% Acciones de Exportación y Notificación
    EXP_CSV[controllers/exportar-csv.php]:::controller
    EXP_PDF[controllers/exportar-pdf.php]:::controller
    ENV_MAIL[controllers/enviar-email-turno.php]:::controller
    LIB_TCPDF[[Librería: TCPDF]]:::libreria
    LIB_MAIL[[Librería: PHPMailer]]:::libreria

    %% Flujo del ADMINISTRADOR
    MAESTRO[crear_maestro.php]:::admin
    ADM_LOG_V[views/login_admin.php]:::admin
    ADM_LOG_C[controllers/verif_admin.php]:::controller
    ADM_PAN_V[views/panel_admin.php]:::admin
    CONF_T[controllers/confirmar_turno.php]:::controller
    EXP_XLS[controllers/exportar_excel.php]:::controller

    %% --- RELACIONES DEL FLUJO PACIENTE ---
    REG_V -- POST Datos --> REG_C
    REG_C -- password_hash --> DB
    LOG_V -- POST Credenciales --> LOG_C
    LOG_C -- Verifica Hash --> DB
    LOG_C -- Inicializa $_SESSION<br>Redirige --> PAN_V
    
    PAN_V -- Carga Datos e Historial --> UD_C
    UD_C -- SELECT Turnos JOIN --> DB
    UD_C -- Acción: borrar / actualizar --> DB
    
    PAN_V -- Solicita Turno --> CAL_C
    CAL_C -- Query Ocupados/Médicos --> DB
    CAL_C -- INSERT nuevo turno --> DB
    CAL_C -- Redirige con ID --> PRINT_V

    PRINT_V -- Click Descargar CSV --> EXP_CSV
    PRINT_V -- Click Descargar PDF --> EXP_PDF
    PRINT_V -- Click Enviar por Mail --> ENV_MAIL
    
    EXP_CSV -- Validación de dueño --> DB
    EXP_PDF -- Usa TCPDF --> LIB_TCPDF
    EXP_PDF -- Consulta Datos --> DB
    ENV_MAIL -- Obtiene SMTP_USER/PASS --> CFG_L
    ENV_MAIL -- Genera PDF intermedio --> LIB_TCPDF
    ENV_MAIL -- Envía adjunto --> LIB_MAIL

    %% --- RELACIONES DEL FLUJO ADMINISTRADOR ---
    MAESTRO -- Inserta admin provisional --> DB
    ADM_LOG_V -- POST Credenciales --> ADM_LOG_C
    ADM_LOG_C -- Consulta admin --> DB
    ADM_LOG_C -- password_verify TRUE<br>Inicia $_SESSION['admin_id'] --> ADM_PAN_V
    
    ADM_PAN_V -- Acción: Confirmar --> CONF_T
    CONF_T -- UPDATE estado = 'confirmado' --> DB
    ADM_PAN_V -- Click Exportar Excel --> EXP_XLS
    EXP_XLS -- SELECT Turnos con INNER JOIN --> DB
```
<\div>

## 📂 Estructura del Proyecto
El proyecto sigue una arquitectura modular para separar la lógica de negocio de la interfaz de usuario:

```
ODONTOWEB/
├── controllers/          # Lógica de control y procesamiento de datos
│   ├── calendar-controller.php   # Lógica del calendario y disponibilidad
│   ├── exportar-pdf.php          # Generación de reportes con TCPDF
│   ├── exportar-csv.php          # Exportación de turnos a Excel/CSV
│   ├── login_controller.php      # Autenticación de pacientes y admins
│   └── ... (registro, email, gestión de doctores)
│
├── includes/             # Componentes reutilizables y configuración base
│   ├── conexion.php              # Conexión centralizada a MySQL
│   ├── header.php / footer.php   # Elementos comunes de la interfaz
│   └── ...
│
├── lib/                  # Librerías externas (instalación manual)
│   └── TCPDF/                    # Motor de generación de PDF
│
├── models/               # Archivos de base de datos
│   └── odontoweb.sql             # Estructura y datos iniciales de las tablas
│
├── public/               # Recursos estáticos accesibles por el navegador
│   ├── css/                      # Hojas de estilo modulares (login, user, calendar)
│   ├── img/                      # Imágenes del sitio y galería de profesionales
│   └── img/screenshots/          # Capturas de pantalla para documentación
│
├── views/                # Interfaz de usuario (Páginas finales)
│   ├── login.php                 # Acceso para pacientes
│   ├── turno.php                 # Interfaz de reserva de turnos
│   ├── user_panel.php            # Panel de gestión del paciente
│   └── ... (panel_admin, registro, vista de impresión)
│
├── vendor/                  # Librerías externas ocultas (instalación manual)
│   └── PHPmailer/                    # Motor de envío de email
├── config.php            # Configuración de rutas y constantes globales
├── index.php             # Punto de entrada principal
└── README.md             # Documentación del proyecto
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

