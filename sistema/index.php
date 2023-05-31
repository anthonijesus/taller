<?php

@session_start();

if(empty($_SESSION['active']))
	{
	header('location: ../');	
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
	  <title>Panel Administrador</title>
</head>
<body>

    <?php include "includes/header.php"; ?>

      <section id="container-fluid">
        <br>

        
      </section>

    <?php include "includes/footer.php"; ?>

   


</body>
</html>