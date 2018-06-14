<?php
require_once("../libreria.php");
$registronro=coger_dato_externo("registronro");
//echo $registronro;
switch ($registronro) {
  case "NuevoTDDD":
    //extract($_POST);
    $cboTipodocumentoID=coger_dato_externo("cboTipodocumentoID");
    $txtNombreTDDD=coger_dato_externo("txtNombreTDDD");
    $txtDescripcionTDDD=coger_dato_externo("txtDescripcionTDDD");
    $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
    if (!empty($txtNombreTDDD) && !empty($cboTipodocumentoID)) {
        $stmt = $ConexionSealDBComunicacionDispersa->prepare("call InsertarTDD_Detalle(
                                        :varTipoDocumentoDetalleID,
                                        :varNombre,
                                        :varDescripcion,
                                        :varImagenReferencial)");
        $rows = $stmt->execute(array(':varTipoDocumentoDetalleID'=>$cboTipodocumentoID,
                                    ':varNombre'=>$txtNombreTDDD,
                                    ':varDescripcion'=>$txtDescripcionTDDD,
                                    ':varImagenReferencial'=>null));
        if($rows > 0){
            msg_verde("Nuevo subtipo de documento guardado");
            fnCargaSimple("subdocumentos.php","Mostrando Cambios...","#divPrincipal","#divMensajero");
        }else{
          msg_rojo("Por alguna razon desconocida no se pudo guardar este registro. Intentalo de nuevo");
        }
    }else{
        msg_rojo("Debe llenar los campos obligatorios");
    }
    break;
  case 'ActualizarTDDD':
    $txtTDDD_ID=coger_dato_externo("txtTDDD_ID");
    $cboTipoDocuento_a=coger_dato_externo("cboTipoDocuento_a");
    $txtNombreTDDD_a=coger_dato_externo("txtNombreTDDD_a");
    $txtDescripcion_a=coger_dato_externo("txtDescripcion_a");
    $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
    $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
    $stmt = $ConexionSealDBComunicacionDispersa->prepare("call ModificarTDD_Detalle(
                                    :varTDD_DetalleID,
                                    :varTipoDocumentoDetalleID,
                                    :varNombre,
                                    :varDescripcion,
                                    :varImagenReferencial)");
    $rows = $stmt->execute(array( ':varTDD_DetalleID'=>$txtTDDD_ID,
                                    ':varTipoDocumentoDetalleID'=>$cboTipoDocuento_a,
                                    ':varNombre'=>$txtNombreTDDD_a,
                                    ':varDescripcion'=>$txtDescripcion_a,
                                    ':varImagenReferencial'=>null));
    if( $rows > 0 ){
        msg_verde("Subtipo de documento actualizado");
        echo "<script>$('$popNombreModal').modal('hide');</script>";
        fnCargaSimple("subdocumentos.php","Mostrando Cambios...","#divPrincipal","#divMensajero");
    }else {
      msg_rojo("Por alguna razon desconocida no se pudo guardar este registro. Intentelo nuevamente");
    }
    $ConexionSealDBComunicacionDispersa=null;
    break;
  case 'EliminarTDDD':
    $txtTDDD_ID_e=coger_dato_externo("txtTDDD_ID_e");
    $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
    $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
    $stmt = $ConexionSealDBComunicacionDispersa->prepare("call EliminarTDD_Detalle(:varTDD_DetalleID)");
    $rows = $stmt->execute(array(':varTDD_DetalleID'=>$txtTDDD_ID_e));
    if( $rows > 0 ){
        msg_verde("Subtipo de documento eliminado");
        //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
        //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
        //echo "Respuesta: ".$stmt[]['errno'];
        echo "<script>$('$popNombreModal').modal('hide');</script>";
        fnCargaSimple("subdocumentos.php","Mostrando Cambios","#divPrincipal","#divMensajero");
    }else {
      msg_rojo("No se pudo eliminar este registro, verifica que no este vinculado a otros registros. Intentelo nuevamente");
    }
	default:
		# code...
		break;
}
?>