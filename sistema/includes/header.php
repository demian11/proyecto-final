<!--en esta parte se le esta dando seguridad a la pagina para que cierre completamente la sesion-->
<link rel="stylesheet" type="text/css" href="./css/style.css">
<?php
//session_start();

if (empty($_SESSION['active'])) {
    header('location: ../index.php');
}
?>


<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <img src="logo.jpg" alt="Logo" style="width:50px;" class="rounded-pill">
            <a class="navbar-brand">Ciber Center</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                        
                        <?php
                        //solo el administrador podra ver esta opcion
                        //if($_SESSION['rol'] == 1){
                        ?>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Usuarios
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="registro_usuario.php">Nuevo Usuario</a></li>
                            <li><a class="dropdown-item" href="lista_usuarios.php">Lista de Usuarios</a></li>
                        </ul>
                    </li>

                    <?php //} ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Clientes
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="registro_cliente.php">Nuevo Cliente</a></li>
                            <li><a class="dropdown-item" href="lista_clientes.php">Lista de Clientes</a></li>
                        </ul>
                    </li>
                    <?php
                    //solo el rol administrador y supervisor podran ver esta opcion
                        //if($_SESSION['rol'] == 1) || $_SESSION['rol'] ==2{
                        ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Proveedores
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="registro_proveedor.php">Nuevo Proveedor</a></li>
                            <li><a class="dropdown-item" href="lista_proveedor.php">Lista de Proveedores</a></li>
                        </ul>
                    </li>

                    <?php //} ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Productos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                            //solo el rol administrador y supervisor podran ver esta opcion
                            //if($_SESSION['rol'] == 1) || $_SESSION['rol'] ==2{
                            ?>
                            <li><a class="dropdown-item" href="registro_producto.php">Nuevo Producto</a></li>
                            <?php //} ?>

                            <li><a class="dropdown-item" href="lista_producto.php">Lista de Productos</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Facturas
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Nueva Factura</a></li>
                            <li><a class="dropdown-item" href="#">Lista de Facturas</a></li>
                        </ul>

                    </li>

                    <li class="nav-item dropdown">
                        <!--Aqui estara el usuario personalizado-->
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           Usuario <?php echo $_SESSION['user'] ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="./salir.php">Cerrar sesion</a></li>
                        </ul>

                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<!--caja que actualiza los datos de los productos, precio y cantidad en el almacen-->
<!--
<div class="modal">
    <div class="bodyModal">
    </div>
</div>
                            -->
                            