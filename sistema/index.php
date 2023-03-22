<?php 
	session_start();
  /*if(empty($_SESSION['active']))
  {
    header('location: ../');
  } */
 ?>
<html lang="en">
<head>
  <title>Ciber Center</title>
  <meta charset="utf-8">
  <!--todo los scripts de los diseños se pasaron en el archivo de scripts.php-->
  <?php include "includes/scripts.php" ?>
</head>

<body>

  <!--aqui se incluye el contenido del encabezado desde otro archivo llamado header.php-->
  <?php 
  include "includes/header.php";
  include "../conexion.php";

  //datos de la empresa
  $nit ='';
  $nombreEmpresa = '';
  $razonSocial = '';
  $telEmpresa = '';
  $emailEmpresa= '';
  $dirEmpresa = '';
  $iva = '';

  $query_empresa =mysqli_query($conection,"SELECT * FROM configuracion");
  $row_empresa = mysqli_num_rows($query_empresa);
  if($row_empresa > 0)
  {
    while($arrInfoEmpresa = mysqli_fetch_assoc($query_empresa)){
      $nit = $arrInfoEmpresa['nit'];
      $nombreEmpresa= $arrInfoEmpresa['nombre'];
      $razonSocial = $arrInfoEmpresa['razon_social'];
      $telEmpresa = $arrInfoEmpresa['email'];
      $dirEmpresa =$arrInfoEmpresa['direccion'];
      $iva = $arrInfoEmpresa['iva'];
    }
  }

  $query_dash =mysqli_query($conection,"CALL dataDashboard();");
  $result_dash =mysqli_num_rows($query_dash);
  if($result_dash > 0){
    $data_dash =mysqli_fetch_assoc($query_dash);
    mysqli_close($conection);
  }
  ?>
  <!--aqui abajo estara todo el contenido de la pagina-->
  <section id="container">
    <div class="divContainer">
      <div>
        <h1 class="titlePanelControl" id="titlePanelControl">Panel de control </h1>
      </div>
      <div>
      <div class="dashboard">
        <?php
        if($_SESSION['rol'] == 1){
        ?>
        <a href="lista_usuarios.php">
          <i class="fas fa-users"></i>
          <p>
            <strong>Usuarios</strong><br>
            <span><?=$data_dash['usuarios'] ?></span>
          </p>
        </a>
        <?php } ?>
        <a href="lista_clientes.php">
          <i class="fas fa-user"></i>
          <p>
            <strong>clientes</strong><br>
            <span><?=$data_dash['clientes']; ?></span>
          </p>
        </a>
        <a href="lista_proveedor.php">
          <i class="far fa-building"></i>
          <p>
            <strong>Proveedores</strong><br>
            <span><?=$data_dash['proveedores']; ?></span>
          </p>
        </a>
        <a href="lista_producto.php">
          <i class="fas fa-cubes"></i>
          <p>
            <strong>Productos</strong><br>
            <span><?=$data_dash['productos']; ?></span>
          </p>
        </a>
        <a href="ventas.php">
          <i class="far fa-file-alt"></i>
          <p>
            <strong>Ventas</strong><br>
            <span><?=$data_dash['ventas']; ?></span>
          </p>
        </a>
      </div>
    </div>
      <div class="divInfoSistema">
        <div>
          <h1 class="titlePanelControl">Configuracion</h1>
        </div>
        <div class="containerPerfil">
          <div class="containerDataUser">
            <div class="logoUser">
              <img src="img/logoUser.png" alt="">
            </div>
            <div class="divDataUser">
              <h4>Informacion personal </h4>
              <div>
                <label>Nombre:</label> <span><?= $_SESSION['nombre']; ?></span>
              </div>
              <div>
                <label>Correo:</label> <span><?= $_SESSION['correo']; ?></span>
              </div>
              <h4>Datos Usuario</h4>
              <div>
                <label >Rol:</label><span><?= $_SESSION['rol_name']; ?></span>
              </div>
              <div>
                <label>Usuario</label><span><?= $_SESSION['usuario']; ?></span>
              </div>

              <h4>cambiar contraseña</h4>
              <form action="" method="post" name="frmChangePass" id="frmChangePass">
                <div>
                  <input type="password" name="txtPassUser" id="txtPassUser" placeholder="Contraseña actual" 
                  required>
                </div>
                <div>
                  <input class="newPass" type="password" name="txtNewPassUser" id="txtNewPassUser" placeholder="Nueva contraseña" 
                  required>
                </div>
                <div>
                  <input class="newPass" type="password" name="txtPassConfirm" id="txtPassConfirm" placeholder="Confirmar contraseña" 
                  required>
                </div>
                <div class="alertChangePass" style="display: none;">
                </div>
                <div>
                  <button type="submit" class="btn_save btnChangePass"><i class="fas fa-key"></i>Cambiar contraseña</button>
                </div>
              </form>

            </div>
          </div>
          <?php if($_SESSION['rol'] == 1){ ?>
          <div class="containerDataEmpresa">
          <div class="logoUser">
              <img src="img/LogoEmpresa.png" alt="">
            </div>

            <h4>Datos de la empresa</h4>
            <form action="" method="post" name="frmEmpresa" id="frmEmpresa">
              <input type="hidden" name="action" value="updateDataEmpresa">
              <div>
                <label>Nit:</label><input type="text" name="txtNit" id="txtNit" placeholder="Numero de la empresa" value="<?= $nit; ?>" required>
              </div>
              <div>
                <label>Nombre:</label><input type="text" name="txtNombre" id="txtNombre" placeholder="Nombre de la empresa" value="<?= $nombreEmpresa; ?>" required>
              </div>
              <div>
                <label>Razon social</label> <input type="text" name="txtRSocial" id="txtRSocial" placeholder="Razon social" value="<?= $razonSocial; ?>">
              </div>
              <div>
                <label>Telefono</label><input type="text" name="txtTelEmpresa" id="txtTelEmpresa" placeholder="Numero de telefono" value="<?= $telEmpresa; ?>" required>
              </div>
              <div>
                <label>Correo electronico</label><input type="email" name="txtEmailEmpresa" id="txtEmailEmpresa" placeholder="Correo electronico" value="<?= $emailEmpresa; ?>" required>
              </div>
              <div>
                <label>Direccion:</label> <input type="text" name="txtDirEmpresa" id="txtEmprea" placeholder="Direccion de la empresa" value="<?= $dirEmpresa; ?>" required>
              </div>
              <div>
                <label>Iva(%)</label> <input type="text" name="txtIva" id="txtIva" placeholder="Impuesto al valor agregago (IVA)" value="<?= $iva; ?>" required>
              </div>
              <div class="alertFormEmpresa" style="display: none;"></div>
              <div>
                <button type=" submit" class="btn_save btnChangePass"><i class="far fa-save fa-lg"></i>Guardar datos</button>
                </div>
              
            </form>
         
          
          </div>
          <?php } ?>
        </div>
      </div>
    
  </section>

  <!--Se agreggo una ruta de pide de pagina en caso de usarlo para el proyecto-->
  <?php include "includes/footer.php"; ?>

</body>

</html>