<html>
<head>
  <title> Alta de un registro </title>
</head>
 <body>
  <?php 
   if (isset($_POST["curp"])) {
         $curp =$_POST["curp"];
         $nombre =$_POST["nombre"];
         $contra =$_POST["contra"];
         $edad =$_POST["edad"];
         

         $enlace = mysqli_connect("localhost","root","","registro");
         if (!$enlace)
         {	 
            die("Error en la conexion: " . mysqli_connect_error());
            exit;
         }

   
   $sql = "INSERT INTO usuario (curp, nombre, contra, edad) VALUES ('$curp', '$nombre', '$contra', '$edad')";

if (mysqli_query($enlace, $sql)) {
  echo "Se guardo en la base  de datos";
    header("Location: https://nhernan.vrtoolsglobal.com/insert.html");
  } else {
  echo "Error: " . $sql . "<br>" . mysqli_error($enlace);
}

mysqli_close($enlace);
   }
?>
  </body>
 </html>