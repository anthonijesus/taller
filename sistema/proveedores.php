<?php

session_start();

include "../conexion.php";

/****ESTE CODIGO REGISTRA LOS PROVEEDORES****/
if (!empty($_POST)) {


	if (empty($_POST['proveedor']) || empty($_POST['per_contacto']) || empty($_POST['telefono']) || empty($_POST['direccion'])) {
		echo '<script type="text/javascript">
		alert("Complete todos los campos");
		window.location.href="proveedores.php";
		</script>';

	} else {

		$proveedor = $_POST['proveedor'];
		$per_contacto = $_POST['per_contacto'];
		$telefono = $_POST['telefono'];
		$direccion = $_POST['direccion'];
		$idusuario = $_SESSION['idusuario'];

		$result = 0;


		$query_insert = mysqli_query($conection, "INSERT INTO proveedor(proveedor,per_contacto,telefono,direccion,id_usuario) 
													VALUES('$proveedor','$per_contacto','$telefono','$direccion','$idusuario')");

		if ($query_insert) {
			echo '<script type="text/javascript">
							alert("Proveedor registrado correctamente");
							window.location.href="proveedores.php";
							</script>';

		} else {
			echo '<script type="text/javascript">
							alert("Error al registrar Proveedor");
							window.location.href="proveedores.php";
							</script>';
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
	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Lista Proveedores</title>

</head>

<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<div class="container">

			<div class="usuario-header">
				<h5 class="titulos_prov">Lista de Proveedores</h5>
				<a href="#modal-formulario" class="modal-trigger msj_reparacion tooltipped" data-position="bottom"
					data-tooltip="Agregar Proveedor">
					<i class="Small material-icons">group_add</i>
				</a>
			</div>

			<!-- Modal de registro de Proveedor -->
			<div id="modal-formulario" class="modal modal-fixed-footer">
				<div class="modal-content">
					<h5>Registro de Proveedor</h5>

					<form action="" method="POST">
						<div class="input-field">
							<input name="proveedor" type="text" class="validate">
							<label for="proveedor">Nombre Proveedor</label>
						</div>
						<div class="input-field">
							<input name="per_contacto" type="text" class="validate">
							<label for="per_contacto">Persona de Contacto</label>
						</div>
						<div class="input-field">
							<input name="telefono" type="text" class="validate">
							<label for="telefono">Teléfono</label>
						</div>
						<div class="input-field">
							<input name="direccion" type="text" class="validate">
							<label for="direccion">Dirección</label>
						</div>
						<button type="submit" class="waves-effect waves-light btn">Registrar</button>
					</form>
				</div>
			</div>

			<table class="striped">
				<thead>
					<tr>
						<th>Codigo</th>
						<th>Nombre Proveedor</th>
						<th>Persona de Contacto</th>
						<th>Teléfono</th>
						<th>Dirección</th>
						<th>Usuario que Registró</th>
						<th>Fecha Registro</th>
						<th>Acciones</th>
					</tr>
				</thead>

				<?php
				/*PAGINADOR*/
				$sql_register = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM proveedor WHERE estatus = 1");
				$result_register = mysqli_fetch_array($sql_register);
				$total_registro = $result_register['total_registro'];
				$por_pagina = 10;
				if (empty($_GET['pagina'])) {
					$pagina = 1;
				} else {
					$pagina = $_GET['pagina'];
				}
				$desde = ($pagina - 1) * $por_pagina;
				$total_pagina = ceil($total_registro / $por_pagina);
				/*********************/
				$query = mysqli_query($conection, "SELECT p.cod_proveedor, p.proveedor, p.per_contacto, p.telefono, p.direccion, p.id_usuario, u.username, p.date_add
										FROM proveedor p
										INNER JOIN usuarios u ON p.id_usuario  = u.idusuario
										WHERE p.estatus =1 ORDER BY p.proveedor ASC LIMIT $desde,$por_pagina");
				$result = mysqli_num_rows($query);

				////***CIERRA LA CONEXION A LA BD*////
				mysqli_close($conection);

				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)) {

						$formato = 'Y-m-d H:i:s';
						$fecha = DateTime::createFromFormat($formato, $data["date_add"])
							?>
						<tr>
							<td>
								<?php echo $data['cod_proveedor']; ?>
							</td>
							<td>
								<?php echo $data['proveedor']; ?>
							</td>
							<td>
								<?php echo $data['per_contacto']; ?>
							</td>
							<td>
								<?php echo $data['telefono']; ?>
							</td>
							<td>
								<?php echo $data['direccion']; ?>
							</td>
							<td>
								<?php echo $data['username']; ?>
							</td>
							<td>
								<?php echo $fecha->format('d-m-Y'); ?>
							</td>
							<td>
								<a class="msj_edit tooltipped" data-position="bottom" data-tooltip="Editar"
									href="editar_proveedor.php?id=<?php echo $data["cod_proveedor"]; ?>">
									<i class="Small material-icons">mode_edit</i>
								</a>

								<?php
								if ($_SESSION['rol'] == 1) {
									?>

									<a class="msj_delete tooltipped" data-position="bottom" data-tooltip="Borrar"
										href="eliminar_proveedor.php?id=<?php echo $data["cod_proveedor"]; ?>">
										<i class="Small material-icons">delete</i>
									</a>
									<?php
								}
								?>
							</td>
						</tr>
						<?php
					}
				}
				?>
			</table>

			<div class="paginador">

				<ul>
					<?php
					if ($pagina != 1) {
						?>

						<li><a href="?pagina=<?php echo 1; ?>">|<< </a>
						</li>
						<li><a href="?pagina=<?php echo $pagina - 1; ?>">
								<<< </a>
						</li>
						<?php
					}
					for ($i = 1; $i <= $total_pagina; $i++) {

						if ($i == $pagina) {
							echo '<li class="pageSelected">' . $i . '</li>';
						} else {
							echo '<li><a href="?pagina=' . $i . '">' . $i . '</a></li>';
						}
					}

					if ($pagina != $total_pagina) {
						?>

						<li><a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
						<li><a href="?pagina=<?php echo $total_pagina; ?>">>|</a></li>
					<?php } ?>

				</ul>
			</div>
		</div>
	</section>
	<?php include "includes/footer.php"; ?>
</body>