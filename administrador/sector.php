<?php
require_once("../libreria.php");
$ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
$sqlListarSector="CALL ListarTodoSector()";
$stmt=$ConexionSealDBGeneralidades->prepare($sqlListarSector);
$stmt->execute();
?>
<table>
  <tr>
    <td>
      <?php
      echo "<table>";
      echo "<tr><th>Nro Sector</th><th>Nombre Sector</th><th>Descripcion Sector</th><th>Acciones</th></tr>";
      foreach($stmt as $ResultadoSector) {
        $SectorID=$ResultadoSector['idSector'];
        $NroSector=$ResultadoSector['NroSector'];
        $NombreSector=$ResultadoSector['NombreSector'];
        $DescripcionSector=$ResultadoSector['DescripcionSector'];
        echo "<tr>";
        echo "<td>$NroSector</td>";
        echo "<td>$NombreSector</td>";
        echo "<td>$DescripcionSector</td>";
        //para enviar lso
        echo "<td>
                <button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#popSectorModal' data-sectorid='$SectorID' data-nombresector='$NombreSector' data-descripcion='".$DescripcionSector."' data-nrosector='$NroSector'>Modificar</button>
                <button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#popEliminarSector' data-sectorid_e='$SectorID' data-nombresector_e='$NombreSector' data-descripcion_e='".$DescripcionSector."' data-nrosector_e='$NroSector'>Eliminar</button>
        </td>";
        echo "</tr>";
      }
      echo "</table>";
      ?>
    </td>
    <td>
      <div class="card border-info text-center mb-4">
        <form name="importa" id="frmimportarsector" method="post" enctype="multipart/form-data" onsubmit="return false;" >
        <div class="card-header bg-info">Actualizar Sectores en Bloque</div>
        <div class="card-body">
          <h4 class="card-title">Archivo a importar</h4>
          <p class="card-text">Sube un archivo con el formato correcto para insertar o actualizar todos los sectores</p>
            <input type="file" name="excel" />
            <input type="hidden" class="btn btn-primary" value="upload" name="action" />
            <input type="hidden" name="registronro" value="ImportarSector">
          </form>
            <input type='button' class="btn btn-primary" name='enviar'  value="Importar" onclick="envio_general_forms('#frmimportarsector','sector_registro.php','#divCuerpo','#divPieCard','Importando Sectores...');" />
          <div id="divPieCard"></div>
        </div>
      </div>
    </td>
  </tr>
</table>
<div id="divCuerpo"></div>


<!--Popup Para Actualizar Datos-->
<div class="modal fade" id="popSectorModal" tabindex="-1" role="dialog" aria-labelledby="popSectorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalSector" id="frmModalSector">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popSectorModalLabel">Actualizar Sector</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popSectorModal">
          <input type="hidden" name="txtSectorID" id="txtSectorID">
          <input type="hidden" name="registronro" value="ActualizarSector">
          <label for="txtNroSector" class="col-form-label">Nro Sector:</label>
          <input type="text" id="txtNroSector" name="txtNroSector" class="form-control">
          <label for="txtNombreSector" class="col-form-label">Nombre Sector:</label>
          <input type="text" id="txtNombreSector" name="txtNombreSector" class="form-control">
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Descripcion:</label>
          <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"></textarea>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalSector','sector_registro.php','#divCuerpo','#divPieModal','Guardando Cambios...');">Guardar Cambios</button>
        <div id="divPieModal"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<!--Popup Para Eliminar Datos-->
<div class="modal fade" id="popEliminarSector" tabindex="-1" role="dialog" aria-labelledby="popEliminarSectorLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalEliminarSector" id="frmModalEliminarSector">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popEliminarSectorLabel">Eliminar Sector</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popEliminarSector">
          <input type="hidden" name="txtSectorID_e" id="txtSectorID_e">
          <input type="hidden" name="registronro" value="EliminarSector">
          <p><strong>¿Estas seguro de eliminar el sector?</strong><br>
            Nro Sector: <span id="spNroSector"></span><br>
            Nombre Sector: <span id="spNombreSector"></span><br>
            Descripcion Sector: <span id="spDescripcionSector"></span>
          </p>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalEliminarSector','sector_registro.php','#divCuerpo','#divPieModal_e','Eliminando Sector...');">Si, Eliminar</button>
        <div id="divPieModal_e"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#popSectorModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varSectorID=button.data('sectorid')
    var varNroSector=button.data('nrosector')
    var varNombreSector = button.data('nombresector') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#txtSectorID').val(varSectorID);
    modal.find('#txtNroSector').val(varNroSector)
    modal.find('#txtNombreSector').val(varNombreSector)
    modal.find('#txtDescripcion').val(varDescripcion)
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
  $('#popEliminarSector').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varSectorID = button.data('sectorid_e')
    var varNroSector = button.data('nrosector_e')
    var varNombreSector = button.data('nombresector_e') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion_e') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)

    modal.find('#txtSectorID_e').val(varSectorID);
    modal.find('#spNroSector').html(varNroSector)
    modal.find('#spNombreSector').html(varNombreSector)
    modal.find('#spDescripcionSector').html(varDescripcion)
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
</script>