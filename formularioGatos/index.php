<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatos en el plantel</title>
    <link rel="stylesheet" href="gatos1.css">
</head>
<body>
    

<div>


<main class="table">
   
    <section class="table__header">
    <div>
    
<form action="buscar.php" method="post">

<input type="text" name="buscar" id="">
<input type="submit" value="Buscar">
<a href="nuevo.php">&nbsp;&nbsp;Nuevo gato &nbsp;&nbsp; </a> <a href="#">Usuarios &nbsp;&nbsp;</a> <a href="#">Solicitudes de adopcion&nbsp;&nbsp;</a> <a href="#">Pagina&nbsp;&nbsp;</a> <br><br>


</form>

</div>
<h1>Gatos del plantel</h1>
    </section>
  <section class="table__body">



<table>
<tr>

<td>ID</td>
<td>NOMBRES</td>
<td>SEXO</td>
<td>EDAD</td>
<td>ENFERMEDADES DETECTADAS</td>
<td>OPCIONES</td>

</tr>

<?php

$cnx = mysqli_connect("localhost","root","","registro");

$sql = "SELECT id, nombre, sexo, edad ,enfermedades,imagen FROM registro_gatos order by id desc";

$rta = mysqli_query($cnx,$sql);

while ($mostrar = mysqli_fetch_row($rta)){

?>

<tr>

<td><?php echo $mostrar['0'] ?></td>
<td><?php echo $mostrar['1'] ?></td>
<td><?php echo $mostrar['2'] ?></td>
<td><?php echo $mostrar['3'] ?></td>
<td><?php echo $mostrar['4'] ?></td>
<td><img height="50px" src="data:image/jpg;base64, <?php echo base64_encode($mostrar['5']) ?>"></td>
<td>
<!-- 
<a href="editar.php?

id=<?php // echo $mostrar['0'] ?> &
nombre=<?php // echo $mostrar['1']?>&
sexo=<?php // echo $mostrar['2'] ?>&
edad=<?php // echo $mostrar['3']?>&
enfermedades=<?php // echo $mostrar['4']?>
imagen=<?php // echo base64_encode($mostrar['5']) ?>


">Editar</a>


-->
<a href="editar.php?id=<?php echo $mostrar['0'] ?>">Editar</a>


<a href="sp_eliminar.php? id=<?php echo  $mostrar['0']?>">Eliminar</a>

</td>

</tr>

<?php

}
?>


</section>

</center>
</table>
</div>

</main>

</body>
</html>