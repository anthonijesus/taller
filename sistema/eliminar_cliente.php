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
		
	
		$ID_Cliente = $_POST['ID_Cliente'];
		
		$query_delete = mysqli_query($conection,"UPDATE cliente SET estatus = 0 WHERE ID_Cliente =$ID_Cliente");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);

		if($query_delete)
		{
			echo '<script type="text/javascript">
            alert("Cliente eliminado");
            window.location.href="clientes.php";
            </script>';
		}else{
			echo '<script type="text/javascript">
            alert("Error al eliminar cliente");
            window.location.href="clientes.php";
            </script>';
		}

	}

	/****** Validacion del ID cuando hacemos clic en el boton eliminar *//////

	if(empty($_REQUEST['id'])) {
		
		header("location: clientes.php");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);
	}else{

		$ID_Cliente = $_REQUEST['id'];

		$query = mysqli_query($conection, "SELECT * FROM cliente WHERE ID_Cliente = $ID_Cliente and estatus = 1");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);

		$result = mysqli_num_rows($query);

		if($result > 0){

			while ($data = mysqli_fetch_array($query)) {
				
				$ID_Cliente 	    = $data['ID_Cliente'];
				$CI 	        	= $data['CI'];
				$nom_ape 			= $data['nom_ape'];
                $direccion 		    = $data['direccion'];
				}
			}else{

				header("location: clientes.php");
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<?php include "includes/functions.php"; ?>
	<title>Eliminar Cliente</title>

</head>
<body>
	
	<?php include "includes/header.php"; ?>

	<section id="container">
		
		<div class="data_delete">
			<h5> Seguro de eliminar este Cliente? </h5>

			<p>Cedula: 					<span> <?php echo $CI; ?></span></p>
			<p>Nombre y Apellido: 		<span> <?php echo $nom_ape; ?></span></p>
			<p>Direccion: 	            <span> <?php echo $direccion; ?></span></p>

			<form method="post" action="">
				
				<input type="hidden" name="ID_Cliente" value="<?php echo $ID_Cliente; ?>">
				<input type="submit" value="Aceptar" class="btn_ok">
				<a href="clientes.php" class="btn_cancel">Cancelar</a>

			</form>

		</div>

	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>