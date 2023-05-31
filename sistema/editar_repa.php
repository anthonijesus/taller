<?php

/***CON ESTE CODIGO VALIDAMOS QUE EL USUARIO LOGEADO NO TENGA ACCESO A LAS FUNCIONES DE ADMINISTRADOR*/
session_start();

if ($_SESSION['rol'] != 1) {

    header("location: ./");
}


include "../conexion.php";

if (!empty($_POST)) {


    if (
        empty($_POST['marca']) || empty($_POST['modelo']) || empty($_POST['equipo']) || empty($_POST['des_falla'])
        || empty($_POST['estatus'])
    ) {

        echo '<script type="text/javascript">
            alert("Complete todos los campos");
            window.location.href="reparaciones.php";
            </script>';
    } else {

        $id_rep = $_POST['id'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $equipo = $_POST['equipo'];
        $des_falla = $_POST['des_falla'];
        $observacion = $_POST['observacion'];
        $estatus = $_POST['estatus'];

        $sql_update = mysqli_query($conection, "UPDATE reparaciones
														SET marca  = '$marca', modelo  = '$modelo', equipo = '$equipo', des_falla = '$des_falla',
                                                            observacion = '$observacion', estatus = '$estatus' 
														WHERE id_rep = $id_rep");
    }

    if ($sql_update) {

        echo '<script type="text/javascript">
            alert("Reparación actualizada correctamente");
            window.location.href="reparaciones.php";
            </script>';
    } else {

        echo '<script type="text/javascript">
            alert("Error al actualizar reparación");
            window.location.href="reparaciones.php";
            </script>';
    }
}

//Cargar datos en formulario de edición//

if (empty($_REQUEST['id'])) {
    header('location: reparaciones.php');

    ////***CIERRA LA CONEXION A LA BD*////
    mysqli_close($conection);
}

$idrep = $_REQUEST['id'];

$sql = mysqli_query($conection, "SELECT * FROM reparaciones WHERE id_rep = $idrep and rep_act = 1");


$result_sql = mysqli_num_rows($sql);

if ($result_sql == 0) {

    header('location: reparaciones.php');
} else {

    $option = '';
    while ($data = mysqli_fetch_array($sql)) {

        $id_rep = $data['id_rep'];
        $marca = $data['marca'];
        $modelo = $data['modelo'];
        $equipo = $data['equipo'];
        $des_falla = $data['des_falla'];
        $observacion = $data['observacion'];
        $estatus = $data['estatus'];
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <?php include "includes/functions.php"; ?>
    <title>Editar Reparación</title>
</head>

<body>

    <?php include "includes/header.php"; ?>

    <section id="container" class="container">

        <div class="form_register">
            <h5>Editar Reparación</h5>
            <hr>
            <form class="edit_cli" action="" method="post">
                <input type="hidden" name="id" value="<?php echo $id_rep; ?>">

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

                <div>
                    <label for="modelo">Modelo</label>
                    <input type="text" name="modelo" id="modelo" placeholder="Modelo" value="<?php echo $modelo; ?>" required>
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

                <div>
                    <label for="observacion">Observacion</label>
                    <input type="text" name="observacion" id="observacion" placeholder="Observacion" value="<?php echo $observacion; ?>">
                </div>

                <!-- Select estatus -->
                <?php
                $query_estatus = mysqli_query($conection, "SELECT id_estatus, estatus
                                                           FROM estatus ORDER BY estatus ASC");
                $result_estatus = mysqli_num_rows($query_estatus);
                ////***CIERRA LA CONEXION A LA BD*////
                mysqli_close($conection);
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
                <div>
                    <br>
                    <div>
                        <input type="submit" value="Editar Reparación" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>
</body>

</html>