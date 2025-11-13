<?php

$nombre =$_POST['nombre'];
$sexo =$_POST['sexo'];
$edad =$_POST['edad'];
$enfermedades =$_POST['enfermedades'];
$imagen =addslashes(file_get_contents($_FILES['imagen']['tmp_name']));




$cnx = mysqli_connect("localhost","root","","registro");

$sql = "INSERT INTO registro_gatos(nombre,sexo,edad,enfermedades,imagen) VALUES('$nombre','$sexo','$edad','$enfermedades','$imagen')";

$rta = mysqli_query($cnx,$sql);

if(!$rta){


echo "No se inserto";

}
else{


header("Location: index.php");


}
?>