<?php
// Habilitar la visualización de errores (Quitar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// 1. CONEXIÓN A LA BASE DE DATOS (DEBE SER LO PRIMERO)
$cnx = mysqli_connect("localhost","root","","registro");

if (!$cnx) { 
    die("Fallo de conexión a la BD: " . mysqli_connect_error());
}

// 2. OBTENER Y SANEAR DATOS DE TEXTO
$id = $_POST['id'];
$nombre = mysqli_real_escape_string($cnx, $_POST['nombre']); 
$sexo = mysqli_real_escape_string($cnx, $_POST['sexo']);
$edad = mysqli_real_escape_string($cnx, $_POST['edad']);
$enfermedades = mysqli_real_escape_string($cnx, $_POST['enfermedades']);


// ** 3. LÓGICA DE ACTUALIZACIÓN DE IMAGEN **
$set_imagen = ""; // Variable para añadir el campo de imagen al SQL si es necesario

// Verificar si el usuario SUBIÓ un nuevo archivo de imagen
if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] == UPLOAD_ERR_OK) {
    
    // Leer el contenido BINARIO del archivo
    $imagen_tmp = $_FILES['nueva_imagen']['tmp_name'];
    $imagen_binaria = file_get_contents($imagen_tmp);
    
    // Sanear la imagen (esencial para datos binarios)
    $imagen_segura = mysqli_real_escape_string($cnx, $imagen_binaria);
    
    // Preparar el segmento SQL para actualizar la imagen
    $set_imagen = ", imagen='$imagen_segura'"; 
}


// 4. CONSTRUIR Y EJECUTAR LA CONSULTA
// La consulta incluye $set_imagen SOLO si se subió una nueva imagen.
$sql = "UPDATE registro_gatos SET 
        nombre='$nombre',
        sexo='$sexo',
        edad='$edad',
        enfermedades='$enfermedades'
        " . $set_imagen . " 
        WHERE id = $id";

$rta = mysqli_query($cnx,$sql);


// 5. REDIRECCIÓN
if(!$rta){
    echo "No se actualizó. Error: " . mysqli_error($cnx);
}
else{
    header("Location: index.php");
}
?>