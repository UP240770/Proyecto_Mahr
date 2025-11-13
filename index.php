<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gatos en el plantel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- Apartado del sidebar-->
    <div class="sidebar">
        <div class="sidebar-item" data-view="product-view">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/product.png" alt="Producto">
            <span>Producto</span>
        </div>
        <div class="sidebar-item" data-view="quotation-view">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/bill.png" alt="Cotización">
            <span>Cotización</span>
        </div>
        <div class="sidebar-item active" data-view="client-view">
            <img src="https://img.icons8.com/ios-filled/50/8a2be2/group.png" alt="Clientes">
            <span>Clientes</span>
        </div>
        <div class="sidebar-item" data-view="generate-quotation-view">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/price-tag.png" alt="Generar Cotización">
            <span>Generar Cotización</span>
        </div>
    </div>

    <div class="main-content"> 
        <!-- Vista de Productos -->
        <div id="product-view" class="view">
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
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>genero</th>
                            <th>edad</th>
                            <th>enfermedades</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

<?php

                        $cnx = mysqli_connect("localhost","root","","registro");

                        $sql = "SELECT id, nombre, sexo, edad ,enfermedades,imagen FROM registro_gatos order by id desc";

                        $rta = mysqli_query($cnx,$sql);





                        while ($mostrar = mysqli_fetch_row($rta)){

?>


                    <tbody>
                        <tr>
                            <td><?php echo $mostrar['0'] ?></td>
                            <td><?php echo $mostrar['1'] ?></td>
                            <td><?php echo $mostrar['2'] ?></td>
                            <td><?php echo $mostrar['3'] ?></td>
                            <td><?php echo $mostrar['4'] ?></td>
                            <td><img height="50px" src="data:image/jpg;base64, <?php echo base64_encode($mostrar['5']) ?>"></td>
                            <td class="action-buttons">
                               <span class="material-icons delete"><a href="php/sp_eliminar.php? id=<?php echo  $mostrar['0']?>">delete</a></span>  
                               <span class="material-icons edit"><a href="php/editar.php?id=<?php echo $mostrar['0'] ?>"> edit</a></span> 
                            </td>
                        </tr>
 <?php

}
?>
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <div class="pagination-button">FIRST PAGE</div>
                <div class="pagination-number active">1</div>
                <div class="pagination-number">2</div>
                <div class="pagination-number">3</div>
                <div class="pagination-button">LAST PAGE</div>
            </div>
        </div>

        <!-- Vista de Nuevo Producto -->
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
                <button type="button" class="form-button" id="submit-product-form"><input type="submit" value="Guardar">ENVIAR</button>
                <button type="button" class="form-button clear" id="clear-product-form">BORRAR CAMPOS</button>
                <button type="button" class="form-button clear" id="clear-product-form"> Cancelar </button>
            </div>
            </form>
        </div>
        
    </div>

<div>


  <!-- Vista de Clientes (existente) -->
        <div id="client-view" class="view active">
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
                <div class="pagination-button">FIRST PAGE</div>
                <div class="pagination-number active">1</div>
                <div class="pagination-number">2</div>
                <div class="pagination-number">3</div>
                <div class="pagination-button">LAST PAGE</div>
            </div>
        </div>

        <!-- Vista de Nuevo Cliente (existente) -->
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
        


        <!-- Vistas para Cotización y Generar Cotización (placeholder) -->
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
            const submitProductFormButton = document.getElementById('submit-product-form');
            
            // Botones para limpiar formularios
            const clearClientFormButton = document.getElementById('clear-client-form');
            const clearProductFormButton = document.getElementById('clear-product-form');
            
            // Formularios
            const newClientFormView = document.getElementById('new-client-form-view');
            const newProductFormView = document.getElementById('new-product-form-view');
            
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
                document.getElementById('product-view').classList.remove('active');
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
            
            // Enviar formulario de producto
            submitProductFormButton.addEventListener('click', function() {
                // Aquí iría el código para enviar los datos del formulario
                alert('Producto enviado (simulado)!');
                
                // Volver a la vista de productos
                newProductFormView.style.display = 'none';
                document.getElementById('product-view').classList.add('active');
            });
            
            // Limpiar formulario de cliente
            clearClientFormButton.addEventListener('click', function() {
                const formInputs = newClientFormView.querySelectorAll('input');
                formInputs.forEach(input => {
                    input.value = '';
                });
            });
            
            // Limpiar formulario de producto sada
            clearProductFormButton.addEventListener('click', function() {
                const formInputs = newProductFormView.querySelectorAll('input, select');
                formInputs.forEach(input => {
                    input.value = '';
                });
            });
        });
    </script>

</body>
</html>