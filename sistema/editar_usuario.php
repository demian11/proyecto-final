<?php
    session_start();
	if($_SESSION['rol'] != 1)
	{
		header("location: ./");
	}

include "../conexion.php";

if (!empty($_POST)) 
{
    $alert = '';
    if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['rol'])) 
    {
        $alert = '<p class="msg_error">Todos los campos son obligatorios</p>';
    } else {

        $idUsuario = $_POST['idUsuario'];
        $nombre = $_POST['nombre'];
        $email = $_POST['correo'];
        $user = $_POST['usuario'];
        $clave = md5($_POST['clave']);
        $rol = $_POST['rol'];


        $query = mysqli_query($conection, "SELECT * FROM usuario 
                            WHERE (usuario = '$user' AND idusuario != $idUsuario) 
                            OR (correo = '$email' AND idusuario != $idUsuario) ");

        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<p class="msg_error">El correo o el usuario ya existe</p>';
        } else {

            if (empty($_POST['clave'])) 
            {

                $sql_update = mysqli_query($conection, "UPDATE usuario
                                                        SET nombre = '$nombre', correo = '$email',usuario ='$user',rol='$rol'
                                                        WHERE idusuario= $idUsuario");
            } else {
                $sql_update = mysqli_query($conection, "UPDATE usuario
                SET nombre = '$nombre', correo = '$email',usuario ='$user',clave='$clave',rol='$rol'
                WHERE idusuario= $idUsuario");
            }
            
            if ($sql_update) {
                $alert = '<p class="msg_save">Usuario actualizado correctamente</p>';
            } else {
                $alert = '<p class="msg_error">Error al actualizar el usuario</p>';
            }
        }
    }
}

//Mostrar datos
if (empty($_GET['id'])) 
{
    header('location: lista_usuarios.php');
    mysqli_close($conection);
}
$iduser = $_GET['id'];

$sql = mysqli_query($conection, "SELECT u.idusuario, u.nombre, u.correo, u.usuario, (u.rol) as idrol,  (r.rol) as rol
                                            FROM usuario u
                                            INNER JOIN rol r
                                            on u.rol = r.idrol
                                            where idusuario= $iduser");
mysqli_close($conection);
$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    header('location: lista_usuarios.php');
} else {
    $option = '';
    while ($data = mysqli_fetch_array($sql)) {

        $iduser = $data['idusuario'];
        $nombre = $data['nombre'];
        $correo = $data['correo'];
        $usuario = $data['usuario'];
        $idrol = $data['idrol'];
        $rol = $data['rol'];

        if ($idrol == 1) {
            $option = ' <option value="'.$idrol.'"select>'.$rol.'</option>';
        } else if ($idrol == 2) {
            $option = ' <option value="'.$idrol.'"select>'.$rol.'</option>';
        } else if ($idrol == 3) {
            $option = ' <option value="'.$idrol.'"select>'.$rol.'</option>';
        }
    }
}

?>

<html lang="en">

<head>
    <title>Editar usuario</title>
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
            <h1>Editar usuario usuario</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">
                <input type="hidden" name="idUsuario" value="<?php echo $iduser; ?>">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre; ?>">
                <label for="correo">Correo electronico</label>
                <input type="email" name="correo" id="correo" placeholder="Correo electronico" value="<?php echo $correo; ?>">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php echo $usuario; ?>">
                <label for="clave">Clave</label>
                <input type="password" name="clave" id="clave" placeholder="Clave de acceso">
                <label for="rol">Tipo de usuario</label>

                <?php
                include "../conexion.php";
                $query_rol = mysqli_query($conection, "SELECT * FROM rol");
                mysqli_close($conection);
                $result_rol = mysqli_num_rows($query_rol);

                ?>

                <select name="rol" id="rol" class="notItemOne">
                    <?php
                    echo $option;
                    if ($result_rol > 0) 
                    {
                        while ($rol = mysqli_fetch_array($query_rol)) {
                    ?>
                            <option value="<?php echo $rol["idrol"]; ?>"><?php echo $rol["rol"] ?></option>
                    <?php

                        }
                    }
                    ?>
                </select>
                <input type="submit" value="Actualizar usuario " class="btn_save">

            </form>

        </div>

    </section>

    <!--Se agreggo una ruta de pide de pagina en caso de usarlo para el proyecto-->
    <?php include "includes/footer.php"; ?>

</body>

</html>