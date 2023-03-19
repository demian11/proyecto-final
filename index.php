<!--este es el inicio de sesion-->
<?php

$alert ='';

session_start();

if(!empty($_SESSION['active']))
{
  header('location: sistema/');
}else{

if(!empty($_POST))
{
  if(empty($_POST['usuario']) || empty ($_POST['clave']))
  {
    $alert = 'Ingrese su usuario y su clave';
  }else{

    require_once "conexion.php";
    //aqui se va a encriptar la contraseña con seguridad md5
    $user = mysqli_real_escape_string($conection,$_POST['usuario']);
    $pass = md5( mysqli_real_escape_string($conection, $_POST['clave']));

    $query =mysqli_query($conection, "SELECT * FROM usuario WHERE usuario= '$user' AND clave ='$pass' ");
    mysqli_close($conection);
    $result =mysqli_num_rows($query);

    if($result > 0)
    {
      $data = mysqli_fetch_array($query);
      $_SESSION['active'] =true;
      $_SESSION['idUser'] = $data ['idusuario'];
      $_SESSION['nombre'] = $data['nombre'];
      $_SESSION['correo'] = $data['correo'];
      $_SESSION['usuario'] = $data['usuario'];
      $_SESSION['rol'] = $data['rol'];

      header('location: sistema/');
    }else{
      $alert = 'El usuario o contraseña son incorrectos';
      session_destroy();
    }

  }

}
}
?>

<!--Aqui estara el inicio de sesion-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <title>Inciar sesion</title>
    <!--dentro del style se encuentra la ruta de la imagen que aparece en el login-->
   
 <style>
        body{
            background:#BB1E19;
            background: linear-gradient(to right,#5B2C6F, #16A085)
        }
        .bg{
            background-image: url(./img/logo.png);
            background-position: center  right;
        }
    </style>
</head>
<body>

<div class="container w-100 bg-link mt-5 rounded shadow">
        <div class="row align-items-stretch">
            <div class="col bg d-done d-lg-block col-md-7 col-lg-8 col-xl-6 rounded">
        
        </div>
        <div class="col bg-link p-5 rounded-end">
            <h2 class="fw-bold text-center py-5">Bienvenido</h2>

        <section id ="container">
            <!--inicio del login, todo el formulario-->
            <form action="" method="post">
                <div class="mb-4">
                    <label for="email" class="form-label">Usuario</label>
                    <input type="text" name="usuario" class="form-control" >
                </div>

            <div class="mb-4">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="clave" >
            </div>

            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary" name="btningresar">Iniciar sesion</button>
            </div>
          
        </form>

    </section>
        <!--esto le da un poco mas de cuerpo al login-->
        <div class="container w-100 my-5">        
            <div class="row">
                <div class="col">                    
                </div>
                <div class="col">   
                </div>
            </div> 
        </div>
        </div>
    </div>
</div>
    <!--video de referencia para hacer el diseño -->
    <!--https://www.youtube.com/watch?v=NDQfhTWyD8E -->
</body>
</html>