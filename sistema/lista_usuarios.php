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
            <th>Nombre y apellido</th>
            <th>Correo</th>
            <th>Usuario</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr> 
        </thead>

        <?php
        //para los usuarios que se (eliminen) lo que hacemos es poner de estatus 1 a 0 para no no aparezcan en la tabla de la pagina pero si en la base de datos
         $query = mysqli_query($conection, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, r.rol FROM usuario u INNER JOIN rol r ON u.rol = r.idrol WHERE estatus = 1");

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
              <!--en esta linea de codigo lo que se hace es no permitir eliminar el super usuario (administrador 1) -->
                <?php
                  if($data ["idusuario"] != 1)
                  {

                ?>
                <a class="link_delet" href="eliminar_confirmar_usuario.php?id=<?php echo $data ["idusuario"] ?>">Eliminar</a>

                <?php } ?>
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