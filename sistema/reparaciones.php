<?php
/***CON ESTE CODIGO VALIDAMOS QUE EL USUARIO LOGEADO NO TENGA ACCESO A LAS FUNCIONES DE ADMINISTRADOR*/
session_start();

include "../conexion.php";

/****ESTE CODIGO REGISTRA REPARACIONES****/
if (isset($_POST['form_Cliente']) && $_POST['form_Cliente'] === 'registro_cliente') {

  if (empty($_POST['modelo'])) {
    echo '<script type="text/javascript">
        alert("Complete el modelo del equipo");
        window.location.href="reparaciones.php";
        </script>';

  } else {

    $cliente          = $_POST['ID_Cliente'];
    $marca            = $_POST['marca'];
    $modelo           = $_POST['modelo'];
    $equipo           = $_POST['equipo'];
    $des_falla        = $_POST['des_falla'];
    $observacion      = $_POST['observacion'];
    $fecha            = $_POST['fecha'];
    $estatus          = $_POST['estatus'];
    $idusuario        = $_SESSION['username'];



    $query_insert = mysqli_query($conection, "INSERT INTO reparaciones(cliente,marca,modelo,equipo,des_falla,observacion,fecha,estatus,username) 
                                                VALUES('$cliente','$marca','$modelo','$equipo','$des_falla','$observacion','$fecha','$estatus','$idusuario')");

    if ($query_insert) {
      echo '<script type="text/javascript">
        alert("Reparación registrada correctamente");
        window.location.href="reparaciones.php";
        </script>';

    } else {
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
  <title>Lista Reparaciones</title>
</head>

<body>

  <?php include "includes/header.php"; ?>

  <section id="container">

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Registrar Reparación</h1>
          </div>
          <div class="modal-body">

            <form action="" method="POST">
              <input type="hidden" name="form_Cliente" value="registro_cliente">

              <!-- Select Cliente -->
              <?php
              $query_cliente = mysqli_query($conection, "SELECT * FROM cliente ORDER BY nom_ape ASC");
              $result_cliente = mysqli_num_rows($query_cliente);
              ?>

              <div>
                <label for="cliente">Cliente</label>
                <select name="ID_Cliente" id="ID_Cliente">
                  <?php
                  if ($result_cliente > 0) {
                    while ($cliente = mysqli_fetch_array($query_cliente)) {
                      ?>
                      <option value="<?php echo $cliente['ID_Cliente']; ?>"><?php echo $cliente['nom_ape']; ?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <!-- Select Marca -->
              <?php
              $query_marca = mysqli_query($conection, "SELECT * FROM marca ORDER BY marca ASC");
              $result_marca = mysqli_num_rows($query_marca);
              ?>

              <div>
                <label for="marca">Marca</label>
                <select name="marca" id="marca">
                  <?php
                  if ($result_marca > 0) {
                    while ($marca = mysqli_fetch_array($query_marca)) {
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
                <input name="modelo" type="text" class="validate" required>
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
                  if ($result_equipo > 0) {
                    while ($equipo = mysqli_fetch_array($query_equipo)) {
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
                  if ($result_desc_falla > 0) {
                    while ($falla = mysqli_fetch_array($query_desc_falla)) {
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
              <div class="input-field">
                <label for="fecha">Fecha</label>
                <input name="fecha" type="date" class="validate">
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
                  if ($result_estatus > 0) {
                    while ($estatus = mysqli_fetch_array($query_estatus)) {
                      ?>
                      <option value="<?php echo $estatus['estatus']; ?>"><?php echo $estatus['estatus']; ?></option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>
              <br>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary">Registrar</button>

            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="container-lg">
      <div class="d-flex justify-content-center">
        <div class="usuario-header text-center">
          <h5 class="titulos">Lista de Reparaciones</h5>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="fa-sharp fa-solid fa-wrench fa-lg"></i>
          </button>
        </div>
      </div>
      <br>
      <table class="table">
        <thead class="table-dark">
          <tr>
            <th>id_rep</th>
            <th>Cliente</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Equipo</th>
            <th>Descripción de Falla</th>
            <th>Fecha</th>
            <th>Observacion</th>
            <th>Usuario</th>
            <th>Estatus</th>
            <th>Acciones</th>
          </tr>
        </thead>

        <?php

        /*PAGINADOR*/
        $sql_register = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM reparaciones
                                                          WHERE rep_act = 1 AND estatus != 'Facturado'");

        $result_register = mysqli_fetch_array($sql_register);

        $total_registro = $result_register['total_registro'];

        $por_pagina = 20;

        if (empty($_GET['pagina'])) {
          $pagina = 1;
        } else {
          $pagina = $_GET['pagina'];
        }

        $desde = ($pagina - 1) * $por_pagina;

        $total_pagina = ceil($total_registro / $por_pagina);

        /*********************/

        /*******LISTA USUARIOS********/
        $query = mysqli_query($conection, "SELECT r.id_rep, c.nom_ape, r.marca, r.modelo, r.equipo, r.des_falla, r.fecha, r.observacion, u.username, r.estatus
                                            FROM reparaciones r 
                                            INNER JOIN cliente c ON r.cliente = c.ID_Cliente
                                            INNER JOIN usuarios u ON r.username = u.username   
                                            WHERE rep_act = 1 AND r.estatus != 'Facturado'
                                            ORDER BY r.fecha 
                                            LIMIT $desde,$por_pagina");

        $result = mysqli_num_rows($query);

        ////***CIERRA LA CONEXION A LA BD*////
        mysqli_close($conection);


        if ($result > 0) {

          while ($data = mysqli_fetch_array($query)) {


        ?>

            <tbody>
              <tr>
                <td><?php echo $data["id_rep"]; ?></td>
                <td><?php echo $data["nom_ape"]; ?></td>
                <td><?php echo $data["marca"]; ?></td>
                <td><?php echo $data["modelo"]; ?></td>
                <td><?php echo $data["equipo"]; ?></td>
                <td><?php echo $data["des_falla"]; ?></td>
                <td><?php echo $data["fecha"];?></td>
                <td><?php echo $data["observacion"]; ?></td>
                <td><?php echo $data["username"]; ?></td>
                <td><?php echo $data["estatus"]; ?></td> 

                <!--ACCIONES -->
                <td class="acciones">
                  <div class="dropdown">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Acciones
                    </button>
                    <ul class="dropdown-menu">
                      <?php
                        if ($data['estatus'] != 'Facturado') {
                      ?>
                        <a href="facturar.php?id=<?php echo $data["id_rep"]; ?>" class="dropdown-item">
                          FACTURAR
                        </a>
                      <?php } ?>

                      <?php
                        if ($data['estatus'] != 'Facturado' & $_SESSION['rol'] == 1) {
                      ?>
                      <a class="dropdown-item" href="editar_repa.php?id=<?php echo $data["id_rep"];?>">
                        EDITAR
                      </a>
                      <?php } ?>

                      <?php
                        if ($_SESSION['rol'] == 1 & $data['estatus'] != 'Facturado') {
                      ?>
                        <a class="dropdown-item" href="eliminar_repa.php?id=<?php echo $data["id_rep"]; ?>">
                          BORRAR
                        </a>
                      <?php } ?>
                    </ul>
                  </div>
                </td>
                <!--CIERRE ACCIONES -->
              </tr>
            </tbody>
            <?php
          }
        }
        ?>
      </table>

      <!-- PAGINADOR -->
      <div class="paginador">

        <ul>
          <?php
          if ($pagina != 1) {
            ?>

            <li><a href="?pagina=<?php echo 1; ?>">|<< </a></li>
            <li><a href="?pagina=<?php echo $pagina - 1; ?>"><< </a></li>
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