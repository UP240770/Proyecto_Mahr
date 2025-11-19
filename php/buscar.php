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
 <th>Price Reference</th>
 <th>Currency</th>
 <th>Product Code</th>
 <th>Description 1</th>
 <th>Description 2</th>
 <th>Order Unit</th>
 <th>List Price</th>
 <th>Numero Orden</th>
 <th>Acciones</th>
</tr>

<?php

// 1. CONEXIÓN (Orientada a Objetos)
$cnx = new mysqli("localhost", "root", "", "mahr");

if ($cnx->connect_error) {
    die("Conexión fallida: " . $cnx->connect_error);
}

// 2. SENTENCIA PREPARADA (CORREGIDO: Ordenar por IDProducto para ser consistente)
$sql_prepare = "SELECT IDProducto, PriceReference, Currency, ProductCode, DescriptionLong1, DescriptionLong2, OrderUnit, Listprice, NumeroOrden FROM producto WHERE IDProducto LIKE ? OR ProductCode LIKE ? ORDER BY IDProducto DESC";

$stmt = $cnx->prepare($sql_prepare);

if ($stmt === false) {
    die("Error al preparar la consulta: " . $cnx->error);
}

// 3. ENLAZAR PARÁMETROS ('s' = string)
// Ahora $search_param tiene el % incluido, por lo que se enlaza directamente
$stmt->bind_param("ss", $search_param, $search_param);

$stmt->execute();
$rta = $stmt->get_result(); // Obtenemos el resultado para iterar

// 4. MOSTRAR RESULTADOS
while ($mostrar = $rta->fetch_row()){
?>

<tr>
<td><?php echo htmlspecialchars($mostrar[0]) ?></td>
<td><?php echo htmlspecialchars($mostrar[1]) ?></td>
<td><?php echo htmlspecialchars($mostrar[2]) ?></td>
<td><?php echo htmlspecialchars($mostrar[3]) ?></td>
<td><?php echo htmlspecialchars($mostrar[4]) ?></td>
<td><?php echo htmlspecialchars($mostrar[5]) ?></td>
<td><?php echo htmlspecialchars($mostrar[6]) ?></td>
<td><?php echo htmlspecialchars($mostrar[7]) ?></td>
<td><?php echo htmlspecialchars($mostrar[8]) ?></td>
<td>
<a href="editar.php?IDProducto=<?php echo urlencode($mostrar[0]) ?>&PriceReference=<?php echo urlencode($mostrar[1]) ?>&Currency=<?php echo urlencode($mostrar[2]) ?>&ProductCode=<?php echo urlencode($mostrar[3]) ?>&DescriptionLong1=<?php echo urlencode($mostrar[4]) ?>&DescriptionLong2=<?php echo urlencode($mostrar[5]) ?>&OrderUnit=<?php echo urlencode($mostrar[6]) ?>&Listprice=<?php echo urlencode($mostrar[7]) ?>&NumeroOrden=<?php echo urlencode($mostrar[8]) ?>">Editar</a>

<a href="sp_eliminar.php?id=<?php echo urlencode($mostrar[0]) ?>">Eliminar</a>

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