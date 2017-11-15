<?php
require_once("../libreria.php");

$registronro=coger_dato_externo("registronro");
switch ($registronro) {
  case "ImportarZonas":
		//extract($_POST);
    $action=$_POST["action"];
    if ($action == "upload") {
        //cargamos el archivo al servidor con el mismo nombre
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
                $_DATOS_EXCEL[$i]['NroZona'] = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['NombreZona'] = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Descripcion'] = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
            }
            fnConsoloLog("Filas Detectadas: ".$FilasTotales);
        }
        //si por algo no cargo el archivo bak_ 
        else {
            msg_rojo("Necesitas primero importar el archivo");
        }
        $errores = 0;
        //recorremos el arreglo multidimensional 
        //para ir recuperando los datos obtenidos
        //del excel e ir insertandolos en la BD
        echo "<table>";
        echo "<tr><th>NroZona</th><th>Nombre Zona</th><th>Descripcion</th></th>";
        $contadorguardados=0;
        $ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
        foreach ($_DATOS_EXCEL as $campo => $valor) {
          if (!empty($valor['NroZona']) && !empty($valor['NombreZona'])) {
            $stmt = $ConexionSealDBGeneralidades->prepare("call IngresarZona(
                                            :varNroZona,
                                            :varNombreZona,
                                            :varDescripcionZona)");
            $rows = $stmt->execute(array(':varNroZona'=>$valor['NroZona'],
                                            ':varNombreZona'=>$valor['NombreZona'],
                                            ':varDescripcionZona'=>$valor['Descripcion']));
            if( $rows > 0 ){
                //msg_verde("<span class='glyphicon glyphicon-ok' aria-hidden='true'></span> Nuevo Cliente Guardado");
                $contadorguardados+=1;
                //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
                //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
                //echo "Respuesta: ".$stmt[]['errno'];
            }else {
              msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro:<br>-NroZona: ".$valor['NroZona'].", Nombre Zona: ".$valor['NombreZona']." intentalo de nuevo.");
            }
            echo "<tr>";
            echo "<td>".$valor["NroZona"]."</td>";
            echo "<td>".$valor["NombreZona"]."</td>";
            echo "<td>".$valor["Descripcion"]."</td>";
            echo "</tr>";
          }
        }
        if ($contadorguardados==($FilasTotales-1)) {//$FilasTotales-1, porque no empieza en la primera fila, sino desde la segun fila, porque la primera es la cabecera que no se importa.
          msg_verde("Zonas importadas y actualizadas correctamente.");
        }
        echo "</table>";
        echo "<strong><center>ARCHIVO IMPORTADO CON EXITO, EN TOTAL $campo REGISTROS Y $errores ERRORES</center></strong>";
        //una vez terminado el proceso borramos el archivo que esta en el servidor el bak_
        unlink($destino);
    }
    break;
  case 'ActualizarEstadoLocal':
    
    break;
  case 'EliminarEstadoLocal':
    
	default:
		# code...
		break;
}

?>
