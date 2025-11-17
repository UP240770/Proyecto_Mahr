<?php
//conexion a la base de datos
$servidor = "localhost";
$usuario = "root";
$password = "";
$basedatos = "prueba";

//crear relacion
$conexion = new mysqli($servidor, $usuario, $password, $basedatos);

//verificacion
if ($conexion -> connect_error) {
    die("Error de conexión: " . $conexion -> connect_error);
}
?>