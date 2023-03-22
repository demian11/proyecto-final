<?php
session_start();
if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
{
  header("location: ./");
}
include "../conexion.php";

if(!empty($_POST))
{
  $alert='';
  if(empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono'] || empty($_POST['direccion'])))
  {
    $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
  }else{

    $proveedor = $_POST ['proveedor'];
    $contacto = $_POST['contacto'];
    $telefono =$_POST['telefono'];
    $direccion = $_POST['direccion'];
    $usuario_id =$_SESSION['idUser'];

   
        $query_insert = mysqli_query($conection, "INSERT INTO proveedor(proveedor,contacto,telefono,direccion,usuario_id) 
                                                 VALUES('$proveedor','$contacto','$telefono','$direccion','$usuario_id')");

     if($query_insert){
      $alert = '<p class="msg_save">Proveedor guardado correctamente</p>';
        }else{
        $alert = '<p class="msg_error">Error al Guardar el cliente </p>';
     }
    }
    mysqli_close($conection);
  }
  


?>
<html lang="en">

<head>
  <title>Registro de Proveedor</title>
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
    <div class="form_register">
        <h1>Registrar proveedor</h1>
        <hr>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

        <form action="" method="post">
        <label for="proveedor">Proveedor</label>
            <input type="text" name="proveedor" id="proveedor" placeholder="Nombre del proveedor">
            <label for="contacto">Contacto</label>
            <input type="text" name="contacto" id="contacto" placeholder="Nombre completo del contacto">
            <label for="telefono">Telefono</label>
            <input type="number" name="telefono" id="telefono" placeholder="Telefono">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id="direccion" placeholder="Direccion completa">
            
            <input type="submit" value="Agregar proveedor" class="btn_save">

        </form>

    </div>

  </section>

  <!--Se agreggo una ruta de pide de pagina en caso de usarlo para el proyecto-->
  <?php include "includes/footer.php"; ?>

</body>

</html>