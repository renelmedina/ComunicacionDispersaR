<?php
require_once("../libreria.php");
//$dbConexion=new Conexion();
$cabecera=new PaginaPrincipal;
echo $cabecera->FrameworkModernos();
//echo $cabecera->FrameworkComunes();
echo $cabecera->ArchivosEsenciales();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  	<title>Comunicacion Dispersa</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">-->

  </head>
  <body>
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
              <a class="dropdown-item" href="javascript:fnCargaSimple('tipocontrato.php','Cargando Importador','#divPrincipal','#divmensajero');">Tipos de Contrato</a>
              <a class="dropdown-item" href="javascript:fnCargaSimple('importar_zonas.php','Cargando Importador','#divPrincipal','#divmensajero');">Zonas</a>
              <a class="dropdown-item" href="javascript:fnCargaSimple('sector.php','Cargando Importador','#divPrincipal','#divmensajero');">Sector</a>
              <a class="dropdown-item" href="javascript:fnCargaSimple('libro.php','Cargando Importador','#divPrincipal','#divmensajero');">Libro</a>
              <a class="dropdown-item" href="javascript:fnCargaSimple('hojas.php','Cargando Importador','#divPrincipal','#divmensajero');">Hojas</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="javascript:fnCargaSimple('contratos.php','Cargando Importador','#divPrincipal','#divmensajero');">Ver Contratos</a>
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







    <div id="divPrincipal" style="border: solid 1px red;">divPrincipal</div>
    <div id="divMensajero">divMensajero</div>
    <div id="divPie">divPie</div>
  </body>
</html>