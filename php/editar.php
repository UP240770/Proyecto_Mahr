<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
// 1. OBTENER EL ID del gato desde la URL (usando GET)
// Es correcto usar $_GET aquí porque es el ID lo único que viaja en la URL corta
$id = $_GET['IDProducto'];

// 2. CONEXIÓN A LA BASE DE DATOS
$cnx = mysqli_connect("localhost", "root", "", "mahr");

// 3. CONSULTAR TODOS LOS DATOS DEL GATO USANDO EL ID
$sql_select = "SELECT IDProducto, PriceReference , Currency , ProductCode, DescriptionLong1 , DescriptionLong2 ,OrderUnit,Listprice , NumeroOrden FROM producto WHERE IDProducto = " . $id;
$resultado = mysqli_query($cnx, $sql_select);

// 4. EXTRAER LOS DATOS y rellenar las variables
if ($gato = mysqli_fetch_assoc($resultado)) {
    $PriceReference = $gato['PriceReference'];
    $Currency = $gato['Currency'];
    $ProductCode = $gato['ProductCode'];
    $DescriptionLong1 = $gato['DescriptionLong1'];
    $DescriptionLong2 = $gato['DescriptionLong2'];
    $OrderUnit = $gato['OrderUnit'];
    $Listprice = $gato['Listprice'];
    $NumeroOrden = $gato['NumeroOrden'];
} else {
    // Manejar el caso de que el ID no exista
    echo "<h1>Error: Producto no encontrado </h1>";
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

<td><input type="text" name="IDProducto" id="" style="visibility:hidden"value="<?=$id ?>"></td>

</tr>
<tr>

<td>Price Reference </td>
<td><input type="text" name="PriceReference" id="" value="<?=$PriceReference ?>"></td>

</tr>
<tr>

<td>Currency</td>
<td><input type="text" name="Currency" id="" value="<?=$Currency ?>"></td>

</tr>
<tr>

<td>ProductCode</td>
<td><input type="text" name="ProductCode" id="" value="<?=$ProductCode ?>"></td>

</tr>
<tr>

<td>Description Long 1:</td>
<td><input type="text" name="DescriptionLong1" id="" value="<?=$DescriptionLong1 ?>"></td>

</tr>


<tr>

<td>Description Long 2 :</td>
<td><input type="text" name="DescriptionLong2" id="" value="<?=$DescriptionLong2 ?>"></td>

</tr>


<tr>

<td>Order Unit</td>
<td><input type="text" name="OrderUnit" id="" value="<?=$OrderUnit ?>"></td>

</tr>

<tr>

<td>List Price</td>
<td><input type="text" name="Listprice" id="" value="<?=$Listprice ?>"></td>

</tr>


<tr>

<td><input type="text" name="NumeroOrden" id="" style="visibility:hidden" value="<?=$NumeroOrden ?>"></td>

</tr>

<!-- 
<tr>
    <td>IMAGEN ACTUAL:</td>
    <td><img height="50px" src="data:image/jpg;base64, <?php // echo base64_encode($gato['imagen']) ?>"></td>
</tr>

 
<tr>
    <td>SELECCIONAR NUEVA IMAGEN:</td>
    <td><input type="file" name="nueva_imagen" id="nueva_imagen"></td>
</tr>

-->

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