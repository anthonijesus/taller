<?php 
	
	/***CON ESTE CODIGO VALIDAMOS QUE EL USUARIO LOGEADO NO TENGA ACCESO A LAS FUNCIONES DE ADMINISTRADOR*/
		session_start();
		
        if($_SESSION['rol'] != 1){

			header ("location: ./");
		}
		///**********///

	    include "../conexion.php";


	/******* Accion del boton aceptar del formulario de eliminar *//////

	if(!empty($_POST))
	{
		
	
		$cod_gasto = $_POST['cod_gasto'];
		
		$query_delete = mysqli_query($conection,"UPDATE gastos SET estatus = 0 WHERE cod_gasto =$cod_gasto");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);

		if($query_delete)
		{
			echo '<script type="text/javascript">
            alert("Gasto eliminado");
            window.location.href="gastos.php";
            </script>';
		}else{
			echo '<script type="text/javascript">
            alert("Error al eliminar Gasto");
            window.location.href="gastos.php";
            </script>';
		}

	}

	/****** Validacion del ID cuando hacemos clic en el boton eliminar *//////

	if(empty($_REQUEST['id'])) {
		
		header("location: gastos.php");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);
	}else{

		$cod_gasto = $_REQUEST['id'];

		$query = mysqli_query($conection, "SELECT g.cod_gasto, g.nro_fact_gasto, g.descripcion, p.proveedor, g.monto
                                           FROM gastos g
                                           INNER JOIN proveedor p ON g.proveedor = p.cod_proveedor
                                           WHERE cod_gasto = $cod_gasto and g.estatus = 1");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);

		$result = mysqli_num_rows($query);

		if($result > 0){

			while ($data = mysqli_fetch_array($query)) {
				
				$cod_gasto 	    	= $data['cod_gasto'];
				$nro_fact_gasto 	= $data['nro_fact_gasto'];
				$descripcion 		= $data['descripcion'];
                $proveedor 		    = $data['proveedor'];
                $monto 		    	= $data['monto'];
				}
			}else{

				header("location: gastos.php");
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<?php include "includes/functions.php"; ?>
	<title>Eliminar Gasto</title>

</head>
<body>
	
	<?php include "includes/header.php"; ?>

	<section id="container">
		
		<div class="data_delete">
			<h5> Seguro de eliminar este Gasto? </h5>

			<p>Nro. de factura: 		<span> <?php echo $nro_fact_gasto; ?></span></p>
			<p>Descripción: 			<span> <?php echo $descripcion; ?></span></p>
			<p>proveedor: 	            <span> <?php echo $proveedor; ?></span></p>
            <p>Monto: 	                <span> <?php echo $monto; ?></span></p>

			<form method="post" action="">
				
				<input type="hidden" name="cod_gasto" value="<?php echo $cod_gasto; ?>">
				<input type="submit" value="Aceptar" class="btn_ok">
				<a href="gastos.php" class="btn_cancel">Cancelar</a>

			</form>

		</div>

	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>