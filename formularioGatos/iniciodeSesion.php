<?php


$dbhost="localhost";
$dbuser="root";
$dbpass="";
$dbname="registro";

$usuarioprimario='CecyTeAMOrLeloS';
$contrase='67890';

$conn=mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(!$conn){

    die("No hay conexion: ".mysqli_connect_error());

}

         $nombre =$_POST["nombre"];
         $contra =$_POST["contra"]; 


         $query=mysqli_query($conn,"SELECT * FROM usuario WHERE nombre='".$nombre."'and contra ='".$contra."'");
         $nr=mysqli_num_rows($query);

         if($nr==1){

            //header("Location: pagina.html");
            echo "Bienvenido: ".$nombre;
         } else if($nr==0){

            echo "No ingresas tonto";
         }
         else{
            echo "Ingrese bien los datos";
         }
         
         if($nombre==$usuarioprimario && $contra==$contrase){

            header("Location: index.php");
         }

?>