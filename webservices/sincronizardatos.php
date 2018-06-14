<?php
require_once("../libreria.php");
$Usuario=coger_dato_externo("usuario");
$Password=coger_dato_externo("password");
$Password=GenerarPassword($Password);
$CodigoPersonal=0;
$CodigoEstado=0;
$TextoEstado="face inical";
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
header("Content-type: text/xml");
$TextoXml="";
$TextoXml.='<?xml version="1.0" encoding="utf-8"?>';
$TextoXml.='<datos>';
$ConexionSealDBComunicacionDispersa=null;
//verificando si el acceso es correcto
if ($CodigoEstado==1) {
	$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
	$stmtScriptSQL=$ConexionSealDBComunicacionDispersa->prepare("call WS_SincronizarTrabajoCel(:PersonalID)");
	$stmtScriptSQL->execute(array(
		':PersonalID'=>$CodigoPersonal
	));
	$num_rows_SQL = $stmtScriptSQL->rowCount();
	if ($num_rows_SQL>0) {
		foreach($stmtScriptSQL as $ListaSQL) {
			$idDocumentosTrabajo=$ListaSQL["idDocumentosTrabajo"];
			$IdTDD_Detalle=$ListaSQL["IdTDD_Detalle"];
			$NombreTDDD=$ListaSQL["NombreTDDD"];
			$IdNotificador=$ListaSQL["IdNotificador"];
	        $NombreCompletoNotificador=$ListaSQL["NombreCompletoNotificador"];
	        $ApellidoPaternoNotificador=$ListaSQL["ApellidoPaternoNotificador"];
	        $ApellidoMaternoNotificador=$ListaSQL["ApellidoMaternoNotificador"];
			$NroContrato=$ListaSQL["NroContrato"];
			$CodBarra=$ListaSQL["CodBarra"];
			$NroDocumento=$ListaSQL["NroDocumento"];
			$NombreCliente=$ListaSQL["NombreCliente"];
			$Direccion=$ListaSQL["Direccion"];
			$FechaTrabajo=$ListaSQL["FechaTrabajo"];
			$FechaAsignacion=$ListaSQL["FechaAsignacion"];
			$FechaEjecucion=$ListaSQL["FechaEjecucion"];
			$Estado=$ListaSQL["Estado"];
			$CMNombreCliente=$ListaSQL["CMNombreCliente"];
			$CMDireccionMedidor=$ListaSQL["CMDireccionMedidor"];
			$CMSed=$ListaSQL["CMSed"];
			$CMLongitud=$ListaSQL["CMLongitud"];
			$CMLatitud=$ListaSQL["CMLatitud"];
			$TextoXml.= "
			<comunicaciones>
			    <codigos codigodoc='$idDocumentosTrabajo' nrosuministro='$NroContrato'/>
			    <tipodoc codigo='$IdTDD_Detalle' nombretipodoc='$NombreTDDD' nrodocumentoseal='$NroDocumento'/>
			    <codigobarra>$CodBarra</codigobarra>
			    <coordenadas lat='$CMLatitud' long='$CMLongitud'/>
			    <fechaasig>$FechaAsignacion</fechaasig>
			    <cliente dni='0' nombrecliente='$NombreCliente' />
		  	</comunicaciones>";
		}
	}
	$ConexionSealDBComunicacionDispersa=null;
}
//echo "$CodigoEstado ";
$TextoXml.="</datos>";
echo $TextoXml;
?>