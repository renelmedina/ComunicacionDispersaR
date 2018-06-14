<?php
require_once("../libreria.php");
$ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
$sqlListarZonas="CALL ListarTodoZonas()";
$stmt=$ConexionSealDBGeneralidades->prepare($sqlListarZonas);
$stmt->execute();
?>
<table>
  <tr>
    <td>
      <?php
      echo "<table>";
      echo "<tr><th>Nro Zona</th><th>Nombre Zona</th><th>Descripcion Zona</th><th>Acciones</th></tr>";
      foreach($stmt as $ResultadoZonas) {
        $ZonaID=$ResultadoZonas['idZona'];
        $NombreZona=$ResultadoZonas['NombreZona'];
        $NroZona=$ResultadoZonas['NroZona'];
        $DescripcionZona=$ResultadoZonas['DescripcionZona'];
        echo "<tr>";
        echo "<td>$NroZona</td>";
        echo "<td>$NombreZona</td>";
        echo "<td>$DescripcionZona</td>";
        //para enviar lso
        echo "<td>
                <button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#exampleModal' data-zonaid='$ZonaID' data-nombrezona='$NombreZona' data-descripcion='".$DescripcionZona."' data-nrozona='$NroZona'>Modificar</button>
                <button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#popEliminarZona' data-zonaid_e='$ZonaID' data-nombrezona_e='$NombreZona' data-descripcion_e='".$DescripcionZona."' data-nrozona_e='$NroZona'>Eliminar</button>
                  
        </td>";
        
        echo "</tr>";
      }
      echo "</table>";
      ?>
    </td>
    <td valign="top">
      <div class="card border-info text-center mb-4">
        <form name="importa" id="frmimporta" method="post" action="importar_zonas.php" enctype="multipart/form-data" onsubmit="return false;" >
        <div class="card-header bg-info">Actualizar Zonas en Bloque</div>
        <div class="card-body">
          <img src="../images/zonaPlantilla.jpg" alt="" style="border: solid 1px black;"><br>
          <a href="../plantillasxls/zonaPlantilla.xlsx" download>Descargar Plantilla</a>
          <h4 class="card-title">Archivo a importar</h4>
          <p class="card-text">Sube un archivo con el formato correcto para insertar o actualizar todas las zonas</p>
            <input type="file" name="excel" />
            <input type="hidden" class="btn btn-primary" value="upload" name="action" />
            <input type="hidden" name="registronro" value="ImportarZonas">
          </form>
            <input type='button' class="btn btn-primary" name='enviar'  value="Importar" onclick="envio_general_forms('#frmimporta','zona_registro.php','#divCuerpo','#divPieCard','Importando Zonas..........');" />
          <div id="divPieCard"></div>
        </div>
      </div>
    </td>
  </tr>
</table>
<div id="divCuerpo"></div>


<!--Popup Para Actualizar Datos-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalZona" id="frmModalZona">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="exampleModalLabel">Actualizar Zona</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#exampleModal">
          <input type="hidden" name="txtZonaID" id="txtZonaID">
          <input type="hidden" name="registronro" value="ActualizarZona">
          <label for="txtNroZona" class="col-form-label">Nro Zona:</label>
          <input type="text" id="txtNroZona" name="txtNroZona" class="form-control" id="recipient-name">
          <label for="txtNombreZona" class="col-form-label">Nombre Zona:</label>
          <input type="text" id="txtNombreZona" name="txtNombreZona" class="form-control" id="recipient-name">
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Descripcion:</label>
          <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"></textarea>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalZona','zona_registro.php','#divCuerpo','#divPieModal','Guardando Cambios...');">Guardar Cambios</button>
        <div id="divPieModal"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<!--Popup Para Eliminar Datos-->
<div class="modal fade" id="popEliminarZona" tabindex="-1" role="dialog" aria-labelledby="popEliminarZonaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalEliminarZona" id="frmModalEliminarZona">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popEliminarZonaLabel">Eliminar Zona</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popEliminarZona">
          <input type="hidden" name="txtZonaID_e" id="txtZonaID_e">
          <input type="hidden" name="registronro" value="EliminarZona">
          <p><strong>¿Estas seguro de eliminar la zona?</strong><br>
            Nro Zona: <span id="spNroZona"></span><br>
            Nombre Zona: <span id="spNombreZona"></span><br>
            Descripcion Zona: <span id="spDescripcionZona"></span>
          </p>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalEliminarZona','zona_registro.php','#divCuerpo','#divPieModal_e','Eliminando Zona...');">Si, Eliminar</button>
        <div id="divPieModal_e"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#exampleModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varZonaID=button.data('zonaid')
    var varNroZona=button.data('nrozona')
    var varNombreZona = button.data('nombrezona') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#txtZonaID').val(varZonaID);
    modal.find('#txtNroZona').val(varNroZona)
    modal.find('#txtNombreZona').val(varNombreZona)
    modal.find('#txtDescripcion').val(varDescripcion)
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
  $('#popEliminarZona').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varZonaID=button.data('zonaid_e')
    var varNroZona=button.data('nrozona_e')
    var varNombreZona = button.data('nombrezona_e') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion_e') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)

    modal.find('#txtZonaID_e').val(varZonaID);
    modal.find('#spNroZona').html(varNroZona)
    modal.find('#spNombreZona').html(varNombreZona)
    modal.find('#spDescripcionZona').html(varDescripcion)
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
</script>