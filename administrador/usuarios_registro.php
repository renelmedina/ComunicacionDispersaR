<?php
require_once("../libreria.php");
$registronro=coger_dato_externo("registronro");
echo $registronro;

switch ($registronro) {
  case "NuevoUsuario":
    //extract($_POST);
    $cboTipoAccesoID=coger_dato_externo("cboTipoAccesoID");
    $cboPersonalID=coger_dato_externo("cboPersonalID");
    $txtUsuario=coger_dato_externo("txtUsuario");
    $txtContrasenia=coger_dato_externo("txtContrasenia");
    $vtxtPassword1=GenerarPassword($txtContrasenia);
    $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
    if (!empty($cboTipoAccesoID) && !empty($cboPersonalID) && !empty($txtUsuario) && !empty($txtContrasenia)) {
        $stmt = $ConexionSealDBComunicacionDispersa->prepare("call InsertarAccesoLogin(
                                        :varPersonalID,
                                        :varUsuario,
                                        :varPassword,
                                        :varTipoAcceso)");
        $rows = $stmt->execute(array(':varPersonalID'=>$cboPersonalID,
                                    ':varUsuario'=>$txtUsuario,
                                    ':varPassword'=>$vtxtPassword1,
                                    ':varTipoAcceso'=>$cboTipoAccesoID));
        if($rows > 0){
            msg_verde("Nuevo usuario creado");
            fnCargaSimple("usuarios.php","Mostrando Cambios...","#divPrincipal","#divMensajero");
        }else{
          msg_rojo("Por alguna razon desconocida no se pudo guardar este registro. Intentalo de nuevo");
        }
    }else{
        msg_rojo("Debe llenar los campos obligatorios");
    }
    break;
  case 'ActualizarUsuario':
    $txtAccesoLoginID=coger_dato_externo("txtAccesoLoginID");
    $cboTipoAccesoID_a=coger_dato_externo("cboTipoAccesoID_a");
    $txtPersonalID=coger_dato_externo("txtPersonalID");
    $txtUsuario_a=coger_dato_externo("txtUsuario_a");
    $txtContrasenia_a=coger_dato_externo("txtContrasenia_a");
    $vtxtPassword1=GenerarPassword($txtContrasenia_a);
    $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
    $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
    $stmt = $ConexionSealDBComunicacionDispersa->prepare("call ModificarAccesoLogin(
                                    :varAccesoLoginID,
                                    :varPersonalID,
                                    :varUsuario,
                                    :varPassword,
                                    :varTipoAcceso)");
    $rows = $stmt->execute(array( ':varAccesoLoginID'=>$txtAccesoLoginID,
                                    ':varPersonalID'=>$txtPersonalID,
                                    ':varUsuario'=>$txtUsuario_a,
                                    ':varPassword'=>$vtxtPassword1,
                                    ':varTipoAcceso'=>$cboTipoAccesoID_a));
    if( $rows > 0 ){
        msg_verde("Usuario actualizado");
        echo "<script>$('$popNombreModal').modal('hide');</script>";
        fnCargaSimple("usuarios.php","Mostrando Cambios...","#divPrincipal","#divMensajero");
    }else {
      msg_rojo("Por alguna razon desconocida no se pudo guardar este registro. Intentelo nuevamente");
    }
    $ConexionSealDBComunicacionDispersa=null;
    break;
    case 'EliminarUsuarios':
        $txtUsuariosID_e=coger_dato_externo("txtUsuariosID_e");
        $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
        $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
        $stmt = $ConexionSealDBComunicacionDispersa->prepare("call EliminarAccesoLogin(:varAccesoLoginID)");
        $rows = $stmt->execute(array(':varAccesoLoginID'=>$txtUsuariosID_e));
        if( $rows > 0 ){
            msg_verde("Usuario eliminado");
            //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
            //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
            //echo "Respuesta: ".$stmt[]['errno'];
            echo "<script>$('$popNombreModal').modal('hide');</script>";
            fnCargaSimple("usuarios.php","Mostrando Cambios","#divPrincipal","#divMensajero");
        }else {
          msg_rojo("No se pudo eliminar este registro, verifica que no este vinculado a otros registros. Intentelo nuevamente");
        }
        break;
    case 'IngresarPersonalExterno':
        $txtAccesoLoginID=coger_dato_externo("txtAccesoLoginID_2");

        $txtApellidos=coger_dato_externo("txtApellidos");
        $txtNombres=coger_dato_externo("txtNombres");
        $txtDNI=coger_dato_externo("txtDNI");
        $txtDireccion=coger_dato_externo("txtDireccion");
        $txtTelefonos=coger_dato_externo("txtContrasenia_a");
        $cboRelacionado_a=coger_dato_externo("cboRelacionado_a");
        $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
        $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();

        $Verificador=0;
        echo "<br>$txtAccesoLoginID :: $txtApellidos :: $txtNombres :: $txtDNI :: $txtDireccion :: $txtTelefonos :: $cboRelacionado_a :: $popNombreModal";
        if (empty($cboRelacionado_a)||$cboRelacionado_a=="0") {
            # Se Registra uno Nuevo
            $stmt = $ConexionSealDBComunicacionDispersa->prepare("call PersonalExterno_Insertar(
                                            :varApellidos,
                                            :varNombres,
                                            :varDNI,
                                            :varDireccion,
                                            :varTelefonos)");
            $rows = $stmt->execute(array( ':varApellidos'=>$txtApellidos,
                                            ':varNombres'=>$txtNombres,
                                            ':varDNI'=>$txtDNI,
                                            ':varDireccion'=>$txtDireccion,
                                            ':varTelefonos'=>$txtTelefonos));
            if ($rows>0) {
                $IdObtenido=0;
                foreach ($stmt as $columna) {
                    $IdObtenido=$columna["IdObtenido"];
                }
                $stmt = $ConexionSealDBComunicacionDispersa->prepare("call AccesosLogin_PersonalID(
                                                :varAccesoLoginID,
                                                :varPersonalID)");
                $rows2 = $stmt->execute(array( ':varAccesoLoginID'=>$txtAccesoLoginID,
                                                ':varPersonalID'=>$IdObtenido));
                if ($rows2>0) {
                    # Se registro la actualizacion
                    $Verificador+=1;
                }else{
                    # No se registro la actualizacion
                    echo "Error : 1";

                }
            }else{
                echo "Error : 2";
                # No se registro la actualizacion
            }
        }else{
            # Se Actualiza el Existente
            $stmt = $ConexionSealDBComunicacionDispersa->prepare("call PersonalExterno_Actualizar(
                                            :varPersonalExternoID,
                                            :varApellidos,
                                            :varNombres,
                                            :varDNI,
                                            :varDireccion,
                                            :varTelefonos)");
            $rows3 = $stmt->execute(array(':varPersonalExternoID'=>$cboRelacionado_a,
                                            ':varApellidos'=>$txtApellidos,
                                            ':varNombres'=>$txtNombres,
                                            ':varDNI'=>$txtDNI,
                                            ':varDireccion'=>$txtDireccion,
                                            ':varTelefonos'=>$txtTelefonos));
            if ($rows3>0) {
                $stmt = $ConexionSealDBComunicacionDispersa->prepare("call AccesosLogin_PersonalID(
                                                :varAccesoLoginID,
                                                :varPersonalID)");
                $rows4 = $stmt->execute(array( ':varAccesoLoginID'=>$txtAccesoLoginID,
                                                ':varPersonalID'=>$cboRelacionado_a));
                if ($rows4>0) {
                    $Verificador+=1;
                }
            }else{
                echo "Error : 3";

            }
        }
        if( $Verificador > 0 ){
            msg_verde("Usuario actualizado ($Verificador)");
            //echo "string";
            echo "<script>$('$popNombreModal').modal('hide');</script>";
            fnCargaSimple("usuarios.php","Mostrando Cambios...","#divPrincipal","#divMensajero");
        }else {
          msg_rojo("Por alguna razon desconocida no se pudo guardar este registro. Intentelo nuevamente");
        }
        $ConexionSealDBComunicacionDispersa=null;
        break;
	default:
		# code...
		break;
}
?>