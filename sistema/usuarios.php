<?php
/***CON ESTE CODIGO VALIDAMOS QUE EL USUARIO LOGEADO NO TENGA ACCESO A LAS FUNCIONES DE ADMINISTRADOR*/
session_start();
if ($_SESSION['rol'] != 1) {
    header("location: ./");
}
///**********///
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
        <title>Lista Usuarios</title>

	</head>
	<body>
    <?php include "includes/header.php"; ?>
    <section id="container">

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
            </div>
        </div>
        </div>



        <div class="container-lg">
        <div class="d-flex justify-content-center">
            <div class="usuario-header text-center">
                <h5 class="titulos">Lista de Usuarios</h5>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa-solid fa-address-card fa-xl"></i>
                </button>
            </div>
        </div>
<br>
        <table class="table">
            <thead class="table-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Usuario</th>
                <th scope="col">Rol</th>
                <th scope="col">Acciones</th>
                </tr>
            </thead>

    <?php
            /*PAGINADOR*/
            $sql_register = mysqli_query($conection, "SELECT COUNT(*) as total_registro FROM usuarios WHERE estatus = 1");
            $result_register = mysqli_fetch_array($sql_register);
            $total_registro = $result_register['total_registro'];
            $por_pagina = 5;
            if (empty($_GET['pagina'])) {
                $pagina = 1;
            } else {
                $pagina = $_GET['pagina'];
            }
            $desde = ($pagina - 1) * $por_pagina;
            $total_pagina = ceil($total_registro / $por_pagina);
            /*********************/
            $query = mysqli_query($conection, "SELECT u.idusuario, u.nombre, u.username, u.password, r.rol
                                            FROM usuarios u INNER JOIN rol r 
                                            ON u.rol = r.idrol WHERE estatus =1 ORDER BY u.idusuario LIMIT $desde,$por_pagina");
            $result = mysqli_num_rows($query);
            
            ////***CIERRA LA CONEXION A LA BD*////
            mysqli_close($conection);
            
            if ($result > 0) {
                while ($data = mysqli_fetch_array($query)) {
                    // code...
    ?>

            <tbody>
                <tr>
                    <th scope="row"><?php echo $data['idusuario'];?></th>
                    <td><?php echo $data['nombre']; ?></td>
                    <td><?php echo $data['username']; ?></td>
                    <td><?php echo $data['rol']; ?></td>
                    <td>
                        <a class="icon_editar" href="editar_usuario.php?id=<?php echo $data["idusuario"]; ?>">
                            <span class="fa-solid fa-user-pen"></span>
                        </a>
                        <?php
                            if ($data['idusuario'] != 1) {
                        ?>
                            
                        <a class="icon_delete" href="eliminar_usuario.php?id=<?php echo $data["idusuario"]; ?>">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    <?php
                        }
                    ?>
                    </td>
                </tr>
            </tbody>
        <?php
            }
        } 
        ?>

        </table>
        </div>
    
    </section>
        <?php include "includes/footer.php"; ?>
</body>
