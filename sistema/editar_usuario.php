<?php

/***CON ESTE CODIGO VALIDAMOS QUE EL USUARIO LOGEADO NO TENGA ACCESO A LAS FUNCIONES DE ADMINISTRADOR*/
session_start();

if ($_SESSION['rol'] != 1) {

	header("location: ./");
}
///**********///

include "../conexion.php";

if (!empty($_POST)) {

	$alert = '';

	if (empty($_POST['nombre']) || empty($_POST['username'])) {
		
		echo '<script type="text/javascript">
            alert("Complete todos los campos");
            window.location.href="usuarios.php";
            </script>';

	} else {

		$idusuario 		= $_POST['id'];
		$nombre 		= $_POST['nombre'];
		$username 		= $_POST['username'];
		$password 		= md5($_POST['password']);
		$rol 			= $_POST['rol'];


		/* Validamos que el usuario no exista */
		$query_user = mysqli_query($conection, "SELECT * FROM usuarios 
														 WHERE (username = '$username' AND idusuario != $idusuario) ");


		$result_user = mysqli_fetch_array($query_user);

		if ($result_user > 0) {

			echo '<script type="text/javascript">
            alert("Usuario ya existente");
            window.location.href="usuarios.php";
            </script>';	
			

		} else {
			if (empty($_POST['clave'])) {
				$sql_update = mysqli_query($conection, "UPDATE usuarios
														SET nombre = '$nombre', username = '$username', rol = '$rol' 
														WHERE idusuario = $idusuario");
			} else {
				$sql_update = mysqli_query($conection, "UPDATE usuarios
																	   SET nombre  = '$nombre', username  = '$username', password = '$password', rol = '$rol' 
																	   WHERE idusuario = $idusuario");

			}

			if ($sql_update) {

				echo '<script type="text/javascript">
            alert("Usuario actualizado correctamente");
            window.location.href="usuarios.php";
            </script>';	

			} else {

				echo '<script type="text/javascript">
            alert("Error al actualizar usuario");
            window.location.href="usuarios.php";
            </script>';	
			}
		}
	}
}

//Cargar datos en formulario de edición//

if (empty($_REQUEST['id'])) {
	header('location: usuarios.php');

	////***CIERRA LA CONEXION A LA BD*////
	mysqli_close($conection);
}

$iduser = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT u.idusuario,u.nombre,u.username,(u.rol) AS idrol,
						    (r.rol) AS rol 
							FROM usuarios u
							INNER JOIN rol r
							ON u.rol = r.idrol
							WHERE idusuario= $iduser and estatus = 1");

////***CIERRA LA CONEXION A LA BD*////
mysqli_close($conection);

$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {

	header('location: usuarios.php');
} else {

	$option = '';
	while ($data = mysqli_fetch_array($sql)) {

		$iduser 		= $data['idusuario'];
		$nombre 		= $data['nombre'];
		$username 		= $data['username'];
		$idrol 			= $data['idrol'];
		$rol 			= $data['rol'];

		/////Coloca tipo de ROL en el Formulario///////

		if ($idrol == 1) {
			$option = '<option value="' . $idrol . '" select>' . $rol . '</option>';
		} else if ($idrol == 2) {
			$option = '<option value="' . $idrol . '" select>' . $rol . '</option>';
		} else if ($idrol == 3) {
			$option = '<option value="' . $idrol . '" select>' . $rol . '</option>';
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
	<title>Editar Usuario</title>
</head>

<body>

	<?php include "includes/header.php"; ?>

	<section id="container" class="container">

		<div class="form_register">

			<h5>Editar Usuario</h5>
			<hr>
			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo $iduser; ?>">
					<div>
						<label for="nombre">Nombre</label>
						<input type="text" name="nombre" id="nombre" placeholder="Nombre Completo"
							value="<?php echo $nombre; ?>">
					</div>
					<div>
						<label for="username">Nombre de usuario</label>
						<input type="text" name="username" id="username" placeholder="Nombre de Usuario"
							value="<?php echo $username; ?>">
					</div>
					<div>
						<label for="password">Clave</label>
						<input type="password" name="password" id="password" placeholder="clave de acceso">
					</div>
					<div>
						<label for="rol">Tipo Usuario</label>
						<select name="rol" id="rol">
							<?php
							include "../conexion.php";
							$query_rol = mysqli_query($conection, "SELECT * FROM rol");
							mysqli_close($conection);

							$result_rol = mysqli_num_rows($query_rol);

							if ($result_rol > 0) {
								while ($rol = mysqli_fetch_array($query_rol)) {
									?>
									<option value="<?php echo $rol["idrol"]; ?>" <?php if ($rol['idrol'] == $idrol) {
										   echo 'selected';
									   } ?>><?php echo $rol["rol"]; ?></option>
									<?php
								}
							}
							?>
						</select>
					</div>
				<div>
					<br>
					<div>
						<input type="submit" value="Editar Usuario" class="btn btn-primary">
					</div>
				</div>
			</form>
		</div>
	</section>

	<?php include "includes/footer.php"; ?>
</body>

</html>