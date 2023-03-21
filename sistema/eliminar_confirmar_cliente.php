<?php
session_start();
//si no es administrador o supervisor no tendra permisos de borrar el registro
if($_SESSION['rol'] =! 1 and $ $_SESSION['rol'] =! 2)
{
  header("location: ./");
}

include "../conexion.php";
//estas lineas de codigo lo que ayuda es a no eliminar el super usuario y nos mande a la lista de usuarios de forma segura
//esto ayuda a dar seguridad para no eliminarlo desde el modo desarrollador del navegador 
if (!empty($_POST)) 
{ 
  if(empty($_POST['idcliente']))
  {
    header("location: lista_cliente.php");  
    mysqli_close($conection);
  }  
  
  $idcliente = $_POST['idcliente'];
  //este query es la forma con la que se elimina un usuario
  // $query_delete =mysqli_query($conection, "DELETE FROM usuario WHERE idusuario = $idusuario ");
  $query_delete = mysqli_query($conection, "UPDATE cliente SET estatus = 0 WHERE idcliente = $idcliente");
  mysqli_close($conection);
  if ($query_delete) {
    header("location: lista_clientes.php");
  } else {
    echo "Error al eliminar el cliente";
  }
}

//aqui le estamos dando seguridad al (super usuario) de no ser eliminado y automaticamente nos rediriga a otra pestaña
if (empty($_REQUEST['id'])) {
  header("location: lista_clientes.php");
  mysqli_close($conection);
} else {

  $idcliente = $_REQUEST['id'];
  $query = mysqli_query($conection, "SELECT *FROM cliente WHERE idcliente = $idcliente");

  mysqli_close($conection);
  $result = mysqli_num_rows($query);

  if ($result > 0) {
    while ($data = mysqli_fetch_array($query)) {
        $nit = $data['nit'];
        $nombre = $data['nombre'];
    }
  } else {
    header("location: lista_clientes.php");
  }
}
?>
<html lang="en">

<head>
  <title>Eliminar cliente</title>
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
        <h1 class="display-4">Seguro que quieres eliminar el cliente?</h1>
        <p class="lead">Nombre del cliente: <span><?php echo $nombre; ?></span></p>
        <p class="lead">Nit: <span><?php echo $nit; ?></span></p>
        <hr class="my-4">
        <p>Despues de eliminar el usuario no se podra revertiri los cambios</p>
        <p class="lead">
        <!-- aqui estaran los botones que hagan las acciones de eliminar o regresar, por favor no tocar!!!  (69-72)-->
        <form method="post" action="">
          <input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
          <a href="lista_clientes.php" class="btn btn-primary btn-lg">Cancelar</a>
          <input type="submit" value="Eliminar" class="btn btn-primary btn-lg">
        </form>
        </p>
      </div>

    </div>
  </section>

  <!--Se agreggo una ruta de pide de pagina en caso de usarlo para el proyecto-->
  <?php include "includes/footer.php"; ?>

</body>

</html>