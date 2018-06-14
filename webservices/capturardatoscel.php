<?php
require_once("../libreria.php");
$CodigoTrabajador=coger_dato_externo("CodigoTrabajador");
$EstadoFirmaDocumento=coger_dato_externo("EstadoFirmaDocumento");
$Parentesco=coger_dato_externo("Parentesco");
$DNIRecepcion=coger_dato_externo("DNIRecepcion");
$LecturaMedidor=coger_dato_externo("LecturaMedidor");
$GPSLatitud=coger_dato_externo("GPSLatitud");
$GPSLongitud=coger_dato_externo("GPSLongitud");
$EstadoDocumento=coger_dato_externo("EstadoDocumento");//Si se entrego o no el documento

/*echo "CodigoTrabajador: ".$CodigoTrabajador;
echo "EstadoFirmaDocumento: ".$EstadoFirmaDocumento;
echo "Parentesco: ".$Parentesco;
echo "DNIRecepcion: ".$DNIRecepcion;
echo "LecturaMedidor: ".$LecturaMedidor;
echo "GPSLatitud: ".$GPSLatitud;
echo "GPSLongitud: ".$GPSLongitud;
echo "EstadoDocumento: ".$EstadoDocumento;*/



?>
<datosdevueltos>
	<respuesta codigo="200"/>
</datosdevueltos>