<?php
require_once("../libreria.php");
verificarsession("No hay session iniciada");
//verificar_administrador();
//$dbConexion=new Conexion();
$cabecera=new PaginaPrincipal;
echo $cabecera->FrameworkModernos();
echo $cabecera->ArchivosEsenciales();
//echo $cabecera->FrameworkComunes();
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
    <!-- <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="">ACC SAC</a>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        
        
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Mantenimiento</a>
            <div class="dropdown-menu">

              <a class="dropdown-item" href="javascript:fnCargaSimple('atencioncliente.php','Cargando Importador','#divPrincipal','#divmensajero');">A. Cliente</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="javascript:fnCargaSimple('tipodocumento.php','Cargando Areas','#divPrincipal','#divmensajero');">Areas</a>
              <a class="dropdown-item" href="javascript:fnCargaSimple('documentos.php','Cargando Areas','#divPrincipal','#divmensajero');">Tipos de documentos</a>
              <a class="dropdown-item" href="javascript:fnCargaSimple('subdocumentos.php','Cargando Areas','#divPrincipal','#divmensajero');">Subtipos de documentos</a>
            </div>
          </li>
          <li class="nav-item dropdown">
          </li>
          <li class="nav-item">
            <a class="nav-link" href="javascript:fnCargaSimple('acdocumentos_visitacampo.php','Cargando Areas','#divPrincipal','#divmensajero');">Visitas Campo</a>
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
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Configuraciones</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="javascript:fnCargaSimple('usuarios.php','Cargando Importador','#divPrincipal','#divmensajero');">Usuarios</a>
              <a class="dropdown-item" href="../apk/app-debug.apk" download>Descargar APP</a>
            </div>

          </li>
        </ul>



        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Buscar">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
          <div class="btn-group">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo $_SESSION["UsuarioSistema"]; ?>
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Mis Datos</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Salir</a>
            </div>
          </div>
        </form>
      </div>
    </nav> -->

    <div id="divPrincipal" style="border: solid 1px red;">
      <?php
        require_once("acdocumentos_visitacampo.php");
      ?>
    </div>
    <div id="divMensajero" style="clear: both;">divMensajero</div>
    <div id="divPie" style="clear: both;">divPie</div>
  </body>
</html>