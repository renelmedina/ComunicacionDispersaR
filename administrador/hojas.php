<?php
require_once("../libreria.php");
$ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
$sqlListarHojas="CALL ListarTodoHojas()";
$stmt=$ConexionSealDBGeneralidades->prepare($sqlListarHojas);
$stmt->execute();
?>
<table>
  <tr>
    <td>
      <?php
      echo "<table>";
      echo "<tr><th>Nro Hoja</th><th>Nombre Hoja</th><th>Descripcion Hoja</th><th>Acciones</th></tr>";
      foreach($stmt as $Resultadohojas) {
        $HojaID=$Resultadohojas['idHoja'];
        $NroHoja=$Resultadohojas['NroHoja'];
        $NombreHoja=$Resultadohojas['NombreHoja'];
        $DescripcionHoja=$Resultadohojas['DescripcionHoja'];
        echo "<tr>";
        echo "<td>$NroHoja</td>";
        echo "<td>$NombreHoja</td>";
        echo "<td>$DescripcionHoja</td>";
        //para enviar lso
        echo "<td>
                <button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#popHojaModal' data-hojaid='$HojaID' data-nombrehoja='$NombreHoja' data-descripcion='".$DescripcionHoja."' data-nrohoja='$NroHoja'>Modificar</button>
                <button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#popEliminarHoja' data-hojaid_e='$HojaID' data-nombrehoja_e='$NombreHoja' data-descripcion_e='".$DescripcionHoja."' data-nrohoja_e='$NroHoja'>Eliminar</button>
        </td>";
        echo "</tr>";
      }
      echo "</table>";
      ?>
    </td>
    <td>
      <div class="card border-info text-center mb-4">
        <form name="importa" id="frmimportarhoja" method="post" enctype="multipart/form-data" onsubmit="return false;" >
        <div class="card-header bg-info">Actualizar Hojas en Bloque</div>
        <div class="card-body">
          <h4 class="card-title">Archivo a importar</h4>
          <p class="card-text">Sube un archivo con el formato correcto para insertar o actualizar todas las hojas</p>
            <input type="file" name="excel" />
            <input type="hidden" class="btn btn-primary" value="upload" name="action" />
            <input type="hidden" name="registronro" value="ImportarHojas">
          </form>
            <input type='button' class="btn btn-primary" name='enviar'  value="Importar" onclick="envio_general_forms('#frmimportarhoja','hojas_registro.php','#divCuerpo','#divPieCard','Importando Hojas...');" />
          <div id="divPieCard"></div>
        </div>
      </div>
    </td>
  </tr>
</table>
<div id="divCuerpo"></div>


<!--Popup Para Actualizar Datos-->
<div class="modal fade" id="popHojaModal" tabindex="-1" role="dialog" aria-labelledby="popHojaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalHoja" id="frmModalHoja">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popHojaLabel">Actualizar Hoja</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popHojaModal">
          <input type="hidden" name="txtHojaID" id="txtHojaID">
          <input type="hidden" name="registronro" value="ActualizarHoja">
          <label for="txtNroHoja" class="col-form-label">Nro Hoja:</label>
          <input type="text" id="txtNroHoja" name="txtNroHoja" class="form-control">
          <label for="txtNombreHoja" class="col-form-label">Nombre Hoja:</label>
          <input type="text" id="txtNombreHoja" name="txtNombreHoja" class="form-control">
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Descripcion:</label>
          <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"></textarea>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalHoja','hojas_registro.php','#divCuerpo','#divPieModal','Guardando Cambios...');">Guardar Cambios</button>
        <div id="divPieModal"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<!--Popup Para Eliminar Datos-->
<div class="modal fade" id="popEliminarHoja" tabindex="-1" role="dialog" aria-labelledby="popEliminarHojaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalEliminarHoja" id="frmModalEliminarHoja">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popEliminarHojaLabel">Eliminar Hoja</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popEliminarHoja">
          <input type="hidden" name="txtHojaID_e" id="txtHojaID_e">
          <input type="hidden" name="registronro" value="EliminarHoja">
          <p><strong>¿Estas seguro de eliminar la hoja?</strong><br>
            Nro Hoja: <span id="spNroHoja"></span><br>
            Nombre Hoja: <span id="spNombreHoja"></span><br>
            Descripcion Hoja: <span id="spDescripcionHoja"></span>
          </p>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalEliminarHoja','hojas_registro.php','#divCuerpo','#divPieModal_e','Eliminando Hoja...');">Si, Eliminar</button>
        <div id="divPieModal_e"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#popHojaModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varHojaID=button.data('hojaid')
    var varNroHoja=button.data('nrohoja')
    var varNombreHoja = button.data('nombrehoja') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#txtHojaID').val(varHojaID);
    modal.find('#txtNroHoja').val(varNroHoja)
    modal.find('#txtNombreHoja').val(varNombreHoja)
    modal.find('#txtDescripcion').val(varDescripcion)
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
  $('#popEliminarHoja').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varHojaID=button.data('hojaid_e')
    var varNroHoja=button.data('nrohoja_e')
    var varNombreHoja = button.data('nombrehoja_e') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion_e') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#txtHojaID_e').val(varHojaID);
    modal.find('#spNroHoja').html(varNroHoja)
    modal.find('#spNombreHoja').html(varNombreHoja)
    modal.find('#spDescripcionHoja').html(varDescripcion)
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
</script>