<?php
$id = $_GET['IDProducto'];



$cnx = mysqli_connect("localhost","root","","mahr");

$sql = "DELETE FROM producto where IDProducto like $id";

$rta = mysqli_query($cnx,$sql);

if(!$rta){


echo "No se elimino";

}
else{


header("Location: " . $_SERVER['PHP_SELF']);


}
?>