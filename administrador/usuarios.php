<?php
require_once("../libreria.php");
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$sqlListarPersonalExterno="CALL PersonalExterno_ListarTodo()";
$stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarPersonalExterno);
$stmt->execute();
$ListaPersonalE=array();
foreach ($stmt as $ResultadoPE) {
  $ListaPersonalE[]=$ResultadoPE;
}

$ConexionSealDBComunicacionDispersa= null;
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$sqlListarSector="CALL ListarTodoAccesoLogin()";
$stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarSector);
$stmt->execute();
?>
<table>
  <tr>
    <td>
      <?php
      echo "<table>";
      echo "<tr><th>Nombre Personal</th><th>Usuario</th><th>Tipo Acceso</th><th>Acciones</th></tr>";
      foreach($stmt as $ResultadoUsuarios) {
        $AccesoLoginID=$ResultadoUsuarios['idAccesoLogin'];
        $PersonalID=$ResultadoUsuarios['PersonalID'];
        $Usuario=$ResultadoUsuarios['Usuario'];
        $Password=$ResultadoUsuarios['Contrasenia'];
        $TipoAcceso=$ResultadoUsuarios['TipoAcceso'];
        $NombreAcceso=$ResultadoUsuarios['NombreAcceso'];
        $NombreCompleto=$ResultadoUsuarios['NombresCompletos'];
        echo "<tr>";
        echo "<td>$NombreCompleto</td>";
        echo "<td>$Usuario</td>";
        echo "<td>$NombreAcceso</td>";
        //para enviar lso
        echo "<td>
                <button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#popTipoDocumentoModal' data-accesologinid='$AccesoLoginID' data-personalid='$PersonalID' data-personalnombre='$NombreCompleto' data-tipoaccesoid='$TipoAcceso'>M</button>";
        if ($NombreAcceso=="Personal Temporal") {
          echo "<button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#popPersonalTemporal' data-accesologinid_2='$AccesoLoginID' data-personalid_u='$PersonalID'>M. Datos</button>";
        }
        echo "<button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#popEliminarTipoDocumento' data-accesologinid_e='$AccesoLoginID' data-personalnombre_e='$Usuario'>Eliminar</button>
        </td>";
        echo "</tr>";
      }
      $ConexionSealDBComunicacionDispersa=null;
      echo "</table>";
      ?>
    </td>

    <td style="width: 40%;">
      <div class="card border-info mb-2">
        <form name="importa" id="frmtipodocumento" method="post" enctype="multipart/form-data" onsubmit="return false;" >
          <div class="card-header bg-info">Nuevo Usuario</div>
          <div class="card-body">
            <div class="btn-group" role="group">
              Tipo de Acceso:
              <select name="cboTipoAccesoID" id="cboTipoAccesoID" class="form-control">
                <?php
                  $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
                  $sqlListarSector="CALL ListarTodoTiposAcceso()";//cero significa que mostrara toda la lista
                  $stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarSector);
                  $stmt->execute();
                  $ListaTipoUsuarios=array();
                  foreach($stmt as $ResultadoUsuarios) {
                    $ListaTipoUsuarios[]=$ResultadoUsuarios;
                    $TiposAccesoID=$ResultadoUsuarios['idTiposAcceso'];
                    $NombreAcceso=$ResultadoUsuarios['NombreAcceso'];
                    echo "<option value='$TiposAccesoID'>$NombreAcceso</option>";
                  }
                  $ConexionSealDBComunicacionDispersa=null;
                ?>
                
              </select>
            </div>
            <div class="btn-group" role="group">
              <label class="form-control" for="">Personal:</label>
              <select name="cboPersonalID" id="cboPersonalID" class="form-control">
                <?php
                  $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
                  $sqlListarSector="CALL ListarPersonalSealPersonalACC()";//cero significa que mostrara toda la lista
                  $stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarSector);
                  $stmt->execute();
                  $ListaPersonal=array();
                  foreach($stmt as $ListaPersonalACC) {
                    $ListaPersonal[]=$ListaPersonalACC;
                    $PersonalACCID=$ListaPersonalACC['id'];
                    $NombreCompleto=$ListaPersonalACC['nombre_completo'];
                    $ApellidoPaterno=$ListaPersonalACC['apellido_paterno'];
                    $ApellidoMaterno=$ListaPersonalACC['apellido_materno'];
                    $SubZonalID=$ListaPersonalACC['subzonalID'];
                    $Foto=$ListaPersonalACC['foto'];
                    echo "<option value='$PersonalACCID'>$ApellidoPaterno $ApellidoMaterno $NombreCompleto</option>";
                  }
                  $ConexionSealDBComunicacionDispersa=null;
                ?>
                <option value='-1'>Personal Externo 1</option>
                <option value='-2'>Personal Externo 2</option>
                <option value='-3'>Personal Externo 3</option>
                <option value='-4'>Personal Externo 4</option>
                <option value='-5'>Personal Externo 5</option>
                <option value='-6'>Personal Externo 6</option>
                <option value='-7'>Personal Externo 7</option>
                <option value='-8'>Personal Externo 8</option>
                <option value='-9'>Personal Externo 9</option>
                <option value='-10'>Personal Externo 10</option>
              </select>
            </div><br>
            <label for="">Usuario:</label>
            <input type="text" name="txtUsuario" class="form-control" placeholder="Usuario">
            <label for="">Contraseña:</label>
            <input type="text" name="txtContrasenia" class="form-control" placeholder="Contraseña">
            <input type="hidden" name="registronro" value="NuevoUsuario"><br>
            <input type='button' class="btn btn-primary" name='enviar' value="Crear Usuario" onclick="envio_general_forms('#frmtipodocumento','usuarios_registro.php','#divCuerpo','#divPieCard','Creando usuario...');" />
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
      <form name="frmUsuarios_a" id="frmUsuarios_a">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popTipoDocumentoModalLabel">Actualizar Usuarios</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popTipoDocumentoModal">
          <input type="hidden" name="txtAccesoLoginID" id="txtAccesoLoginID">
          <input type="hidden" name="txtPersonalID" id="txtPersonalID">
          <label for="">Tipo de Acceso:</label>
          <select name="cboTipoAccesoID_a" id="cboTipoAccesoID_a" class="form-control">
            <?php
              foreach($ListaTipoUsuarios as $ResultadoUsuarios) {
                $TiposAccesoID=$ResultadoUsuarios['idTiposAcceso'];
                $NombreAcceso=$ResultadoUsuarios['NombreAcceso'];
                echo "<option value='$TiposAccesoID'>$NombreAcceso</option>";
              }
            ?>
          </select>
          <label for="txtUsuario_a" class="col-form-label">Personal Asignado:</label>
          <input type="text" id="txtPersonalNombre_a" name="txtPersonalNombre_a" class="form-control" disabled>
          <label for="txtUsuario_a" class="col-form-label">Usuario:</label>
          <input type="text" id="txtUsuario_a" name="txtUsuario_a" class="form-control">
          <label for="txtContrasenia_a" class="col-form-label">Contraseña:</label>
          <input type="text" id="txtContrasenia_a" name="txtContrasenia_a" class="form-control">
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmUsuarios_a','usuarios_registro.php?registronro=ActualizarUsuario','#divCuerpo','#divPieModal','Guardando Cambios...');">Guardar Cambios</button>
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
      <form name="frmModalEliminarUsuarios" id="frmModalEliminarUsuarios">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popEliminarTipoDocumentoLabel">Eliminar Usuarios</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popEliminarTipoDocumento">
          <input type="hidden" name="txtUsuariosID_e" id="txtUsuariosID_e">
          
          <p><strong>¿Estas seguro de eliminar este tipo de documento?</strong><br>
            Usuario: <span id="spUsuario"></span><br>
          </p>
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmModalEliminarUsuarios','usuarios_registro.php?registronro=EliminarUsuarios','#divCuerpo','#divPieModal_e','Eliminando tipo de documento...');">Si, Eliminar</button>
        <div id="divPieModal_e"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<!--Popup Para Ingresar Personal Temporal-->
<div class="modal fade" id="popPersonalTemporal" tabindex="-1" role="dialog" aria-labelledby="popPersonalTemporalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="form-group">
      <form name="frmPersonalExterno_u" id="frmPersonalExterno_u">
      <div class="modal-content">
        <div class="modal-header text-white bg-info">
          <h5 class="modal-title" id="popPersonalTemporalLabel">Personal Temporal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="popNombreModal" value="#popPersonalTemporal">
          <input type="hidden" name="txtAccesoLoginID_2" id="txtAccesoLoginID_2">
          <label for="">Vinculado a:</label>
          <select name="cboRelacionado_a" id="cboRelacionado_a" class="form-control">
            <option value="0">- Nuevo Personal Externo -</option>
            <?php
              foreach($ListaPersonalE as $ResultadoPersonalExterno) {
                $PersonalExternoID=$ResultadoPersonalExterno['idPersonalExterno'];
                $Apellidos=$ResultadoPersonalExterno['Apellidos'];
                $Nombres=$ResultadoPersonalExterno['Nombres'];
                $DNI=$ResultadoPersonalExterno['DNI'];
                $Direccion=$ResultadoPersonalExterno['Direccion'];
                $Telefonos=$ResultadoPersonalExterno['Telefonos'];
                echo "<option value='$PersonalExternoID'>$Apellidos $Nombres</option>";
              }
            ?>
          </select>
          <label for="txtApellidos" class="col-form-label">Apellidos:</label>
          <input type="text" id="txtApellidos" name="txtApellidos" class="form-control">
          <label for="txtNombres" class="col-form-label">Nombres:</label>
          <input type="text" id="txtNombres" name="txtNombres" class="form-control">
          <label for="txtDNI" class="col-form-label">DNI:</label>
          <input type="text" id="txtDNI" name="txtDNI" class="form-control">
          <label for="txtDireccion" class="col-form-label">Direccion:</label>
          <input type="text" id="txtDireccion" name="txtDireccion" class="form-control">
          <label for="txtTelefonos" class="col-form-label">Telefonos:</label>
          <input type="text" id="txtTelefonos" name="txtTelefonos" class="form-control">
        </div>
      </div>
      <div class="modal-footer bg-info">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="envio_general_forms('#frmPersonalExterno_u','usuarios_registro.php?registronro=IngresarPersonalExterno','#divCuerpo','#divPieModal_u','Guardando Cambios...');">Guardar Cambios Realizados</button>
        <div id="divPieModal_u"></div>
      </div>
    </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('#popTipoDocumentoModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varAccesoLoginID=button.data('accesologinid');
    var varTipoAccesoID=button.data('tipoaccesoid');
    var varPersonalID=button.data('personalid');
    var varPersonalNombre = button.data('personalnombre'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('#txtAccesoLoginID').val(varAccesoLoginID);
    modal.find('#cboTipoAccesoID_a').val(varTipoAccesoID);
    modal.find('#txtPersonalID').val(varPersonalID)
    modal.find('#txtPersonalNombre_a').val(varPersonalNombre);
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
  $('#popEliminarTipoDocumento').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varAccesoLoginID_e = button.data('accesologinid_e');
    var varNombre = button.data('personalnombre_e'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('#txtUsuariosID_e').val(varAccesoLoginID_e);
    modal.find('#spUsuario').html(varNombre);
    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
  
  $('#popPersonalTemporal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    //Es importante que los data-zonaid='valor', la propieda sea todo en minusculas
    var varAccesoLoginID_u = button.data('accesologinid_2');
    var varPersonalID_u=button.data('personalid_u')
    //var varNombre = button.data('personalnombre_e'); // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this);
    modal.find('#txtAccesoLoginID_2').val(varAccesoLoginID_u);
    modal.find('#cboRelacionado_a').val(varPersonalID_u);
    //modal.find('#cboPersonalID').val(varPersonalID);

    /*modal.find("#cboRelacionado_a > option[value='"+varAccesoLoginID_u+"']").attr({
      selected: 'selected'
    });*/

    /*modal.find('.modal-title').val('New message to ' + varDescripcion)
    modal.find('.modal-body input').val(varDescripcion)*/
  })
</script>