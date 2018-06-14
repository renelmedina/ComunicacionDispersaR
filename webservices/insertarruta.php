<?php
require_once("../libreria.php");
$IdPersonal=coger_dato_externo("idpersonal");
$Latitud=coger_dato_externo("latitud");
$Longitud=coger_dato_externo("longitud");
$Direccion=coger_dato_externo("direccion");
$FechaHora=coger_dato_externo("fechahora");

$datodevuelto="-1";
$bd=new SQLite3("RutasGenerales.db");
if (!empty($IdPersonal)) {
	# code...
	$ejecutar=$bd->exec("INSERT INTO rutas(IdPersonal,Latitud,Longitud,Direccion,FechaHora)VALUES('$IdPersonal','$Latitud','$Longitud','$Direccion','$FechaHora')");

	if (!$ejecutar) {
		$datodevuelto="0";//que no se inserto
	}else{
		$datodevuelto="1";//que se inserto este dato
	}
}
echo $datodevuelto;
$bd->close();
?>