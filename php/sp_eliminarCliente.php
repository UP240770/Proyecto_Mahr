<?php
$id = $_GET['IDCliente'];



$cnx = mysqli_connect("localhost","root","","mahr");

$sql = "DELETE FROM cliente where IDCliente like $id";

$rta = mysqli_query($cnx,$sql);

if(!$rta){


echo "No se elimino";

}
else{


header("Location: " . $_SERVER['PHP_SELF']);


}
?>