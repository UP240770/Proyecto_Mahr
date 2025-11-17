<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo amiguito</title>
    <link rel="stylesheet" href="gatos1.css">
</head>
<body>
    
<div>

<form action="sp_insertar.php" method="post" enctype="multipart/form-data">

<main class="table">
   
    <section class="table__header">
    <h1>Nuevo gatito</h1>
    </section>

    <section class="table__body">


<table>

<tr>

<td>Ingrese datos</td>

</tr>
<tr>

<td>NOMBRES: </td>
<td><input type="text" name="nombre" id="" required=""></td>

</tr>
<tr>

<td>Genero:</td>
<td><input type="text" name="sexo" id=""></td>

</tr>
<tr>

<td>Edad:</td>
<td><input type="text" name="edad" id=""></td>

</tr>
<tr>

<td>Enfermedades detectadas:</td>
<td><input type="text" name="enfermedades" id=""></td>

</tr>
<tr>


<td>Foto de gatito</td>
<td><input type="file" name="imagen" id=""></td>

</tr>
<tr>



<td><input type="submit" value="Guardar"></td>
<td><a href="index.php">Cancelar</a></td>
</tr>
</table>


</form>

</div>
</section>
</main>
</body>
</html>