<?php
session_start();
if($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2)
{
  header("location: ./");
}
include "../conexion.php";

?>
<html lang="en">

<head>
  <title>Lista de proveedores</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="./css/style.css">
  <!--todo los scripts de los diseños se pasaron en el archivo de scripts.php-->
  <?php include "includes/scripts.php" ?>
</head>
<style>
body{
            background:#BB1E19;
            background: linear-gradient(to right,#5B2C6F, #16A085)
        }
        </style>
<body>

  <!--aqui se incluye el contenido del encabezado desde otro archivo llamado header.php-->
  <?php include "includes/header.php"; ?>

  <!--aqui abajo estara todo el contenido de la pagina-->
  <section id="container">
    <br>
    <h1>Lista de proveedores</h1>
    <br>
    
    <nav class="navbar navbar-link bg-link">
  <div class="container-fluid">
  <a href="registro_proveedor.php" type="button" class="btn btn-success"> Agregar un nuevo proveedor</a>
    <form action="buscar_proveedor.php" method="get" class="d-flex" role="search">
      <input class="form-control me-2"  name="busqueda" id="busqueda" type="search" placeholder="Buscar" aria-label="Buscar">
      <button class="btn btn-outline-success" type="submit">Buscar</button>
    </form>
  </div>
</nav>

    <table class="table table-striped">

      <thead>
        <tr>
          <th>ID</th>
          <th>Proveedor</th>
          <th>Contacto</th>
          <th>Telefono</th>
          <th>Direccion</th>
          <th>Fecha</th>
          <th>Acciones</th>
        </tr>
      </thead>

      <!--contenido que ayudara para el desplasamiento del paginador-->
      <?php

      $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS total_registro FROM proveedor WHERE estatus =1");
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
      $query = mysqli_query($conection, "SELECT * FROM proveedor  
                                                  WHERE estatus = 1 ORDER BY codproveedor ASC LIMIT $desde, $por_pagina");

      mysqli_close($conection);

      $result = mysqli_num_rows($query);

      if ($result > 0) {

        while ($data = mysqli_fetch_array($query)) {
                //aqui se crea una variable para mostrar las fechas
            $formato = 'Y-m-d H:i:s';
            $fecha =DateTime::createFromFormat($formato,$data["date_add"]);

      ?>
          <tbody>
            <tr>
              <td><?php echo $data["codproveedor"] ?></td>
              <td><?php echo $data["proveedor"] ?></td>
              <td><?php echo $data["contacto"] ?></td>
              <td><?php echo $data["telefono"] ?></td>
              <td><?php echo $data["direccion"] ?></td>
              <!--esto nos muestra la fecha en la que se hizo el registro-->
              <td><?php echo $fecha->format('d-m-Y'); ?></td>
              <td>

                <a class="link_edit" href="editar_proveedor.php?id=<?php echo $data["codproveedor"] ?>">
                <img src= "../img/editar.png" width="30" height="30">
              </a>
                <!--en esta linea de codigo lo que se hace es no permitir eliminar el super usuario (administrador 1) -->
                  
                  <a class="link_delet" href="eliminar_confirmar_proveedor.php?id=<?php echo $data["codproveedor"] ?>">
                  <img src= "../img/eliminar.png" width="30" height="30">
                </a>
                    
                
              </td>
            </tr>
        <?php
        }
      }

        ?>

          </tbody>
    </table>
        <!--dentro del paginador le estamos dando la cantidad los registros que tenemos y los divide en distintas tablas-->
       
        <div class="container mt-3 ">
      <ul class="pagination">
        <li class="page-item"><a class="page-link" href="?pagina=<?php echo 1; ?>">Ir al inicio</a></li>
        <?php
          
        for ($i = 1; $i <= $total_paginas; $i++) {
          if($i == $pagina)
          {
            echo '<li class="page-item active"><a class="page-link" >'.$i.'</a></li>';
          }else{
          echo '<li class="page-item"><a class="page-link" href="?pagina='.$i.'">'.$i.'</a></li>';
          }
        }
        if($pagina != $total_paginas)
				{
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