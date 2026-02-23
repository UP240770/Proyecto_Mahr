<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Prueba de conexión a la base de datos</h2>";

// Intentar conectar
$cnx = mysqli_connect("localhost", "root", "", "mahr");

if (!$cnx) {
    echo "<p style='color: red;'>❌ Error de conexión: " . mysqli_connect_error() . "</p>";
    echo "<p>Número de error: " . mysqli_connect_errno() . "</p>";
} else {
    echo "<p style='color: green;'>✅ Conexión exitosa a la base de datos 'mahr'</p>";
    
    // Verificar si la tabla 'productos' existe
    $result = mysqli_query($cnx, "SHOW TABLES LIKE 'productos'");
    if (mysqli_num_rows($result) > 0) {
        echo "<p style='color: green;'>✅ La tabla 'productos' existe</p>";
        
        // Contar registros
        $count = mysqli_query($cnx, "SELECT COUNT(*) as total FROM productos");
        $row = mysqli_fetch_assoc($count);
        echo "<p>Total de productos: " . $row['total'] . "</p>";
    } else {
        echo "<p style='color: red;'>❌ La tabla 'productos' NO existe</p>";
    }
    
    mysqli_close($cnx);
}

// Probar conexión sin seleccionar base de datos
echo "<h3>Listando bases de datos disponibles:</h3>";
$cnx2 = mysqli_connect("localhost", "root", "");
$dbs = mysqli_query($cnx2, "SHOW DATABASES");
echo "<ul>";
while ($db = mysqli_fetch_array($dbs)) {
    echo "<li>" . $db[0] . ($db[0] == 'mahr' ? " ← (esta es tu BD)" : "") . "</li>";
}
echo "</ul>";
mysqli_close($cnx2);
?>
