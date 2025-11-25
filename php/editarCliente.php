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
// 1. OBTENER EL ID del cliente desde la URL
$id = $_GET['IDCliente'];

// 2. CONEXIÓN A LA BASE DE DATOS
$cnx = mysqli_connect("localhost", "root", "", "mahr");

// 3. CONSULTAR TODOS LOS DATOS DEL CLIENTE USANDO EL ID
$sql_select = "SELECT IDCliente, NombreEmpresa, AttnCliente, Direccion, Phone, Email FROM cliente WHERE IDCliente = " . $id;
$resultado = mysqli_query($cnx, $sql_select);

// 4. EXTRAER LOS DATOS y rellenar las variables
if ($gato = mysqli_fetch_assoc($resultado)) {
    $NombreEmpresa = $gato['NombreEmpresa'];
    $AttnCliente = $gato['AttnCliente'];
    $Direccion = $gato['Direccion'];
    $Phone = $gato['Phone'];
    $Email = $gato['Email'];
} else {
    // Manejar el caso de que el ID no exista
    echo "<h1>Error: Cliente no encontrado </h1>";
    exit;
}
?>

<div>
<form action="sp_editarCliente.php" method="post" enctype="multipart/form-data">
<main class="table">
    <section class="table__header">
    <h1>Cambie los datos</h1>
    </section>
    <section class="table__body">
<table>
<tr>
    <td>Ingrese datos</td>
    <!-- CORRECCIÓN: Usar type="hidden" en lugar de visibility:hidden -->
    <td><input type="hidden" name="IDCliente" value="<?=$id ?>"></td>
</tr>
<tr>
    <td>Nombre de empresa</td>
    <td><input type="text" name="NombreEmpresa" value="<?=htmlspecialchars($NombreEmpresa)?>"></td>
</tr>
<tr>
    <td>Nombre de Cliente</td>
    <td><input type="text" name="AttnCliente" value="<?=htmlspecialchars($AttnCliente)?>"></td>
</tr>
<tr>
    <td>Direccion</td>
    <td><input type="text" name="Direccion" value="<?=htmlspecialchars($Direccion)?>"></td>
</tr>
<tr>
    <td>Telefono</td>
    <td><input type="text" name="Phone" value="<?=htmlspecialchars($Phone)?>"></td>
</tr>
<tr>
    <td>Email</td>
    <td><input type="text" name="Email" value="<?=htmlspecialchars($Email)?>"></td>
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