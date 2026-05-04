<?php
    $host="localhost";
    $pass="";
    $user="root";
    $db="odontoweb";
    $port="3307";

    $conn = new mysqli($host, $user, $pass, $db);

    if($conn->connect_errno){
        die("Fallo la conexión: " . $conn->connect_error);
    }
?>