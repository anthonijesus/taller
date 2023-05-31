<?php

/***CON ESTE CODIGO VALIDAMOS QUE EL USUARIO LOGEADO NO TENGA ACCESO A LAS FUNCIONES DE ADMINISTRADOR*/
session_start();

if ($_SESSION['rol'] != 1 and ($_SESSION['rol'] != 2)) {

    header("location: ./");
}


include "../conexion.php";

if (!empty($_POST)) {


    if (
        empty($_POST['nro_fact_gasto']) || empty($_POST['descripcion']) || empty($_POST['monto']) || empty($_POST['proveedor'])
    ) {

        echo '<script type="text/javascript">
            alert("Complete todos los campos");
            window.location.href="gastos.php";
            </script>';

    } else {

        $cod_gasto          = $_POST['id'];
        $nro_fact_gasto     = $_POST['nro_fact_gasto'];
        $descripcion        = $_POST['descripcion'];
        $monto              = $_POST['monto'];
        $proveedor          = $_POST['proveedor'];


        $sql_update = mysqli_query($conection, "UPDATE gastos
												SET nro_fact_gasto = '$nro_fact_gasto', descripcion  = '$descripcion', monto = '$monto', proveedor  = '$proveedor' 
											    WHERE cod_gasto = $cod_gasto");
    }

    if ($sql_update) {

        echo '<script type="text/javascript">
            alert("Gasto actualizado correctamente");
            window.location.href="gastos.php";
            </script>';

    } else {

        echo '<script type="text/javascript">
            alert("Error al actualizar Gasto");
            window.location.href="gastos.php";
            </script>';
    }
}

//Cargar datos en formulario de edición//

if (empty($_REQUEST['id'])) {
    header('location: gastos.php');

    ////***CIERRA LA CONEXION A LA BD*////
    mysqli_close($conection);
}

$cod_gasto = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT g.cod_gasto, g.nro_fact_gasto, g.descripcion, g.monto, (g.proveedor) AS cod_proveedor,
                                (p.proveedor) AS proveedor
                                FROM gastos g
                                INNER JOIN proveedor p
                                ON g.proveedor = p.cod_proveedor
                                WHERE cod_gasto = $cod_gasto and g.estatus = 1");


$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {

    header('location: gastos.php');
} else {

    $option = '';
    while ($data = mysqli_fetch_array($sql)) {

        $cod_gasto          = $data['cod_gasto'];
        $nro_fact_gasto     = $data['nro_fact_gasto'];
        $descripcion        = $data['descripcion'];
        $monto              = $data['monto'];
        $cod_proveedor      = $data['cod_proveedor'];
        $proveedor          = $data['proveedor'];

        /////Coloca tipo de Proveedor por defecto en el Formulario///////
        if($cod_proveedor == 1){
            $option = '<option value="'.$cod_proveedor.'" select>'.$proveedor.'</option>';
        }else if($cod_proveedor == 2){
            $option = '<option value="'.$cod_proveedor.'" select>'.$proveedor.'</option>';
        }else if($cod_proveedor == 3){
            $option = '<option value="'.$cod_proveedor.'" select>'.$proveedor.'</option>';
        }else if($cod_proveedor == 4){
            $option = '<option value="'.$cod_proveedor.'" select>'.$proveedor.'</option>';
        }else if($cod_proveedor == 5){
            $option = '<option value="'.$cod_proveedor.'" select>'.$proveedor.'</option>';
        }else if($cod_proveedor == 5){
            $option = '<option value="'.$cod_proveedor.'" select>'.$proveedor.'</option>';
        }else if($cod_proveedor == 7){
            $option = '<option value="'.$cod_proveedor.'" select>'.$proveedor.'</option>';
        }else if($cod_proveedor == 8){
            $option = '<option value="'.$cod_proveedor.'" select>'.$proveedor.'</option>';
        }else if($cod_proveedor == 9){
            $option = '<option value="'.$cod_proveedor.'" select>'.$proveedor.'</option>';
        }else if($cod_proveedor == 10){
            $option = '<option value="'.$cod_proveedor.'" select>'.$proveedor.'</option>';
        }else if($cod_proveedor == 11){
            $option = '<option value="'.$cod_proveedor.'" select>'.$proveedor.'</option>';
        }else if($cod_proveedor == 12){
            $option = '<option value="'.$cod_proveedor.'" select>'.$proveedor.'</option>';
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <?php include "includes/functions.php"; ?>
    <title>Editar Gasto</title>
</head>

<body>

    <?php include "includes/header.php"; ?>

    <section id="container" class="container">

        <div class="form_register">
            <h5>Editar Gasto</h5>
            <hr>
            <form class="edit_cli" action="" method="post">
                <input type="hidden" name="id" value="<?php echo $cod_gasto; ?>">

                <div>
                    <label for="nro_fact_gasto">Nro. Factura</label>
                    <input type="text" name="nro_fact_gasto" id="nro_fact_gasto" placeholder="Nro. Factura"
                        value="<?php echo $nro_fact_gasto; ?>">
                </div>
                <div>
                    <label for="descripcion">Descripcion</label>
                    <input type="text" name="descripcion" id="descripcion" placeholder="descripcion"
                        value="<?php echo $descripcion; ?>">
                </div>
                
                <!-- Select Proveedor -->
                <?php
                $query_proveedor = mysqli_query($conection, "SELECT cod_proveedor, proveedor FROM proveedor
                                                             WHERE estatus = 1 ORDER BY proveedor ASC");
                ////***CIERRA LA CONEXION A LA BD*////
				mysqli_close($conection);

                $result_proveedor = mysqli_num_rows($query_proveedor);
                ?>
                <div>
                    <label for="proveedor">Proveedor</label>
                    
                    <select name="proveedor" id="proveedor" class="">
	         		<?php 
	         			echo $option;
	         			if($result_proveedor > 0)
	         			{
	         				while ($proveedor = mysqli_fetch_array($query_proveedor)){
	         		    ?>
	         		
	         		<option value="<?php echo $proveedor["cod_proveedor"];?>"><?php echo $proveedor["proveedor"]; ?></option>

	         		<?php			
	         				}
	         			}
	         		 ?>
	         </select>
                </div>

                <div>
                    <label for="monto">Monto</label>
                    <input type="text" name="monto" id="monto" placeholder="monto" value="<?php echo $monto; ?>">
                </div>
                    <div>
                        <button type="submit" value="Editar Cliente" class="btn btn-primary mx-auto d-block m-2">Editar Gasto</button>
                    </div>
        </div>
        </form>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>
</body>

</html>