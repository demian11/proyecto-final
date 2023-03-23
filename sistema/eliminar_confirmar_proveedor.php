<?php
session_start();
//si no es administrador o supervisor no tendra permisos de borrar el registro
if($_SESSION['rol'] != 1 and $ $_SESSION['rol'] != 2)
{
  header("location: ./");
}

include "../conexion.php";
//estas lineas de codigo lo que ayuda es a no eliminar el super usuario y nos mande a la lista de usuarios de forma segura
//esto ayuda a dar seguridad para no eliminarlo desde el modo desarrollador del navegador 
if (!empty($_POST)) 
{ 
  if(empty($_POST['idproveedor']))
  {
    header("location: lista_proveedor.php");  
    mysqli_close($conection);
  }  
  
  $idproveedor = $_POST['idproveedor'];
  //este query es la forma con la que se elimina un usuario
  // $query_delete =mysqli_query($conection, "DELETE FROM usuario WHERE idusuario = $idusuario ");
  $query_delete = mysqli_query($conection, "UPDATE proveedor SET estatus = 0 WHERE codproveedor = $idproveedor");
  mysqli_close($conection);
  if ($query_delete) {
    header("location: lista_proveedor.php");
  } else {
    echo "Error al eliminar el proveedor";
  }
}

//aqui le estamos dando seguridad al (super usuario) de no ser eliminado y automaticamente nos rediriga a otra pestaña
if (empty($_REQUEST['id'])) {
  header("location: lista_clientes.php");
  mysqli_close($conection);
} else {

  $idproveedor = $_REQUEST['id'];
  $query = mysqli_query($conection, "SELECT *FROM proveedor WHERE codproveedor = $idproveedor");
  mysqli_close($conection);
  $result = mysqli_num_rows($query);

  if ($result > 0) {
    while ($data = mysqli_fetch_array($query)) {
        $proveedor = $data['proveedor'];
    }
  } else {
    header("location: lista_proveedor.php");
  }
}
?>
<html lang="en">

<head>
  <title>Eliminar proveedor</title>
  <meta charset="utf-8">
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
    <div class="data_delete">

      <div class="jumbotron">
        <h1 class="display-4">Seguro que quieres eliminar el proveedor?</h1>
        <p class="lead">Nombre del proveedor: <span><?php echo $proveedor; ?></span></p>
        <hr class="my-4">

        <p class="lead">

        <!-- aqui estaran los botones que hagan las acciones de eliminar o regresar, por favor no tocar!!!  (69-72)-->
        <form method="post" action="">
          <input type="hidden" name="proveedor" value="<?php echo $idproveedor; ?>">
          <a href="lista_proveedor.php" class="btn btn-danger btn-lg">Cancelar</a>
          <input type="submit" value="Eliminar" class="btn btn-warning btn-lg">
        </form>
        </p>
      </div>

    </div>
  </section>

  <!--Se agreggo una ruta de pide de pagina en caso de usarlo para el proyecto-->
  <?php include "includes/footer.php"; ?>

</body>

</html>