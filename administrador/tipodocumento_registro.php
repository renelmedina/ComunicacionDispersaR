<?php
require_once("../libreria.php");
$registronro=coger_dato_externo("registronro");
echo $registronro;
switch ($registronro) {
  case "NuevoTipoDocumento":
    //extract($_POST);
    $NombreTipoDocumento=coger_dato_externo("txtNombreArea");
    $Descripcion=coger_dato_externo("txtDescripcionArea");
    $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
    if (!empty($NombreTipoDocumento)) {
        $stmt = $ConexionSealDBComunicacionDispersa->prepare("call InsertarTipoDocumento(
                                        :varNombre,
                                        :varDescripcion,
                                        :varImagenReferencial)");
        $rows = $stmt->execute(array(':varNombre'=>$NombreTipoDocumento,
                                    ':varDescripcion'=>$Descripcion,
                                    ':varImagenReferencial'=>null));
        if($rows > 0){
            msg_verde("Nuevo Area Guardada");
            fnCargaSimple("tipodocumento.php","Mostrando Cambios...","#divPrincipal","#divMensajero");
        }else{
          msg_rojo("Por alguna razon desconocida no se pudo guardar este registro. Intentalo de nuevo");
        }
    }
    break;
  case 'ActualizarArea':
    $txtTipoDocumentoID=coger_dato_externo("txtTipoDocumentoID");
    $txtNombreArea=coger_dato_externo("txtNombreArea");
    $txtDescripcion=coger_dato_externo("txtDescripcion");
    $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
    $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
    $stmt = $ConexionSealDBComunicacionDispersa->prepare("call ModificarTipoDocumento(
                                    :varTipoDocumentoID,
                                    :varNombre,
                                    :varDescripcion,
                                    :varImagenReferencial)");
    $rows = $stmt->execute(array(  ':varTipoDocumentoID'=>$txtTipoDocumentoID,
                                    ':varNombre'=>$txtNombreArea,
                                    ':varDescripcion'=>$txtDescripcion,
                                    ':varImagenReferencial'=>null));
    if( $rows > 0 ){
        msg_verde("Area Actualizada");
        echo "<script>$('$popNombreModal').modal('hide');</script>";
        fnCargaSimple("tipodocumento.php","Mostrando Cambios...","#divPrincipal","#divMensajero");
    }else {
      msg_rojo("Por alguna razon desconocida no se pudo guardar este registro. Intentelo nuevamente");
    }
    $ConexionSealDBComunicacionDispersa=null;
    break;
  case 'EliminarSector':
    $txtTipoDocumentoID_e=coger_dato_externo("txtTipoDocumentoID_e");
    $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
    $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
    $stmt = $ConexionSealDBComunicacionDispersa->prepare("call EliminarTipoDocumento(:varTipoDocumentoID)");
    $rows = $stmt->execute(array(':varTipoDocumentoID'=>$txtTipoDocumentoID_e));
    if( $rows > 0 ){
        msg_verde("Area Eliminada");
        //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
        //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
        //echo "Respuesta: ".$stmt[]['errno'];
        echo "<script>$('$popNombreModal').modal('hide');</script>";
        fnCargaSimple("tipodocumento.php","Mostrando Cambios","#divPrincipal","#divMensajero");
    }else {
      msg_rojo("No se pudo eliminar este registro, verifica que no este vinculado a otros registros. Intentelo nuevamente");
    }
	default:
		# code...
		break;
}
?>