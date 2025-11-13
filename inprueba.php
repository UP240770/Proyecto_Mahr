<?php
//mrelacion entre documentos y la BD
include 'prueba.php';

//elementos mostrados
$elementos_pagina = 5;

//pagina en la que esta
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

//primer elemento en pagina
$inicio = ($pagina_actual - 1) * $elementos_pagina;

//consulta elementos totales
$sql_total = "SELECT COUNT(*) AS total FROM productos";
$resultado_total = $conexion->query($sql_total);
$fila_total = $resultado_total->fetch_assoc();
$total_elementos = $fila_total['total'];

//total de paginas
$total_paginas = ceil($total_elementos / $elementos_pagina);

//consulta elementos en pagina actual
$sql = "SELECT * FROM productos LIMIT $inicio, $elementos_pagina";
$resultado = $conexion->query($sql);
?>

<!-- HTML & CSS que no entiendo -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paginacion PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .producto {
            border: 1px solid #ddd;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }

        .paginacion {
            margin-top: 20px;
            text-align: center;
        }

        .paginacion a {
            display: inline-block;
            padding: 8px 16px;
            margin: 0 4px;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #333;
        }

        .paginacion a.activa {
            background-color: #b8473fff;
            color: white;
            border: 1px solid #b8473fff;
        }

        .paginacion a:not(.activa):hover {
            background-color: #ddd;
        }

        .btn-retroceder {
            background-color: #b8473fff; 
            color: white !important;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 5px;
        }

        .btn-retroceder:hover {
            background-color: #b8473fff;
            color: black !important;
        }

        .btn-avanzar {
            background-color: #b8473fff; 
            color: white !important;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            margin-left: 5px;
        }

        .btn-avanzar:hover {
            background-color: #b8473fff;
            color: black !important;
        }
    </style>
</head>

<!-- html con php creo -->
<body>
    <h1>Lista Productos</h1>

    <!-- info de la pagina -->
    <p>Mostrando página <?php echo $pagina_actual; ?> de <?php echo $total_paginas; ?>
    (Total: <?php echo $total_elementos; ?> productos)</p>

    <!-- Lista de los productos -->
    <?php
    if ($resultado->num_rows > 0) {
        while($fila = $resultado->fetch_assoc()) {
            echo "<div class='producto'>";
            echo "<h3>" . $fila['nombre'] . "<h3>";
            echo "<p>Precio: $" . $fila['precio'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No hay productos para mostrar.</p>";
    }
    ?>

    <!-- Navegacion de la paginacion -->
    <div class="paginacion">
        <?php
        
        //Boton para retroceder
        if ($pagina_actual > 1) {
            echo "<a href='inprueba.php?pagina=" . ($pagina_actual - 1) . "' class='btn-retroceder'>« Retroceder</a>";
        }

        //Numeración

        //viejo codigo:
        /*for ($i = 1; $i <= $total_paginas; $i++) {
            if ($i == $pagina_actual) {
                echo "<a href='inprueba.php?pagina=" . $i . "' class='activa'>" . $i . "</a>";
            } else {
                echo "<a href='inprueba.php?pagina=" . $i . "'>" . $i . "</a>";
            }
        }*/
        
        //Nuevo codigo
        $rango = 2;
        $inicio = max(2, $pagina_actual - $rango);
        $fin = min($total_paginas - 1, $pagina_actual + $rango);

        //Mostando la primera pagina
        echo "<a href='inprueba.php?pagina=1' " . ($pagina_actual == 1 ? "class='activa'" : "") . ">1</a>";

        //Boton que salta paginas (inicio-activa)
        if ($inicio > 2) {
            echo "<a href='javascript:void(0)'>...</a>";
        }

        //Rango alrededor de la pag activa
        for ($i = $inicio; $i <= $fin; $i++) {
            if ($i == $pagina_actual) {
                echo "<a href='inprueba.php?pagina=$i' class='activa'>$i</a>";
            } else {
                echo "<a href='inprueba.php?pagina=$i'>$i</a>";
            }
        }

        //Boton que salta paginas (activa-fin)
        if ($fin < $total_paginas - 1) {
            echo "<a href='javascripy:voi(0)'>...</a>";
        }

        //Mostrando la ultima pagina
        if ($total_paginas > 1) {
            echo "<a href='inprueba.php?pagina=$total_paginas' " . ($pagina_actual == $total_paginas ? "class='activa'" : "" ) . ">$total_paginas</a>";
        }


        //Boton para avanzar
        if ($pagina_actual < $total_paginas) {
            echo "<a href='inprueba.php?pagina=" .($pagina_actual + 1) . "' class='btn-avanzar'>Avanzar »</a>";
        }
        ?>

    </div>

    </body>
    </html>

    <?php

    //cerrar conexion
    $conexion->close();
    ?>