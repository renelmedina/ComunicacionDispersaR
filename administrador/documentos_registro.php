<?php
require_once("../libreria.php");
$registronro=coger_dato_externo("registronro");
//echo $registronro;
switch ($registronro) {
  case "NuevoTipoDocumentoDetalle":
    //extract($_POST);
    $cboAreaID=coger_dato_externo("cboAreaID");
    $txtNombreTDD=coger_dato_externo("txtNombreTDD");
    $txtDescripcionTipoDocumento=coger_dato_externo("txtDescripcionTipoDocumento");
    $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
    if (!empty($txtNombreTDD) && !empty($cboAreaID)) {
        $stmt = $ConexionSealDBComunicacionDispersa->prepare("call InsertarTDD(
                                        :varIdTipoDocumento,
                                        :varNombreTDD,
                                        :varDescripcion,
                                        :varImagenReferencial)");
        $rows = $stmt->execute(array(':varIdTipoDocumento'=>$cboAreaID,
                                    ':varNombreTDD'=>$txtNombreTDD,
                                    ':varDescripcion'=>$txtDescripcionTipoDocumento,
                                    ':varImagenReferencial'=>null));
        if($rows > 0){
            msg_verde("Nuevo tipo de documento guardado");
            fnCargaSimple("documentos.php","Mostrando Cambios...","#divPrincipal","#divMensajero");
        }else{
          msg_rojo("Por alguna razon desconocida no se pudo guardar este registro. Intentalo de nuevo");
        }
    }else{
        msg_rojo("Debe llenar los campos obligatorios");
    }
    break;
  case 'ActualizarTDD':
    $txtTDD_ID=coger_dato_externo("txtTDD_ID");
    $cboTipoArea=coger_dato_externo("cboTipoArea");
    $txtNombreTDD=coger_dato_externo("txtNombreTDD_a");
    $txtDescripcionTipoDocumento=coger_dato_externo("txtDescripcion_a");
    $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
    $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
    $stmt = $ConexionSealDBComunicacionDispersa->prepare("call ModificarTDD(
                                    :varTipoDocumentoDetalleID,
                                    :varIdTipoDocumento,
                                    :varNombreTDD,
                                    :varDescripcion,
                                    :varImagenReferencial)");
    $rows = $stmt->execute(array( ':varTipoDocumentoDetalleID'=>$txtTDD_ID,
                                    ':varIdTipoDocumento'=>$cboTipoArea,
                                    ':varNombreTDD'=>$txtNombreTDD,
                                    ':varDescripcion'=>$txtDescripcionTipoDocumento,
                                    ':varImagenReferencial'=>null));
    if( $rows > 0 ){
        msg_verde("Tipo de documento actualizado");
        echo "<script>$('$popNombreModal').modal('hide');</script>";
        fnCargaSimple("documentos.php","Mostrando Cambios...","#divPrincipal","#divMensajero");
    }else {
      msg_rojo("Por alguna razon desconocida no se pudo guardar este registro. Intentelo nuevamente");
    }
    $ConexionSealDBComunicacionDispersa=null;
    break;
  case 'EliminarTDD':
    $txtTDD_ID_e=coger_dato_externo("txtTDD_ID_e");
    $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
    $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
    $stmt = $ConexionSealDBComunicacionDispersa->prepare("call EliminarTDD(:varTipoDocumentoDetalleID)");
    $rows = $stmt->execute(array(':varTipoDocumentoDetalleID'=>$txtTDD_ID_e));
    if( $rows > 0 ){
        msg_verde("Tipo de documento eliminado");
        //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
        //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
        //echo "Respuesta: ".$stmt[]['errno'];
        echo "<script>$('$popNombreModal').modal('hide');</script>";
        fnCargaSimple("documentos.php","Mostrando Cambios","#divPrincipal","#divMensajero");
    }else {
      msg_rojo("No se pudo eliminar este registro, verifica que no este vinculado a otros registros. Intentelo nuevamente");
    }
	default:
		# code...
		break;
}
?>