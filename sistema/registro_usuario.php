<?php

include "../conexion.php";

if(!empty($_POST))
{
  $alert='';
  if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || 
  empty($_POST['clave']) || empty($_POST['rol']))
  {
    $alert='<p class="msg_error">Todos los campos son obligatorios</p>';
  }else{

    
    $nombre = $_POST['nombre'];
    $email = $_POST['correo'];
    $user = $_POST['usuario'];
    $clave = md5($_POST['clave']);
    $rol = $_POST['rol'];

    $query = mysqli_query($conection, "SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$email' ");
    $result = mysqli_fetch_array($query);

    if($result >0){
      $alert ='<p class="msg_error">El correo o el usuario ya existe</p>';
    }else{

      $query_insert =mysqli_query($conection, "INSERT INTO usuario(nombre,correo,usuario,clave,rol) 
      VALUE('$nombre','$email','$user','$clave','$rol')");
      if($query_insert){
        $alert = '<p class="msg_save">Usuario creado correctamente</p>';
      }else{
        $alert = '<p class="msg_error">Error al crear el usuario</p>';
      }
    }

  }

}

?>
<html lang="en">

<head>
  <title>Registro de usuarios</title>
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
        <h1>Registrar usuario</h1>
        <hr>
        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

        <form action="" method="post">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre completo">
            <label for="correo">Correo electronico</label>
            <input type="email" name="correo" id="correo" placeholder="Correo electronico">
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" placeholder="Usuario">
            <label for="clave">Clave</label>
            <input type="password" name="clave" id="clave" placeholder="Clave de acceso">
            <label for="rol">Tipo de usuario</label>

            <?php

              $query_rol = mysqli_query($conection, "SELECT * FROM rol");
              $result_rol =mysqli_num_rows($query_rol);

            ?>

            <select name="rol" id="rol">
              <?php 
                if($result_rol > 0)
                {
                  while ($rol = mysqli_fetch_array($query_rol)){
                  ?>
                  <option value="<?php echo $rol["idrol"]; ?>"><?php echo $rol["rol"] ?></option>
                    <?php
                    
                  }
                }
              ?>
              
            </select>
            <input type="submit" value="Crear usuario" class="btn_save">

        </form>

    </div>

  </section>

  <!--Se agreggo una ruta de pide de pagina en caso de usarlo para el proyecto-->
  <?php include "includes/footer.php"; ?>

</body>

</html>