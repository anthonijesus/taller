<?php 


	$alert = '';

	session_start();

	if(!empty($_SESSION['active']))
	{
	header('location: sistema/');	
	}else{

	if(!empty($_POST))
	{
		if(empty($_POST['usuario']) || empty($_POST['clave']))
		{
			$alert = 'Ingrese usuario y clave';

		}else{
			
			require_once "conexion.php";

			$user = mysqli_real_escape_string ($conection, $_POST['usuario']);
			$pass = md5(mysqli_real_escape_string ($conection, $_POST['clave']));

			$query = mysqli_query($conection, "SELECT * FROM usuarios WHERE username='$user' AND password = '$pass'");
			
			/***CIERRA LA CONEXION A LA bd*////
			mysqli_close($conection);

			$result = mysqli_num_rows($query);

			if($result > 0)
			{
				$data = mysqli_fetch_array($query);

				$_SESSION['active'] 		= true;
				$_SESSION['idusuario'] 		= $data['idusuario'];
				$_SESSION['nombre'] 		= $data['nombre'];
				$_SESSION['username']		= $data['username'];
				$_SESSION['password'] 		= $data['password'];
				$_SESSION['rol'] 			= $data['rol'];

				header('location: sistema/');
			}else{
				$alert = 'Usuario y clave incorrectos';
				session_destroy();
			}
		}
	}
}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Inicio de sesión</title>
	<style>
		body {
			background-size: cover;
			background-position: center;
			font-family: Arial, sans-serif;
			color: #333;
		}
		form {
			max-width: 400px;
			margin: 80px auto 0;
			padding: 20px;
			background-color: #fff;
			box-shadow: 0 0 10px rgba(0,0,0,0.3);
			border-radius: 10px;
			text-align: center;
		}
		input[type="text"], input[type="password"] {
			display: block;
			width: 100%;
			padding: 10px;
			margin-bottom: 20px;
			border-radius: 5px;
			border: 1px solid #ccc;
			box-sizing: border-box;
			font-size: 16px;
		}
		input[type="submit"] {
			background-color: #4CAF50;
			color: #fff;
			padding: 10px 20px;
			border: none;
			border-radius: 5px;
			cursor: pointer;
			font-size: 16px;
		}
		.alert{
    		width: 50%;
    		background: #c6e07d66;
    		border-radius: 15px;
    		margin: 30px 0;
    		text-align: center;
			}

	</style>
</head>
<body>
	<form action="" method="post">
				<img src="img/login.png" width= 120px>
		<h2>Iniciar sesión</h2>
		<br>
		<label for="username">Nombre de usuario:</label>
		<input type="text" id="usuario" name="usuario">
		<label for="password">Clave:</label>
		<input type="password" id="clave" name="clave">
		<div class="alert"> <?php echo isset($alert) ? $alert : ''; ?></div>
		<input type="submit" value="Iniciar sesión">
	</form>
</body>
</html>
