<?php

/***CON ESTE CODIGO VALIDAMOS QUE EL USUARIO LOGEADO NO TENGA ACCESO A LAS FUNCIONES DE ADMINISTRADOR*/
session_start();

if ($_SESSION['rol'] != 1 AND ($_SESSION['rol'] != 2)) {

    header("location: ./");
}


include "../conexion.php";

if (!empty($_POST)) {


    if (
        empty($_POST['nom_ape']) || empty($_POST['direccion']) || empty($_POST['telefono'])) {

        echo '<script type="text/javascript">
            alert("Complete todos los campos");
            window.location.href="clientes.php";
            </script>';

    } else {

        $ID_Cliente         = $_POST['id'];
        $CI                 = $_POST['CI'];
        $nom_ape            = $_POST['nom_ape'];
        $direccion          = $_POST['direccion'];
        $telefono           = $_POST['telefono'];

        if(is_numeric($CI) || $CI == 0 )
				{
					$query = mysqli_query($conection, "SELECT * FROM cliente 
                                                       WHERE (CI = '$CI' AND ID_Cliente != $ID_Cliente)");

					$result = mysqli_fetch_array($query);

				}

				if($result > 0)
				{
					echo '<script type="text/javascript">
                    alert("CI o RUT ya existente (Si no tiene CI o RUT coloque CERO)");
                    window.location.href="clientes.php";
                    </script>';
          
				}else{
                    if($CI == '')
						{
							$CI = 'N/A';
						}
                    $sql_update = mysqli_query($conection, "UPDATE cliente
												            SET CI  = '$CI', nom_ape  = '$nom_ape', direccion = '$direccion',
                                                                telefono = '$telefono' 
											                WHERE ID_Cliente = $ID_Cliente");
                    }

    if ($sql_update) {

        echo '<script type="text/javascript">
            alert("Cliente actualizado correctamente");
            window.location.href="clientes.php";
            </script>';

    } else {

        echo '<script type="text/javascript">
            alert("Error al actualizar Cliente");
            window.location.href="clientes.php";
            </script>';
    }
}
}

//Cargar datos en formulario de edición//

if (empty($_REQUEST['id'])) {
    
    header('location: clientes.php');

    ////***CIERRA LA CONEXION A LA BD*////
    mysqli_close($conection);
}

$ID_Cliente = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT * FROM cliente WHERE ID_Cliente = $ID_Cliente and estatus = 1");


$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {

    header('location: clientes.php');
} else {


    while ($data = mysqli_fetch_array($sql)) {

        $ID_Cliente     = $data['ID_Cliente'];
        $CI             = $data['CI'];
        $nom_ape        = $data['nom_ape'];
        $direccion      = $data['direccion'];
        $telefono       = $data['telefono'];
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <?php include "includes/functions.php"; ?>
    <title>Editar Cliente</title>
</head>

<body>

    <?php include "includes/header.php"; ?>

    <section id="container" class="container">

        <div class="form_register">
            <h5>Editar Cliente</h5>
            <hr>
            <form class="edit_cli" action="" method="post">
                <input type="hidden" name="id" value="<?php echo $ID_Cliente; ?>">
                <div>
                    <label for="ci">CI</label>
                    <input type="text" name="CI" id="ci" placeholder="ci"
                        value="<?php echo $CI; ?>">
                </div>
                <div>
                    <label for="nom_ape">Nombre y Apellido</label>
                    <input type="text" name="nom_ape" id="nom_ape" placeholder="nom_ape"
                        value="<?php echo $nom_ape; ?>" required>
                </div>
                <div>
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion" placeholder="direccion"
                        value="<?php echo $direccion; ?>" required>
                </div>
                <div>
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" placeholder="telefono"
                        value="<?php echo $telefono; ?>" required>
                </div>
                    <div>
                        <button type="submit" value="Editar Cliente" class="btn btn-primary mx-auto d-block m-2">Editar Cliente</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>
</body>

</html>