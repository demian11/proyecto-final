<?php

include "../conexion.php";
//estas lineas de codigo de la 7- 11 lo que ayuda es a no eliminar el super usuario y nos mande a la lista de usuarios de forma segura
//esto ayuda a dar seguridad para no eliminarlo desde el modo desarrollador del navegador 
if (!empty($_POST)) 
{ 
  if($_POST ['idusuario'] == 1){

    header("location: lista_usuarios.php");
    exit;
  }  
  
  $idusuario = $_POST['idusuario'];
  //este query es la forma con la que se elimina un usuario
  // $query_delete =mysqli_query($conection, "DELETE FROM usuario WHERE idusuario = $idusuario ");
  $query_delete = mysqli_query($conection, "UPDATE usuario SET estatus = 0 WHERE idusuario = $idusuario");

  if ($query_delete) {
    header("location: lista_usuarios.php");
  } else {
    echo "Error al eliminar el usuario";
  }
}
//aqui le estamos dando seguridad al (super usuario) de no ser eliminado y automaticamente nos rediriga a otra pestaña
if (empty($_REQUEST['id']) || $_REQUEST['id'] == 1) {
  header("location: lista_usuarios.php");
} else {

  $idusuario = $_REQUEST['id'];
  $query = mysqli_query($conection, "SELECT u.nombre, u.usuario, r.rol
            FROM usuario u
            INNER JOIN
            rol r
            ON u.rol = r.idrol
            WHERE u.idusuario = $idusuario");

  $result = mysqli_num_rows($query);

  if ($result > 0) {
    while ($data = mysqli_fetch_array($query)) {
      $nombre = $data['nombre'];
      $usuario = $data['usuario'];
      $rol = $data['rol'];
    }
  } else {
    header("location: lista_usuarios.php");
  }
}
?>
<html lang="en">

<head>
  <title>Eliminar usuario</title>
  <meta charset="utf-8">
  <!--todo los scripts de los diseños se pasaron en el archivo de scripts.php-->
  <?php include "includes/scripts.php" ?>
</head>

<body>

  <!--aqui se incluye el contenido del encabezado desde otro archivo llamado header.php-->
  <?php include "includes/header.php"; ?>
  <!--aqui abajo estara todo el contenido de la pagina-->
  <section id="container">
    <div class="data_delete">

      <div class="jumbotron">
        <h1 class="display-4">Seguro que quieres eliminar el usuario?</h1>
        <p class="lead">Nombre y apellido: <span><?php echo $nombre; ?></span></p>
        <p class="lead">usuario: <span><?php echo $usuario; ?></span></p>
        <p class="lead">Tipo de usuario: <span><?php echo $rol; ?></span></p>
        <hr class="my-4">
        <p>Despues de eliminar el usuario no se podra revertiri los cambios</p>
        <p class="lead">
        <!-- aqui estaran los botones que hagan las acciones de eliminar o regresar, por favor no tocar!!!  (69-72)-->
        <form method="post" action="">
          <input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
          <a href="lista_usuarios.php" class="btn btn-primary btn-lg">Cancelar</a>
          <input type="submit" value="Aceptar" class="btn btn-primary btn-lg">
        </form>
        </p>
      </div>

    </div>
  </section>

  <!--Se agreggo una ruta de pide de pagina en caso de usarlo para el proyecto-->
  <?php include "includes/footer.php"; ?>

</body>

</html>