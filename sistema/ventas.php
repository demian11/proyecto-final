<?php
session_start();
include "../conexion.php";

?>
<html lang="en">

<head>
    <title>Lista de ventas</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <!--todo los scripts de los diseños se pasaron en el archivo de scripts.php-->
    <?php include "includes/scripts.php" ?>
</head>

<body>

    <!--aqui se incluye el contenido del encabezado desde otro archivo llamado header.php-->
    <?php include "includes/header.php"; ?>

    <!--aqui abajo estara todo el contenido de la pagina-->
    <section id="container">
        <br>
        <h1>Lista de ventas</h1>
        <br>

        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <a href="nueva_venta.php" type="button" class="btn btn-success"> Hacer una nueva venta</a>

                <form action="buscar_venta.php" method="get" class="d-flex" role="search" class="form_search">
                    <input class="form-control me-2" name="busqueda" id="busqueda" type="search" placeholder="No. Factura" aria-label="Buscar">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>

                <!--tal vez tenga que quitar el buscador por fechas que esta aqui abajo
    <form action="buscar_venta.php" method="get" class="form_search">
        <input type="text" name="busqueda" id="busqueda" placeholder="No. Factura">
        <button type="submit" class="btn_search"><i class="fas fa-search"></i></button>
    </form>
    -->

                <!--tal vez tenga que quitar el buscador por fechas que esta aqui abajo
    <div>
        <h5>Buscar por fecha</h5>
        <form action="buscar_venta.php" method="get" class="form_search_date">
            <label>DE:</label>
            <input type="date" name="fecha_de" id="fecha_de" required>
            <label>A</label>
            <input type="date" name="fecha_a" id="fecha_a" required>
            <button type="submit" class="btn_view"><i class="fas fa-search"></i></button>
        </form>
    </div>
    -->

            </div>
        </nav>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>Fecha/ Hora</th>
                    <th>Cliente</th>
                    <th>Vendedor</th>
                    <th>Estado</th>
                    <th class="textrigh">Total factura</th>
                    <th class="textrigh">Acciones</th>
                </tr>
            </thead>

            <!--contenido que ayudara para el desplasamiento del paginador-->
            <?php

            $sql_registe = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM factura WHERE estatus != 10");
            $result_register = mysqli_fetch_array($sql_registe);
            $total_registro = $result_register['total_registro'];
            //en esta linea 43 podremos modificarla para decir cuantos registros podremos ver por pagina
            $por_pagina = 5;

            if (empty($_GET['pagina'])) {
                $pagina = 1;
            } else {
                $pagina = $_GET['pagina'];
            }

            $desde = ($pagina - 1) * $por_pagina;
            $total_paginas = ceil($total_registro / $por_pagina);

            $query = mysqli_query($conection, "SELECT f.nofactura,f.fecha,f.totalfactura,f.codcliente,f.estatus,
                                               u.nombre as vendedor,
                                               cl.nombre as cliente
                                               FROM factura f
                                               INNER JOIN usuario u
                                               ON f.usuario= u.idusuario
                                               INNER JOIN cliente cl
                                               ON f.codcliente =cl.idcliente
                                               WHERE f.estatus != 10
                                               ORDER BY f.fecha DESC LIMIT $desde,$por_pagina");

            mysqli_close($conection);

            $result = mysqli_num_rows($query);

            if ($result > 0) {

                while ($data = mysqli_fetch_array($query)) {
                    if ($data["estatus"] == 1) {
                        $estado = '<span class="pagada">Pagada</span>';
                    } else {
                        $estado = '<span class="anulada">Anulada</span>';
                    }
            ?>
                    <tbody>
                        <tr id="row_<?php echo $data["nofactura"]; ?>">
                            <td><?php echo $data["nofactura"]; ?></td>
                            <td><?php echo $data["fecha"]; ?></td>
                            <td><?php echo $data["cliente"]; ?></td>
                            <td><?php echo $data["vendedor"]; ?></td>
                            <td><?php echo $estado; ?></td>
                            <td class="textright totalfactura"><span>$.</span><?php echo $data["totalfactura"]; ?></td>

                            <td>
                                <div class="div_acciones">
                                    <div>
                                        <button class="btn_view view_factura" type="button" cl="<?php echo $data["codcliente"]; ?>" f="<?php echo $data['nofactura']; ?>"></button>
                                    </div>


                                    <?php if ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2) {
                                        if ($data["estatus"] == 1) {
                                    ?>
                                            <div class="div_factura">
                                                <button class="btn_anular anular_factura" fac="<?php $data["nofactura"]; ?>">ver factura</button>
                                            </div>
                                        <?php     } else {  ?>

                                            <div class="div_factura">
                                                <button type="button" class="btn_anular inactive"><i class="fas fa-ban">Eliminar</i></button>
                                            </div>
                                    <?php }
                                    }
                                    ?>

                            </td>
                        </tr>
                <?php
                }
            }
                ?>
                </div>

                    </tbody>
        </table>
        <!--dentro del paginador le estamos dando la cantidad los registros que tenemos y los divide en distintas tablas-->

        <div class="container mt-3 ">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="?pagina=<?php echo 1; ?>">Ir al inicio</a></li>
                <?php

                for ($i = 1; $i <= $total_paginas; $i++) {
                    if ($i == $pagina) {
                        echo '<li class="page-item active"><a class="page-link" >'.$i.'</a></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>';
                    }
                }
                if ($pagina != $total_paginas) {
                ?>

                    <li class="page-item"><a class="page-link" href="?pagina=<?php echo $total_paginas; ?>">Ir al final</a></li>
                <?php } ?>
            </ul>
        </div>
    </section>

    <!--Se agreggo una ruta de pide de pagina en caso de usarlo para el proyecto-->
    <?php include "includes/footer.php"; ?>

</body>

</html>