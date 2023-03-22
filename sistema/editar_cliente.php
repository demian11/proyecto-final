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
    if (empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion'])) 
    {
        $alert = '<p class="msg_error">Todos los campos son obligatorios</p>';
    } else {

        $idcliente = $_POST['id'];
        $nombre = $_POST['nombre'];
        $telefono = $_POST['telefono'];
        $nit = $_POST['nit'];
        $direccion = $_POST['direccion'];      

        //if(is_numeric($nit) AND $nit =! 0)
        //{
        $query = mysqli_query($conection, "SELECT * FROM cliente 
                            WHERE (nit = '$nit' AND idcliente != $idcliente) 
                             ");

        $result = mysqli_fetch_array($query);
        //$result =count($result);
        //}

        if ($result > 0) {
            $alert = '<p class="msg_error">El nit ya existe, ingrese uno nuevo</p>';
        } else {
            if($nit == '')
            {
                $nit =0;
            }

          

                $sql_update = mysqli_query($conection, "UPDATE cliente
                                                        SET nit = '$nit', nombre = '$nombre',telefono ='$telefono'
                                                        ,direccion='$direccion'
                                                        WHERE idcliente= $idcliente");
           
            
            if ($sql_update) {
                $alert = '<p class="msg_save">Cliente actualizado correctamente</p>';
            } else {
                $alert = '<p class="msg_error">Error al actualizar el cliente</p>';
            }
        }
    }
}

//Mostrar datos
if (empty($_GET['id'])) 
{
    header('location: lista_clientes.php');
    mysqli_close($conection);
}
$idcliente = $_GET['id'];

$sql = mysqli_query($conection, "SELECT * FROM cliente WHERE idcliente= $idcliente");
mysqli_close($conection);
$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {
    header('location: lista_usuarios.php');
} else {
    // $option = '';
    while ($data = mysqli_fetch_array($sql)) {

        $idcliente = $data['idcliente'];
        //el dato nit tal vez se tenga que elimiar por no ser relevante para el proyecto
        $nombre = $data['nombre'];
        $telefono = $data['telefono'];
        $nit = $data['nit'];
        $direccion = $data['direccion'];

        
    }
}

?>

<html lang="en">

<head>
    <title>Actualizar cliente</title>
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
            <h1>Actualizar cliente</h1>
            <hr>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $idcliente; ?>">
            <!--el NIT es parecido al curp -->
            <label for="nombre">Nombre y apellido</label>
            <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre; ?>">
            <label for="telefono">Telefono</label>
            <input type="number" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $telefono; ?>">
            <label for="nit">NIT</label>
            <input type="number" name="nit" id="nit" placeholder="Numero de NIT" value="<?php echo $nit; ?>">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id="direccion" placeholder="Direccion completa"value="<?php echo $direccion; ?>">
            
            <input type="submit" value="Actualizar cliente" class="btn_save">

        </form>

        </div>

    </section>

    <!--Se agreggo una ruta de pide de pagina en caso de usarlo para el proyecto-->
    <?php include "includes/footer.php"; ?>

</body>

</html>