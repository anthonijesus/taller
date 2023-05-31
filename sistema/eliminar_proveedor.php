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
		
	
		$cod_proveedor = $_POST['cod_proveedor'];
		
		$query_delete = mysqli_query($conection,"UPDATE proveedor SET estatus = 0 WHERE cod_proveedor =$cod_proveedor");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);

		if($query_delete)
		{
			echo '<script type="text/javascript">
            alert("Proveedor eliminado");
            window.location.href="proveedores.php";
            </script>';
		}else{
			echo '<script type="text/javascript">
            alert("Error al eliminar Proveedor");
            window.location.href="proveedores.php";
            </script>';
		}

	}

	/****** Validacion del ID cuando hacemos clic en el boton eliminar *//////

	if(empty($_REQUEST['id'])) {
		
		header("location: proveedores.php");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);
	}else{

		$cod_proveedor = $_REQUEST['id'];

		$query = mysqli_query($conection, "SELECT * FROM proveedor WHERE cod_proveedor = $cod_proveedor and estatus = 1");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);

		$result = mysqli_num_rows($query);

		if($result > 0){

			while ($data = mysqli_fetch_array($query)) {
				
				$cod_proveedor 	    = $data['cod_proveedor'];
				$proveedor 	       	= $data['proveedor'];
				}
			}else{

				header("location: proveedores.php");
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<?php include "includes/functions.php"; ?>
	<title>Eliminar Proveedor</title>

</head>
<body>
	
	<?php include "includes/header.php"; ?>

	<section id="container">
		
		<div class="data_delete">
			<h5> Seguro de eliminar este Proveedor? </h5>

			<p>Codigo: 					<span> <?php echo $cod_proveedor; ?></span></p>
			<p>Nombre del Proveedor: 	<span> <?php echo $proveedor; ?></span></p>

			<form method="post" action="">
				
				<input type="hidden" name="cod_proveedor" value="<?php echo $cod_proveedor; ?>">
				<input type="submit" value="Aceptar" class="btn_ok">
				<a href="proveedores.php" class="btn_cancel">Cancelar</a>

			</form>

		</div>

	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>