<?php

    include "../conexion.php";

?>
<html lang="en">

<head>
  <title>Lista de usuarios</title>
  <meta charset="utf-8">
  <!--todo los scripts de los diseños se pasaron en el archivo de scripts.php-->
  <?php include "includes/scripts.php" ?>
</head>

<body>

  <!--aqui se incluye el contenido del encabezado desde otro archivo llamado header.php-->
  <?php include "includes/header.php"; ?>
  <!--aqui abajo estara todo el contenido de la pagina-->
  <section id="container">
    <br>
    <h1>Lista de usuarios</h1>
    <br>
    <a href="registro_usuario.php" type="button" class="btn btn-success" > Agregar un nuevo usuario</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Usuario</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr> 
        </thead>

        <?php

         $query = mysqli_query($conection, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol");

         $result = mysqli_num_rows($query);
         if($result > 0){

            while ($data = mysqli_fetch_array($query)){

           
        ?>

        <tbody>
        <tr>
            <td><?php echo $data ["idusuario"] ?></td>
            <td><?php echo $data ["nombre"] ?></td>
            <td><?php echo $data ["correo"] ?></td>
            <td><?php echo $data ["usuario"] ?></td>
            <td><?php echo $data ["rol"] ?></td>
            <td>
            
                <a class="link_edit" href="editar_usuario.php?id=<?php echo $data ["idusuario"] ?>">Editar</a>
                <a class="link_delet" href="">Eliminar</a>
            </td>
        </tr>
        <?php
    }
         }

        ?>

        </tbody>
    </table>
  </section>

  <!--Se agreggo una ruta de pide de pagina en caso de usarlo para el proyecto-->
  <?php include "includes/footer.php"; ?>

</body>

</html>