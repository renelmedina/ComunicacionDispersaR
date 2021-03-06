<?php
require_once("../libreria.php");
$registronro=coger_dato_externo("registronro");
switch ($registronro) {
  case "ImportarSector":
    //extract($_POST);
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
            fnConsoleLog("Archivo Cargado Con Éxito");
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
                $_DATOS_EXCEL[$i]['NombreSector'] = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Descripcion'] = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
            }
            fnConsoleLog("Filas Detectadas: ".($FilasTotales-1));
            msg_verde("Archivo importado con exito, en total ".($FilasTotales-1)." registros Y $errores ERRORES");
        }
        //si por algo no cargo el archivo bak_ 
        else {
            msg_rojo("Necesitas primero importar el archivo");
        }
        //recorremos el arreglo multidimensional 
        //para ir recuperando los datos obtenidos
        //del excel e ir insertandolos en la BD
        echo "<table>";
        echo "<tr><th>NroSector</th><th>Nombre Ruta</th><th>Descripcion</th></tr>";
        $contadorguardados=0;
        $ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
        foreach ($_DATOS_EXCEL as $campo => $valor) {
          if (!empty($valor['NroSector']) && !empty($valor['NombreSector'])) {
            $stmt = $ConexionSealDBGeneralidades->prepare("call IngresarSector(
                                            :varNroSector,
                                            :varNombreSector,
                                            :varDescripcionSector)");
            $rows = $stmt->execute(array(':varNroSector'=>$valor['NroSector'],
                                            ':varNombreSector'=>$valor['NombreSector'],
                                            ':varDescripcionSector'=>$valor['Descripcion']));
            if( $rows > 0 ){
                //msg_verde("<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> Nuevo Cliente Guardado");
                $contadorguardados+=1;
                //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
                //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
                //echo "Respuesta: ".$stmt[]['errno'];
            }else {
              msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro:<br>-NroSector: ".$valor['NroSector'].", Nombre Sector: ".$valor['NombreSector']." intentalo de nuevo.");
            }
            echo "<tr>";
            echo "<td>".$valor["NroSector"]."</td>";
            echo "<td>".$valor["NombreSector"]."</td>";
            echo "<td>".$valor["Descripcion"]."</td>";
            echo "</tr>";
          }
        }
        echo "</table>";
        //una vez terminado el proceso borramos el archivo que esta en el servidor el bak_
        unlink($destino);
        if ($contadorguardados==($FilasTotales-1)) {//$FilasTotales-1, porque no empieza en la primera fila, sino desde la segun fila, porque la primera es la cabecera que no se importa.
          msg_verde("Sectores importados y actualizados correctamente.");
          //echo "<script type='text/javascript'>fnCargaSimple('rutas.php','Cargando Importador','#divPrincipal','#divmensajero');</script>";            
            fnCargaSimple("sector.php","Mostrando Cambios","#divPrincipal","#divMensajero");
        }else{
          msg_azul("Sectores Importados: $contadorguardados, Sectores Sin importar: <strong>".($campo-1-$FilasTotales)."</strong>");
        }
    }
    break;
  case 'ActualizarSector':
    $SectorId=coger_dato_externo("txtSectorID");
    $NroSector=coger_dato_externo("txtNroSector");
    $NombreSector=coger_dato_externo("txtNombreSector");
    $DescripcionSector=coger_dato_externo("txtDescripcion");
    $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
    $ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
    $stmt = $ConexionSealDBGeneralidades->prepare("call ModificarSector(
                                    :varSectorID,
                                    :varNroSector,
                                    :varNombreSector,
                                    :varDescripcionSector)");
    $rows = $stmt->execute(array(  ':varSectorID'=>$SectorId,
                                    ':varNroSector'=>$NroSector,
                                    ':varNombreSector'=>$NombreSector,
                                    ':varDescripcionSector'=>$DescripcionSector));
    if( $rows > 0 ){
        msg_verde("Sector Actualizado");
        //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
        //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
        //echo "Respuesta: ".$stmt[]['errno'];
        echo "<script>$('$popNombreModal').modal('hide');</script>";
        fnCargaSimple("sector.php","Mostrando Cambios","#divPrincipal","#divMensajero");
    }else {
      msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro. Intentelo nuevamente");
    }
    break;
  case 'EliminarSector':
    $RutaID_e=coger_dato_externo("txtSectorID_e");
    $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
    $ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
    $stmt = $ConexionSealDBGeneralidades->prepare("call EliminarSector(:varSectorID)");
    $rows = $stmt->execute(array(':varSectorID'=>$RutaID_e));
    if( $rows > 0 ){
        msg_verde("Sector Eliminado");
        //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
        //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
        //echo "Respuesta: ".$stmt[]['errno'];
        echo "<script>$('$popNombreModal').modal('hide');</script>";
        fnCargaSimple("sector.php","Mostrando Cambios","#divPrincipal","#divMensajero");
    }else {
      msg_rojo("Por alguna razon desconocida no se pudo eliminar este registro. Intentelo nuevamente");
    }
	default:
		# code...
		break;
}
?>