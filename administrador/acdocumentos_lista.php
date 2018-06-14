<?php
require_once("../libreria.php");
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$varTDD_DetalleID=(coger_dato_externo("cboTDD_DetalleID")==null?0:coger_dato_externo("cboTDD_DetalleID"));//tipo de contrato
$varPersonalID=(coger_dato_externo("cboPersonalId")==null?0:coger_dato_externo("cboPersonalId"));
$varFechaInicial=(coger_dato_externo("txtFechaInicial")==null?'':coger_dato_externo("txtFechaInicial"));
$varFechaFinal=(coger_dato_externo("txtFechaFinal")==null?'':coger_dato_externo("txtFechaFinal"));
$varEstado=(coger_dato_externo("cboEstado")==null?0:coger_dato_externo("cboEstado"));
$varCodigoSeal=(coger_dato_externo("cboCodigoSeal")==null?0:coger_dato_externo("cboCodigoSeal"));
$varFiltro=(coger_dato_externo("cboFiltro")==null?0:coger_dato_externo("cboFiltro"));
$varDatoBuscar=(coger_dato_externo("txtDatosBuscar")==null?"":coger_dato_externo("txtDatosBuscar"));
$varBuscarEn=(coger_dato_externo("cboBuscarEn")==null?0:coger_dato_externo("cboBuscarEn"));
$varPaginaActual=(coger_dato_externo("hdPaginaAntual")==null?1:coger_dato_externo("hdPaginaAntual"));
$varPaginasMostrar=50;//cantidad de registros a mostrar
#Contando la cantidad total de la busqueda en la tabla contrato
$sqlCantidad="CALL DocumentosTrabajo_BusquedaAC_1_Cantidad($varTDD_DetalleID,$varPersonalID,'$varFechaInicial','$varFechaFinal',$varEstado,$varCodigoSeal,$varFiltro,'$varDatoBuscar',$varBuscarEn)";
$stmtCantidad= $ConexionSealDBComunicacionDispersa->prepare($sqlCantidad);
$stmtCantidad->execute();
$ListaCantidadSolicitud=array();
foreach($stmtCantidad as $CantidadSolicitud) {
  $ListaCantidadSolicitud[]=$CantidadSolicitud;
}
$PaginasTotales=ceil($ListaCantidadSolicitud[0]["total"]/$varPaginasMostrar);//Ceil redondea un numero, funcion de php
$ConexionSealDBComunicacionDispersa=null;//cerramos la conexion

//Artilugio para poner la cantidad de paginas
$pagina_actual2=($varPaginaActual-1)*$varPaginasMostrar;
#Haciendo Busqueda en la tabla contratos, con Limit, para que este paginado
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$sqlListarContratos="CALL DocumentosTrabajo_BusquedaAC_1($varTDD_DetalleID,$varPersonalID,'$varFechaInicial','$varFechaFinal',$varEstado,$varCodigoSeal,$varFiltro,'$varDatoBuscar',$varBuscarEn,$pagina_actual2,$varPaginasMostrar)";
echo $sqlListarContratos."<br>";
$stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarContratos);
set_time_limit(60);
$stmt->execute();
$ListaDocumentosTrabajoBusqueda=array();
foreach($stmt as $stmtListaDocumentosTrabajoBusquedas) {
  $ListaDocumentosTrabajoBusqueda[]=$stmtListaDocumentosTrabajoBusquedas;
}
$ConexionSealDBComunicacionDispersa=null;//cerramos la conexion

?>
Registros encontrados: <?php echo $ListaCantidadSolicitud[0]["total"]; ?>
<div class="tabla_azul" style="width: 85%;">
      <table>
        <tr>
          <th>Codigo</th>
          <th>NroDocumento</th>
          <th>Suministro</th>
          <th>Tipo</th>
          <th>Asigando A</th>
          <th>F. Emision Seal</th>
          <th title="Fecha de Asignacion a Personal">F. Asig. P.</th><!--Tipo de contrato-->
          <th>F. Ejecucion</th>
          <th title="Fecha Limite Cargo a Seal">F. L. C Seal</th>
          <th>F. Entrega Seal</th>
          <th>Estado</th>
          <th>Cod.</th>
          <th>obs</th>
          <th>Acciones</th>
        </tr>
      <?php
      foreach($ListaDocumentosTrabajoBusqueda as $ResultadoDocumentosTrabajo) {
        $idDocumentosTrabajo=$ResultadoDocumentosTrabajo["idDocumentosTrabajo"];
    		$IdTDD_Detalle=$ResultadoDocumentosTrabajo["IdTDD_Detalle"];
    		$NombreTDDD=$ResultadoDocumentosTrabajo["NombreTDDD"];
    		$IdNotificador=$ResultadoDocumentosTrabajo["IdNotificador"];
    		$NotificadorNombre=$ResultadoDocumentosTrabajo["NotificadorNombre"];
    		
    		$NroContrato=$ResultadoDocumentosTrabajo["NroContrato"];
    		$CodBarra=$ResultadoDocumentosTrabajo["CodBarra"];
    		$NroDocumento=$ResultadoDocumentosTrabajo["NroDocumento"];
    		$NombreCliente=$ResultadoDocumentosTrabajo["NombreCliente"];
    		$Direccion=$ResultadoDocumentosTrabajo["Direccion"];
    		$Tipo=$ResultadoDocumentosTrabajo["Tipo"];
    		$SE=$ResultadoDocumentosTrabajo["SE"];
    		$Zona=$ResultadoDocumentosTrabajo["Zona"];
    		$Sector=$ResultadoDocumentosTrabajo["Sector"];
    		$Libro=$ResultadoDocumentosTrabajo["Libro"];
    		$FechaEmisionDoc=$ResultadoDocumentosTrabajo["FechaEmisionDoc"];
    		$FechaTrabajo=$ResultadoDocumentosTrabajo["FechaTrabajo"];
    		$FechaAsignacion=$ResultadoDocumentosTrabajo["FechaAsignacion"];
    		$FechaEjecucion=$ResultadoDocumentosTrabajo["FechaEjecucion"];
    		$FechaLimiteCargo=$ResultadoDocumentosTrabajo["FechaLimiteCargo"];
    		$FechaEntregaASeal=$ResultadoDocumentosTrabajo["FechaEntregaASeal"];
    		$Estado=$ResultadoDocumentosTrabajo["Estado"];
        $NombreEstado=$ResultadoDocumentosTrabajo["NombreEstado"];
        $CodigoSeal=$ResultadoDocumentosTrabajo["CodigoSeal"];
        $NombreCodigoSeal=$ResultadoDocumentosTrabajo["NombreCodigoSeal"];
    		$Observaciones=$ResultadoDocumentosTrabajo["Observaciones"];
        echo "<tr>";
        echo "<td>$idDocumentosTrabajo</td>";
        echo "<td>$NroDocumento</td>";
        echo "<td>$NroContrato</td>";
        echo "<td>$Tipo</td>";
        echo "<td>$NotificadorNombre</td>";
        echo "<td>$FechaEmisionDoc</td>";
        echo "<td>$FechaAsignacion</td>";
        echo "<td><a href='#' data-toggle='modal' data-target='#popTablaVisitasCampo' data-docid='$idDocumentosTrabajo'>$FechaEjecucion</a></td>";
        echo "<td>$FechaLimiteCargo</td>";
        echo "<td>$FechaEntregaASeal</td>";
        echo "<td>$NombreEstado</td>";
        echo "<td>$CodigoSeal.$NombreCodigoSeal</td>";
        echo "<td>$Observaciones</td>";
        //para enviar lso
        echo "<td>
                <button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#popDocumentosModal' data-documentotrabajoid='$idDocumentosTrabajo' data-tdddetalleid='$IdTDD_Detalle' data-documentonro='$NroDocumento' data-suministronro='$NroContrato' data-fechaemision='$FechaEmisionDoc' data-fechalimite='$FechaLimiteCargo' data-tipo2='$Tipo' data-zonanombre='$Zona' data-personalid='$IdNotificador'>M</button>
                <button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#popEliminarDocumentos' data-documentotrabajoid_e='$idDocumentosTrabajo' data-documentonro_e='$NroDocumento' data-suministronro_e='$NroContrato' data-tipo2_a='$Tipo'>E</button>
        </td>";
        echo "</tr>";
      }
     
      ?>
      
      </table>
</div>
<!--Paginado-->
<?php
# Paginado
$PaginaNavega="acdocumentos_lista.php?varTDD_DetalleID=$varTDD_DetalleID&cboPersonalId=$varPersonalID&txtFechaInicial=varFechaInicial&txtFechaFinal=$varFechaFinal&cboEstado=$varEstado&cboFiltro=$varFiltro&txtDatosBuscar=$varDatoBuscar&cboBuscarEn=$varBuscarEn";
$PaginaAnterior=($varPaginaActual>0?$varPaginaActual-1:1);
$PAnterior=$PaginaNavega."&hdPaginaAntual=$PaginaAnterior";
$PaginaSiguiente=($varPaginaActual<$PaginasTotales?$varPaginaActual+1:$PaginasTotales);
$PSiguiente=$PaginaNavega."&hdPaginaAntual=$PaginaSiguiente";
?>
<nav aria-label="navPaginado">
  <ul class="pagination justify-content-center">
    <?php
    $verificar1raPagina=($varPaginaActual<=1?"disabled":"");
    echo "<li class='page-item $verificar1raPagina'><a class='page-link' href=\"javascript:fnCargaSimple('$PAnterior','Cargando pagina $PaginaAnterior...','#divListaAcDocumentos','#divmensajero');\">Anterior</a></li>";
    for ($i=1; $i <=$PaginasTotales ; $i++) {
      if ($varPaginaActual!=$i) {
        $PaginaNavega.="&hdPaginaAntual=$i";
        echo "<li class='page-item'><a class='page-link' href=\"javascript:fnCargaSimple('$PaginaNavega','Cargando pagina $i...','#divListaAcDocumentos','#divmensajero');\">$i</a></li>";
      }else {
        echo "<li class='page-item active'><span class='page-link'>$i</span></li>";
      }
    }
    $verificarUltimaPagina=($varPaginaActual>=$PaginasTotales?"disabled":"");
    echo "<li class='page-item $verificarUltimaPagina'><a class='page-link' href=\"javascript:fnCargaSimple('$PSiguiente','Cargando pagina $PaginaSiguiente...','#divListaAcDocumentos','#divmensajero');\">Siguiente</a></li>";
    ?>
  </ul>
</nav>
<!--Popup Para Actualizar Datos-->
<div class="modal fade" id="popDocumentosModal" tabindex="-1" role="dialog" aria-labelledby="popDocumentosModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalDocumentos_a" id="frmModalDocumentos_a">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popDocumentosModalLabel">Actualizar documentos de trabajo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
			<input type="hidden" name="popNombreModal" value="#popDocumentosModal">
			<input type="hidden" name="txtDocumentoTrabajoID" id="txtDocumentoTrabajoID">
			<label for="cboDetalleTDD_ID" class="col-form-label">Nro Documento:</label>
			<select name="cboDetalleTDD_ID" id="cboDetalleTDD_ID" class="form-control">
			<?php
			$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
			$sqlListarSector="CALL ListarTodoTDD_Detalle(0)";
			$stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarSector);
			$stmt->execute();
			foreach($stmt as $ResultadoTipoDocumento) {
			$DetalleTDD_ID=$ResultadoTipoDocumento['DetalleTDD_ID'];
			$AreaID=$ResultadoTipoDocumento['AreaID'];
			$AreaNombre=$ResultadoTipoDocumento['AreaNombre'];
			$TipoDocumentoID=$ResultadoTipoDocumento['TipoDocumentoID'];
			$NombreTD=$ResultadoTipoDocumento['NombreTD'];
			$NombreTDD=$ResultadoTipoDocumento['NombreTDD'];
			$DescripcionTDD=$ResultadoTipoDocumento['DescripcionTDD'];
			$ImagenReferencialTDDD=$ResultadoTipoDocumento['ImagenReferencialTDDD'];
			echo "<option value='$DetalleTDD_ID'>$AreaNombre :: $NombreTD :: $NombreTDD</option>";
			}
			?>
			</select>
			<input type="hidden" name="registronro" value="ActualizarDocumentos">
			<label for="txtNroDocumento" class="col-form-label">Nro Documento:</label>
			<input type="text" id="txtNroDocumento" name="txtNroDocumento" class="form-control">
			<label for="txtNroSuministro" class="col-form-label">Nro Suministro:</label>
			<input type="text" id="txtNroSuministro" name="txtNroSuministro" class="form-control">
			<label for="txtFechaEmicionDoc" class="col-form-label">Fecha emision documento:</label>
			<input type="date" id="txtFechaEmicionDoc" name="txtFechaEmicionDoc" class="form-control">
			<label for="txtFechaLimiteEntregaCSeal" class="col-form-label">Fecha limite entrega cargo seal:</label>
			<input type="date" id="txtFechaLimiteEntregaCSeal" name="txtFechaLimiteEntregaCSeal" class="form-control">
			<label for="txtTipo" class="col-form-label">Tipo:</label>
			<input type="text" id="txtTipo" name="txtTipo" class="form-control">
			<label for="txtZona" class="col-form-label">Zona:</label>
			<input type="text" id="txtZona" name="txtZona" class="form-control">
			<label for="cboPersonalID" class="col-form-label">Asignado a:</label>
			<select name="cboPersonalID" id="cboPersonalID" class="form-control">
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
		              $NombreCompleto=$ResultadoUsuarios['ApellidoPaterno']." ".$ResultadoUsuarios['ApellidoMaterno']." ".$ResultadoUsuarios['NombreCompleto'];
		              echo "<option value='$PersonalID'>$NombreCompleto</option>";
		            }
		            $ConexionSealDBComunicacionDispersa=null;
		        ?>
			</select>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalDocumentos_a','acdocumentos_registro.php','#divPieModal','#divPieModal','Guardando Cambios...');">Guardar Cambios</button>
        <div id="divPieModal"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<!--Popup Para Eliminar Datos-->
<div class="modal fade" id="popEliminarDocumentos" tabindex="-1" role="dialog" aria-labelledby="popEliminarDocumentosLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalEliminarDocumentos" id="frmModalEliminarDocumentos">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popEliminarDocumentosLabel">Eliminar documentos de trabajo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popEliminarDocumentos">
          <input type="hidden" name="txtDocumentoTrabajoID_e" id="txtDocumentoTrabajoID_e">
          <input type="hidden" name="registronro" value="EliminarDocumentos">
          <p><strong>¿Estas seguro de eliminar el sector?</strong><br>
            Nro Documentos: <span id="spNroDocumento"></span><br>
            Nro Suministro: <span id="spNroSuministro"></span><br>
            Tipo: <span id="spTipo"></span>
          </p>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalEliminarDocumentos','acdocumentos_registro.php','#divPieModal_e','#divPieModal_e','Eliminando documento de trabajo...');">Si, Eliminar</button>
        <div id="divPieModal_e"></div>
        <div id="divCuerpo"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<!--Popup Para Ver tabal de datos-->
<div class="modal fade" id="popTablaVisitasCampo" tabindex="-1" role="dialog" aria-labelledby="popTablaVisitasCampoLabel" aria-hidden="true" style="width: 100%;">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 100%;max-width: 90%;" >
    <div class="form-group">
      <form name="frmModalEliminarDocumentos" id="frmModalEliminarDocumentos">
      <div class="modal-content" style="width: 100%;max-width: 100%;">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popTablaVisitasCampoLabel">Visitas Campo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="divPopUptablaVisitas" style="width: 100%;max-width: 100%;">
          <!--Aqui vendra la tabla-->
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        
      </div>
    </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#popDocumentosModal').on('show.bs.modal', function (event) {
    $('#popDocumentosModal').css({
      width: '100%',
      border: 'solid red 1px'
    });
    /*$().css({
      property1: 'value1',
      property2: 'value2'
    });*/
    
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varDocumentoTrabajoID=button.data('documentotrabajoid');
    var varTDDDetalleID=button.data('tdddetalleid');
    var varDocumentoNro=button.data('documentonro');
    var varSuministroNro=button.data('suministronro');
    var varFechaEmision=button.data('fechaemision');
    var varFechaLimite=button.data('fechalimite');
    var varTipo2=button.data('tipo2');
    var varZonaNombre=button.data('zonanombre');
    var varPersonalID = button.data('personalid'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#txtDocumentoTrabajoID').val(varDocumentoTrabajoID);
    modal.find('#cboDetalleTDD_ID').val(varTDDDetalleID);
    modal.find('#txtNroDocumento').val(varDocumentoNro);
    modal.find('#txtNroSuministro').val(varSuministroNro);
    modal.find('#txtFechaEmicionDoc').val(varFechaEmision);
    modal.find('#txtFechaLimiteEntregaCSeal').val(varFechaLimite);
    modal.find('#txtTipo').val(varTipo2);
    modal.find('#txtZona').val(varZonaNombre);
    modal.find('#cboPersonalID').val(varPersonalID);
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
  $('#popEliminarDocumentos').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varDocumentoTrabajoID = button.data('documentotrabajoid_e');
    var varDocumentoNro = button.data('documentonro_e');
    var varSuministroNro = button.data('suministronro_e');
    var varTipo2_a = button.data('tipo2_a'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('#txtDocumentoTrabajoID_e').val(varDocumentoTrabajoID);
    modal.find('#spNroDocumento').html(varDocumentoNro);
    modal.find('#spNroSuministro').html(varSuministroNro);
    modal.find('#spTipo').html(varTipo2_a);
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
  
  $('#popTablaVisitasCampo').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varDocumentoTrabajoID = button.data('docid');
    
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('#divPopUptablaVisitas').load("acdocumentos_visitacampo_lista.php?varDocumentosTrabajoID="+varDocumentoTrabajoID);

    
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
</script>