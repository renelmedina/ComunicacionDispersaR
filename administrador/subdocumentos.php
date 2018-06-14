<?php
/*Tambien se le conoceria como area de trabajo*/
require_once("../libreria.php");
$tipodocumentoid=(coger_dato_externo("tipodocumentoid")==null?0:coger_dato_externo("tipodocumentoid"));//tipo de contrato
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$sqlListarSector="CALL ListarTodoTDD_Detalle($tipodocumentoid)";
$stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarSector);
$stmt->execute();
?>
<table>
  <tr>
    <td>
      <?php
      echo "<table>";
      echo "<tr><th>Nombre Area</th><th>Tipo Documento</th><th>SubTipo Documento</th><th>Descripcion</th><th>Acciones</th></tr>";
      foreach($stmt as $ResultadoTipoDocumento) {
        $DetalleTDD_ID=$ResultadoTipoDocumento['DetalleTDD_ID'];
        $AreaID=$ResultadoTipoDocumento['AreaID'];
        $AreaNombre=$ResultadoTipoDocumento['AreaNombre'];
        $TipoDocumentoID=$ResultadoTipoDocumento['TipoDocumentoID'];
        $NombreTD=$ResultadoTipoDocumento['NombreTD'];
        $NombreTDD=$ResultadoTipoDocumento['NombreTDD'];
        $DescripcionTDD=$ResultadoTipoDocumento['DescripcionTDD'];
        $ImagenReferencialTDDD=$ResultadoTipoDocumento['ImagenReferencialTDDD'];
        echo "<tr>";
        echo "<td>$AreaNombre</td>";
        echo "<td>$NombreTD</td>";
        echo "<td>$NombreTDD</td>";
        echo "<td>$DescripcionTDD</td>";
        //para enviar lso
        echo "<td>
                <button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#popTipoDocumentoModal' data-tipodocumentoid='$TipoDocumentoID' data-detalletddid='$DetalleTDD_ID' data-nombre='$NombreTDD' data-descripcion='".$DescripcionTDD."'>Modificar</button>
                <button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#popEliminarTipoDocumento' data-detalletddid_e='$DetalleTDD_ID' data-nombre_e='$NombreTDD' data-descripcion_e='".$DescripcionTDD."'>Eliminar</button>
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
          <div class="card-header bg-info">Nuevo subtipo de documento</div>
          <div class="card-body">
            <label for="">Tipo Documento:</label>
            <select name="cboTipodocumentoID" id="cboTipodocumentoID">
              <?php
                $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
                $sqlListarSector="CALL ListarTodo_TDD(0)";//cero significa que mostrara toda la lista
                $stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarSector);
                $stmt->execute();
                $ListaTipoDocumento=array();
                foreach($stmt as $ResultadoTipoDocumento) {
                  $ListaTipoDocumento[]=$ResultadoTipoDocumento;
                  $TipoDocumentoDetalleID=$ResultadoTipoDocumento['TipoDocumentoDetalleID'];
                  $NombreTD=$ResultadoTipoDocumento['NombreTD'];
                  $NombreTDD=$ResultadoTipoDocumento['NombreTDD'];
                  echo "<option value='$TipoDocumentoDetalleID'>$NombreTD :: $NombreTDD</option>";
                }
                $ConexionSealDBComunicacionDispersa=null;
              ?>
            </select><br>
            <label for="">Nombre:</label>
            <input type="text" name="txtNombreTDDD" placeholder="Ingrese Nombre Subtipo Documento"><br>
            <label for="">Descripcion:</label>
            <textarea name="txtDescripcionTDDD" id="txtDescripcionTDDD" cols="30" rows="10" placeholder="Breve descripcion del subtipo de documento a crear"></textarea>
            <input type="hidden" name="registronro" value="NuevoTDDD"><br>
            <input type='button' class="btn btn-primary" name='enviar'  value="Guardar Subtipo Documento" onclick="envio_general_forms('#frmtipodocumento','subdocumentos_registro.php','#divCuerpo','#divPieCard','Creando nuevo tipo...');" />
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
      <form name="frmModalSubDocumentos" id="frmModalSubDocumentos">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popTipoDocumentoModalLabel">Actualizar subtipo documento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popTipoDocumentoModal">
          <input type="hidden" name="txtTDDD_ID" id="txtTDDD_ID">
          <input type="hidden" name="registronro" value="ActualizarTDDD">
          <select name="cboTipoDocuento_a" id="cboTipoDocuento_a">
          <?php
            foreach ($ListaTipoDocumento as $ListaAreas) {
              $TipoDocumentoDetalleID_a=$ListaAreas['TipoDocumentoDetalleID'];
              $NombreTD_a=$ListaAreas['NombreTD'];
              $NombreTDD_a=$ListaAreas['NombreTDD'];
              echo "<option value='$TipoDocumentoDetalleID_a'>$NombreTD_a :: $NombreTDD_a</option>";
            }
          ?>
          </select><br>
          <label for="txtNombreTDDD_a" class="col-form-label">Nombre Area:</label>
          <input type="text" id="txtNombreTDDD_a" name="txtNombreTDDD_a" class="form-control">
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Descripcion:</label>
          <textarea class="form-control" id="txtDescripcion_a" name="txtDescripcion_a"></textarea>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalSubDocumentos','subdocumentos_registro.php','#divCuerpo','#divPieModal','Guardando Cambios...');">Guardar Cambios</button>
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
          <input type="hidden" name="txtTDDD_ID_e" id="txtTDDD_ID_e">
          <input type="hidden" name="registronro" value="EliminarTDDD">
          <p><strong>¿Estas seguro de eliminar este tipo de documento?</strong><br>
            Nombre tipo documento: <span id="spNombreTDDD"></span><br>
            Descripcion: <span id="spDescripcionTDDD"></span>
          </p>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalEliminarArea','subdocumentos_registro.php','#divCuerpo','#divPieModal_e','Eliminando tipo de documento...');">Si, Eliminar</button>
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
    var varTipoDocumenID=button.data('tipodocumentoid');
    var varDetalleTDD_ID=button.data('detalletddid')
    var varNombre = button.data('nombre') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#cboTipoDocuento_a').val(varTipoDocumenID);
    modal.find('#txtTDDD_ID').val(varDetalleTDD_ID);
    modal.find('#txtNombreTDDD_a').val(varNombre);
    modal.find('#txtDescripcion_a').val(varDescripcion);
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
  $('#popEliminarTipoDocumento').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varDetalleTDDDID_e = button.data('detalletddid_e');
    var varNombre = button.data('nombre_e'); // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion_e'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('#txtTDDD_ID_e').val(varDetalleTDDDID_e);
    modal.find('#spNombreTDDD').html(varNombre);
    modal.find('#spDescripcionTDDD').html(varDescripcion);
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
</script>