<?php
require_once("../libreria.php");
$registronro=coger_dato_externo("registronro");
switch ($registronro) {
  case "IngresarTipo":
    $contadorguardados=0;
    $txtNombreTipo=coger_dato_externo("txtNombreTipo");
    $txtDescripcionTipo=coger_dato_externo("txtDescripcionTipo");
    if (empty($txtNombreTipo)) {
        msg_rojo("Debes ingresar un nombre");
        return;
    }
    $ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
    $stmt = $ConexionSealDBGeneralidades->prepare("call IngresarTipoContrato(
                                    :varNombreTipo,
                                    :varDescripcionTipo)");
    $rows = $stmt->execute(array(':varNombreTipo'=>$txtNombreTipo,
                                    ':varDescripcionTipo'=>$txtDescripcionTipo));
    if( $rows > 0 ){
        msg_verde("Registro Guardado");
        fnCargaSimple("tipocontrato.php","Mostrando Cambios","#divPrincipal","#divMensajero");
    }else {
      msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro. intentalo de nuevo.");
    }
    break;
  case 'ActualizarTipo':
    $txtTipoID=coger_dato_externo("txtTipoID");
    $NombreTipo=coger_dato_externo("txtNombreTipo");
    $DescripcionTipo=coger_dato_externo("txtDescripcion");
    $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
    $ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
    $stmt = $ConexionSealDBGeneralidades->prepare("call ModificarTipoContrato(
                                    :varTipoContratoID,
                                    :varNombreTipo,
                                    :varDescripcionTipo)");
    $rows = $stmt->execute(array(  ':varTipoContratoID'=>$txtTipoID,
                                    ':varNombreTipo'=>$NombreTipo,
                                    ':varDescripcionTipo'=>$DescripcionTipo));
    if( $rows > 0 ){
        msg_verde("Tipo de contrato actualizado");
        //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
        //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
        //echo "Respuesta: ".$stmt[]['errno'];
        echo "<script>$('$popNombreModal').modal('hide');</script>";
        fnCargaSimple("tipocontrato.php","Mostrando Cambios...","#divPrincipal","#divMensajero");
    }else {
      msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro. Intentelo nuevamente");
    }
    break;
  case 'EliminarTipo':
    $txtTipoID_e=coger_dato_externo("txtTipoID_e");
    $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
    $ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
    $stmt = $ConexionSealDBGeneralidades->prepare("call EliminarTipoContrato(:varTipoContratoID)");
    $rows = $stmt->execute(array(':varTipoContratoID'=>$txtTipoID_e));
    if( $rows > 0 ){
        msg_verde("Tipo Contrato Eliminado");
        //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
        //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
        //echo "Respuesta: ".$stmt[]['errno'];
        echo "<script>$('$popNombreModal').modal('hide');</script>";
        fnCargaSimple("tipocontrato.php","Mostrando Cambios","#divPrincipal","#divMensajero");
    }else {
      msg_rojo("No se pudo eliminar este registro, verifica que no este vinculado a otros registros. Intentelo nuevamente");
    }
	default:
		# code...
		break;
}
?>d