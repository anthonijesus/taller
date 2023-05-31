<?php

session_start();

include "../conexion.php";

/****ESTE CODIGO REGISTRA COMPRAS****/
if (!empty($_POST)) {
  if (empty($_POST['nro_fact']) || empty($_POST['descripcion']) || empty($_POST['precio'])) {
    echo '<script type="text/javascript">
    alert("Complete todos los campos");
    window.location.href="compras.php";
    </script>';
  } else {

    $nro_fact = $_POST['nro_fact'];
    $descripcion = $_POST['descripcion'];
    $proveedor = $_POST['proveedor'];
    $precio = $_POST['precio'];
    $fecha = $_POST['fecha'];
    $idusuario = $_SESSION['username'];



    $query_insert = mysqli_query($conection, "INSERT INTO compras(nro_fact,descripcion,proveedor,precio,fecha,username) 
                                                      VALUES('$nro_fact','$descripcion','$proveedor','$precio','$fecha','$idusuario')");

    if ($query_insert) {
      echo '<script type="text/javascript">
                alert("Compra registrada correctamente");
                window.location.href="compras.php";
                </script>';

    } else {
      echo '<script type="text/javascript">
                    alert("Error al registrar Compra");
                    window.location.href="compras.php";
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
  <title>Compras</title>

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
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Registrar Compra</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body">

            <form action="" method="POST">

              <div class="input-field">
                <label for="nro_fact">Nro de Factura</label>
                <input name="nro_fact" type="text" class="validate" required>
              </div>

              <div class="input-field">
                <label for="descripcion">Descripcion de Compra</label>
                <input name="descripcion" type="text" class="validate" required>
              </div>

              <!-- Select Proveedor -->
              <?php
              $query_marca = mysqli_query($conection, "SELECT * FROM proveedor ORDER BY proveedor ASC");
              $result_marca = mysqli_num_rows($query_marca);
              ?>

              <div>
                <label for="proveedor">Proveedor</label>
                <select name="proveedor" id="proveedor">
                  <?php
                  if ($result_marca > 0) {
                    while ($proveedor = mysqli_fetch_array($query_marca)) {
                      ?>
                      <option value="<?php echo $proveedor['cod_proveedor']; ?>"><?php echo $proveedor['proveedor']; ?>
                      </option>
                      <?php
                    }
                  }
                  ?>
                </select>
              </div>

              <div class="input-field">
                <label for="precio">Monto</label>
                <input name="precio" type="text" class="validate" required>
              </div>
              <div class="input-field">
                <label for="fecha">Fecha</label>
                <input name="fecha" type="date" class="validate" required>
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
          <h5 class="titulos">Lista de Compras</h5>
          <!-- Button trigger modal -->
          <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            <i class="fa-solid fa-cart-shopping fa-xl"></i>
          </button>
        </div>
      </div>
      <br>
      <table class="table">
        <thead class="table-dark">
          <tr>
            <th scope="col">Codigo</th>
            <th scope="col">Nro de Factura</th>
            <th scope="col">fecha</th>
            <th scope="col">Descricpión</th>
            <th scope="col">Proveedor</th>
            <th scope="col">Precio</th>
            <th scope="col">Usuario</th>
            <?php
            if ($_SESSION['rol'] == 1) {
              ?>
              <th scope="col">Acciones</th>

            <?php } ?>
          </tr>
        </thead>

        <?php

        /*PAGINADOR*/
        $sql_register = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM compras
                          WHERE estatus = 1");

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

        /*********************/

        /*******LISTA COMPRAS********/
        $query = mysqli_query($conection, "SELECT c.cod_compra, c.nro_fact, c.fecha, c.descripcion, p.proveedor, c.precio,
                          c.username
                  FROM compras c 
                  INNER JOIN proveedor p ON c.proveedor = p.cod_proveedor  
                  WHERE c.estatus =1 ORDER BY c.fecha 
                  LIMIT $desde,$por_pagina");

        $result = mysqli_num_rows($query);

        ////***CIERRA LA CONEXION A LA BD*////
        mysqli_close($conection);


        if ($result > 0) {

          $total = 0;

          while ($data = mysqli_fetch_array($query)) {

              ?>

            <tbody>
              <tr>
                <td>
                  <?php echo $data["cod_compra"]; ?>
                </td>
                <td>
                  <?php echo $data["nro_fact"]; ?>
                </td>
                <td>
                  <?php echo $data['fecha']; ?>
                </td>
                <td>
                  <?php echo $data["descripcion"]; ?>
                </td>
                <td>
                  <?php echo $data["proveedor"]; ?>
                </td>
                <td>
                  <?php echo $data["precio"]; ?>
                </td>
                <td>
                  <?php echo $data["username"]; ?>
                </td>
                <?php
                $total += $data["precio"]; // Suma el monto de la factura a la variable $total
                ?>
                <!--ACCIONES -->
                <td>

                  <?php
                  if ($_SESSION['rol'] == 1) {
                    ?>

                    <a class="icon_editar" href="editar_compra.php?id=<?php echo $data["cod_compra"]; ?>">
                    <span class="fa-solid fa-user-pen"></span>
                    </a>

                    <a class="icon_delete" href="eliminar_compra.php?id=<?php echo $data["cod_compra"]; ?>">
                    <i class="fa-solid fa-trash"></i>
                    </a>
                  <?php } ?>
              <tr>

                </td>
                <!--CIERRE ACCIONES -->
              </tr>
            </tbody>
            <?php
          }
        }
        ?>
        <tfoot class="tfoot">
          <tr class="tfoot">
            <td>Total</td>
            <td colspan="4"></td>
            <td>
              <?php echo $total; ?>
            </td>
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