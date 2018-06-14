<?php
require_once("../libreria.php");
$ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
$varTipoID=(coger_dato_externo("cboTipoContrato")==null?0:coger_dato_externo("cboTipoContrato"));//tipo de contrato
$varZonaID=(coger_dato_externo("cboZonaId")==null?0:coger_dato_externo("cboZonaId"));
$varSectorID=(coger_dato_externo("cboSectorId")==null?0:coger_dato_externo("cboSectorId"));
$varLibroID=(coger_dato_externo("cboLibroId")==null?0:coger_dato_externo("cboLibroId"));
$varHoja=(coger_dato_externo("cboHojaId")==null?0:coger_dato_externo("cboHojaId"));
$varDatoBuscar=(coger_dato_externo("txtDatosBuscar")==null?"":coger_dato_externo("txtDatosBuscar"));
$varBuscarEn=(coger_dato_externo("cboBuscarEn")==null?0:coger_dato_externo("cboBuscarEn"));
$varPaginaActual=(coger_dato_externo("hdPaginaAntual")==null?1:coger_dato_externo("hdPaginaAntual"));
$varPaginasMostrar=200;//cantidad de registros a mostrar
#Contando la cantidad total de la busqueda en la tabla contrato
$sqlCantidad="CALL ContratosMedidores_Busqueda_Cantidad2($varTipoID,$varZonaID,$varSectorID,$varLibroID,'$varHoja','$varDatoBuscar',$varBuscarEn)";
$stmtCantidad= $ConexionSealDBGeneralidades->prepare($sqlCantidad);
$stmtCantidad->execute();
$ListaCantidadSolicitud=array();
foreach($stmtCantidad as $CantidadSolicitud) {
  $ListaCantidadSolicitud[]=$CantidadSolicitud;
}
$PaginasTotales=ceil($ListaCantidadSolicitud[0]["total"]/$varPaginasMostrar);//Ceil redondea un numero, funcion de php
$ConexionSealDBGeneralidades=null;//cerramos la conexion

//Artilugio para poner la cantidad de paginas
$pagina_actual2=($varPaginaActual-1)*$varPaginasMostrar;
#Haciendo Busqueda en la tabla contratos, con Limit, para que este paginado
$ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
$sqlListarContratos="CALL ContratosMedidores_Busqueda2($varTipoID,$varZonaID,$varSectorID,$varLibroID,'$varHoja','$varDatoBuscar',$varBuscarEn,$pagina_actual2,$varPaginasMostrar)";
//echo $sqlListarContratos."<br>";
$stmt=$ConexionSealDBGeneralidades->prepare($sqlListarContratos);
$stmt->execute();
$ListaContratosBusqueda=array();
foreach($stmt as $stmtListaContratosBusquedas) {
  $ListaContratosBusqueda[]=$stmtListaContratosBusquedas;
}
$ConexionSealDBGeneralidades=null;//cerramos la conexion

?>
Registros encontrados: <?php echo $ListaCantidadSolicitud[0]["total"]; ?>
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
          <th>GPS</th>
          <!--<th>Latitud</th>
          <th>Longitud</th>-->
          <th>Acciones</th>
        </tr>
      <?php
      foreach($ListaContratosBusqueda as $ResultadoContrato) {
        $NroContrato=$ResultadoContrato["NroContrato"];
        $NroZona=$ResultadoContrato["NroZona"];
        $NroSector=$ResultadoContrato["SectorNro"];
        $NroLibro=$ResultadoContrato["LibroNro"];
        $NroHoja=$ResultadoContrato["HojaNro"];
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
        echo "<td>$NroHoja</td>";
        echo "<td>$NombreTipo</td>";
        echo "<td>$Nim</td>";
        echo "<td>$NombresDuenio</td>";
        echo "<td>$DireccionMedidor</td>";
        echo "<td>$Sed</td>";
        if (!empty($Longitud) && !empty($Latitud)) {
          echo "<td><a href='mapaxuno.php?lat=$Latitud&lng=$Longitud' target='_blank'><span class='icon icon-location' style='font-size: 14px;'></span></a></td>";
        }else{
          echo "<td>-</td>";
        }
        //echo "<td>$Longitud</td>";
        //echo "<td>$Latitud</td>";
        //para enviar lso
        echo "<td>
                <button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#popSectorModal' data-sectorid='$SectorID' data-nombresector='$NombreSector' data-descripcion='".$DireccionMedidor."' data-nrosector='$NroSector'>M</button>
                <button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#popEliminarSector' data-sectorid_e='$SectorID' data-nombresector_e='$NombreSector' data-descripcion_e='".$DireccionMedidor."' data-nrosector_e='$NroSector'>E</button>
        </td>";
        echo "</tr>";
      }
      ?>
      </table>
    </td>
    <td>
      
    </td>
  </tr>
</table>
<!--Paginado-->
<?php
# Paginado
$PaginaNavega="contratos_lista.php?cboTipoContrato=$varTipoID&cboZonaId=$varZonaID&cboSectorId=$varSectorID&cboLibroId=$varLibroID&cboHojaId=$varHoja&txtDatosBuscar=$varDatoBuscar&cboBuscarEn=$varBuscarEn";
$PaginaAnterior=($varPaginaActual>0?$varPaginaActual-1:1);
$PAnterior=$PaginaNavega."&hdPaginaAntual=$PaginaAnterior";
$PaginaSiguiente=($varPaginaActual<$PaginasTotales?$varPaginaActual+1:$PaginasTotales);
$PSiguiente=$PaginaNavega."&hdPaginaAntual=$PaginaSiguiente";
?>
<nav aria-label="navPaginado">
  <ul class="pagination justify-content-center">
    <?php
    $verificar1raPagina=($varPaginaActual<=1?"disabled":"");
    echo "<li class='page-item $verificar1raPagina'><a class='page-link' href=\"javascript:fnCargaSimple('$PAnterior','Cargando pagina $PaginaAnterior...','#divListaContratos','#divmensajero');\">Anterior</a></li>";
    $paginafinlimite=$PaginasTotales;
        $paginainilimite=1;
        $condicion=0;
        if ($PaginasTotales-$varPaginaActual<=10) {
          $paginafinlimite=$PaginasTotales+1;
          $paginainilimite=$PaginasTotales-10;
          $condicion=1;
        }else if($varPaginaActual+10==$PaginasTotales){
          $paginafinlimite=$PaginasTotales+1;
          $paginainilimite=$varPaginaActual;
          $condicion=2;
        }else if($varPaginaActual<=10){
          $paginafinlimite=$varPaginaActual+10;
          $paginainilimite=$varPaginaActual;
        }else{
          $paginafinlimite=$varPaginaActual+5;
          $paginainilimite=$varPaginaActual-5;
          $condicion=4;
        }
    /*for ($i=1; $i <=$PaginasTotales ; $i++) {
      if ($varPaginaActual!=$i) {
        $PaginaNavega.="&hdPaginaAntual=$i";
        echo "<li class='page-item'><a class='page-link' href=\"javascript:fnCargaSimple('$PaginaNavega','Cargando pagina $i...','#divListaContratos','#divmensajero');\">$i</a></li>";
      }else {
        echo "<li class='page-item active'><span class='page-link'>$i</span></li>";
      }
    }*/

    if ($PaginasTotales>10) {
            for ($i=$paginainilimite; $i < ($paginafinlimite) ; $i++) {
              if ($varPaginaActual!=$i) {
                //$PaginaNavega.="&hdPaginaActual=$i";
                $navegacionpag=$PaginaNavega."&hdPaginaActual=$i";
                echo "<li class='page-item'><a class='page-link' href=\"javascript:fnCargaSimple('$navegacionpag','Cargando pagina $i...','#divPrincipal','#divMensajero');\">$i</a></li>";
              }else {
                echo "<li class='page-item active'><span class='page-link'>$i</span></li>";
              }
            }
        }else{
          for ($i=1; $i <=$PaginasTotales ; $i++) {
            if ($varPaginaActual!=$i) {
              //$PaginaNavega.="&hdPaginaActual=$i";
              $navegacionpag=$PaginaNavega."&hdPaginaActual=$i";
              echo "<li class='page-item'><a class='page-link' href=\"javascript:fnCargaSimple('$navegacionpag','Cargando pagina $i...','#divPrincipal','#divMensajero');\">$i</a></li>";
            }else {
              echo "<li class='page-item active'><span class='page-link'>$i</span></li>";
            }
          }
        }
    $verificarUltimaPagina=($varPaginaActual>=$PaginasTotales?"disabled":"");
    echo "<li class='page-item $verificarUltimaPagina'><a class='page-link' href=\"javascript:fnCargaSimple('$PSiguiente','Cargando pagina $PaginaSiguiente...','#divListaContratos','#divmensajero');\">Siguiente</a></li>";
    ?>
  </ul>
</nav>
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