<?php
// Habilitar la visualización de errores (Quitar en producción)
// **ATENCIÓN:** Esto es útil en desarrollo, pero desactívalo en producción.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. CONEXIÓN A LA BASE DE DATOS
$cnx = new mysqli("localhost", "root", "", "mahr"); // Usamos el modo orientado a objetos

if ($cnx->connect_error) { 
    die("Fallo de conexión a la BD: " . $cnx->connect_error);
}

// 2. OBTENER Y VALIDAR DATOS DE ENTRADA
// Usamos el operador de fusión nula (??) para evitar errores si un campo POST no existe
$id = $_POST['IDProducto'] ?? null;
$PriceReference = $_POST['PriceReference'] ?? '';
$Currency = $_POST['Currency'] ?? '';
$ProductCode = $_POST['ProductCode'] ?? '';
$DescriptionLong1 = $_POST['DescriptionLong1'] ?? '';
$DescriptionLong2 = $_POST['DescriptionLong2'] ?? '';
$OrderUnit = $_POST['OrderUnit'] ?? '';
$Listprice = $_POST['Listprice'] ?? 0; // Se asume que Listprice es numérico

// El ID del producto es crucial para la actualización
if (is_null($id)) {
    die("Error: IDProducto no recibido.");
}

// 3. CONSTRUIR Y PREPARAR LA CONSULTA DE ACTUALIZACIÓN (SEGURO)

$sql = "UPDATE producto SET 
        PriceReference = ?,
        Currency = ?,
        ProductCode = ?,
        DescriptionLong1 = ?,
        DescriptionLong2 = ?,
        OrderUnit = ?,
        Listprice = ?
        WHERE IDProducto = ?"; // Usamos IDProducto como clave

$stmt = $cnx->prepare($sql);

if ($stmt === false) {
    die("Error al preparar la consulta: " . $cnx->error);
}

// 4. ENLAZAR PARÁMETROS Y TIPOS DE DATOS
// Tipos: s=string, i=integer, d=double. Asumimos PriceReference, Listprice son strings o decimales.
// Si Listprice es un número, podrías cambiar 's' por 'd' o 'i'.
// Si Listprice es un decimal o float, es mejor usar 'd'
$tipos = "sssssssi"; // s*6 (cadenas) + s (Listprice) + i (IDProducto)

$stmt->bind_param($tipos, 
    $PriceReference, 
    $Currency, 
    $ProductCode, 
    $DescriptionLong1, 
    $DescriptionLong2, 
    $OrderUnit, 
    $Listprice, // Debería ser un string 's' si es un decimal
    $id
);

// 5. EJECUTAR LA SENTENCIA
$ejecucion_exitosa = $stmt->execute();

// 6. CERRAR Y REDIRECCIÓN
if (!$ejecucion_exitosa) {
    echo "No se actualizó. Error: " . $stmt->error;
} else {
    // Si la ejecución fue exitosa, pero no se afectó ninguna fila (ej. los datos no cambiaron),
    // aún así consideramos la operación como "exitosa".
    $stmt->close();
    $cnx->close();
    header("Location: index.php");
    exit(); // Es buena práctica usar exit() después de header()
}

$stmt->close();
$cnx->close();
?>