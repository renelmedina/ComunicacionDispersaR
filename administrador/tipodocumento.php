<?php
/*Tambien se le conoceria como area de trabajo*/
require_once("../libreria.php");
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$sqlListarSector="CALL ListarTodoTipoDocumento()";
$stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarSector);
$stmt->execute();
?>
<table>
  <tr>
    <td>
      <?php
      echo "<table>";
      echo "<tr><th>Nombre Area</th><th>Descripcion</th><th>Acciones</th></tr>";
      foreach($stmt as $ResultadoTipoDocumento) {
        $TipoDocumentoID=$ResultadoTipoDocumento['idTipoDocumento'];
        $NombreTipoDocumento=$ResultadoTipoDocumento['Nombre'];
        $Descripcion=$ResultadoTipoDocumento['Descripcion'];
        $ImagenReferencial=$ResultadoTipoDocumento['ImagenReferencial'];
        echo "<tr>";
        echo "<td>$NombreTipoDocumento</td>";
        echo "<td>$Descripcion</td>";
        //para enviar lso
        echo "<td>
                <button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#popTipoDocumentoModal' data-tipodocumentoid='$TipoDocumentoID' data-nombre='$NombreTipoDocumento' data-descripcion='".$Descripcion."'>Modificar</button>
                <a href=\"javascript:fnCargaSimple('documentos.php?areaid=$TipoDocumentoID','Cargando Tipos de documento','#divPrincipal','#divmensajero');\"><button type='button' class='btn btn-outline-primary btn-sm'>Ver tipos de documento</button></a>
                <button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#popEliminarTipoDocumento' data-tipodocumentoid_e='$TipoDocumentoID' data-nombre_e='$NombreTipoDocumento' data-descripcion_e='".$Descripcion."'>Eliminar</button>
        </td>";
        echo "</tr>";
      }
      echo "</table>";
      ?>
    </td>

    <td>
      <div class="card border-info text-center mb-4">
        <form name="importa" id="frmtipodocumento" method="post" enctype="multipart/form-data" onsubmit="return false;" >
          <div class="card-header bg-info">Nueva Area</div>
          <div class="card-body">
            <!--<h4 class="card-title">Archivo a importar</h4>-->
            <label for="">Nombre:</label>
            <input type="text" name="txtNombreArea" placeholder="Ingrese Nombre de Area"><br>
            <label for="">Descripcion:</label>
            <textarea name="txtDescripcionArea" id="txtDescripcionArea" cols="30" rows="10" placeholder="Breve descripcion del area a crear"></textarea>
            <input type="hidden" name="registronro" value="NuevoTipoDocumento"><br>
              <input type='button' class="btn btn-primary" name='enviar'  value="Guardar Nueva Area" onclick="envio_general_forms('#frmtipodocumento','tipodocumento_registro.php','#divCuerpo','#divPieCard','Creando Nueva Area...');" />
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
          <h5 class="modal-title" id="popTipoDocumentoModalLabel">Actualizar Area</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popTipoDocumentoModal">
          <input type="hidden" name="txtTipoDocumentoID" id="txtTipoDocumentoID">
          <input type="hidden" name="registronro" value="ActualizarArea">
          <label for="txtNombreArea" class="col-form-label">Nombre Area:</label>
          <input type="text" id="txtNombreArea" name="txtNombreArea" class="form-control">
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Descripcion:</label>
          <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"></textarea>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalSector','tipodocumento_registro.php','#divCuerpo','#divPieModal','Guardando Cambios...');">Guardar Cambios</button>
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
          <h5 class="modal-title" id="popEliminarTipoDocumentoLabel">Eliminar Area</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popEliminarTipoDocumento">
          <input type="hidden" name="txtTipoDocumentoID_e" id="txtTipoDocumentoID_e">
          <input type="hidden" name="registronro" value="EliminarSector">
          <p><strong>¿Estas seguro de eliminar el area?</strong><br>
            Nombre Area: <span id="spNombreArea"></span><br>
            Descripcion Area: <span id="spDescripcionArea"></span>
          </p>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalEliminarArea','tipodocumento_registro.php','#divCuerpo','#divPieModal_e','Eliminando area...');">Si, Eliminar</button>
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
    var varTipoDocumentoID=button.data('tipodocumentoid')
    var varNombre = button.data('nombre') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#txtTipoDocumentoID').val(varTipoDocumentoID);
    modal.find('#txtNombreArea').val(varNombre)
    modal.find('#txtDescripcion').val(varDescripcion)
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
    modal.find('#txtTipoDocumentoID_e').val(varTipoDocumentoID);
    modal.find('#spNombreArea').html(varNombre);
    modal.find('#spDescripcionArea').html(varDescripcion);
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
</script>