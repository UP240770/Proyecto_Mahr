<?php
// Habilitar la visualización de errores (Quitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 1. CONEXIÓN A LA BASE DE DATOS
$cnx = new mysqli("localhost", "root", "", "mahr"); // Usamos el modo orientado a objetos

if ($cnx->connect_error) { 
    die("Fallo de conexión a la BD: " . $cnx->connect_error);
}

// 2. OBTENER Y VALIDAR DATOS DE ENTRADA

// Usamos filter_var para validar y sanear los datos numéricos, evitando el error 
// 'Incorrect integer value: '''.

// PriceReference (Asumimos float/double en BD)
$PriceReference_input = $_POST['PriceReference'] ?? 0;
$PriceReference = filter_var($PriceReference_input, FILTER_VALIDATE_FLOAT) ?: 0;

$Currency = $_POST['Currency'] ?? '';

// ProductCode (Asumimos integer en BD)
$ProductCode_input = $_POST['ProductCode'] ?? 0;
$ProductCode = filter_var($ProductCode_input, FILTER_VALIDATE_INT) ?: 0;

// DescriptionLong1 y DescriptionLong2 (Nombres corregidos en el formulario HTML)
$DescriptionLong1 = $_POST['DescriptionLong1'] ?? '';
$DescriptionLong2 = $_POST['DescriptionLong2'] ?? '';

$OrderUnit = $_POST['OrderUnit'] ?? '';

// Listprice (CORRECCIÓN APLICADA: Aseguramos la lectura del campo 'Listprice' del formulario)
$Listprice_input = $_POST['Listprice'] ?? 0;
$Listprice = filter_var($Listprice_input, FILTER_VALIDATE_FLOAT) ?: 0;

// NumeroOrden (Asumimos integer en BD)
$NumeroOrden_input = $_POST['NumeroOrden'] ?? 0;
$NumeroOrden = filter_var($NumeroOrden_input, FILTER_VALIDATE_INT) ?: 0;


// 3. CONSTRUIR Y PREPARAR LA CONSULTA DE INSERCIÓN (SEGURO)

$sql = "INSERT INTO producto (
            PriceReference, 
            Currency, 
            ProductCode, 
            DescriptionLong1, 
            DescriptionLong2, 
            OrderUnit, 
            Listprice, 
            NumeroOrden
        ) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)"; 

$stmt = $cnx->prepare($sql);

if ($stmt === false) {
    die("Error al preparar la consulta: " . $cnx->error);
}

// 4. ENLAZAR PARÁMETROS Y TIPOS DE DATOS
// Tipos: d=double/float, s=string, i=integer
// d s i s s s d i -> Double, String, Integer, String*3, Double, Integer
$tipos = "dsissdsi"; 

$stmt->bind_param($tipos, 
    $PriceReference,     // d (Double)
    $Currency,           // s (String)
    $ProductCode,        // i (Integer)
    $DescriptionLong1,   // s (String)
    $DescriptionLong2,   // s (String)
    $OrderUnit,          // s (String)
    $Listprice,          // d (Double)
    $NumeroOrden         // i (Integer)
);

// 5. EJECUTAR LA SENTENCIA
$ejecucion_exitosa = $stmt->execute();

// 6. CERRAR Y REDIRECCIÓN
if (!$ejecucion_exitosa) {
    echo "No se pudo insertar. Error: " . $stmt->error;
} else {
    $stmt->close();
    $cnx->close();
    // Redirecciona a la misma página del formulario (asumiendo que el formulario está en el script principal)
   // header("Location: " . $_SERVER['PHP_SELF']);

    exit(); 
}

$stmt->close();
$cnx->close();
?>