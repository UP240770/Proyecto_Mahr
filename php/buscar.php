<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    

<?php

$buscar = $_POST['buscar'];

?>
<div>
    
<form action="" method="post">

<input type="text" name="buscar" id="" value="<?=$buscar?>">
<input type="submit" value="Buscar">
<a href="nuevo.php">Nuevo</a>

</form>

</div>

<div>


<table border="1">
<tr>

<td>ID</td>
<td>NOMBRES</td>
<td>SEXO</td>
<td>EDAD</td>
<td>ENFERMEDADES DETECTADAS</td>
<td>OPCIONES</td>

</tr>

<?php

$buscar = $_POST['buscar'];

$cnx = mysqli_connect("localhost","root","","registro");

$sql = "SELECT nombre, sexo,edad, enfermedades FROM registro_gatos where nombre like '$buscar' '%' or sexo like '$buscar' '%' order by id desc";

$rta = mysqli_query($cnx,$sql);

while ($mostrar = mysqli_fetch_row($rta)){

?>

<tr>

<td><?php echo $mostrar['0'] ?></td>
<td><?php echo $mostrar['1'] ?></td>
<td><?php echo $mostrar['2'] ?></td>
<td><?php echo $mostrar['3'] ?></td>
<td><?php echo $mostrar['4'] ?></td>
<td>

<a href="editar.php?

id=<?php echo $mostrar['0'] ?> &
nombre=<?php echo $mostrar['1']?>&
sexo=<?php echo $mostrar['2'] ?>&
edad=<?php echo $mostrar['3']?>&
enfermedades=<?php echo $mostrar['4']?>


">Editar</a>
<a href="sp_eliminar.php? id=<?php echo $mostrar['0'] ?>">Eliminar</a>

</td>

</tr>

<?php

}
?>
</table>
</div>

</body>
</html>