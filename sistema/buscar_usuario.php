<?php
session_start();
if($_SESSION['rol'] != 1)
{
    header("location: ./");
}

include "../conexion.php";

?>
<html lang="en">

<head>
    <title>Lista de usuarios</title>
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
        <?php

        $busqueda = strtolower($_REQUEST['busqueda']);
        if (empty($busqueda)) {
            header("location: lista_usuarios.php");
            mysqli_close($conection);
        }

        ?>

        <br>
        <h1>Lista de usuarios</h1>
        <br>
        <nav class="navbar navbar-light bg-light">
            <div class="container-fluid">
                <a href="registro_usuario.php" type="button" class="btn btn-success"> Agregar un nuevo usuario</a>

                <!-- posible error dentro del boton o en la barra de busqueda, no da los usuarios, video 22 buscador -->
                <form action="buscar_usuario.php" method="get" class="d-flex" role="search">
                    <input class="form-control me-2" name="busqueda" id="busqueda" type="search" placeholder="Buscar" aria-label="Buscar" value="<?php echo $busqueda ?>">
                    <button class="btn btn-outline-success" class="btn_search" type="submit">Buscar</button>
                </form>
            </div>
        </nav>

        <table class="table table-striped">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre y apellido</th>
                    <th>Correo</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <!--contenido que ayudara para el desplasamiento del paginador-->
            <?php
            $rol = '';
            if ($busqueda == 'administrador') 
            {
                $rol = " OR rol LIKE '%1%' ";

            } else if ($busqueda == 'supervisor') {

                $rol = " OR rol LIKE '%2%' ";

            } else if ($busqueda == 'vendedor') {

                $rol = " OR rol LIKE '%3%' ";
            }

            $sql_registe = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM usuario 
            WHERE (idusuario LIKE '%$busqueda%' OR 
            nombre LIKE '%$busqueda%' OR 
            correo LIKE '%$busqueda%' OR 
            usuario LIKE '%$busqueda%' $rol) AND estatus = 1");

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

            //para los usuarios que se (eliminen) lo que hacemos es poner de estatus 1 a 0 para no no aparezcan en la tabla de la pagina pero si en la base de datos
            $query = mysqli_query($conection, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.rol FROM usuario u 
            INNER JOIN rol r ON u.rol = r.idrol 
                WHERE 
                (u.idusuario LIKE '%$busqueda%' OR 
                u.nombre LIKE '%$busqueda%' OR 
                u.correo LIKE '%$busqueda%' OR 
                u.usuario LIKE '%$busqueda%' OR
                r.rol LIKE '%$busqueda%')
                AND
                estatus = 1 ORDER BY U.idusuario ASC LIMIT $desde, $por_pagina");
           
            mysqli_close($conection);
            $result = mysqli_num_rows($query);

            if ($result > 0) {

                while ($data = mysqli_fetch_array($query)) {


            ?>

                    <tbody>
                        <tr>
                            <td><?php echo $data["idusuario"]; ?></td>
                            <td><?php echo $data["nombre"]; ?></td>
                            <td><?php echo $data["correo"]; ?></td>
                            <td><?php echo $data["usuario"]; ?></td>
                            <td><?php echo $data["rol"]; ?></td>
                            <td>

                                <a class="link_edit" href="editar_usuario.php?id=<?php echo $data["idusuario"]; ?>">Editar</a>

                                <!--en esta linea de codigo lo que se hace es no permitir eliminar el super usuario (administrador 1) -->
                                <?php
                                if ($data["idusuario"] != 1) {

                                ?>
                                    <a class="link_delet" href="eliminar_confirmar_usuario.php?id=<?php echo $data["idusuario"]; ?>">Eliminar</a>

                                <?php } ?>
                            </td>
                        </tr>
                <?php
                }
            }

                ?>

                    </tbody>
        </table>
        <?php

        if ($total_registro != 1) 
        {

        ?>
            <!--dentro del paginador le estamos dando la cantidad los registros que tenemos y los divide en distintas tablas-->
            <div class="container mt-3 ">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">Ir al inicio</a></li>
                    <?php

                    for ($i = 1; $i <= $total_paginas; $i++) {
                        if ($i == $pagina) {
                            echo '<li class="page-item active"><a class="page-link" >' . $i . '</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="?pagina=' . $i . ' &busqueda=' . $busqueda . '">' . $i . '</a></li>';
                        }
                    }
                    ?>

                    <li class="page-item"><a class="page-link" href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>">Ir al final</a></li>
                </ul>
            </div>
        <?php } ?>
    </section>

    <!--Se agreggo una ruta de pide de pagina en caso de usarlo para el proyecto-->
    <?php include "includes/footer.php"; ?>

</body>

</html>