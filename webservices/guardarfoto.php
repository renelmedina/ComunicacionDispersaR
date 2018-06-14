<?php
require_once("../libreria.php");
$filetipo="";
$IdVisitascampo=coger_dato_externo("Idfotovisitascampo");
$FechaFoto=coger_dato_externo("fechatiempo");
$imagencargada=null;
//echo "(".$IdVisitascampo."-".$FechaFoto.")";

if (!empty($_FILES['uploadedfile']['name'])) {
	$ruta="../images/fotos/";//ruta carpeta donde queremos copiar las imágenes 
	$uploadfile_temporal=$_FILES['uploadedfile']['tmp_name']; 
	$uploadfile_nombre=$ruta.$_FILES['uploadedfile']['name'];
	$filesize = $_FILES['uploadedfile']['size'];
	$filetipo = $_FILES['uploadedfile']['type']; 
	//if (((strpos($filetipo, "gif")) || (strpos($filetipo, "png")) || (strpos($filetipo, "pjpeg")) || (strpos($filetipo, "jpg")) || (strpos($filetipo, "jpeg"))) && ($filesize < 2048000)){
	if (($filesize < 2048000)){

		if (is_uploaded_file($uploadfile_temporal)){ 
			if (move_uploaded_file($uploadfile_temporal,$uploadfile_nombre)){
				$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
				$stmtScriptSQL=$ConexionSealDBComunicacionDispersa->prepare("CALL WS_Registrarfoto(
					:varVisitasCampoID,
					:varFecha,
					:varRutaFoto)"
				);
				$stmtScriptSQL->execute(array(
					':varVisitasCampoID'=>$IdVisitascampo,
					':varFecha'=>$FechaFoto,
					':varRutaFoto'=>$uploadfile_nombre
				));
				$num_rows_SQL = $stmtScriptSQL->rowCount();
				if ($num_rows_SQL>0) {
					# code...
					$subidook = "cliente/".$_FILES['uploadedfile']['name'];//$uploadfile_nombre;
					$mensaje2="Imagen Subida Correctamente($num_rows_SQL)";
					$imagencargada="si";
				}else{
					$imagencargada="no";
				}
			}
		}else{ 
			$mensaje2="La Imagen No se subio por problemas de conexion. SI se registro Correctamente, puede cambiar la foto en configuraciones de producto y subir su foto"; 
			$subidook="cliente/noproducto.png"; 
			$imagencargada="no";
		}
	}else{
		$mensaje2="No se Subio la Imagen, Recuerda que debe ser un archivo de imagen(de preferencia JPG) y con peso menor a 2MB".$filetipo;
		$subidook="cliente/noproducto.png";
		$imagencargada="no"; 
	}
}else{
	$subidook="cliente/noproducto.png"; 
	$imagencargada="no";
	$mensaje2="Ud. No subio Ninguna Foto, puede realizarlo mas tarde.";
}

echo $imagencargada;//este dato es recogido por los celulares.
?>