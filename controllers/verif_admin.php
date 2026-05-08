<?php
session_start();

require_once("../includes/conexion.php");

$usuario_ingresado = $_POST["usuario"]; 
$password_ingresada = $_POST["password"]; 

$sql = "SELECT id, usuario, password_hash FROM administradores WHERE usuario = '$usuario_ingresado'";
$resultado = $conn->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    
    $admin = $resultado->fetch_assoc();
    
    if (password_verify($password_ingresada, $admin['password_hash'])) {
        
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_usuario'] = $admin['usuario'];
        
        echo "<div style='text-align: center; margin-top: 50px; font-family: sans-serif;'>";
        echo "<h2 style='color: #10B981;'>¡Acceso autorizado!</h2>";
        echo "<p>Bienvenido, " . $admin['usuario'] . ". Te estamos redirigiendo a tu panel...</p>";
        echo "</div>";
        
        header("refresh:2;url=../views/panel_admin.php");
        exit();

    } else {
        echo "<div style='text-align: center; margin-top: 50px; font-family: sans-serif;'>";
        echo "<h2 style='color: #EF4444;'>Error: La contraseña es incorrecta.</h2>";
        echo "<a href='../views/login_admin.php' style='padding: 10px; background: #333; color: white; text-decoration: none; border-radius: 5px;'>Volver a intentar</a>";
        echo "</div>";
    }

} else {
    echo "<div style='text-align: center; margin-top: 50px; font-family: sans-serif;'>";
    echo "<h2 style='color: #EF4444;'>Error: El usuario administrador no existe.</h2>";
    echo "<a href='../views/login_admin.php' style='padding: 10px; background: #333; color: white; text-decoration: none; border-radius: 5px;'>Volver a intentar</a>";
    echo "</div>";
}

$conn->close();
?>