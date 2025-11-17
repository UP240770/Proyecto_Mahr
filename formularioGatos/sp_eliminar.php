<?php
$id = $_GET['id'];



$cnx = mysqli_connect("localhost","root","","registro");

$sql = "DELETE FROM registro_gatos where id like $id";

$rta = mysqli_query($cnx,$sql);

if(!$rta){


echo "No se elimino";

}
else{


header("Location: index.php");


}
?>