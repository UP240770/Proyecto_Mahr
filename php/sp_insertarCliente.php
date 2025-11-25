<?php
// Habilitar la visualización de errores (Quitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. CONEXIÓN A LA BASE DE DATOS
$cnx = new mysqli("localhost", "root", "", "mahr");

if ($cnx->connect_error) { 
    die("Fallo de conexión a la BD: " . $cnx->connect_error);
}

// 2. OBTENER Y VALIDAR DATOS DE ENTRADA
$NombreEmpresa = $_POST['NombreEmpresa'] ?? '';
$AttnCliente = $_POST['AttnCliente'] ?? '';
$Direccion = $_POST['Direccion'] ?? '';
$Phone = $_POST['Phone'] ?? '';
$Email = $_POST['Email'] ?? '';

// 3. CONSTRUIR Y PREPARAR LA CONSULTA DE INSERCIÓN
$sql = "INSERT INTO cliente (
            NombreEmpresa, 
            AttnCliente, 
            Direccion, 
            Phone, 
            Email
        ) 
        VALUES (?, ?, ?, ?, ?)"; 

$stmt = $cnx->prepare($sql);

if ($stmt === false) {
    die("Error al preparar la consulta: " . $cnx->error);
}

// 4. ENLAZAR PARÁMETROS Y TIPOS DE DATOS - CORREGIDO
// Todos los parámetros son strings, por lo que usamos 5 's'
$tipos = "sssss"; 

$stmt->bind_param($tipos, 
    $NombreEmpresa,     // s (String)
    $AttnCliente,       // s (String)
    $Direccion,         // s (String)
    $Phone,             // s (String)
    $Email              // s (String)
);

// 5. EJECUTAR LA SENTENCIA
$ejecucion_exitosa = $stmt->execute();

// 6. CERRAR Y REDIRECCIÓN
if (!$ejecucion_exitosa) {
    echo "No se pudo insertar. Error: " . $stmt->error;
    $stmt->close();
    $cnx->close();
} else {
    $stmt->close();
    $cnx->close();
    // Redirecciona a la página principal
    header("Location: index.php");
    exit();
}
?>