<?php

/***CON ESTE CODIGO VALIDAMOS QUE EL USUARIO LOGEADO NO TENGA ACCESO A LAS FUNCIONES DE ADMINISTRADOR*/
session_start();

if ($_SESSION['rol'] != 1 AND ($_SESSION['rol'] != 2)) {

    header("location: ./");
}


include "../conexion.php";

if (!empty($_POST)) {


    if (
        empty($_POST['descripcion']) || empty($_POST['proveedor']) || empty($_POST['precio'])) {

        echo '<script type="text/javascript">
            alert("Complete todos los campos");
            window.location.href="compras.php";
            </script>';

    } else {

        $cod_compra         = $_POST['id'];
        $descripcion        = $_POST['descripcion'];
        $proveedor          = $_POST['proveedor'];
        $precio             = $_POST['precio'];

        $sql_update = mysqli_query($conection, "UPDATE compras
												SET descripcion  = '$descripcion', proveedor  = '$proveedor', precio = '$precio' 
											    WHERE cod_compra = $cod_compra");
    }

    if ($sql_update) {

        echo '<script type="text/javascript">
            alert("Compra actualizada correctamente");
            window.location.href="compras.php";
            </script>';

    } else {

        echo '<script type="text/javascript">
            alert("Error al actualizar compra");
            window.location.href="compras.php";
            </script>';
    }
}

//Cargar datos en formulario de edición//

if (empty($_REQUEST['id'])) {
    header('location: compras.php');

    ////***CIERRA LA CONEXION A LA BD*////
    mysqli_close($conection);
}

$codCompra = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT * FROM compras WHERE cod_compra = $codCompra and estatus = 1");


$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {

    header('location: compras.php');
} else {


    while ($data = mysqli_fetch_array($sql)) {

        $cod_compra         = $data['cod_compra'];
        $descripcion        = $data['descripcion'];
        $proveedor          = $data['proveedor'];
        $precio             = $data['precio'];
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <?php include "includes/functions.php"; ?>
    <title>Editar Compra</title>
</head>

<body>

    <?php include "includes/header.php"; ?>

    <section id="container" class="container">

        <div class="form_register">
            <h5>Editar Compra</h5>
            <hr>
            <form class="edit_cli" action="" method="post">
                <input type="hidden" name="id" value="<?php echo $cod_compra; ?>">

                <div>
                    <label for="descripcion">Descripcion</label>
                    <input type="text" name="descripcion" id="descripcion" placeholder="descripcion"
                        value="<?php echo $descripcion; ?>" required>
                </div>
                <!-- Select Equipo -->
                <?php
                $query_proveedor = mysqli_query($conection, "SELECT cod_proveedor, proveedor
								                             FROM proveedor");
                $result_proveedor = mysqli_num_rows($query_proveedor);
                ?>
                <div>
                    <label for="proveedor">Proveedor</label>
                    <select name="proveedor" id="proveedor">
                        <?php
                        if ($result_proveedor > 0) {
                            while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                                ?>
                                <option value="<?php echo $proveedor['cod_proveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <div>
                    <label for="precio">Precio</label>
                    <input type="text" name="precio" id="precio" placeholder="precio"
                        value="<?php echo $precio; ?>" required>
                </div>
                    <div>
                        <input type="submit" value="Editar Compra" class="btn btn-primary mx-auto d-block m-2">
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>
</body>

</html>