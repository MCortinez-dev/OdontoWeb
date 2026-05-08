<?php
require_once("includes/conexion.php");

$usuario_nuevo = "admin";
$password_plana = "admin123";

$password_segura = password_hash($password_plana, PASSWORD_DEFAULT);

$sql = "INSERT INTO administradores (usuario, password_hash) VALUES ('$usuario_nuevo', '$password_segura')";

if($conn->query($sql) === TRUE) {
    echo "<h1>¡Éxito!</h1>";
    echo "<p>Administrador creado correctamente.</p>";
    echo "<ul><li><strong>Usuario:</strong> admin</li><li><strong>Clave:</strong> admin123</li></ul>";
    echo "<p><strong>IMPORTANTE:</strong> Por seguridad, borra este archivo (crear_maestro.php) después de que funcione.</p>";
} else {
    echo "Error al crear: " . $conn->error;
}

$conn->close();
?>