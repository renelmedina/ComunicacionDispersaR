<?php
require_once("../libreria.php");
$registronro=coger_dato_externo("registronro");
switch ($registronro) {
  case "ImportarContratos":
    //extract($_POST);
    $cboTipoContrato_a=coger_dato_externo("cboTipoContrato_a");
    if (empty($_FILES['excel']['name'])) {
        msg_rojo("Debes de seleccionar un archivo");
        return;
    }
    $action=$_POST["action"];
    if ($action == "upload") {
        //cargamos el archivo al servidor con el mismo nombre
        $errores = 0;
        //solo le agregue el sufijo bak_ 
        $archivo = $_FILES['excel']['name'];
        $tipo = $_FILES['excel']['type'];
        $destino = "bak_" . $archivo;
        if (copy($_FILES['excel']['tmp_name'], $destino)){
            //echo "Archivo Cargado Con Éxito";
            fnConsoloLog("Archivo Cargado Con Éxito");
        }
        else{
            msg_rojo("Error Al Cargar el Archivo");
        }
        if (file_exists("bak_" . $archivo)) {
            /** Clases necesarias */
            require_once('../Classes/PHPExcel.php');
            require_once('../Classes/PHPExcel/Reader/Excel2007.php');
            // Cargando la hoja de cálculo
            $objReader = new PHPExcel_Reader_Excel2007();
            $objPHPExcel = $objReader->load("bak_" . $archivo);
            $objFecha = new PHPExcel_Shared_Date();
            // Asignar hoja de excel activa
            $objPHPExcel->setActiveSheetIndex(0);
            //conectamos con la base de datos 
            /*$cn = mysql_connect("localhost", "root", "") or die("ERROR EN LA CONEXION");
            $db = mysql_select_db("prueba", $cn) or die("ERROR AL CONECTAR A LA BD");*/
            // Llenamos el arreglo con los datos  del archivo xlsx
            $FilasTotales=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            for ($i = 2; $i <= $FilasTotales; $i++) {//$FilasTotales el total aceptado es 1303
                $_DATOS_EXCEL[$i]['NroSector'] = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['NroZona'] = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['NroLibro'] = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Hoja'] = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['NroContrato'] = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Nim'] = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['TipoContrato'] = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Cliente'] = $objPHPExcel->getActiveSheet()->getCell('H' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Direccion'] = $objPHPExcel->getActiveSheet()->getCell('I' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Sed'] = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Longitud'] = $objPHPExcel->getActiveSheet()->getCell('K' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Latitud'] = $objPHPExcel->getActiveSheet()->getCell('L' . $i)->getCalculatedValue();
            }
            fnConsoloLog("Filas Detectadas: ".($FilasTotales-1));
            msg_verde("Archivo importado con exito, en total ".($FilasTotales-1)." registros Y $errores ERRORES");
        }else{
            //si por algo no cargo el archivo bak_
            msg_rojo("Necesitas primero importar el archivo");
        }
        //recorremos el arreglo multidimensional 
        //para ir recuperando los datos obtenidos
        //del excel e ir insertandolos en la BD
        //echo "<table>";
        //echo "<tr><th>NroHoja</th><th>Nombre Hoja</th><th>Descripcion</th></tr>";
        $contadorguardados=0;
        $ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
        foreach ($_DATOS_EXCEL as $campo => $valor) {
          if (!empty($valor['NroSector']) && !empty($valor['NroZona'])&& !empty($valor['NroLibro'])&& !empty($valor['Hoja'])&& !empty($valor['NroContrato'])) {
            $stmt = $ConexionSealDBGeneralidades->prepare("call InsertarContrato(
                                            :varNroContrato,
                                            :varSectorID,
                                            :varZonaID,
                                            :varLibroID,
                                            :varHoja,
                                            :varNim,
                                            :varTipoID,
                                            :varNombresDuenio,
                                            :varDireccionMedidor,
                                            :varSed,
                                            :varLongitud,
                                            :varLatitud)");
            $rows = $stmt->execute(array(':varNroContrato'=>$valor['NroContrato'],
                                            ':varSectorID'=>$valor['NroSector'],
                                            ':varZonaID'=>$valor['NroZona'],
                                            ':varLibroID'=>$valor['NroLibro'],
                                            ':varHoja'=>$valor['Hoja'],
                                            ':varNim'=>$valor['Nim'],
                                            ':varTipoID'=>$valor['TipoContrato'],
                                            ':varNombresDuenio'=>$valor['Cliente'],
                                            ':varDireccionMedidor'=>$valor['Direccion'],
                                            ':varSed'=>$valor['Sed'],
                                            ':varLongitud'=>$valor['Longitud'],
                                            ':varLatitud'=>$valor['Latitud']));
            if( $rows > 0 ){
                //msg_verde("<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> Nuevo Cliente Guardado");
                $contadorguardados+=1;
                //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
                //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
                //echo "Respuesta: ".$stmt[]['errno'];
            }else {
              msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro:<br>-NroHoja: ".$valor['NroHoja'].", Nombre Hoja: ".$valor['NombreHoja']." intentalo de nuevo.");
            }
            //echo "<tr>";
            //echo "<td>".$valor["NroHoja"]."</td>";
//            echo "<td>".$valor["NombreHoja"]."</td>";
//            echo "<td>".$valor["Descripcion"]."</td>";
            //echo "</tr>";
          }
        }
        //echo "</table>";
        //una vez terminado el proceso borramos el archivo que esta en el servidor el bak_
        unlink($destino);
        if ($contadorguardados==($FilasTotales-1)) {//$FilasTotales-1, porque no empieza en la primera fila, sino desde la segun fila, porque la primera es la cabecera que no se importa.
          msg_verde("Hojas importadas y actualizadas correctamente.");
          //echo "<script type='text/javascript'>fnCargaSimple('rutas.php','Cargando Importador','#divPrincipal','#divmensajero');</script>";            
            fnCargaSimple("hojas.php","Mostrando Cambios","#divPrincipal","#divMensajero");
        }else{
          msg_azul("Hojas Importadas: $contadorguardados, Hojas Sin importar: <strong>".($campo-1-$FilasTotales)."</strong>");
        }
    }
    break;
  case 'ActualizarHoja':
    $HojaId=coger_dato_externo("txtHojaID");
    $NroHoja=coger_dato_externo("txtNroHoja");
    $NombreHoja=coger_dato_externo("txtNombreHoja");
    $DescripcionHoja=coger_dato_externo("txtDescripcion");
    $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
    $ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
    $stmt = $ConexionSealDBGeneralidades->prepare("call ModificarHoja(
                                    :varHojaID,
                                    :varNroHoja,
                                    :varNombreHoja,
                                    :varDescripcionHoja)");
    $rows = $stmt->execute(array(  ':varHojaID'=>$HojaId,
                                    ':varNroHoja'=>$NroHoja,
                                    ':varNombreHoja'=>$NombreHoja,
                                    ':varDescripcionHoja'=>$DescripcionHoja));
    if( $rows > 0 ){
        msg_verde("Hoja Actualizado");
        //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
        //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
        //echo "Respuesta: ".$stmt[]['errno'];
        echo "<script>$('$popNombreModal').modal('hide');</script>";
        fnCargaSimple("hojas.php","Mostrando Cambios...","#divPrincipal","#divMensajero");
    }else {
      msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro. Intentelo nuevamente");
    }
    break;
  case 'EliminarHoja':
    $HojaID_e=coger_dato_externo("txtHojaID_e");
    $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
    $ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
    $stmt = $ConexionSealDBGeneralidades->prepare("call EliminarHoja(:varHojaID)");
    $rows = $stmt->execute(array(':varHojaID'=>$HojaID_e));
    if( $rows > 0 ){
        msg_verde("Hoja Eliminado");
        //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
        //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
        //echo "Respuesta: ".$stmt[]['errno'];
        echo "<script>$('$popNombreModal').modal('hide');</script>";
        fnCargaSimple("hojas.php","Mostrando Cambios","#divPrincipal","#divMensajero");
    }else {
      msg_rojo("No se pudo eliminar este registro, verifica que no este vinculado a otros registros. Intentelo nuevamente");
    }
	default:
		# code...
		break;
}
?>