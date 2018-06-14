<?php
require_once("../libreria.php");
$Usuario=coger_dato_externo("usuario");
$Password=coger_dato_externo("password");
$Password=GenerarPassword($Password);
$varDocumentosTrabajoID=coger_dato_externo("DocumentosTrabajoID");
$varFechaAsignado=coger_dato_externo("FechaAsignado");
$varFechaEjecutado=coger_dato_externo("FechaEjecutado");
$varEstado=coger_dato_externo("Estado");
$varEstadoSeal=coger_dato_externo("EstadoSeal");
$varNombreRecepcionador=coger_dato_externo("NombreRecepcionador");
$varDNIRecepcionador=coger_dato_externo("DNIRecepcionador");
$varParentesco=coger_dato_externo("Parentesco");
$varLecturaMedidor=coger_dato_externo("LecturaMedidor");
$varLatitudVisita=coger_dato_externo("LatitudVisita");
$varLongitudVisita=coger_dato_externo("LongitudVisita");
$varObservaciones=coger_dato_externo("Observaciones");
$varNroSuministro=coger_dato_externo("NroSuministro");
$CodigoPersonal=0;
$CodigoEstado=0;
$TextoEstado="face inical";
header("Content-type: text/xml");
$TextoXml='<?xml version="1.0" encoding="utf-8"?>';
$TextoXml.="<datos>";
//Logeando en el sistema
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$stmtScriptSQL=$ConexionSealDBComunicacionDispersa->prepare("CALL AccesoLogin(:usuario,:password)");
$stmtScriptSQL->execute(array(
	':usuario'=>$Usuario,
	':password'=>$Password
));
$num_rows_SQL = $stmtScriptSQL->rowCount();
if ($num_rows_SQL>0) {
	$CodigoEstado=1;
	$TextoEstado="Acceso Correcto";
	foreach($stmtScriptSQL as $ListaSQL) {
		$idAccesoLogin=$ListaSQL["idAccesoLogin"];
		$CodigoPersonal=$ListaSQL["PersonalID"];
		$Usuario=$ListaSQL["Usuario"];
		$Password=$ListaSQL["Password"];
		$TipoAcceso=$ListaSQL["TipoAcceso"];
		$NombrePersonal=$ListaSQL["NombrePersonal"];
	}
}else{
	$CodigoEstado=2;//Significa Acceso Denegado, usuario y contraseña incorrecto
	$TextoEstado="Usuario o Contraseña Incorrectos...";
}
//echo $CodigoPersonal;

//verificando si el acceso es correcto
if ($CodigoEstado==1) {
	$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
	$stmtScriptSQL=$ConexionSealDBComunicacionDispersa->prepare("call WS_RegistrarVisitaXId(
		:varDocumentosTrabajoID,
		:varNroSuministro,
		:varIdNotificador,
		:varFechaAsignado,
		:varFechaEjecutado,
		:varEstado,
		:varEstadoSeal,
		:varNombreRecepcionador,
		:varDNIRecepcionador,
		:varParentesco,
		:varLecturaMedidor,
		:varLatitudVisita,
		:varLongitudVisita,
		:varObservaciones
	)");
	/*$sql="call WS_RegistrarVisitaXId(
		$varDocumentosTrabajoID,
		$varNroSuministro,
		$CodigoPersonal,
		$varFechaAsignado,
		$varFechaEjecutado,
		$varEstado,
		$varEstadoSeal,
		$varNombreRecepcionador,
		$varDNIRecepcionador,
		$varParentesco,
		$varLecturaMedidor,
		$varLatitudVisita,
		$varLongitudVisita,
		$varObservaciones
		)";*/
	//$CodigoPersonal=(empty($CodigoPersonal)||$CodigoPersonal<=0)?null:$CodigoPersonal;
	$stmtScriptSQL->execute(array(
		':varDocumentosTrabajoID'=>$varDocumentosTrabajoID,
		':varNroSuministro'=>$varNroSuministro,
		':varIdNotificador'=>$idAccesoLogin,
		':varFechaAsignado'=>$varFechaAsignado,
		':varFechaEjecutado'=>$varFechaEjecutado,
		':varEstado'=>$varEstado,
		':varEstadoSeal'=>$varEstadoSeal,
		':varNombreRecepcionador'=>$varNombreRecepcionador,
		':varDNIRecepcionador'=>$varDNIRecepcionador,
		':varParentesco'=>$varParentesco,
		':varLecturaMedidor'=>$varLecturaMedidor,
		':varLatitudVisita'=>$varLatitudVisita,
		':varLongitudVisita'=>$varLongitudVisita,
		':varObservaciones'=>$varObservaciones
	));
	$num_rows_SQL = $stmtScriptSQL->rowCount();
	if ($num_rows_SQL>0) {
		$IdObtenido="0";
		foreach ($stmtScriptSQL as $ResultadosEnvio) {
			$IdObtenido=$ResultadosEnvio["IdCreado"];
		}
		$TextoXml.= "<cantidad>".$num_rows_SQL. "</cantidad>";
		$TextoXml.= "<IdObtenido>".$IdObtenido. "</IdObtenido>";
		//Aqui debes dar una actulizacion al registro principal para que se vea que se hizo el trabajo
		$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
		$stmtScriptSQL2=$ConexionSealDBComunicacionDispersa->prepare("call WS_ActualizarDocumentoEjecutado(
			:varDocumentoID,
			:PersonalID,
			:varFechaEjecucion,
			:varEstado,
			:varCodigoSeal,
			:varObservaciones
		)");
		$stmtScriptSQL2->execute(array(
			':varDocumentoID'=>$varDocumentosTrabajoID,
			':PersonalID'=>$idAccesoLogin,
			':varFechaEjecucion'=>$varFechaEjecutado,
			':varEstado'=>$varEstado,
			':varCodigoSeal'=>$varEstadoSeal,
			':varObservaciones'=>$varObservaciones
		));
	}else{
		$TextoXml.= "<cantidad>".$num_rows_SQL. "99</cantidad>";
		$TextoXml.= "<IdObtenido>0</IdObtenido>";

	}
	$ConexionSealDBComunicacionDispersa=null;
}else{
	//Contraseña Incorrecta
		$TextoXml.= "<cantidad>0</cantidad>";
}
//echo "$CodigoEstado ";
//$TextoXml.="<usuario>$sql</usuario>";
$TextoXml.="</datos>";
echo $TextoXml;


//$target_path = "../images/fotos/";

?>