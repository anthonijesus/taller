<?php

session_start();

include "../conexion.php";


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
  <title>Ventas</title>

</head>

<body>

  <?php include "includes/header.php"; ?>

  <section id="container">

    <div class="container-lg">
      <div class="d-flex justify-content-center">
        <h5 class="titulos">Lista de Ventas</h5>
      </div>

            <table class="table">
              <thead class="table-dark">
                <tr>
                  <th scope="col">Nro de factura</th>
                  <th scope="col">fecha</th>
                  <th scope="col">ID Reparación</th>
                  <th scope="col">Cliente</th>
                  <th scope="col">Item</th>
                  <th scope="col">Usuario</th>
                  <th scope="col">Monto</th>
                  <?php
                        if ($_SESSION['rol'] == 1) {
                  ?>
                  <th>Acciones</th>
                  <?php } ?>
                </tr>
              </thead>

              <?php

              /*PAGINADOR*/
              $sql_register = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM facturas
                                                        WHERE estatus = 1");

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

              /*******LISTA USUARIOS********/
              $query = mysqli_query($conection, "SELECT * FROM facturas   
                                                 WHERE estatus =1 ORDER BY fecha 
                                                 LIMIT $desde,$por_pagina");

              $result = mysqli_num_rows($query);

              ////***CIERRA LA CONEXION A LA BD*////
              mysqli_close($conection);

              
              if ($result > 0) {
                
                $total = 0;

                while ($data = mysqli_fetch_array($query)) {
                    
                  $formato = 'Y-m-d H:i:s';
                  $fecha = DateTime::createFromFormat($formato, $data["fecha"])
                  

                    ?>
                <tbody>
                  <tr>
                    <td><?php echo $data["nro_factura"]; ?></td>
                    <td><?php echo $fecha->format('d-m-Y'); ?></td>
                    <td><?php echo $data["id_rep"]; ?></td>
                    <td><?php echo $data["cliente"]; ?></td>
                    <td><?php echo $data["descripcion"]; ?></td>
                    <td><?php echo $data["username"]; ?></td>
                    <td><?php echo $data["precio_total"]; ?></td>
                    <?php
                        $total += $data["precio_total"]; // Suma el monto de la factura a la variable $total
                    ?>
                    <!--ACCIONES -->
                    <td>

                      <?php
                      if ($_SESSION['rol'] == 1) {
                      ?>
                        <a class="icon_delete"
                          href="eliminar_venta.php?id=<?php echo $data["id_rep"]; ?>">
                          <i class="fa-solid fa-trash"></i>
                        </a>
                      <?php } ?>
                      <tr>
                        
                    </td>
                    <!--CIERRE ACCIONES -->
                  </tr>

                  <?php
                }
              }
              ?>
              <tfoot class="tfoot">
                    <tr class="tfoot">
                        <td>Total</td>
                        <td colspan="5"></td>
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