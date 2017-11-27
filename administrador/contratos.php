<?php
require_once("../libreria.php");
$ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
$varTipoID=(coger_dato_externo("cboTipoContrato")==null?0:coger_dato_externo("cboTipoContrato"));//tipo de contrato
$varZonaID=(coger_dato_externo("cboZonaId")==null?0:coger_dato_externo("cboZonaId"));
$varSectorID=(coger_dato_externo("cboSectorId")==null?0:coger_dato_externo("cboSectorId"));
$varLibroID=(coger_dato_externo("cboLibroId")==null?0:coger_dato_externo("cboLibroId"));
$varHoja=(coger_dato_externo("cboHojaId")==null?0:coger_dato_externo("cboHojaId"));
$varDatoBuscar=(coger_dato_externo("txtDatosBuscar")==null?0:coger_dato_externo("txtDatosBuscar"));
$varBuscarEn=(coger_dato_externo("cboBuscarEn")==null?0:coger_dato_externo("cboBuscarEn"));
$varPaginaActual=(coger_dato_externo("hdPaginaAntual")==null?1:coger_dato_externo("hdPaginaAntual"));
$varPaginasMostrar=50;//cantidad de registros a mostrar
$sqlListarContratos="CALL ContratosMedidores_Busqueda($varTipoID,$varZonaID,$varSectorID,$varLibroID,$varHoja,$varDatoBuscar,$varDatoBuscar,$varPaginaActual,$varPaginasMostrar)";
$stmt=$ConexionSealDBGeneralidades->prepare($sqlListarContratos);
$stmt->execute();
$ConexionSealDBGeneralidades=null;
#Listando Tipo de Contrato
$ConexionSealDBGeneralidades_TC= new ConexionSealDBGeneralidades();
$sqlListarTipoContratos="CALL ListarTodoTipoContrato();";
$stmtTipoContratos=$ConexionSealDBGeneralidades_TC->prepare($sqlListarTipoContratos);
$stmtTipoContratos->execute();
$ListaTipoContrato=array();
foreach($stmtTipoContratos as $stmtListaTipoContratos) {
  $ListaTipoContrato[]=$stmtListaTipoContratos;
}
?>
<form action="" id="frmBuscarContratos" name="frmBuscarContratos" onsubmit="envio_general_forms('#frmBuscarContratos','contratos.php','#divPrincipal','#divMensajero','Buscando...');return false;">
  <div class="row">
    <div class="col"><!--class="col-lg-6"-->
      <div class="input-group">
        <span class="input-group-addon">Tipo Contrato</span>
        <select name="cboTipoContrato" id="cboTipoContrato" class="form-control">
          <option value="0">Todos</option>
          <?php
            foreach ($ListaTipoContrato as $LitaTipoContrato) {
              $idTipoContrato=$LitaTipoContrato["idTipoContrato"];
              $NombreTipo=$LitaTipoContrato["NombreTipo"];
              $DescripcionTipo=$LitaTipoContrato["DescripcionTipo"];
              echo "<option value='$idTipoContrato'>$NombreTipo</option>";
            }
          ?>
        </select>
        <span class="input-group-addon">Zona:</span>
        <select name="cboZonaId" id="cboZonaId" class="form-control">
          <option value="0">Todos</option>
        </select>
        <span class="input-group-addon">Sector:</span>
        <select name="cboSectorId" id="cboSectorId" class="form-control">
          <option value="0">Todos</option>
        </select>
        <span class="input-group-addon">Libro:</span>
        <select name="cboLibroId" id="cboLibroId" class="form-control">
          <option value="0">Todos</option>
        </select>
        <span class="input-group-addon">Hoja:</span>
        <select name="cboHojaId" id="cboHojaId" class="form-control">
          <option value="0">Todos</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="input-group">
        <span class="input-group-addon">Buscar:</span>
        <input type="text" name="txtDatosBuscar" class="form-control" placeholder="Dato a Buscar">
        <select name="cboBuscarEn" id="cboBuscarEn" class="form-control">
          <option value="0">Todos</option>
          <option value="1">Nim</option>
          <option value="2">Cliente</option>
          <option value="3">Direccion</option>
          <option value="4">Sed</option>
          <option value="5">Longitud</option>
          <option value="6">Latitud</option>
        </select>
        <span class="input-group-btn">
          <button class="btn btn-info" type="button" onclick="envio_general_forms('#frmBuscarContratos','contratos.php','#divPrincipal','#divMensajero','Buscando...');">Buscar</button>
        </span>
      </div>
    </div>
  </div>
</form>
<table>
  <tr>
    <td>
      <table>
        <tr>
          <th>NroContrato</th>
          <th>Zon</th>
          <th>Sec</th>
          <th>Libro</th>
          <th>Hoja</th>
          <th>T.C.</th><!--Tipo de contrato-->
          <th>Nim</th>
          <th>Cliente</th>
          <th>Direccion</th>
          <th>Sed</th>
          <th>Latitud</th>
          <th>Longitud</th>
          <th>Acciones</th>
        </tr>
      <?php
      foreach($stmt as $ResultadoContrato) {
        $NroContrato=$ResultadoContrato["NroContrato"];
        $ZonaID=$ResultadoContrato["ZonaID"];
        $NroZona=$ResultadoContrato["NroZona"];
        $NombreZona=$ResultadoContrato["NombreZona"];
        $SectorID=$ResultadoContrato["SectorID"];
        $NroSector=$ResultadoContrato["NroSector"];
        $NombreSector=$ResultadoContrato["NombreSector"];
        $LibroID=$ResultadoContrato["LibroID"];
        $NroLibro=$ResultadoContrato["NroLibro"];
        $NombreLibro=$ResultadoContrato["NombreLibro"];
        $Hoja=$ResultadoContrato["Hoja"];
        $TipoID=$ResultadoContrato["TipoID"];
        $NombreTipo=$ResultadoContrato["NombreTipo"];//Tipo de contrato
        $Nim=$ResultadoContrato["Nim"];
        $NombresDuenio=$ResultadoContrato["NombresDuenio"];
        $DireccionMedidor=$ResultadoContrato["DireccionMedidor"];
        $Sed=$ResultadoContrato["Sed"];
        $Longitud=$ResultadoContrato["Longitud"];
        $Latitud=$ResultadoContrato["Latitud"];
        echo "<tr>";
        echo "<td>$NroContrato</td>";
        echo "<td>$NroZona</td>";
        echo "<td>$NroSector</td>";
        echo "<td>$NroLibro</td>";
        echo "<td>$Hoja</td>";
        echo "<td>$NombreTipo</td>";
        echo "<td>$Nim</td>";
        echo "<td>$NombresDuenio</td>";
        echo "<td>$DireccionMedidor</td>";
        echo "<td>$Sed</td>";
        echo "<td>$Longitud</td>";
        echo "<td>$Latitud</td>";
        //para enviar lso
        echo "<td>
                <button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#popSectorModal' data-sectorid='$SectorID' data-nombresector='$NombreSector' data-descripcion='".$DescripcionSector."' data-nrosector='$NroSector'>Modificar</button>
                <button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#popEliminarSector' data-sectorid_e='$SectorID' data-nombresector_e='$NombreSector' data-descripcion_e='".$DescripcionSector."' data-nrosector_e='$NroSector'>Eliminar</button>
        </td>";
        echo "</tr>";
      }
      ?>
      </table>
    </td>
    <td>
      <div class="card border-info text-center mb-4">
        <form name="frmImportarContratos" id="frmImportarContratos" method="post" enctype="multipart/form-data" onsubmit="return false;" >
        <div class="card-header bg-info">Actualizar Contratos en Bloque</div>
        <div class="card-body">
          <div class="row">
            <div class="col">
              <div class="input-group">
                <span class="input-group-addon">Tipo Contrato:</span>
                <select name="cboTipoContrato_a" id="cboTipoContrato_a" class="form-control">
                  <?php
                    foreach ($ListaTipoContrato as $LitaTipoContrato) {
                      $idTipoContrato=$LitaTipoContrato["idTipoContrato"];
                      $NombreTipo=$LitaTipoContrato["NombreTipo"];
                      $DescripcionTipo=$LitaTipoContrato["DescripcionTipo"];
                      echo "<option value='$idTipoContrato'>$NombreTipo</option>";
                    }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="input-group">
                <input type="file" name="excel" class="form-control"/>
                <input type="hidden" class="btn btn-primary" value="upload" name="action" />
                <input type="hidden" name="registronro" value="ImportarContratos">
                <span class="input-group-btn">
                  <button class="btn btn-info" type="button" onclick="envio_general_forms('#frmImportarContratos','contratos_registro.php','#divPieCard','#divPieCard','Importando...');">Importar</button>
                </span>
              </div>
            </div>
          </div>
          <p class="card-text">Sube un archivo con el formato correcto para insertar o actualizar todos los contratos</p>
          </form>
          <div id="divPieCard"></div>
          <div id="divCuerpo"></div>
        </div>
      </div>
    </td>
  </tr>
</table>
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
</script>|