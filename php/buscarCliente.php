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
// Manejo seguro de la variable $buscar para evitar errores
// Si no existe, se inicializa como cadena vacía
$buscar = $_POST['buscar'] ?? ''; 
// Preparamos el patrón de búsqueda con comodines para buscar en cualquier parte del campo
$search_param = '%' . $buscar . '%'; 
?>

<div>
    
<form action="" method="post">
    <input type="text" name="buscar" id="search_input" value="<?php echo htmlspecialchars($buscar); ?>">
    <input type="submit" value="Buscar">
    <a href="nuevo.php">Nuevo</a>
</form>

</div>

<div>
<table border="1">
<tr>
 <th>ID</th>
 <th>NombreEmpresa</th>
 <th>Nombre Cliente</th>
 <th>Direccion</th>
 <th>Telefono</th>
 <th>Email</th>
 <th>Acciones</th>
</tr>

<?php

// 1. CONEXIÓN (Orientada a Objetos)
$cnx = new mysqli("localhost", "root", "", "mahr");

if ($cnx->connect_error) {
    die("Conexión fallida: " . $cnx->connect_error);
}

// 2. SENTENCIA PREPARADA: Buscar en varios campos
$sql_prepare = "SELECT IDCliente, NombreEmpresa, AttnCliente, Direccion, Phone, Email 
                FROM cliente 
                WHERE NombreEmpresa LIKE ? OR AttnCliente LIKE ? OR Direccion LIKE ? OR Phone LIKE ? OR Email LIKE ?
                ORDER BY IDCliente DESC";

$stmt = $cnx->prepare($sql_prepare);

if ($stmt === false) {
    die("Error al preparar la consulta: " . $cnx->error);
}

// 3. ENLAZAR PARÁMETROS (5 parámetros, todos strings)
$stmt->bind_param("sssss", $search_param, $search_param, $search_param, $search_param, $search_param);

$stmt->execute();
$rta = $stmt->get_result(); // Obtenemos el resultado para iterar

// 4. MOSTRAR RESULTADOS
while ($mostrar = $rta->fetch_assoc()){
    // Usamos fetch_assoc para mayor claridad
?>

<tr>
<td><?php echo htmlspecialchars($mostrar['IDCliente']) ?></td>
<td><?php echo htmlspecialchars($mostrar['NombreEmpresa']) ?></td>
<td><?php echo htmlspecialchars($mostrar['AttnCliente']) ?></td>
<td><?php echo htmlspecialchars($mostrar['Direccion']) ?></td>
<td><?php echo htmlspecialchars($mostrar['Phone']) ?></td>
<td><?php echo htmlspecialchars($mostrar['Email']) ?></td>
<td>
<a href="editar_cliente.php?IDCliente=<?php echo urlencode($mostrar['IDCliente']) ?>">Editar</a>
<a href="sp_eliminar_cliente.php?IDCliente=<?php echo urlencode($mostrar['IDCliente']) ?>">Eliminar</a>
</td>
</tr>

<?php
}

// 5. CERRAR CONEXIÓN
$stmt->close();
$cnx->close();
?>
</table>
</div> </body>
</html>