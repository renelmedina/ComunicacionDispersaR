<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>Comunicacion Dispersa</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="../js/acciones.js"></script>
  </head>
  <body>
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <!--<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>-->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>


    <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">ACC SAC</a>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        
        
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link active" href="#">Active</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Contratos</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Tipos de Contrato</a>
              <a class="dropdown-item" href="#">Zonas</a>
              <a class="dropdown-item" href="#">Sector</a>
              <a class="dropdown-item" href="#">Ruta</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="javascript:fnCargaSimple('importar.php','Cargando Importador','#divPrincipal','#divmensajero');">Ver contratos-GPS</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Enlace</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Enlace Deshabilitado</a>
          </li>
        </ul>



        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Buscar">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
          <!--<ul class="nav nav-pills">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
              </div>
            </li>
            
          </ul>-->
          <div class="btn-group">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Carlos Manrique Salinas del Padro
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Mis Datos</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Salir</a>
            </div>
          </div>
        </form>
      </div>
    </nav>







    <div id="divPrincipal">divPrincipal</div>
    <div id="divMensajero">divMensajero</div>
    <div id="divPie">divPie</div>
  </body>
</html>