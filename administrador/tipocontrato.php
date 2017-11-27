<?php
require_once("../libreria.php");
$ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
$sqlListarTipoContrato="CALL ListarTodoTipoContrato()";
$stmt=$ConexionSealDBGeneralidades->prepare($sqlListarTipoContrato);
$stmt->execute();
?>
<table>
  <tr>
    <td>
      <?php
      echo "<table>";
      echo "<tr><th>Tipo de Contrato</th><th>Descripcion</th><th>Acciones</th></tr>";
      foreach($stmt as $Resultadotiposcontrato) {
        $TipoContratoID=$Resultadotiposcontrato['idTipoContrato'];
        $NombreTipo=$Resultadotiposcontrato['NombreTipo'];
        $DescripcionTipo=$Resultadotiposcontrato['DescripcionTipo'];
        echo "<tr>";
        echo "<td>$NombreTipo</td>";
        echo "<td>$DescripcionTipo</td>";
        //para enviar lso
        echo "<td>
                <button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#popTipoModal' data-tipoid='$TipoContratoID' data-nombretipo='$NombreTipo' data-descripcion='".$DescripcionTipo."'>Modificar</button>
                <button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#popEliminarTipo' data-tipoid_e='$TipoContratoID' data-nombretipo_e='$NombreTipo' data-descripcion_e='".$DescripcionTipo."'>Eliminar</button>
        </td>";
        echo "</tr>";
      }
      echo "</table>";
      ?>
    </td>
    <td>
      <div class="card border-info text-center mb-4">
        <form name="importa" id="frmimportartipo" method="post" enctype="multipart/form-data" onsubmit="return false;" >
        <div class="card-header bg-info">Ingresar tipos de contrato</div>
        <div class="card-body">
          <h4 class="card-title">Tipos de contrato</h4>
          <label for="txtNombreTipo">Nombre de tipo de contrato:</label>
          <input type="text" id="txtNombreTipo" name="txtNombreTipo" value="" placeholder="Nombre de tipo de contrato">
          <br>
          <textarea name="txtDescripcionTipo" id="txtDescripcionTipo" cols="20" rows="3" placeholder="Descripcion" style="width: 100%;" ></textarea>
          <input type="hidden" class="btn btn-primary" value="upload" name="action" />
          <input type="hidden" name="registronro" value="IngresarTipo"><br>
          <input type='button' class="btn btn-primary" name='enviar'  value="Ingresar" onclick="envio_general_forms('#frmimportartipo','tipocontrato_registro.php','#divCuerpo','#divPieCard','Registrando...');" />
          <div id="divPieCard"></div>
        </div>
        </form>
      </div>
    </td>
  </tr>
</table>
<div id="divCuerpo"></div>


<!--Popup Para Actualizar Datos-->
<div class="modal fade" id="popTipoModal" tabindex="-1" role="dialog" aria-labelledby="popTipoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalTipo" id="frmModalTipo">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popTipoLabel">Actualizar tipo de contrato</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popTipoModal">
          <input type="hidden" name="txtTipoID" id="txtTipoID">
          <input type="hidden" name="registronro" value="ActualizarTipo">
          <label for="txtNombreTipo" class="col-form-label">Nombre tipo:</label>
          <input type="text" id="txtNombreTipo" name="txtNombreTipo" class="form-control">
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Descripcion:</label>
          <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"></textarea>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalTipo','tipocontrato_registro.php','#divCuerpo','#divPieModal','Guardando Cambios...');">Guardar Cambios</button>
        <div id="divPieModal"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<!--Popup Para Eliminar Datos-->
<div class="modal fade" id="popEliminarTipo" tabindex="-1" role="dialog" aria-labelledby="popEliminarTipoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalEliminarTipo" id="frmModalEliminarTipo">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popEliminarTipoLabel">Eliminar tipo de contrato</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popEliminarTipo">
          <input type="hidden" name="txtTipoID_e" id="txtTipoID_e">
          <input type="hidden" name="registronro" value="EliminarTipo">
          <p><strong>¿Estas seguro de eliminar este tipo de contrato?</strong><br>
            Nombre Tipo: <span id="spNombreTipo"></span><br>
            Descripcion Tipo: <span id="spDescripcionTipo"></span>
          </p>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalEliminarTipo','tipocontrato_registro.php','#divCuerpo','#divPieModal_e','Eliminando Tipo...');">Si, Eliminar</button>
        <div id="divPieModal_e"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#popTipoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varTipoID=button.data('tipoid')
    var varNombreTipo = button.data('nombretipo') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#txtTipoID').val(varTipoID);
    modal.find('#txtNombreTipo').val(varNombreTipo);
    modal.find('#txtDescripcion').val(varDescripcion);
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
  $('#popEliminarTipo').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varTipoID=button.data('tipoid_e')
    var varNombreTipo = button.data('nombretipo_e') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion_e') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#txtTipoID_e').val(varTipoID);
    modal.find('#spNombreTipo').html(varNombreTipo);
    modal.find('#spDescripcionTipo').html(varDescripcion);
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
</script>