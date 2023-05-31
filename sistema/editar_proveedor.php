<?php

/***CON ESTE CODIGO VALIDAMOS QUE EL USUARIO LOGEADO NO TENGA ACCESO A LAS FUNCIONES DE ADMINISTRADOR*/
session_start();

if ($_SESSION['rol'] != 1 AND ($_SESSION['rol'] != 2)) {

    header("location: ./");
}


include "../conexion.php";

if (!empty($_POST)) {


    if (
        empty($_POST['proveedor']) || empty($_POST['per_contacto']) || empty($_POST['telefono'])
                                   || empty($_POST['direccion'])) {

        echo '<script type="text/javascript">
            alert("Complete todos los campos");
            window.location.href="proveedores.php";
            </script>';

    } else {

        $cod_proveedor        = $_POST['cod_proveedor'];
        $proveedor            = $_POST['proveedor'];
        $per_contacto         = $_POST['per_contacto'];
        $telefono             = $_POST['telefono'];
        $direccion            = $_POST['direccion'];

        $sql_update = mysqli_query($conection, "UPDATE proveedor
												SET proveedor  = '$proveedor', per_contacto  = '$per_contacto', telefono = '$telefono', direccion = '$direccion' 
											    WHERE cod_proveedor = $cod_proveedor");
    }

    if ($sql_update) {

        echo '<script type="text/javascript">
            alert("Proveedor actualizado correctamente");
            window.location.href="proveedores.php";
            </script>';

    } else {

        echo '<script type="text/javascript">
            alert("Error al actualizar Proveedor");
            window.location.href="proveedores.php";
            </script>';
    }
}

//Cargar datos en formulario de edición//

if (empty($_REQUEST['id'])) {
    header('location: proveedores.php');

    ////***CIERRA LA CONEXION A LA BD*////
    mysqli_close($conection);
}

$cod_proveedor = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT * FROM proveedor WHERE cod_proveedor = $cod_proveedor and estatus = 1");


$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {

    header('location: proveedores.php');
} else {


    while ($data = mysqli_fetch_array($sql)) {

        $cod_proveedor        = $data['cod_proveedor'];
        $proveedor            = $data['proveedor'];
        $per_contacto         = $data['per_contacto'];
        $telefono             = $data['telefono'];
        $direccion            = $data['direccion'];
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <?php include "includes/functions.php"; ?>
    <title>Editar Proveedor</title>
</head>

<body>

    <?php include "includes/header.php"; ?>

    <section id="container" class="container">

        <div class="form_register">
            <h5>Editar Proveedor</h5>
            <hr>
            <form action="" method="post">
                <input type="hidden" name="cod_proveedor" value="<?php echo $cod_proveedor; ?>">

                <div>
                    <label for="proveedor">Proveedor</label>
                    <input type="text" name="proveedor" id="proveedor" placeholder="proveedor"
                        value="<?php echo $proveedor; ?>">
                </div>
                <div>
                    <label for="per_contacto">Persona de Contacto</label>
                    <input type="text" name="per_contacto" id="per_contacto" placeholder="per_contacto"
                        value="<?php echo $per_contacto; ?>">
                </div>
                <div>
                    <label for="telefono">Telefono</label>
                    <input type="text" name="telefono" id="telefono" placeholder="telefono"
                        value="<?php echo $telefono; ?>">
                </div>
                <div>
                    <label for="direccion">Direccion</label>
                    <input type="text" name="direccion" id="direccion" placeholder="direccion"
                        value="<?php echo $direccion; ?>">
                </div>
                <div>
                        <input type="submit" value="Editar Proveedor" class="btn blue-grey">
                </div>
                </div>
            </form>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>
</body>

</html>