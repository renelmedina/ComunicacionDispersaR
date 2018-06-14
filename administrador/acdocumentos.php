<?php
require_once("../libreria.php");
#Listando Tipo de Contrato
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$sqlListarTDD_Detalle="CALL ListarTodoTDD_Detalle(0)";
$stmtTDD_Detalle=$ConexionSealDBComunicacionDispersa->prepare($sqlListarTDD_Detalle);
$stmtTDD_Detalle->execute();
$ListaTDD_Detalle=array();
foreach($stmtTDD_Detalle as $stmtTDD_Detalless) {
  $ListaTDD_Detalle[]=$stmtTDD_Detalless;
}
$ConexionSealDBComunicacionDispersa=null;
?>
<form action="" id="frmBuscarAcDocumentos" name="frmBuscarAcDocumentos" onsubmit="envio_general_forms('#frmBuscarAcDocumentos','acdocumentos_lista.php','#divListaAcDocumentos','#divMensajero','Buscando...');return false;">
  <div class="row">
    <div class="col"><!--class="col-lg-6"-->
      <div class="input-group">
        <span class="input-group-addon">Tipo Documento</span>
        <select name="cboTDD_DetalleID" id="cboTDD_DetalleID" class="form-control">
          <option value="0">Todos</option>
          <?php
            foreach ($ListaTDD_Detalle as $ListaTipoDocumento) {
              $DetalleTDD_ID=$ListaTipoDocumento["DetalleTDD_ID"];
              $NombreTDD=$ListaTipoDocumento["NombreTDD"];
              $NombreTD=$ListaTipoDocumento["NombreTD"];
              $AreaNombre=$ListaTipoDocumento["AreaNombre"];
              echo "<option value='$DetalleTDD_ID'>$AreaNombre :: $NombreTD :: $NombreTDD</option>";
            }
          ?>
        </select>
        <span class="input-group-addon">Personal:</span>
        <select name="cboPersonalId" id="cboPersonalId" class="form-control">
          <option value="0">Todos</option>
          <?php
            $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
            $sqlListarUsuarios="CALL ListarTodoAccesoLogin()";
            $stmtUsuarios=$ConexionSealDBComunicacionDispersa->prepare($sqlListarUsuarios);
            $stmtUsuarios->execute();
            foreach($stmtUsuarios as $ResultadoUsuarios) {
              $AccesoLoginID=$ResultadoUsuarios['idAccesoLogin'];
              $PersonalID=$ResultadoUsuarios['PersonalID'];
              $Usuario=$ResultadoUsuarios['Usuario'];
              $Password=$ResultadoUsuarios['Contrasenia'];
              $TipoAcceso=$ResultadoUsuarios['TipoAcceso'];
              $NombreAcceso=$ResultadoUsuarios['NombreAcceso'];
              $NombreCompleto=$ResultadoUsuarios['NombresCompletos'];
              echo "<option value='$AccesoLoginID'>$NombreCompleto</option>";
            }
            $ConexionSealDBComunicacionDispersa=null;
          ?>
        </select>
        <span class="input-group-addon">Fecha Inicial:</span>
        <input type="date" name="txtFechaInicial" id="txtFechaInicial">
        <span class="input-group-addon">Fecha Final:</span>
        <input type="date" name="txtFechaFinal" id="txtFechaFinal">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="input-group">
        <span class="input-group-addon">Estado:</span>
        <select name="cboEstado" id="cboEstado" class="form-control">
          <option value="0">Todos</option>
          <option value="1">Doc. Registrado</option>
          <option value="2">Doc. Asignado</option>
          <option value="3">Doc. Rezagado</option>
          <option value="4">Doc. Entregado Cliente</option>
          <option value="5">Doc.R.E. a Seal</option>
          <option value="6">Doc. Entregado a Seal</option>
        </select>
        <span class="input-group-addon">C.S:</span>
        <select name="cboCodigoSeal" id="cboCodigoSeal" class="form-control">
          <option value="0">Todos</option>
          <option value="10">10.Con Firma</option>
          <option value="11">11.Sin Firma</option>
          <option value="12">12.Ausente</option>
          <option value="13">13.No ubicado</option>
          <option value="14">14.Rechazado</option>
          <option value="15">15.Terreno baldio</option>
          <option value="16">16.NIS no corresponde</option>
          <option value="17">17.Construccion Paralizada</option>
        </select>

        <span class="input-group-addon">Filtro:</span>
        <select name="cboFiltro" id="cboFiltro" class="form-control">
          <option value="0">Todos</option>
          <option value="1">Doc. Sin Asignar</option>
          <option value="2">Doc. Asignados</option>
        </select>
        <span class="input-group-addon">Buscar:</span>
        <input type="text" name="txtDatosBuscar" class="form-control" placeholder="Dato a Buscar">
        <select name="cboBuscarEn" id="cboBuscarEn" class="form-control">
          <option value="0">Todos</option>
          <option value="1">Codigo</option>
          <option value="2">Nro Contrato</option>
          <option value="3">Nro Documento</option>
          <option value="4">Obervaciones</option>
        </select>
        <span class="input-group-btn">
          <button class="btn btn-info" type="button" onclick="envio_general_forms('#frmBuscarAcDocumentos','acdocumentos_lista.php','#divListaAcDocumentos','#divMensajero','Buscando...');">Buscar</button>
        </span>
      </div>
    </div>
  </div>
</form>
<div id="divListaAcDocumentos">
  <?php require_once("acdocumentos_lista.php"); ?>
</div>
