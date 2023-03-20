<?php
include "../conexion.php";
session_start();

if (!empty($_POST)) {

    //Extraer datos del producto
    if($_POST['action'] == 'infoProducto') 
    {
        $producto_id = $_POST['producto'];

        $query = mysqli_query($conection, "SELECT codproducto,descripcion,existencia,precio FROM producto
                                              WHERE codproducto =$producto_id AND estatus = 1");
        mysqli_close($conection);

        $result = mysqli_num_rows($query);
        if ($result > 0) {
            $data = mysqli_fetch_assoc($query);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            exit;
        }
        echo 'error';
        exit;
    }

    //agregar productos a entrada
    if ($_POST['action'] == 'addProduct') 
    {

        if (!empty($_POST['cantidad']) || !empty($_POST['precio']) || !empty($_POST['producto_id'])) {
            $cantidad = $_POST['cantidad'];
            $precio = $_POST['precio'];
            $producto_id = $_POST['producto_id'];
            $usuario_id = $_SESSION['idUser'];

            $query_insert = mysqli_query($conection, "INSERT INTO entradas 
                (codproducto,cantidad,precio,usuario_id) value ($producto_id,$cantidad,$precio,$usuario_id) ");

            if ($query_insert) {
                $query_upd = mysqli_query($conection, "CALL actualizar_precio_producto($cantidad,$precio,$producto_id)");
                $result_pro = mysqli_num_rows($query_upd);
                if ($result_pro > 0) {
                    $data = mysqli_fetch_assoc($query_upd);
                    $data['producto_id'] = $producto_id;

                    echo json_encode($data, JSON_UNESCAPED_UNICODE);
                    exit;
                }
            } else {
                echo 'error';
            }
            mysqli_close($conection);
        } else {
            echo 'error';
        }
        exit;
    }

    //Eliminar producto
    if ($_POST['action'] == 'delProduct') {
        if (empty($_POST['producto_id']) || !is_numeric($_POST['producto_id'])) {
            echo 'error';
        } else {
            //posiblemente corregir el query ya que no pude ver todo
            $idproducto = $_POST['producto_id'];
            $query_delete = mysqli_query($conection, "UPDATE producto SET estatus = 0
                idproducto");
            mysqli_close($conection);

            if ($query_delete) {
                echo 'ok';
            } else {
                echo 'error';
            }
        }
        echo 'error';
        exit;
    }

    //buscar cliente
    if ($_POST['action'] == 'searchCliente') {
        if (!empty($_POST['cliente'])) {

            $nit = $_POST['cliente'];
            $query = mysqli_query($conection, "SELECT * FROM cliente WHERE nit LIKE '$nit' and estatus = 1");
            mysqli_close($conection);
            $result = mysqli_num_rows($query);

            $data = '';
            if ($result > 0) {
                $data = mysqli_fetch_assoc($query);
            } else {
                $data = 0;
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        exit;
    }

    //registra cliente -ventas 
    if ($_POST['action'] == 'addCliente') 
    {
        $nit         = $_POST['nit_cliente'];
        $nombre      = $_POST['nom_cliente'];
        $telefono    = $_POST['tel_cliente'];
        $direccion   = $_POST['dir_cliente'];
        $usuario_id  = $_SESSION['idUser'];

        $query_insert = mysqli_query($conection, "INSERT INTO cliente(
                                                        nit,nombre,telefono,direccion,usuario_id)
                                                        VALUES('$nit','$nombre','$telefono','$direccion','$usuario_id')");

        if ($query_insert) {
            $codCliente = mysqli_insert_id($conection);
            $msg = $codCliente;
        } else {
            $msg = 'error';
        }
        mysqli_close($conection);
        echo $msg;
        exit;
    }

    //Agregar producto al detalle temporal
    if ($_POST['action'] == 'addProductoDetalle') {
        if (empty($_POST['producto']) || empty($_POST['cantidad'])) 
        {
            echo 'error';
        } else {
            $codproducto   = $_POST['producto'];
            $cantidad      = $_POST['cantidad'];
            $token         = md5($_SESSION['idUser']);

            $query_iva = mysqli_query($conection, "SELECT iva FROM configuracion");
            $result_iva = mysqli_num_rows($query_iva);

            $query_detalle_temp = mysqli_query($conection, "CALL add_detalle_temp($codproducto,$cantidad,'$token')");
            $result = mysqli_num_rows($query_detalle_temp);

            $detalleTabla = '';
            $sub_total    = 0;
            $iva          = 0;
            $total        = 0;
            $arrayData = array();

            if ($result > 0) {
                if ($result_iva > 0) {
                    $info_iva = mysqli_fetch_assoc($query_iva);
                    $iva = $info_iva['iva'];
                }

                while ($data = mysqli_fetch_assoc($query_detalle_temp)) {
                    $precioTotal  = round($data['cantidad'] * $data['precio_venta'], 2);
                    $sub_total    = round($sub_total + $precioTotal, 2);
                    $total        = round($total + $precioTotal, 2);

                    //aqui se puso un . detras de la variables para concatenar los datos (posiblemente cause problemas todo este bien)
                    $detalleTabla .= '<tr>
                    <td>'.$data['codproducto'].'</td>
                    <td colspan="2">' . $data['descripcion'] . '</td>
                    <td class="textcenter">' . $data['cantidad'] . '</td>
                    <td class="textright">' . $data['precio_venta'] . '</td>
                    <td class="textright">' . $precioTotal . '</td>
                    <td class="">
                        <a class="link_delete" href="#" onclick="event.preventDefault(); del_product_detalle('.$data['codproducto'].');"><i class="far fa-trash-alt"></i></a>
                    </td>
                </tr>';
                }

                $impuesto = round($sub_total * ($iva / 100), 2);
                $tl_sniva = round($sub_total - $impuesto, 2);
                $total    = round($tl_sniva + $impuesto, 2);

                $detalleTotales = '<tr>
                                    <td colspan="5" class="textriggt">Subtotal</td>
                                    <td class="textright">' . $tl_sniva . '</td>
                                    </tr>
                                    <tr>
                                    <td colspan="5" class="textriggt">IVA (' . $iva . '%)</td>
                                    <td class="textright">' . $impuesto . '</td>
                                    </tr>
                                    <tr>
                                    <td colspan ="5" class= textright>Total</td>
                                    <td class="textright">' . $total . '</td>
                                    </tr>';

                $arrayData['detalle'] = $detalleTabla;
                $arrayData['totales'] = $detalleTotales;

                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            } else {
                echo 'error';
            }
            mysqli_close($conection);
        }
        exit;
    }

    //Extrae datos del detalle_temp
    if ($_POST['action'] == 'serchForDetalle') {
        if (empty($_POST['user'])) 
        {
            echo 'error';
        } else {

            $token = md5($_SESSION['idUser']);

            $query = mysqli_query($conection, "SELECT tmp.correlativo,
                                                    tmp.token_user,
                                                    tmp.cantidad,
                                                    tmp.precio_venta,
                                                    p.codproducto,
                                                    p.descripcion
                                                    FROM detalle_temp tmp
                                                    INNER JOIN producto p
                                                    ON tmp.codproducto=p.codproducto
                                                    WHERE token_user = '$token' ");

            $result = mysqli_num_rows($query);

            $query_iva = mysqli_query($conection, "SELECT iva FROM configuracion");
            $result_iva = mysqli_num_rows($query_iva);



            $detalleTabla = '';
            $sub_total    = 0;
            $iva          = 0;
            $total        = 0;
            $arrayData = array();

            if ($result > 0) {
                if ($result_iva > 0) {
                    $info_iva = mysqli_fetch_assoc($query_iva);
                    $iva = $info_iva['iva'];
                }
                while ($data = mysqli_fetch_assoc($query)) {
                    $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
                    $sub_total   = round($sub_total + $precioTotal, 2);
                    $total       = round($total + $precioTotal, 2);
                    
                    //se debe agregar un incono de eliminar dentro de esta seccion y despues eliminar este comentario
                    $detalleTabla .= '<tr>
                                        <td>'.$data['codproducto'].'</td>
                                        <td colspan="2">'.$data['descripcion'].'</td>
                                        <td class="textcenter">'.$data['cantidad'].'</td>
                                        <td class="textright">'.$data['precio_venta'].'</td>
                                        <td class="textright">'.$precioTotal.'</td>
                                        <td class="">
                                            <a class="link_delete" href="#" onclick="event.preventDefault(); 
                                            del_product_detalle('.$data['correlativo'].');"><i class="far fa-trash-alt"></i>eliminar</a>
                                        </td>
                                    </tr>';
                }

                $impuesto = round($sub_total * ($iva / 100), 2);
                $tl_sniva = round($sub_total - $impuesto, 2);
                $total    = round($tl_sniva + $impuesto, 2);

                $detalleTotales = '<tr>
                                    <td colspan="5" class="textriggt">Subtotal</td>
                                    <td class="textright">'.$tl_sniva.'</td>
                                    </tr>
                                    <tr>
                                    <td colspan="5" class="textriggt">IVA ('.$iva.'%)</td>
                                    <td class="textright">'.$impuesto.'</td>
                                    </tr>
                                    <tr>
                                    <td colspan ="5" class= textright>Total</td>
                                    <td class="textright">'.$total.'</td>
                                    </tr>';

                $arrayData['detalle'] = $detalleTabla;
                $arrayData['totales'] = $detalleTotales;

                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            } else {
                echo 'error';
            }
            mysqli_close($conection);
        }
        exit;
    }
    
    if ($_POST['action'] == 'delProductoDetalle') {
    
        if (empty($_POST['id_detalle'])) 
        {
            echo 'error';
        } else {
            $id_detalle = $_POST['id_detalle'];
            $token      = md5($_SESSION['idUser']);

            $query_iva = mysqli_query($conection, "SELECT iva FROM configuracion");
            $result_iva = mysqli_num_rows($query_iva);

            $query_detalle_temp = mysqli_query($conection, "CALL del_detalle_temp($id_detalle,'$token')");
            $result=mysqli_num_rows($query_detalle_temp);


            $detalleTabla = '';
            $sub_total    = 0;
            $iva          = 0;
            $total        = 0;
            $arrayData = array();

            if ($result > 0) {
                if ($result_iva > 0) {
                    $info_iva = mysqli_fetch_assoc($query_iva);
                    $iva = $info_iva['iva'];
                }
                while ($data = mysqli_fetch_assoc($query_detalle_temp)) {
                    $precioTotal = round($data['cantidad'] * $data['precio_venta'], 2);
                    $sub_total   = round($sub_total + $precioTotal, 2);
                    $total       = round($total + $precioTotal, 2);
                    
                    //se debe agregar un incono de eliminar dentro de esta seccion y despues eliminar este comentario
                    $detalleTabla .= '<tr>
                                        <td>'.$data['codproducto'].'</td>
                                        <td colspan="2">'.$data['descripcion'].'</td>
                                        <td class="textcenter">'.$data['cantidad'].'</td>
                                        <td class="textright">'.$data['precio_venta'].'</td>
                                        <td class="textright">'.$precioTotal.'</td>
                                        <td class="">
                                            <a class="link_delete" href="#" onclick="event.preventDefault(); 
                                            del_product_detalle('.$data['correlativo'].');"><i class="far fa-trash-alt"></i>eliminar</a>
                                        </td>
                                    </tr>';
                }

                $impuesto = round($sub_total * ($iva / 100), 2);
                $tl_sniva = round($sub_total - $impuesto, 2);
                $total    = round($tl_sniva + $impuesto, 2);

                $detalleTotales = '<tr>
                                    <td colspan="5" class="textriggt">Subtotal</td>
                                    <td class="textright">'.$tl_sniva.'</td>
                                    </tr>
                                    <tr>
                                    <td colspan="5" class="textriggt">IVA ('.$iva.'%)</td>
                                    <td class="textright">'.$impuesto.'</td>
                                    </tr>
                                    <tr>
                                    <td colspan ="5" class= textright>Total</td>
                                    <td class="textright">'.$total.'</td>
                                    </tr>';

                $arrayData['detalle'] = $detalleTabla;
                $arrayData['totales'] = $detalleTotales;

                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
            } else {
                echo 'error';
            }
            mysqli_close($conection);
        }
        exit;
    
    }

    //Anular Venta. esto jala chido
    if($_POST['action'] == 'anularVenta'){

        $token  =md5($_SESSION['idUser']);

        $query_del =mysqli_query($conection, "DELETE FROM detalle_temp WHERE token_user = '$token'");
        mysqli_close($conection);
        if($query_del){
            echo 'ok';
        }else{
            echo 'error';
        }
        exit;
    }

    //Procesar venta
    if($_POST['action'] == 'procesarVenta'){

        if(empty($_POST['codcliente'])){
            $codCliente =1;
        }else{
            $codCliente = $_POST['codcliente'];
        }
        $token   =md5($_SESSION['idUser']);
        $usuario =$_SESSION['idUser'];

        $query = mysqli_query($conection, "SELECT * FROM detalle_temp WHERE token_user = '$token'");
        $result = mysqli_num_rows($query);

        if($result > 0)
        {
            $query_procesar = mysqli_query($conection, "CALL procesar_venta($usuario,$codcliente,'$token')");
            $result_detalle = mysqli_num_rows($query_procesar);

            if($result_detalle > 0)
            {
                $data =mysqli_fetch_assoc($query_procesar);

                if($result_detalle > 0){
                    $data = mysqli_fetch_assoc($query_procesar);
                    echo json_decode($data,JSON_UNESCAPED_UNICODE);
                }else{
                    echo "error";
                }
            }else{
                echo "error";
            }
            mysqli_close($conection);
            exit;
        }
    
    }

}

exit;

 ?>