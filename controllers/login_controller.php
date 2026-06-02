<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/ODONTOWEB/includes/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identificador = $_POST['identificador'];
    $password = $_POST['password'];


    $stmt_admin = $conn->prepare("SELECT id, usuario, password_hash FROM administradores WHERE usuario = ?");
    $stmt_admin->bind_param("s", $identificador);
    $stmt_admin->execute();
    $res_admin = $stmt_admin->get_result();

    if ($row_admin = $res_admin->fetch_assoc()) {
        if (password_verify($password, $row_admin['password_hash'])) {
            
            $_SESSION['admin_id'] = $row_admin['id'];
            $_SESSION['admin_usuario'] = $row_admin['usuario'];
            $_SESSION['rol'] = 'admin';

            header("Location: " . BASE_URL . "views/panel_admin.php");
            exit();
        }
    }

   
    $stmt_paciente = $conn->prepare("SELECT id, nombre, password_hash FROM pacientes WHERE email = ?");
    $stmt_paciente->bind_param("s", $identificador);
    $stmt_paciente->execute();
    $res_paciente = $stmt_paciente->get_result();

    if ($row_paciente = $res_paciente->fetch_assoc()) {
        if (password_verify($password, $row_paciente['password_hash'])) {
            
            $_SESSION['paciente_id'] = $row_paciente['id'];
            $_SESSION['paciente_nombre'] = $row_paciente['nombre'];
            $_SESSION['rol'] = 'paciente';

            header("Location: " . BASE_URL . "views/user_panel.php");
            exit();
<<<<<<< HEAD
        }
    }

    
    header("Location: " . BASE_URL . "views/login.php?error=credenciales_incorrectas");
    exit();
=======
        } else {
            header("Location: " . BASE_URL . "views/login.php?error=password_incorrecta");
            exit();
        }
    } else {
        header("Location: " . BASE_URL . "views/login.php?error=usuario_no_encontrado");
        exit();
    }
>>>>>>> d32cf7d34ab90c12876ae73b6a3aca73f9af6881
}
?>