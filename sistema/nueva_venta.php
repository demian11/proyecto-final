<?php
session_start();
include "../conexion.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   
    <?php include "includes/scripts.php"; ?>
    <title>nueva venta</title>
</head>
<style>
body{
            background:#BB1E19;
            background: linear-gradient(to right,#5B2C6F, #16A085)
        }
        </style>
<body>
    <?php include "includes/header.php"; ?>

    <section id="container">
        <div>
            <h1><i class="fas fa-cube"></i>Nueva venta</h1>
        </div>
        <div class="datos_cliente">
            <div class="action_cliente">
                <h4>Datos del cliente</h4>
                <a href="#" class="btn_new btn_new_cliente">
                    <img src= "../img/agregar.png" width="30" height="30"> 
                    <i class="fas fa-plus"></i>
                 </a>
            </div>
            <form name="form_new_cliente_venta" id="form_new_cliente_venta" class="datos">
                <input type="hidden" name="action" value="addCliente">
                <input type="hidden" id="idcliente" name="idcliente" value="" required>
                <div class="wd30">
                    <label>Nit</label>
                    <input type="text" name="nit_cliente" id="nit_cliente">
                </div>
                <div class="wd30">
                    <label>Nombre</label>
                    <input type="text" name="nom_cliente" id="nom_cliente" disabled required>
                </div>
                <div class="wd30">
                    <label>Telefono</label>
                    <input type="number" name="tel_cliente" id="tel_cliente" disabled required>
                </div>
                <div class="wd100">
                    <label>Direccion</label>
                    <input type="text" name="dir_cliente" id="dir_cliente" disabled required>
                </div>
                <!--tal vez se tenga que quitar el id o los css para que aparezca el boton de guardar-->
                <div id="div_registro_cliente" class="wd100">
                    <button type="submit" class="btn_save"><i class="far fa-save fa-lg"></i>Guardar</button>
                </div>
            </form>

        </div>
        <div>
            <div class="datos_ventas">
                <h4>Datos de venta</h4>
                <div class="datos">
                    <div class="wd50">
                        <label>Vendedor</label>
                        <p><?php echo $_SESSION['nombre']; ?></p>
                    </div>
                    <div class="wd50">
                        <label>Acciones</label>
                        <div id="acciones_venta">
                            <a href="#" class="btn_ok textcenter" id="btn_anular_venta">
                            <img src= "../img/pro.png" width="30" height="30"> 
                            <!--<i class="fas fa-ban"></i>-->
                        </a>
                            <a href="#" class="btn_new textcenter" id="btn_facturar_venta" style="display: none;">
                            <img src= "../img/block.png" width="30" height="30"> 
                            
                            <!--<i class="far fa-edit"></i> --></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-3">
        <table class="tbl_venta">
            <thead >
                <tr>
                    
                    <th width="100px">Codigo</th>
                    <th>Descripcion</th>
                    <th>Existencia</th>
                    <th width="100px">cantidad</th>
                    <th class="textright">Precio</th>
                    <th class="textright">Precio Total</th>
                    <th>Accion</th>
                </tr>
                <tr>
                    <!--tabla en la que se muestra los productos que se desean agregar-->
                    <td><input type="text" name="txt_cod_producto" id="txt_cod_producto"></td>
                    <td id="txt_descripcion">-</td>
                    <td id="txt_existencia">-</td>
                    <td><input type="text" name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled></td>
                    <td id="txt_precio" class="textright">0.00</td>
                    <td id="txt_precio_total" class="textright">0.00</td>
                    <td><a href="#" id="add_product_venta" class="link_add">
                    <img src= "../img/agregar1.png" width="30" height="30"></a></td>
                </tr>
                <!--tabla en donde se muestran los productos agreggados anteriormente -->
                <tr>
                    <th>Codigo</th>
                    <th colspan="2">Descripcion</th>
                    <th>Cantidad</th>
                    <th class="textright">Precio</th>
                    <th class="texright">Precio Total</th>
                    <th> Accion</th>
                </tr>
            </thead>

            <tbody id="detalle_venta">
               <!--contenido traido por ajax-->

            </tbody>
            <tbody>
            <tfoot id="detalle_totales">
                <!--contenido traido desde el ajax-->
            </tfoot>    
            </tbody>
        </table>
        </div>
        <!--eliminar codigo de aqui hasta terminar el tbodoy de aqui abajo-->
        <tbody>
            <tfoot id="detalle_totales">
                <!--contenido traido desde el ajax-->
            </tfoot>    
            </tbody>

    </section>

    <?php include "includes/footer.php"; ?>
    <script type="text/javascript">
        $(document).ready(function(){
            var usuarioid = '<?php echo $_SESSION['idUser']; ?>';
            serchForDetalle(usuarioid);
        });

        </script>
</body>

</html>