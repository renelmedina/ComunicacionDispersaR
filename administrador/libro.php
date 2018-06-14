<?php
require_once("../libreria.php");
$ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
$sqlListarLibros="CALL ListarTodoLibro()";
$stmt=$ConexionSealDBGeneralidades->prepare($sqlListarLibros);
$stmt->execute();
?>
<table>
  <tr>
    <td>
      <?php
      echo "<table>";
      echo "<tr><th>Nro Libro</th><th>Nombre Libro</th><th>Descripcion Libro</th><th>Acciones</th></tr>";
      foreach($stmt as $ResultadoLibros) {
        $LibroID=$ResultadoLibros['idLibro'];
        $NroLibro=$ResultadoLibros['NroLibro'];
        $NombreLibro=$ResultadoLibros['NombreLibro'];
        $DescripcionLibro=$ResultadoLibros['DescripcionLibro'];
        echo "<tr>";
        echo "<td>$NroLibro</td>";
        echo "<td>$NombreLibro</td>";
        echo "<td>$DescripcionLibro</td>";
        //para enviar lso
        echo "<td>
                <button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#popLibroModal' data-libroid='$LibroID' data-nombrelibro='$NombreLibro' data-descripcion='".$DescripcionLibro."' data-nrolibro='$NroLibro'>Modificar</button>
                <button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#popEliminarLibro' data-libroid_e='$LibroID' data-nombrelibro_e='$NombreLibro' data-descripcion_e='".$DescripcionLibro."' data-nrolibro_e='$NroLibro'>Eliminar</button>
        </td>";
        echo "</tr>";
      }
      echo "</table>";
      ?>
    </td>
    <td valign="top">
      <div class="card border-info text-center mb-4">
        <form name="importa" id="frmimportarlibro" method="post" enctype="multipart/form-data" onsubmit="return false;" >
        <div class="card-header bg-info">Actualizar Libros en Bloque</div>
        <img src="../images/libroPlantilla.jpg" alt="" style="border: solid 1px black;"><br>
        <a href="../plantillasxls/libroPlantilla.xlsx" download>Descargar Plantilla</a>
        <div class="card-body">
          <h4 class="card-title">Archivo a importar</h4>
          <p class="card-text">Sube un archivo con el formato correcto para insertar o actualizar todas los libros</p>
            <input type="file" name="excel" />
            <input type="hidden" class="btn btn-primary" value="upload" name="action" />
            <input type="hidden" name="registronro" value="ImportarLibros">
          </form>
            <input type='button' class="btn btn-primary" name='enviar'  value="Importar" onclick="envio_general_forms('#frmimportarlibro','libro_registro.php','#divCuerpo','#divPieCard','Importando Libro...');" />
          <div id="divPieCard"></div>
        </div>
      </div>
    </td>
  </tr>
</table>
<div id="divCuerpo"></div>


<!--Popup Para Actualizar Datos-->
<div class="modal fade" id="popLibroModal" tabindex="-1" role="dialog" aria-labelledby="popLibroLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalRuta" id="frmModalRuta">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popLibroLabel">Actualizar Libro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popLibroModal">
          <input type="hidden" name="txtLibroID" id="txtLibroID">
          <input type="hidden" name="registronro" value="ActualizarLibro">
          <label for="txtNroLibro" class="col-form-label">Nro Ruta:</label>
          <input type="text" id="txtNroLibro" name="txtNroLibro" class="form-control">
          <label for="txtNombreLibro" class="col-form-label">Nombre Ruta:</label>
          <input type="text" id="txtNombreLibro" name="txtNombreLibro" class="form-control">
        </div>
        <div class="form-group">
          <label for="message-text" class="col-form-label">Descripcion:</label>
          <textarea class="form-control" id="txtDescripcion" name="txtDescripcion"></textarea>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalRuta','libro_registro.php','#divCuerpo','#divPieModal','Guardando Cambios...');">Guardar Cambios</button>
        <div id="divPieModal"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<!--Popup Para Eliminar Datos-->
<div class="modal fade" id="popEliminarLibro" tabindex="-1" role="dialog" aria-labelledby="popEliminarLibroLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmModalEliminarLibro" id="frmModalEliminarLibro">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popEliminarLibroLabel">Eliminar Libro</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popEliminarLibro">
          <input type="hidden" name="txtLibroID_e" id="txtLibroID_e">
          <input type="hidden" name="registronro" value="EliminarLibro">
          <p><strong>¿Estas seguro de eliminar el libro?</strong><br>
            Nro Libro: <span id="spNroLibro"></span><br>
            Nombre Libro: <span id="spNombreLibro"></span><br>
            Descripcion Libro: <span id="spDescripcionLibro"></span>
          </p>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalEliminarLibro','libro_registro.php','#divCuerpo','#divPieModal_e','Eliminando Libro...');">Si, Eliminar</button>
        <div id="divPieModal_e"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#popLibroModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varZonaID=button.data('libroid')
    var varNroZona=button.data('nrolibro')
    var varNombreZona = button.data('nombrelibro') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#txtLibroID').val(varZonaID);
    modal.find('#txtNroLibro').val(varNroZona)
    modal.find('#txtNombreLibro').val(varNombreZona)
    modal.find('#txtDescripcion').val(varDescripcion)
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
  $('#popEliminarLibro').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varZonaID=button.data('libroid_e')
    var varNroZona=button.data('nrolibro_e')
    var varNombreZona = button.data('nombrelibro_e') // Extract info from data-* attributes
    var varDescripcion = button.data('descripcion_e') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)

    modal.find('#txtLibroID_e').val(varZonaID);
    modal.find('#spNroLibro').html(varNroZona)
    modal.find('#spNombreLibro').html(varNombreZona)
    modal.find('#spDescripcionLibro').html(varDescripcion)
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
</script>