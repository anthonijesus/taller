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
    <title>Presupuestos</title>
    <style>
        form {
            max-width: 500px;
            margin: 0 auto;
            padding: auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input,
        textarea {
            width: 100%;
            padding: 5px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button[type="submit"] {
            display: block;
            margin: 0 auto;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <?php include "includes/header.php"; ?>

    <section id="container">
        <br>
        <form action="presupuesto.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" required>

            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="vehiculo">Vehículo:</label>
            <input type="text" id="vehiculo" name="vehiculo" required>

            <label for="descripcion">Descripción de la reparación:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>

            <button type="submit">Generar presupuesto</button>
        </form>


    </section>
    <?php include "includes/footer.php"; ?>
</body>