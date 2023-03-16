<!--en esta parte se le esta dando seguridad a la pagina para que cierre completamente la sesion-->
<!--<link rel="stylesheet" type="text/css" href="./css/style.css">-->
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
            <?php include "includes/nav.php"; ?>
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
                            