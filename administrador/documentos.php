<?php
/*Tambien se le conoceria como Tipos de documentos (contrastes, atencion cliente, facturacion, cobranza)*/
require_once("../libreria.php");
$areaid=(coger_dato_externo("areaid")==null?0:coger_dato_externo("areaid"));//tipo de contrato
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$sqlListarSector="CALL ListarTodo_TDD($areaid)";
$stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarSector);
$stmt->execute();
?>
<table>
  <tr>
    <td>
      <?php
      echo "<table>";
      echo "<tr><th>Nombre Area</th><th>Tipo Documento</th><th>Descripcion</th><th>Acciones</th></tr>";
      foreach($stmt as $ResultadoTipoDocumento) {
        $TipoDocumentoDetalleID=$ResultadoTipoDocumento['TipoDocumentoDetalleID'];
        $TipoDocumentoID=$ResultadoTipoDocumento['TipoDocumentoID'];
        $NombreTD=$ResultadoTipoDocumento['NombreTD'];
        $NombreTDD=$ResultadoTipoDocumento['NombreTDD'];
        $DescripcionTDD=$ResultadoTipoDocumento['DescripcionTDD'];
        $ImagenReferencialTDD=$ResultadoTipoDocumento['ImagenReferencialTDD'];
        echo "<tr>";
        echo "<td>$NombreTD</td>";
        echo "<td>$NombreTDD</td>";
        echo "<td>$DescripcionTDD</td>";
        //para enviar lso
        echo "<td>
                <button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#popTipoDocumentoModal' data-areaid='$TipoDocumentoID' data-tipodocumentoid='$TipoDocumentoDetalleID' data-nombre='$NombreTDD' data-descripcion='".$DescripcionTDD."'>Modificar</button>
                <a href=\"javascript:fnCargaSimple('subdocumentos.php?tipodocumentoid=$TipoDocumentoDetalleID','Cargando Importador','#divPrincipal','#divmensajero');\"><button type='button' class='btn btn-outline-primary btn-sm'>Ver tipos de documento</button></a>
                <button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#popEliminarTipoDocumento' data-tipodocumentoid_e='$TipoDocumentoDetalleID' data-nombre_e='$NombreTDD' data-descripcion_e='".$DescripcionTDD."'>Eliminar</button>
        </td>";
        echo "</tr>";
      }
      $ConexionSealDBComunicacionDispersa=null;
      echo "</table>";
      ?>
    </td>

    <td>
      <div class="card border-info text-center mb-4">
        <form name="importa" id="frmtipodocumento" method="post" enctype="multipart/form-data" onsubmit="return false;" >
          <div class="card-header bg-info">Nuevo tipo de documento</div>
          <div class="card-body">
            <!--<h4 class="card-title">Archivo a importar</h4>-->
            <label for="">Area:</label>
            <select name="cboAreaID" id="cboAreaID">
              <?php
                $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
                $sqlListarSector="CALL ListarTodoTipoDocumento()";
                $stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarSector);
                $stmt->execute();
                $ListaTipoDocumento=array();
                foreach($stmt as $ResultadoTipoDocumento) {
                  $ListaTipoDocumento[]=$ResultadoTipoDocumento;
                  $cboTipoDocumentoID=$ResultadoTipoDocumento['idTipoDocumento'];
                  $cboNombreTipoDocumento=$ResultadoTipoDocumento['Nombre'];
                  echo "<option value='$cboTipoDocumentoID'>$cboNombreTipoDocumento</option>";
                }
              ?>
            </select><br>
            <label for="">Nombre:</label>
            <input type="text" name="txtNombreTDD" placeholder="Ingrese Nombre de Area"><br>
            <label for="">Descripcion:</label>
            <textarea name="txtDescripcionTipoDocumento" id="txtDescripcionTipoDocumento" cols="30" rows="10" placeholder="Breve descripcion del tipo de documento a crear"></textarea>
            <input type="hidden" name="registronro" value="NuevoTipoDocumentoDetalle"><br>
            <input type='button' class="btn btn-primary" name='enviar'  value="Guardar Tipo Documento" onclick="envio_general_forms('#frmtipodocumento','documentos_registro.php','#divCuerpo','#divPieCard','Creando nuevo tipo...');" />
            <div id="divPieCard"></div>
          </div>
        </form>
      </div>
    </td>
  </tr>
</table>
<div id="divCuerpo"></div>


<!--Popup Para Actualizar Datos-->
<div class="modal fade" id="popTipoDocumentoModal" tabindex="-1" role="dialog" aria-labelledby="popTipoDocumentoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalSector" id="frmModalSector">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popTipoDocumentoModalLabel">Actualizar tipo documento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popTipoDocumentoModal">
          <input type="hidden" name="txtTDD_ID" id="txtTDD_ID">
          <input type="hidden" name="registronro" value="ActualizarTDD">
          <select name="cboTipoArea" id="cboTipoArea">
            <?php
              foreach ($ListaTipoDocumento as $ListaAreas) {
                $cboTipoDocumentoID_a=$ListaAreas['idTipoDocumento'];
                $cboNombreTipoDocumento_a=$ListaAreas['Nombre'];
                echo "<option value='$cboTipoDocumentoID_a'>$cboNombreTipoDocumento_a</option>";
              }
            ?>
          </select><br>
          <label for="txtNombreTDD_a" class="col-form-label">Nombre Area:</label>
          <input type="text" id="txtNombreTDD_a" name="txtNombreTDD_a" class="form-control">
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Descripcion:</label>
          <textarea class="form-control" id="txtDescripcion_a" name="txtDescripcion_a"></textarea>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalSector','documentos_registro.php','#divCuerpo','#divPieModal','Guardando Cambios...');">Guardar Cambios</button>
        <div id="divPieModal"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<!--Popup Para Eliminar Datos-->
<div class="modal fade" id="popEliminarTipoDocumento" tabindex="-1" role="dialog" aria-labelledby="popEliminarTipoDocumentoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalEliminarArea" id="frmModalEliminarArea">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popEliminarTipoDocumentoLabel">Eliminar tipo de documento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popEliminarTipoDocumento">
          <input type="hidden" name="txtTDD_ID_e" id="txtTDD_ID_e">
          <input type="hidden" name="registronro" value="EliminarTDD">
          <p><strong>¿Estas seguro de eliminar este tipo de documento?</strong><br>
            Nombre tipo documento: <span id="spNombreTDD"></span><br>
            Descripcion: <span id="spDescripcionTDD"></span>
          </p>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalEliminarArea','documentos_registro.php','#divCuerpo','#divPieModal_e','Eliminando tipo de documento...');">Si, Eliminar</button>
        <div id="divPieModal_e"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#popTipoDocumentoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varAreaID=button.data('areaid');
    var varTipoDocumentoID=button.data('tipodocumentoid')
    var varNombre = button.data('nombre') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#cboTipoArea').val(varAreaID);
    modal.find('#txtTDD_ID').val(varTipoDocumentoID);
    modal.find('#txtNombreTDD_a').val(varNombre);
    modal.find('#txtDescripcion_a').val(varDescripcion);
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
  $('#popEliminarTipoDocumento').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varTipoDocumentoID = button.data('tipodocumentoid_e');
    var varNombre = button.data('nombre_e'); // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion_e'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('#txtTDD_ID_e').val(varTipoDocumentoID);
    modal.find('#spNombreTDD').html(varNombre);
    modal.find('#spDescripcionTDD').html(varDescripcion);
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
</script>