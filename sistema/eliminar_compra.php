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
		
	
		$cod_compra = $_POST['cod_compra'];
		
		$query_delete = mysqli_query($conection,"UPDATE compras SET estatus = 0 WHERE cod_compra =$cod_compra");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);

		if($query_delete)
		{
			echo '<script type="text/javascript">
            alert("Compra eliminada");
            window.location.href="compras.php";
            </script>';
		}else{
			echo '<script type="text/javascript">
            alert("Error al eliminar Compra");
            window.location.href="compras.php";
            </script>';
		}

	}

	/****** Validacion del ID cuando hacemos clic en el boton eliminar *//////

	if(empty($_REQUEST['id'])) {
		
		header("location: compras.php");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);
	}else{

		$cod_compra = $_REQUEST['id'];

		$query = mysqli_query($conection, "SELECT c.cod_compra, c.nro_fact, c.descripcion, p.proveedor, c.precio
                                           FROM compras c
                                           INNER JOIN proveedor p ON c.proveedor = p.cod_proveedor
                                           WHERE cod_compra = $cod_compra and c.estatus = 1");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);

		$result = mysqli_num_rows($query);

		if($result > 0){

			while ($data = mysqli_fetch_array($query)) {
				
				$cod_compra 	    = $data['cod_compra'];
				$nro_fact 	        = $data['nro_fact'];
				$descripcion 		= $data['descripcion'];
                $proveedor 		    = $data['proveedor'];
                $precio 		    = $data['precio'];
				}
			}else{

				header("location: compras.php");
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<?php include "includes/functions.php"; ?>
	<title>Eliminar Compra</title>

</head>
<body>
	
	<?php include "includes/header.php"; ?>

	<section id="container">
		
		<div class="data_delete">
			<h5> Seguro de eliminar esta Compra? </h5>

			<p>Nro. de factura: 		<span> <?php echo $nro_fact; ?></span></p>
			<p>Descripción: 			<span> <?php echo $descripcion; ?></span></p>
			<p>proveedor: 	            <span> <?php echo $proveedor; ?></span></p>
            <p>Precio: 	                <span> <?php echo $precio; ?></span></p>

			<form method="post" action="">
				
				<input type="hidden" name="cod_compra" value="<?php echo $cod_compra; ?>">
				<input type="submit" value="Aceptar" class="btn_ok">
				<a href="compras.php" class="btn_cancel">Cancelar</a>

			</form>

		</div>

	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>