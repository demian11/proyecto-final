<?php
session_start();

include "../conexion.php";

if(!empty($_POST))
{
  $alert='';
  if(empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion']))
  {
    $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
  }else{

    $nit = $_POST ['nit'];
    $nombre = $_POST['nombre'];
    $telefono =$_POST['telefono'];
    $direccion = $_POST['direccion'];
    $usuario_id =$_SESSION['idUser'];

    $result = 0;

    if(is_numeric($nit))
    {
        $query = mysqli_query($conection, "SELECT * FROM cliente WHERE nit = '$nit' ");
        $result =mysqli_fetch_array($query);
    }

    if($result >0)
    {
        $alert = '<p class="msg_save">El numero de nit ya existe</p>';
    }else{
        $query_insert = mysqli_query($conection, "INSERT INTO cliente(nit,nombre,telefono,direccion,usuario_id) 
                                                 VALUES('$nit','$nombre','$telefono','$direccion','$usuario_id')");

     if($query_insert){
      $alert = '<p class="msg_save">Cliente guardado correctamente</p>';
        }else{
        $alert = '<p class="msg_error">Error al Guardar el cliente </p>';
     }
    }
  }
  mysqli_close($conection);
}

?>
<html lang="en">

<head>
  <title>Registro de clientes</title>
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
    <div class="form_register">
        <h1>Registrar cliente</h1>
        <hr>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

        <form action="" method="post">
            <!--el NIT es parecido al curp -->
        <label for="nit">NIT</label>
            <input type="number" name="nit" id="nit" placeholder="Numero de NIT">
            <label for="nombre">Nombre y apellido</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre completo">
            <label for="telefono">Telefono</label>
            <input type="number" name="telefono" id="telefono" placeholder="Telefono">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id="direccion" placeholder="Direccion completa">
            
            <input type="submit" value="Guardar cliente" class="btn_save">

        </form>

    </div>

  </section>

  <!--Se agreggo una ruta de pide de pagina en caso de usarlo para el proyecto-->
  <?php include "includes/footer.php"; ?>

</body>

</html>