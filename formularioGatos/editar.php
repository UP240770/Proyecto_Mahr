<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="stylesheet" href="gatos1.css">
</head>
<body>
<?php
// 1. OBTENER EL ID del gato desde la URL (usando GET)
// Es correcto usar $_GET aquí porque es el ID lo único que viaja en la URL corta
$id = $_GET['id'];

// 2. CONEXIÓN A LA BASE DE DATOS
$cnx = mysqli_connect("localhost", "root", "", "registro");

// 3. CONSULTAR TODOS LOS DATOS DEL GATO USANDO EL ID
$sql_select = "SELECT nombre, sexo, edad, enfermedades , imagen FROM registro_gatos WHERE id = " . $id;
$resultado = mysqli_query($cnx, $sql_select);

// 4. EXTRAER LOS DATOS y rellenar las variables
if ($gato = mysqli_fetch_assoc($resultado)) {
    $nombre = $gato['nombre'];
    $sexo = $gato['sexo'];
    $edad = $gato['edad'];
    $enfermedades = $gato['enfermedades'];
    $imagen = $gato['imagen'];
} else {
    // Manejar el caso de que el ID no exista
    echo "<h1>Error: Gato no encontrado.</h1>";
    exit;
}






// $id = $_POST['id'];
 // $nombre =$_POST['nombre'];
//$sexo =$_POST['sexo'];
//$edad =$_POST['edad'];
//$enfermedades =$_POST['enfermedades'];

?>


<div>

<form action="sp_editar.php" method="post" enctype="multipart/form-data">


<main class="table">
   
    <section class="table__header">
    <h1>Cambie los datos</h1>
    </section>

    <section class="table__body">

<table>

<tr>

<td>Ingrese datos</td>

<td><input type="text" name="id" id="" style="visibility:hidden"value="<?=$id ?>"></td>

</tr>
<tr>

<td>NOMBRES: </td>
<td><input type="text" name="nombre" id="" value="<?=$nombre ?>"></td>

</tr>
<tr>

<td>Genero</td>
<td><input type="text" name="sexo" id="" value="<?=$sexo ?>"></td>

</tr>
<tr>

<td>EDAD:</td>
<td><input type="text" name="edad" id="" value="<?=$edad ?>"></td>

</tr>
<tr>

<td>ENFERMEDADES DETECTADAS:</td>
<td><input type="text" name="enfermedades" id="" value="<?=$enfermedades ?>"></td>

</tr>

<tr>
    <td>IMAGEN ACTUAL:</td>
    <td><img height="50px" src="data:image/jpg;base64, <?php echo base64_encode($gato['imagen']) ?>"></td>
</tr>
<tr>
    <td>SELECCIONAR NUEVA IMAGEN:</td>
    <td><input type="file" name="nueva_imagen" id="nueva_imagen"></td>
</tr>



<tr>


<td><input type="submit" value="Actualizar"></td>
<td><a href="index.php">Cancelar</a></td>

</tr>
</table>
</section>

</form>

</div>

</main>
</body>
</html>