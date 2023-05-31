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
		/*Evalua que el id usuario enviado por POST no sea el administrador*/
		
		if($_POST['idusuario'] == 1){
		header("location: usuarios.php");
		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);

		exit;
		}

		/*****************************/
		
		$idusuario = $_POST['idusuario'];

		/*$query_delete = mysqli_query($conection,"DELETE FROM usuario WHERE idusuario =$idusuario");*/

		$query_delete = mysqli_query($conection,"UPDATE usuarios SET estatus = 0 WHERE idusuario =$idusuario");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);

		if($query_delete)
		{
			header("location: usuarios.php");
		}else{
			echo '<script type="text/javascript">
            alert("Error al eliminar Usuario");
            window.location.href="usuarios.php";
            </script>';
		}

	}

	/****** Validacion del ID cuando hacemos clic en el boton eliminar *//////

	if(empty($_REQUEST['id']) || $_REQUEST['id'] == 1) {
		
		header("location: usuarios.php");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);
	}else{

		$idusuario = $_REQUEST['id'];

		$query = mysqli_query($conection, "SELECT u.nombre,u.username,r.rol
											FROM usuarios u
											INNER JOIN rol r
											ON u.rol = r.idrol
											WHERE u.idusuario = $idusuario and estatus = 1");

		////***CIERRA LA CONEXION A LA BD***///
		mysqli_close($conection);

		$result = mysqli_num_rows($query);

		if($result > 0){

			while ($data = mysqli_fetch_array($query)) {
				
				$nombre 	= $data['nombre'];
				$username 	= $data['username'];
				$rol 		= $data['rol'];
				}
			}else{

				header("location: usuarios.php");
		}
	}



 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<?php include "includes/functions.php"; ?>
	<title>Eliminar Usuario</title>

</head>
<body>
	
	<?php include "includes/header.php"; ?>

	<section id="container">
		
		<div class="data_delete">
			<h5> Seguro de eliminar el usuario? </h5>
			<p>Nombre: 				<span> <?php echo $nombre; ?></span></p>
			<p>Usuario: 			<span> <?php echo $username; ?></span></p>
			<p>Tipo de usuario: 	<span> <?php echo $rol; ?></span></p>

			<form method="post" action="">
				
				<input type="hidden" name="idusuario" value="<?php echo $idusuario; ?>">
				<input type="submit" value="Aceptar" class="btn_ok">
				<a href="usuarios.php" class="btn_cancel">Cancelar</a>

			</form>

		</div>



	</section>

	<?php include "includes/footer.php"; ?>
</body>
</html>