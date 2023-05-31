<?php
session_start();

include "../conexion.php";

/****ESTE CODIGO REGISTRA FACTURAS****/

    if(!empty($_POST)){

    if(empty($_POST['id_rep']) || empty($_POST['cliente']) || empty($_POST['descripcion']) || empty($_POST['precio_total']) )
    {
    echo '<script type="text/javascript">
    alert("Campo requerido vacio");
    window.location.href="reparaciones.php";
    </script>';
        
    }else{

        $id_rep 		    = $_POST['id_rep'];
        $cliente 	        = $_POST['cliente'];
        $descripcion        = $_POST['descripcion'];
        $precio_total 	    = $_POST['precio_total'];
        $idusuario          = $_SESSION['username'];



            $query_insert = mysqli_query($conection, "INSERT INTO facturas(id_rep,cliente,descripcion,precio_total,username) 
                                            VALUES('$id_rep','$cliente','$descripcion','$precio_total','$idusuario')");

        if ($query_insert) {
    // Si la inserción en la tabla de facturas fue exitosa, actualice la columna "estatus" en la tabla de reparaciones a "Facturado"
    $query_update = mysqli_query($conection, "UPDATE reparaciones SET estatus='Facturado' WHERE id_rep='$id_rep'");
    
    if ($query_update) {
      // Si la actualización de la tabla de reparaciones también fue exitosa, puede mostrar un mensaje al usuario o realizar cualquier otra acción necesaria
      echo '<script type="text/javascript">
    alert("Factura registrada correctamente");
    window.location.href="reparaciones.php";
    </script>';	
    
    }else{
            echo '<script type="text/javascript">
    alert("Error al registrar Factura");
    window.location.href="reparaciones.php";
    </script>';
            }

        }
    }
}

if(empty($_REQUEST['id'])){
    header('location: reparaciones.php');
    
    ////***CIERRA LA CONEXION A LA BD*////
    mysqli_close($conection);
}

$id_rep = $_REQUEST['id'];

$sql = mysqli_query($conection,"SELECT r.id_rep, c.nom_ape, r.des_falla, r.marca, r.modelo
                                FROM reparaciones r
                                INNER JOIN cliente c ON r.cliente = c.ID_Cliente
                                WHERE id_rep = $id_rep and rep_act = 1");


$result_sql = mysqli_num_rows($sql);

if($result_sql == 0){
    header('location: reparaciones.php');
}else{

    while($data = mysqli_fetch_array($sql)) {
        
        $id_rep 		    = $data['id_rep'];
        $cliente 			= $data['nom_ape'];
        $des_falla 			= $data['des_falla'];
        $marca 			    = $data['marca'];
        $modelo 			= $data['modelo'];
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
            <title>Facturación</title>
        </head>
	<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <br>
      <div class="container">
        
        <div class="factura">
        <h5>Factura Reparación Nro: <?php echo $id_rep; ?> </h5>
        
        <form action="" method="POST">
        <input type="hidden" name="id_rep" value="<?php echo $id_rep; ?>">
            <div class="input-field">
                <label for="cliente">Cliente</label>
                <input name="cliente" type="text" class="validate" value="<?php echo $cliente; ?>">
            </div>
            <div class="input-field">
                <label for="marca">Marca</label>
                <input name="marca" type="text" class="validate" value="<?php echo $marca; ?>">
            </div>
            <div class="input-field">
                <label for="modelo">Modelo</label>
                <input name="modelo" type="text" class="validate" value="<?php echo $modelo; ?>">
            </div>
            <div class="input-field">
                <label for="descripcion">descripcion</label>
                <input name="descripcion" type="text" class="validate" value="<?php echo $des_falla; ?>">
            </div>
            <div class="input-field">
                <label for="precio_total">Monto</label>
                <input name="precio_total" type="text" class="validate" required>
            </div>
                <br>
        <button type="submit" class="btn btn-primary">Facturar</button>
        </form>
    </div>
    
  </section>
        <?php include "includes/footer.php"; ?>
</body>
