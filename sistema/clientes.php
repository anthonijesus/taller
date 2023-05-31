<?php
      session_start();
        
        include "../conexion.php";

    
        /****ESTE CODIGO REGISTRA LOS CLIENTES****/

      if (isset($_POST['form_Cliente']) && $_POST['form_Cliente'] === 'registro_cliente'){

			if(empty($_POST['nom_ape']) || empty($_POST['direccion']) || empty($_POST['telefono']))
			{
            echo '<script type="text/javascript">
            alert("Complete todos los campos");
            window.location.href="clientes.php";
            </script>';
			}else{

				$CI 		      = $_POST['ci'];
				$nombre 	    = $_POST['nom_ape'];
				$direccion 	  = $_POST['direccion'];
        $telefono 	  = $_POST['telefono'];
				$idusuario    = $_SESSION['username'];


				$result = 0;

				if(is_numeric($CI) || $CI == 0 )
				{
					$query = mysqli_query($conection, "SELECT * FROM cliente WHERE CI = '$CI' ");

					$result = mysqli_fetch_array($query);

				}

				if($result > 0)
				{
					echo '<script type="text/javascript">
            alert("CI o RUT ya existente ");
            window.location.href="clientes.php";
            </script>';
          
				}else{

					$query_insert = mysqli_query($conection, "INSERT INTO cliente(ci,nom_ape,direccion,telefono,username) 
                                                              VALUES('$CI','$nombre','$direccion','$telefono','$idusuario')");

					if($query_insert){
						echo '<script type="text/javascript">
            alert("cliente registrado correctamente");
            window.location.href="clientes.php";
            </script>';	
            
						}else{
							echo '<script type="text/javascript">
            alert("Error al registrar cliente");
            window.location.href="clientes.php";
            </script>';
					}
				}
		
			}

		}
    /****ESTE CODIGO REGISTRA REPARACIONES****/
    if (isset($_POST['form_repa']) && $_POST['form_repa'] === 'registro_repa'){


			if(empty($_POST['modelo']))
			{
            echo '<script type="text/javascript">
            alert("Complete el modelo del equipo");
            window.location.href="clientes.php";
            </script>';
				
			}else{

				$cliente 		    = $_POST['ID_Cliente'];
				$marca 	        = $_POST['marca'];
				$modelo         = $_POST['modelo'];
        $equipo 	      = $_POST['equipo'];
        $des_falla 	    = $_POST['des_falla'];
        $observacion    = $_POST['observacion'];
        $estatus 	      = $_POST['estatus'];
        $fecha   	      = $_POST['fecha'];
				$idusuario      = $_SESSION['username'];

		

					$query_insert = mysqli_query($conection, "INSERT INTO reparaciones(cliente,marca,modelo,equipo,des_falla,observacion,estatus,fecha,username) 
                                                    VALUES('$cliente','$marca','$modelo','$equipo','$des_falla','$observacion','$estatus','$fecha','$idusuario')");

					if($query_insert){
						echo '<script type="text/javascript">
            alert("Reparación registrada correctamente");
            window.location.href="reparaciones.php";
            </script>';	
            
						}else{
							echo '<script type="text/javascript">
            alert("Error al registrar reperación");
            window.location.href="reparaciones.php";
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
        <title>Lista de Clientes</title>
	</head>

	<body>
    <?php include "includes/header.php"; ?>
    
    <section id="container">

      <div class="container-lg">
        <div class="d-flex justify-content-center">
          <div class="usuario-header text-center">
            <h5 class="titulos">Lista de Clientes</h5>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="fa-solid fa-address-card fa-xl"></i>  
            </button>
          </div>
      </div>
<br>

    <!-- Modal de registro de cliente -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-4 mx-auto d-block m-2" id="staticBackdropLabel">Registrar Cliente</h1>
          </div>
       <div class="modal-body">
        <form action="" method="POST">
            <input type="hidden" name="form_Cliente" value="registro_cliente">
            <div class="input-field">
              <label for="ci">CI</label>
              <input name="ci" type="text" class="validate">
            </div>
            <div class="input-field">
              <label for="nombre">Nombre</label>
              <input name="nom_ape" type="text" class="validate" required>
            </div>
            <div class="input-field">
              <label for="direccion">Dirección</label>  
              <input name="direccion" type="text" class="validate" required>
            </div>
            <div class="input-field">
              <label for="telefono">Teléfono</label>
              <input name="telefono" type="text" class="validate" required>
            </div>
              <br>
              <button type="button" class="btn btn-secondary mx-auto d-block m-2 mt-0" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary mx-auto d-block m-2">Registrar</button>
        </form>
       </div> 
     </div>
    </div>
  </div>

    <!-- Modal de registro de Reparacion -->
  <div class="modal fade" id="staticBackdrop-r" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      
      <div class="modal-content">
            <h1 class="modal-title fs-5 mx-auto d-block" id="staticBackdropLabel">Registrar Reparación</h1>

        <form class="modal_form" action="" method="POST">
          <input type="hidden" name="form_repa" value="registro_repa">
          <input type="hidden" id="ID_Cliente" name="ID_Cliente" value="">
      
        <!-- Select Marca -->
        <?php
          $query_marca = mysqli_query($conection, "SELECT * FROM marca ORDER BY marca ASC");
          $result_marca = mysqli_num_rows($query_marca);	
        ?>

      <div>
          <label for="marca">Marca</label>
          <select name="marca" id="marca">
            <?php
              if($result_marca > 0){
                while($marca = mysqli_fetch_array($query_marca)){
            ?>
              <option value="<?php echo $marca['marca']; ?>"><?php echo $marca['marca']; ?></option>
            <?php
                }
              }
            ?>	
          </select>
      </div>
      
      <div class="input-field">
        <label for="modelo">Modelo</label>
        <input name="modelo" type="text" class="validate">
      </div>
      <!-- Select Equipo -->
        <?php
          $query_equipo = mysqli_query($conection, "SELECT id_equipo, equipo
                                                    FROM equipos ORDER BY equipo ASC");
          $result_equipo = mysqli_num_rows($query_equipo);	
        ?>
      <div>
          <label for="equipo">Equipo</label>
          <select name="equipo" id="equipo">
            <?php
              if($result_equipo > 0){
                while($equipo = mysqli_fetch_array($query_equipo)){
            ?>
              <option value="<?php echo $equipo['equipo']; ?>"><?php echo $equipo['equipo']; ?></option>
            <?php
                }
              }
            ?>	
          </select>
      </div>
      
      <!-- Select descripcion -->
        <?php
          $query_desc_falla = mysqli_query($conection, "SELECT * FROM fallas ORDER BY des_falla ASC");
          $result_desc_falla = mysqli_num_rows($query_desc_falla);	
        ?>
      <div>
        <label for="des_falla">Descripcion</label>
        <select name="des_falla" id="des_falla">
          <?php
            if($result_desc_falla > 0){
              while($falla = mysqli_fetch_array($query_desc_falla)){
          ?>
            <option value="<?php echo $falla['des_falla']; ?>"><?php echo $falla['des_falla']; ?></option>
          <?php
              }
            }
          ?>	
        </select>
      </div>
        <div class="input-field">
          <label for="observacion">Observacion</label>
          <input name="observacion" type="text" class="validate">
        </div>
      
        <!-- Select estatus -->
        <?php
          $query_estatus = mysqli_query($conection, "SELECT id_estatus, estatus
                                                    FROM estatus ORDER BY estatus ASC");
          $result_estatus = mysqli_num_rows($query_estatus);	
        ?>
      <div>
      <label for="estatus">Estatus de Reparación</label>
        <select name="estatus" id="estatus">
          <?php
            if($result_estatus > 0){
              while($estatus = mysqli_fetch_array($query_estatus)){
          ?>
            <option value="<?php echo $estatus['estatus']; ?>"><?php echo $estatus['estatus']; ?></option>
          <?php
              }
            }
          ?>	
        </select>
        <div class="input-field">
          <label for="fecha">Fecha</label>
          <input name="fecha" type="date" class="validate">
        </div>
      </div>
          <button type="button" class="btn btn-secondary mx-auto d-block m-2" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary mx-auto d-block m-2">Registrar</button>
    </form>
    </div>
  </div>
</div>

    <table class="table">
      <thead class="table-dark">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">CI</th>
          <th scope="col">Nombre</th>
          <th scope="col">Dirección</th>
          <th scope="col">Teléfono</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
        
      <?php

          $sql_register = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM cliente WHERE estatus = 1");
         
          $result_register = mysqli_fetch_array($sql_register);
          
          $total_registro = $result_register['total_registro'];
          
          $por_pagina = 8;
          
          if (empty($_GET['pagina'])) {
              $pagina = 1;
          } else {
              $pagina = $_GET['pagina'];
          }

          $desde = ($pagina - 1) * $por_pagina;
          
          $total_pagina = ceil($total_registro / $por_pagina);

        /****ESTE CODIGO PHP LISTA LOS CLIENTES****/ 
        $query = mysqli_query($conection,"SELECT * FROM cliente WHERE estatus =1 ORDER BY ID_Cliente LIMIT $desde,$por_pagina");

        $result = mysqli_num_rows($query);
        
        ////***CIERRA LA CONEXION A LA BD*////
			mysqli_close($conection);

        if($result > 0){

            while ($data = mysqli_fetch_array($query)) {

                if($data["CI"] == 0 || $data["CI"] == "")
                {
                    $CI = 'N/A';
                }else{
                    $CI = $data["CI"]; 
                }
      ?>
         <tbody>
            <tr>
              <td><?php echo $data["ID_Cliente"]; ?></td>
              <td><?php echo $CI; ?></td>
              <td><?php echo $data["nom_ape"]; ?></td>
              <td><?php echo $data["direccion"]; ?></td>
              <td><?php echo $data["telefono"]; ?></td>
					
              <td>
              <a class="icon_cli_add_repa" data-bs-toggle="modal" href="#staticBackdrop-r" data-bs-target="#staticBackdrop-r" onclick="abrirModal(<?php echo $data["ID_Cliente"];?>)">
                <i class="fa-sharp fa-solid fa-wrench fa-lg"></i>
              </a>
                <a class="msj_edit tooltipped" data-position="bottom" data-tooltip="Editar" href="editar_cliente.php?id=<?php echo $data["ID_Cliente"];?>">
                  <span class="fa-solid fa-user-pen"></span>
                </a>
                <?php 
                  if($_SESSION['rol'] == 1){
                ?>
                <a class="icon_delete" href="eliminar_cliente.php?id=<?php echo $data["ID_Cliente"];?>">
                  <i class="fa-solid fa-trash"></i>
                </a>
                <?php } ?>
              </td>
					</tr>
        </tbody>
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
                  << </a>
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
</html>
