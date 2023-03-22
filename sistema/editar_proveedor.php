<?php
    session_start();
	if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2)
	{
		header("location: ./");
	}

include "../conexion.php";

if (!empty($_POST)) 
{
    $alert = '';
    if (empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion'])) 
    {
        $alert = '<p class="msg_error">Todos los campos son obligatorios</p>';
    } else {

        $idproveedor = $_POST['id'];
        $proveedor = $_POST['proveedor'];
        $contacto = $_POST['contacto'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];      

        $result =0;
          

                $sql_update = mysqli_query($conection, "UPDATE proveedor
                                                        SET proveedor = '$proveedor', contacto = '$contacto',telefono ='$telefono'
                                                        ,direccion='$direccion'
                                                        WHERE codproveedor= $idproveedor");
           
            
            if ($sql_update) {
                $alert = '<p class="msg_save">Proveedor actualizado correctamente</p>';
            } else {
                $alert = '<p class="msg_error">Error al actualizar el proveedor</p>';
            }
        }
    }


//Mostrar datos
if (empty($_GET['id'])) 
{
    header('location: lista_proveedor.php');
    mysqli_close($conection);
}
$idproveedor = $_GET['id'];

$sql = mysqli_query($conection, "SELECT * FROM proveedor WHERE codproveedor= $idproveedor");
mysqli_close($conection);
$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    header('location: lista_proveedor.php');
} else {
    // $option = '';
    while ($data = mysqli_fetch_array($sql)) {

        $idproveedor = $data['codproveedor'];
        $proveedor = $data['proveedor'];
        $contacto = $data['contacto'];
        $telefono = $data['telefono'];
        $direccion = $data['direccion'];
        
    }
}

?>

<html lang="en">

<head>
    <title>Actualizar proveedor</title>
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
            <h1>Actualizar proveedor</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $idproveedor; ?>">
            <label for="proveedor">Proveedor</label>
            <input type="text" name="proveedor" id="proveedor" placeholder="Nombre del proveedor" value="<?php echo $proveedor ?>">
            <label for="contacto">Contacto</label>
            <input type="text" name="contacto" id="contacto" placeholder="Nombre completo del contacto" value="<?php echo $contacto ?>">
            <label for="telefono">Telefono</label>
            <input type="number" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $telefono ?>">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id="direccion" placeholder="Direccion completa" value="<?php echo $direccion ?>">
            
            <input type="submit" value="Actualizar proveedor" class="btn_save">

        </form>

        </div>

    </section>

    <!--Se agreggo una ruta de pide de pagina en caso de usarlo para el proyecto-->
    <?php include "includes/footer.php"; ?>

</body>

</html>