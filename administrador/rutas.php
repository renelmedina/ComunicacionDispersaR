<?php
require_once("../libreria.php");
$ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
$sqlListarRutas="CALL ListarTodoRuta()";
$stmt=$ConexionSealDBGeneralidades->prepare($sqlListarRutas);
$stmt->execute();
?>
<table>
  <tr>
    <td>
      <?php
      echo "<table>";
      echo "<tr><th>Nro Ruta</th><th>Nombre Ruta</th><th>Descripcion Ruta</th><th>Acciones</th></tr>";
      foreach($stmt as $ResultadoRutas) {
        $RutaID=$ResultadoRutas['idRuta'];
        $NroRuta=$ResultadoRutas['NroRuta'];
        $NombreRuta=$ResultadoRutas['NombreRuta'];
        $DescripcionRuta=$ResultadoRutas['DescripcionRuta'];
        echo "<tr>";
        echo "<td>$NroRuta</td>";
        echo "<td>$NombreRuta</td>";
        echo "<td>$DescripcionRuta</td>";
        //para enviar lso
        echo "<td>
                <button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#popRutaModal' data-rutaid='$RutaID' data-nombreruta='$NombreRuta' data-descripcion='".$DescripcionRuta."' data-nroruta='$NroRuta'>Modificar</button>
                <button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#popEliminarRuta' data-rutaid_e='$RutaID' data-nombreruta_e='$NombreRuta' data-descripcion_e='".$DescripcionRuta."' data-nroruta_e='$NroRuta'>Eliminar</button>
        </td>";
        echo "</tr>";
      }
      echo "</table>";
      ?>
    </td>
    <td>
      <div class="card border-info text-center mb-4">
        <form name="importa" id="frmimportarruta" method="post" enctype="multipart/form-data" onsubmit="return false;" >
        <div class="card-header bg-info">Actualizar Rutas en Bloque</div>
        <div class="card-body">
          <h4 class="card-title">Archivo a importar</h4>
          <p class="card-text">Sube un archivo con el formato correcto para insertar o actualizar todas las rutas</p>
            <input type="file" name="excel" />
            <input type="hidden" class="btn btn-primary" value="upload" name="action" />
            <input type="hidden" name="registronro" value="ImportarRutas">
          </form>
            <input type='button' class="btn btn-primary" name='enviar'  value="Importar" onclick="envio_general_forms('#frmimportarruta','zona_registro.php','#divCuerpo','#divPieCard','Importando Zonas..........');" />
          <div id="divPieCard"></div>
        </div>
      </div>
    </td>
  </tr>
</table>
<div id="divCuerpo"></div>


<!--Popup Para Actualizar Datos-->
<div class="modal fade" id="popRutaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalRuta" id="frmModalRuta">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="exampleModalLabel">Actualizar Ruta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popRutaModal">
          <input type="hidden" name="txtRutaID" id="txtRutaID">
          <input type="hidden" name="registronro" value="ActualizarRuta">
          <label for="txtNroRuta" class="col-form-label">Nro Ruta:</label>
          <input type="text" id="txtNroRuta" name="txtNroRuta" class="form-control">
          <label for="txtNombreRuta" class="col-form-label">Nombre Ruta:</label>
          <input type="text" id="txtNombreRuta" name="txtNombreRuta" class="form-control">
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Descripcion:</label>
          <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"></textarea>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalRuta','ruta_registro.php','#divCuerpo','#divPieModal','Guardando Cambios...');">Guardar Cambios</button>
        <div id="divPieModal"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<!--Popup Para Eliminar Datos-->
<div class="modal fade" id="popEliminarRuta" tabindex="-1" role="dialog" aria-labelledby="popEliminarRutaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalEliminarRuta" id="frmModalEliminarRuta">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popEliminarRutaLabel">Eliminar Ruta</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popEliminarRuta">
          <input type="hidden" name="txtRutaID_e" id="txtRutaID_e">
          <input type="hidden" name="registronro" value="EliminarRuta">
          <p><strong>¿Estas seguro de eliminar la ruta?</strong><br>
            Nro Ruta: <span id="spNroRuta"></span><br>
            Nombre Ruta: <span id="spNombreRuta"></span><br>
            Descripcion Ruta: <span id="spDescripcionRuta"></span>
          </p>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalEliminarRuta','ruta_registro.php','#divCuerpo','#divPieModal_e','Eliminando Ruta...');">Si, Eliminar</button>
        <div id="divPieModal_e"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#popRutaModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varZonaID=button.data('rutaid')
    var varNroZona=button.data('nroruta')
    var varNombreZona = button.data('nombreruta') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#txtRutaID').val(varZonaID);
    modal.find('#txtNroRuta').val(varNroZona)
    modal.find('#txtNombreRuta').val(varNombreZona)
    modal.find('#txtDescripcion').val(varDescripcion)
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
  $('#popEliminarRuta').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varZonaID=button.data('zonaid_e')
    var varNroZona=button.data('nrozona_e')
    var varNombreZona = button.data('nombrezona_e') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion_e') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)

    modal.find('#txtRutaID_e').val(varZonaID);
    modal.find('#spNroRuta').html(varNroZona)
    modal.find('#spNombreRuta').html(varNombreZona)
    modal.find('#spDescripcionRuta').html(varDescripcion)
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
</script>