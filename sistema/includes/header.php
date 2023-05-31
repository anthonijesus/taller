<?php 
	
  @session_start();
  
	if(empty($_SESSION['active']))
	{
	header('location: ../');	
	}
	
?>

<header>
  <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
          <a href="index.php"><img src="img/logo.png" width="60"/></a>
          <h3 class="text-danger">Bienvenido <?php echo $_SESSION['nombre'];?></h3>
          <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Hola</h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="reparaciones.php">Reparaciones Pendientes</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="repa_fact.php">Reparaciones Facturadas</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="usuarios.php">Usuarios</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Administración
                  </a>
                  <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item" href="compras.php">Compras</a></li>
                    <li><a class="dropdown-item" href="ventas.php">Ventas</a></li>
                    <li><a class="dropdown-item" href="clientes.php">Clientes</a></li>
                    <li><a class="dropdown-item" href="gastos.php">Gastos</a></li>
                    <li><a class="dropdown-item" href="banco.php">Banco</a></li>
                    <li><a class="dropdown-item" href="proveedores.php">Proveedores</a></li>
                  </ul>
                  <li>
                      <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="salir.php">Salir</a></li>
                </li>
              </ul>
              <form class="d-flex mt-3" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success" type="submit">Search</button>
              </form>
            </div>
          </div>
        </div>
      </nav>  
  <br>
  </header>