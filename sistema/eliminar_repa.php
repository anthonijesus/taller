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
		
        /*****************************/
		
		$id_rep = $_POST['id_rep'];
		
		$query_delete = mysqli_query($conection,"UPDATE reparaciones SET rep_act = 0 WHERE id_rep =$id_rep");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);

		if($query_delete)
		{
			header("location: reparaciones.php");
		}else{
			echo '<script type="text/javascript">
            alert("Error al eliminar Reparación");
            window.location.href="reparaciones.php";
            </script>';
		}

	}

	/****** Validacion del ID cuando hacemos clic en el boton eliminar *//////

	if(empty($_REQUEST['id'])) {
		
		header("location: reparaciones.php");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);
	}else{

		$id_rep = $_REQUEST['id'];

		$query = mysqli_query($conection, "SELECT * FROM reparaciones WHERE id_rep = $id_rep and rep_act = 1");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);

		$result = mysqli_num_rows($query);

		if($result > 0){

			while ($data = mysqli_fetch_array($query)) {
				
				$id_rep 	    = $data['id_rep'];
				$marca 	        = $data['marca'];
				$modelo 		= $data['modelo'];
                $des_falla 		= $data['des_falla'];
				}
			}else{

				header("location: reparaciones.php");
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<?php include "includes/functions.php"; ?>
	<title>Eliminar Reparación</title>

</head>
<body>
	
	<?php include "includes/header.php"; ?>

	<section id="container">
		
		<div class="data_delete">
			<h5> Seguro de eliminar esta Reparación? </h5>
			<p>ID: 				    <span> <?php echo $id_rep; ?></span></p>
			<p>Marca: 			    <span> <?php echo $marca; ?></span></p>
			<p>Modelo: 	            <span> <?php echo $modelo; ?></span></p>
            <p>Descripción: 	    <span> <?php echo $des_falla; ?></span></p>

			<form method="post" action="">
				
				<input type="hidden" name="id_rep" value="<?php echo $id_rep; ?>">
				<input type="submit" value="Aceptar" class="btn_ok">
				<a href="reparaciones.php" class="btn_cancel">Cancelar</a>

			</form>

		</div>

	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>