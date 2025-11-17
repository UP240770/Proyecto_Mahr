<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatos en el plantel</title>
    <link rel="stylesheet" href="css/style.css"> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
<div class="sidebar">
        <div class="sidebar-item active" data-view="product-view">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/product.png" alt="Producto">
            <span>Producto</span>
        </div>
        <div class="sidebar-item" data-view="quotation-view">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/bill.png" alt="Cotización">
            <span>Cotización</span>
        </div>
        <div class="sidebar-item" data-view="client-view">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/group.png" alt="Clientes">
            <span>Clientes</span>
        </div>
        <div class="sidebar-item" data-view="generate-quotation-view">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/price-tag.png" alt="Generar Cotización">
            <span>Generar Cotización</span>
        </div>
    </div>

    <div class="main-content"> 
        <div id="product-view" class="view active">
            <div class="header">
                <form action="php/buscar.php" method="post">
                <div class="search-bar">
                    <span class="material-icons">search</span>
                    <input type="text" placeholder="Buscar productos...">
                </div>
                </form>

                <div class="new-button" id="show-new-product-form">
                    <span class="material-icons">add</span>
                    <span>Nuevo Producto</span>
                </div>
            </div>

            <div class="table-container">
                <div class="table-header">
                    Productos
                </div>
                
<?php
// Conexión a la base de datos
$cnx = mysqli_connect("localhost","root","","mahr");
if (mysqli_connect_errno()) {
    die("Error de conexión a la BD: " . mysqli_connect_error());
}

// --- LÓGICA DE PAGINACIÓN ---
$elementos_pagina = 5; // Número de registros a mostrar por página

// 1. Determinar página actual (por defecto es 1)
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$pagina_actual = max(1, $pagina_actual); // Asegura que la página sea al menos 1

// 2. Calcular el punto de inicio para la consulta SQL
$inicio = ($pagina_actual - 1) * $elementos_pagina;

// 3. Consultar elementos totales
$sql_total = "SELECT COUNT(*) AS total FROM producto";
$resultado_total = mysqli_query($cnx, $sql_total);
$fila_total = mysqli_fetch_assoc($resultado_total);
$total_elementos = $fila_total['total'];

// 4. Calcular el total de páginas
$total_paginas = ceil($total_elementos / $elementos_pagina);

// 5. Ajustar página actual si el total de páginas es 0 o si la página es inválida
if ($total_paginas === 0) {
    $pagina_actual = 1;
} elseif ($pagina_actual > $total_paginas) {
    $pagina_actual = $total_paginas;
    $inicio = ($pagina_actual - 1) * $elementos_pagina;
}

// 6. Consulta de la página actual con LIMIT
$sql = "SELECT IDProducto, CodigoProducto, Descripcion, PrecioUnitario ,NumeroUnitario,NumeroOrden 
        FROM producto 
        ORDER BY IDProducto DESC 
        LIMIT $inicio, $elementos_pagina";
        
$rta = mysqli_query($cnx, $sql);
// -----------------------------
?>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Codigo Producto</th>
                            <th>Descripcion</th>
                            <th>Precio Unitario</th>
                            <th>Numero Unitario</th>
                            <th>Numero Orden</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
    // Verifica si hay filas y comienza a iterar
    if (mysqli_num_rows($rta) > 0) {
        while ($mostrar = mysqli_fetch_row($rta)){
?>
                        <tr>
                            <td><?php echo $mostrar['0'] ?></td>
                            <td><?php echo $mostrar['1'] ?></td>
                            <td><?php echo $mostrar['2'] ?></td>
                            <td><?php echo $mostrar['3'] ?></td>
                            <td><?php echo $mostrar['4'] ?></td>
                            <td><?php echo $mostrar['5'] ?></td>
                            <td class="action-buttons">
                               <span class="material-icons delete"><a href="php/sp_eliminar.php? IDProducto=<?php echo  $mostrar['0']?>">delete</a></span>  
                               <span class="material-icons edit"><a href="php/editar.php?IDProducto=<?php echo $mostrar['0'] ?>"> edit</a></span> 
                            </td>
                        </tr>
<?php
        } // Fin del while
    } else {
        // Mensaje si no hay productos
?>
                        <tr>
                            <td colspan="7" style="text-align: center;">No hay productos para mostrar.</td>
                        </tr>
<?php
    }
?>
                    </tbody>
                </table>
            </div>

            <p style="text-align: center; margin-top: 10px;">
                Mostrando página **<?php echo $pagina_actual; ?>** de **<?php echo $total_paginas; ?>**
                (Total: **<?php echo $total_elementos; ?>** productos)
            </p>

            <div class="pagination">
                <?php
                $archivo_actual = $_SERVER['PHP_SELF']; 

                if ($total_paginas > 1) { 

                    // Botón "FIRST PAGE"
                    if ($pagina_actual > 1) {
                        echo "<a href='$archivo_actual?pagina=1' class='pagination-button'>FIRST PAGE</a>";
                    } else {
                        echo "<span class='pagination-button disabled'>FIRST PAGE</span>";
                    }

                    // Botón para Retroceder
                    if ($pagina_actual > 1) {
                        echo "<a href='$archivo_actual?pagina=" . ($pagina_actual - 1) . "' class='pagination-button'>Retroceder</a>";
                    } else {
                        echo "<span class='pagination-button disabled'>Retroceder</span>";
                    }

                    // --- Numeración de Paginación (con rango) ---
                    $rango = 2;
                    $inicio_rango = max(2, $pagina_actual - $rango);
                    $fin_rango = min($total_paginas - 1, $pagina_actual + $rango);

                    // Página 1 
                    if ($total_paginas >= 1) {
                        echo "<a href='$archivo_actual?pagina=1' class='pagination-number" . ($pagina_actual == 1 ? " active" : "") . "'>1</a>";
                    }

                    // Puntos suspensivos (inicio-activa)
                    if ($inicio_rango > 2) {
                        echo "<span class='pagination-number' style='cursor: default;'>...</span>";
                    }

                    // Rango alrededor de la página activa
                    for ($i = $inicio_rango; $i <= $fin_rango; $i++) {
                        echo "<a href='$archivo_actual?pagina=$i' class='pagination-number" . ($i == $pagina_actual ? " active" : "") . "'>$i</a>";
                    }

                    // Puntos suspensivos (activa-fin)
                    if ($fin_rango < $total_paginas - 1) {
                        echo "<span class='pagination-number' style='cursor: default;'>...</span>";
                    }
                    
                    // Última página
                    if ($total_paginas > 1 && ($total_paginas != 1)) {
                        echo "<a href='$archivo_actual?pagina=$total_paginas' class='pagination-number" . ($pagina_actual == $total_paginas ? " active" : "" ) . "'>$total_paginas</a>";
                    }

                    // Botón para Avanzar
                    if ($pagina_actual < $total_paginas) {
                        echo "<a href='$archivo_actual?pagina=" . ($pagina_actual + 1) . "' class='pagination-button'>Avanzar</a>";
                    } else {
                        echo "<span class='pagination-button disabled'>Avanzar</span>";
                    }
                    
                    // Botón "LAST PAGE"
                    if ($pagina_actual < $total_paginas) {
                        echo "<a href='$archivo_actual?pagina=$total_paginas' class='pagination-button'>LAST PAGE</a>";
                    } else {
                        echo "<span class='pagination-button disabled'>LAST PAGE</span>";
                    }
                }
                ?>
            </div>
        </div>

        <div id="new-product-form-view" class="form-view">
            <form action="php/sp_insertar.php" method="post" enctype="multipart/form-data">
            <h2>Nuevo Producto</h2>
            <div class="form-group">
                <label for="nombre-producto">Nombre del producto</label>
                <input type="text" name="nombre" id="" required="">
            </div>
            <div class="form-group">
                <label for="descripcion">Genero</label>
                <input type="text" name="sexo" id="">
            </div>
            <div class="form-group">
                <label for="precio-unitario">Edad</label>
                <input type="text" name="edad" id="">
            </div>
            <div class="form-group">
                <label for="numero-orden">Número orden</label>
                <input type="text" name="enfermedades" id="">
            </div>
             <div class="form-group">
                <label for="numero-orden">Foto de gato</label>
                <input type="file" name="imagen" id="">
            </div>
            
            <div class="form-buttons">
                <button type="submit" class="form-button">ENVIAR</button>
                <button type="button" class="form-button clear" id="clear-product-form">BORRAR CAMPOS</button>
                <button type="button" class="form-button clear" id="cancel-product-form"> Cancelar </button>
            </div>
            </form>
        </div>
        
    </div>

<div>




            <!--Vista de tabla de clientes -->

  <div id="client-view" class="view">
            <div class="header">
                <div class="search-bar">
                    <span class="material-icons">search</span>
                    <input type="text" placeholder="Buscar clientes...">
                </div>
                <div class="new-button" id="show-new-client-form">
                    <span class="material-icons">add</span>
                    <span>Nuevo Cliente</span>
                </div>
            </div>

            <div class="table-container">
                <div class="table-header">
                    Clientes
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Empresa</th>
                            <th>Attn Cliente</th>
                            <th>Dirección</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>FlexTronics</td>
                            <td>Carlos Lopez</td>
                            <td>Colonia Mexico 2121 Ags</td>
                            <td>449 333 333</td>
                            <td>carlos@gmail.com</td>
                            <td class="action-buttons">
                                <span class="material-icons delete">delete</span>
                                <span class="material-icons edit">edit</span>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Jatco</td>
                            <td>Pedro Flores</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="action-buttons">
                                <span class="material-icons delete">delete</span>
                                <span class="material-icons edit">edit</span>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Nissan</td>
                            <td>Maria Jose</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="action-buttons">
                                <span class="material-icons delete">delete</span>
                                <span class="material-icons edit">edit</span>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Mabuchi</td>
                            <td>Luis Santos</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="action-buttons">
                                <span class="material-icons delete">delete</span>
                                <span class="material-icons edit">edit</span>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Ford</td>
                            <td>Anastasiac</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="action-buttons">
                                <span class="material-icons delete">delete</span>
                                <span class="material-icons edit">edit</span>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Samsung</td>
                            <td>Pedro Vazquez</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="action-buttons">
                                <span class="material-icons delete">delete</span>
                                <span class="material-icons edit">edit</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <span class="pagination-button disabled">FIRST PAGE</span>
                <span class="pagination-button disabled">Retroceder</span>
                <span class="pagination-number active">1</span>
                <span class="pagination-number">2</span>
                <span class="pagination-number">3</span>
                <span class="pagination-button">Avanzar</span>
                <span class="pagination-button">LAST PAGE</span>
            </div>
        </div>

        <div id="new-client-form-view" class="form-view">
            <h2>Nuevo Cliente</h2>
            <div class="form-group">
                <label for="nombre-empresa">Nombre de empresa</label>
                <input type="text" id="nombre-empresa" name="nombre-empresa">
            </div>
            <div class="form-group">
                <label for="attn-persona">Attn de persona</label>
                <input type="text" id="attn-persona" name="attn-persona">
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="form-buttons">
                <button type="button" class="form-button" id="submit-client-form">ENVIAR</button>
                <button type="button" class="form-button clear" id="clear-client-form">BORRAR CAMPOS</button>
            </div>
        </div>
        


        <div id="quotation-view" class="view">
            <div class="header">
                <div class="search-bar">
                    <span class="material-icons">search</span>
                    <input type="text" placeholder="Buscar cotizaciones...">
                </div>
            </div>
            <div class="table-container">
                <div class="table-header">
                    Cotizaciones
                </div>
                <p style="padding: 20px; text-align: center;">Contenido de cotizaciones aquí</p>
            </div>
        </div>

        <div id="generate-quotation-view" class="view">
            <div class="header">
                <h2>Generar Cotización</h2>
            </div>
            <div class="table-container">
                <div class="table-header">
                    Generar Nueva Cotización
                </div>
                <p style="padding: 20px; text-align: center;">Formulario para generar cotización aquí</p>
            </div>
        </div>
    </div>

<?php
// Cierra la conexión a la base de datos después de usarla
if (isset($cnx)) {
    mysqli_close($cnx);
}
?>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos de navegación del sidebar
            const sidebarItems = document.querySelectorAll('.sidebar-item');
            
            // Elementos de vistas
            const views = document.querySelectorAll('.view');
            
            // Botones para mostrar formularios
            const showNewClientFormButton = document.getElementById('show-new-client-form');
            const showNewProductFormButton = document.getElementById('show-new-product-form');
            
            // Botones de envío de formularios
            const submitClientFormButton = document.getElementById('submit-client-form');
            
            // Botones para limpiar formularios
            const clearClientFormButton = document.getElementById('clear-client-form');
            const clearProductFormButton = document.getElementById('clear-product-form');
            const cancelProductFormButton = document.getElementById('cancel-product-form');
            
            // Formularios
            const newClientFormView = document.getElementById('new-client-form-view');
            const newProductFormView = document.getElementById('new-product-form-view');
            const productView = document.getElementById('product-view');
            
            // Función para cambiar de vista
            function switchView(viewId) {
                // Ocultar todas las vistas
                views.forEach(view => {
                    view.classList.remove('active');
                });
                
                // Mostrar la vista seleccionada
                document.getElementById(viewId).classList.add('active');
                
                // Actualizar estado activo en el sidebar
                sidebarItems.forEach(item => {
                    item.classList.remove('active');
                    if (item.getAttribute('data-view') === viewId) {
                        item.classList.add('active');
                    }
                });
                
                // Ocultar formularios si están visibles
                newClientFormView.style.display = 'none';
                newProductFormView.style.display = 'none';
            }
            
            // Configurar eventos para los elementos del sidebar
            sidebarItems.forEach(item => {
                item.addEventListener('click', function() {
                    const viewId = this.getAttribute('data-view');
                    switchView(viewId);
                });
            });
            
            // Mostrar formulario de nuevo cliente
            showNewClientFormButton.addEventListener('click', function() {
                document.getElementById('client-view').classList.remove('active');
                newClientFormView.style.display = 'flex';
            });
            
            // Mostrar formulario de nuevo producto
            showNewProductFormButton.addEventListener('click', function() {
                productView.classList.remove('active');
                newProductFormView.style.display = 'flex';
            });
            
            // Enviar formulario de cliente
            submitClientFormButton.addEventListener('click', function() {
                // Aquí iría el código para enviar los datos del formulario
                alert('Cliente enviado (simulado)!');
                
                // Volver a la vista de clientes
                newClientFormView.style.display = 'none';
                document.getElementById('client-view').classList.add('active');
            });
            
            // Limpiar formulario de cliente
            clearClientFormButton.addEventListener('click', function() {
                const formInputs = newClientFormView.querySelectorAll('input');
                formInputs.forEach(input => {
                    input.value = '';
                });
            });
            
            // Limpiar formulario de producto
            clearProductFormButton.addEventListener('click', function() {
                const formInputs = newProductFormView.querySelectorAll('input, select');
                formInputs.forEach(input => {
                    input.value = '';
                });
            });

            // Cancelar formulario de producto
            cancelProductFormButton.addEventListener('click', function() {
                newProductFormView.style.display = 'none';
                productView.classList.add('active');
                // Asegúrate de que el sidebar item correspondiente esté activo
                document.querySelector('.sidebar-item[data-view="product-view"]').classList.add('active');
                document.querySelector('.sidebar-item[data-view="client-view"]').classList.remove('active'); // O el que sea necesario
            });

            // Al cargar, asegurarse de que la vista de productos esté activa si no hay otra definida
            if (!document.querySelector('.view.active')) {
                 productView.classList.add('active');
            }
        });
    </script>

</body>
</html>