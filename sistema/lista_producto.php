<?php
session_start();
include "../conexion.php";

?>
<html lang="en">

<head>
  <title>Lista de productos</title>
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
    <h1>Lista de productos</h1>
    <br>
    
    <nav class="navbar navbar-light bg-light">
  <div class="container-fluid">
  <a href="registro_producto.php" type="button" class="btn btn-success"> Agregar un nuevo producto</a>
    <form action="buscar_cliente.php" method="get" class="d-flex" role="search">
      <input class="form-control me-2"  name="busqueda" id="busqueda" type="search" placeholder="Buscar" aria-label="Buscar">
      <button class="btn btn-outline-success" type="submit">Buscar</button>
    </form>
  </div>
</nav>

    <table class="table table-striped">

      <thead>
        <tr>
          <th>Codigo</th>
          <th>Descripcion</th>
          <th>Precio</th>
          <th>Existencia</th>
          <th>
          <?php
                $query_proveedor = mysqli_query($conection, "SELECT codproveedor, proveedor FROM proveedor WHERE
                 estatus=1 ORDER BY proveedor ASC");
                $result_proveedor = mysqli_num_rows($query_proveedor);

                ?>
                <select name="proveedor" id="search_proveedor">
                    <?php
                    if ($result_proveedor > 0) {
                        while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                    ?>
                            <!--aqui estamos mostrando los proveedores desde la base de datos en vez de hacerlo de forma estatica-->
                            <option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
                    <?php
                        }
                    }
                    ?>

                </select>
          </th>
          <th>Foto</th>
           <!--si no eres de ninguno de estos roles no podras editar y eliminar y directamente no se mostrara la tabla acciones-->
          <?php //if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2){ ?>
          <th>Acciones</th>
          <?php
          //}
          ?>
        </tr>
      </thead>

      <!--contenido que ayudara para el desplasamiento del paginador-->
      <?php

      $sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS total_registro FROM producto WHERE estatus =1");
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
      $query = mysqli_query($conection, "SELECT p.codproducto, p.descripcion, p.precio, p.existencia, pr.proveedor, p.foto FROM producto p
                                                  INNER JOIN proveedor pr
                                                  ON p.proveedor =pr.codproveedor  
                                                  WHERE p.estatus = 1 ORDER BY p.codproducto DESC LIMIT $desde, $por_pagina");

      mysqli_close($conection);

      $result = mysqli_num_rows($query);

      if ($result > 0) {

        while ($data = mysqli_fetch_array($query)) {
            if($data ['foto'] != 'img_producto.png'){
                $foto ='img/uploads/'.$data['foto'];
            }else{
                $foto='img/'.$data['foto'];
            }

      ?>

          <tbody>
            <tr class="row<?php echo $data["codproducto"]; ?>">
              <td><?php echo $data["codproducto"]; ?></td>
              <td><?php echo $data["descripcion"]; ?></td>
              <td><?php echo $data["precio"]; ?></td>
              <td><?php echo $data["existencia"]; ?></td>
              <td><?php echo $data["proveedor"]; ?></td>             
              <td class="img_producto"><img src="<?php echo $foto; ?>" alt="<?php echo $data["descripcion"]; ?>"></td>
              <td>         
                <!--en esta linea de codigo lo que se hace es no permitir eliminar el super usuario (administrador 1) -->
                                
                <?php if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2){ ?>
              <a class="link_add add_product" product="<?php echo $data["codproducto"] ?>" href="#">Agregar</a>
                    
                <a class="link_edit" href="editar_producto.php?id=<?php echo $data["codproducto"] ?>">Editar</a>
                  
                  <a class="link_delet" href="eliminar_confirmar_producto.php?id=<?php echo $data["codproducto"] ?>">Eliminar</a>
                  
              </td>
              <?php }?>
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