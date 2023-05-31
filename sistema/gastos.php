<?php

session_start();

include "../conexion.php";

/****ESTE CODIGO REGISTRA LOS GASTOS****/
if (!empty($_POST)) {


	if (empty($_POST['nro_fact_gasto']) || empty($_POST['descripcion']) || empty($_POST['monto']) || empty($_POST['proveedor'])) {
		echo '<script type="text/javascript">
		alert("Complete todos los campos");
		window.location.href="gastos.php";
		</script>';

	} else {

		$nro_fact_gasto = $_POST['nro_fact_gasto'];
		$descripcion 	= $_POST['descripcion'];
		$monto 			= $_POST['monto'];
		$proveedor 		= $_POST['proveedor'];
		$idusuario 		= $_SESSION['idusuario'];

		$query_insert = mysqli_query($conection, "INSERT INTO gastos(nro_fact_gasto,descripcion,monto,proveedor,id_usuario) 
													VALUES('$nro_fact_gasto','$descripcion','$monto','$proveedor','$idusuario')");

		if ($query_insert) {
			echo '<script type="text/javascript">
							alert("Gasto registrado correctamente");
							window.location.href="gastos.php";
							</script>';

		} else {
			echo '<script type="text/javascript">
							alert("Error al registrar Gasto");
							window.location.href="gastos.php";
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
	<title>Lista de Gastos</title>

</head>

<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<div class="container">

			<div class="d-flex justify-content-center">
				<div class="usuario-header text-center">
					<h5 class="titulos">Lista de Gastos</h5>
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
					<i class="fa-solid fa-money-bill-transfer fa-lg"></i>
					</button>
				</div>
			</div>

			<!-- Modal de registro de Gastos -->
			<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      			 aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog">
				  <div class="modal-content">
          			<div class="modal-header">
					  <h1 class="modal-title fs-4 mx-auto d-block m-2" id="staticBackdropLabel">Registrar Gasto</h1>
					</div>
					<div class="modal-body">
					<form action="" method="POST">
						<div class="input-field">
							<label for="nro_fact_gasto">Número de Factura</label>
							<input name="nro_fact_gasto" type="text" class="validate">
						</div>
						<div class="input-field">
							<label for="descripcion">Descripción</label>
							<input name="descripcion" type="text" class="validate">
						</div>
						<div class="input-field">
							<label for="monto">Monto</label>
							<input name="monto" type="text" class="validate">
						</div>
						<!-- Select Proveedor -->
						<?php
						$query_marca = mysqli_query($conection, "SELECT cod_proveedor, proveedor FROM proveedor
						WHERE estatus = 1 ORDER BY proveedor ASC");
						$result_marca = mysqli_num_rows($query_marca);
						?>

						<div>
							<label for="proveedor">Proveedor</label>
							<select name="proveedor" id="proveedor">
								<?php
								if ($result_marca > 0) {
									while ($proveedor = mysqli_fetch_array($query_marca)) {
										?>
										<option value="<?php echo $proveedor['cod_proveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
										<?php
									}
								}
								?>
							</select>
						</div>
						<br>
						<button type="button" class="btn btn-secondary mx-auto d-block m-2 mt-0" data-bs-dismiss="modal">Cerrar</button>
              			<button type="submit" class="btn btn-primary mx-auto d-block m-2">Registrar</button>
					</form>
				   </div>
				 </div>
				</div>
			</div>

			<table class="table">
				<thead class="table-dark">
					<tr>
						<th>Codigo</th>
						<th>Número de Factura</th>
						<th>Fecha Registro</th>
						<th>Descripción del Gasto</th>
						<th>Monto</th>
						<th>Proveedor</th>
						<th>Usuario que Registró</th>
						<th>Acciones</th>
					</tr>
				</thead>

				<?php
				/*PAGINADOR*/
				$sql_register = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM gastos WHERE estatus = 1");
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
				$query = mysqli_query($conection, "SELECT g.cod_gasto, g.nro_fact_gasto, g.fecha, g.descripcion, g.monto, p.proveedor, u.username
				FROM gastos g
				INNER JOIN proveedor p ON p.cod_proveedor  = g.proveedor
				INNER JOIN usuarios u ON p.id_usuario  = u.idusuario
				WHERE g.estatus = 1 ORDER BY g.fecha LIMIT $desde,$por_pagina
				");
				$result = mysqli_num_rows($query);

				////***CIERRA LA CONEXION A LA BD*////
				mysqli_close($conection);

				if ($result > 0) {

					$total = 0;

					while ($data = mysqli_fetch_array($query)) {

						
							?>
						<tr>
							<td>
								<?php echo $data['cod_gasto']; ?>
							</td>
							<td>
								<?php echo $data['nro_fact_gasto']; ?>
							</td>
							<td>
								<?php echo $data['fecha']; ?>
							</td>
							<td>
								<?php echo $data['descripcion']; ?>
							</td>
							<td>
								<?php echo $data['monto']; ?>
							</td>
							<td>
								<?php echo $data['proveedor']; ?>
							</td>
							<td>
								<?php echo $data['username']; ?>
							</td>
							<?php
                        		$total += $data["monto"]; // Suma el monto de la factura a la variable $total
                    		?>
							<td>
								<a class="msj_edit" href="editar_gasto.php?id=<?php echo $data["cod_gasto"]; ?>">
									<span class="fa-solid fa-user-pen"></span>
								</a>

								<?php
								if ($_SESSION['rol'] == 1) {
									?>

									<a class="icon_delete" href="eliminar_gasto.php?id=<?php echo $data["cod_gasto"]; ?>">
										<i class="fa-solid fa-trash"></i>
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
				<tfoot class="tfoot">
                    <tr class="tfoot">
                        <td>Total</td>
                        <td colspan="3"></td>
                        <td><?php echo $total; ?></td>
                        <td></td>
                    </tr>
             </tfoot>
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