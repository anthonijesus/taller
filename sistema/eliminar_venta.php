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
		
		$id_rep = $_POST['id_rep'];
		
		$query_delete = mysqli_query($conection,"UPDATE facturas SET estatus = 0 WHERE id_rep =$id_rep");

		if($query_delete)
		{
			$query_repa_update = mysqli_query($conection,"UPDATE reparaciones SET estatus = 'Pendiente de Facturar' WHERE id_rep =$id_rep");	
			
			////***CIERRA LA CONEXION A LA BD***///
			mysqli_close($conection);

			echo '<script type="text/javascript">
            alert("Se ha actualizado la lista de reparaciones, verifique");
            window.location.href="ventas.php";
            </script>';
		}else{
			echo '<script type="text/javascript">
            alert("Error al eliminar Venta");
            window.location.href="ventas.php";
            </script>';
		}

	}

	/****** Validacion del ID cuando hacemos clic en el boton eliminar *//////

	if(empty($_REQUEST['id'])) {
		
		header("location: ventas.php");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);
	}else{

		$id_rep = $_REQUEST['id'];

		$query = mysqli_query($conection, "SELECT * FROM facturas WHERE id_rep = $id_rep and estatus = 1");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);

		$result = mysqli_num_rows($query);

		if($result > 0){

			while ($data = mysqli_fetch_array($query)) {
				
				$nro_factura 	    = $data['nro_factura'];
				$id_rep 	        = $data['id_rep'];
				$cliente 			= $data['cliente'];
                $descripcion 		= $data['descripcion'];
                $precio_total 		= $data['precio_total'];
				}
			}else{

				header("location: ventas.php");
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<?php include "includes/functions.php"; ?>
	<title>Eliminar Venta</title>

</head>
<body>
	
	<?php include "includes/header.php"; ?>

	<section id="container">
		
		<div class="data_delete">
			<h5> Seguro de eliminar esta Factura? </h5>

			<p>Nro. de factura: 		<span> <?php echo $nro_factura; ?></span></p>
			<p>ID Reparación: 			<span> <?php echo $id_rep; ?></span></p>
			<p>Cliente: 				<span> <?php echo $cliente; ?></span></p>
			<p>Descripción: 			<span> <?php echo $descripcion; ?></span></p>
            <p>Precio: 	                <span> <?php echo $precio_total; ?></span></p>

			<form method="post" action="">
				
				<input type="hidden" name="id_rep" value="<?php echo $id_rep; ?>">
				<input type="submit" value="Aceptar" class="btn_ok">
				<a href="ventas.php" class="btn_cancel">Cancelar</a>

			</form>

		</div>

	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>