<?php
require_once("../libreria.php");
session_start();
$registronro=coger_dato_externo("registronro");
//echo $registronro;
switch ($registronro) {
    case "ImportarAC":
        //extract($_POST);
        $cboDetalleTDD_ID=coger_dato_externo("cboDetalleTDD_ID");
        if (empty($_FILES['flSubirDocumento']['name'])) {
            msg_rojo("Debes de seleccionar un archivo");
            return;
        }
        //cargamos el archivo al servidor con el mismo nombre
        $errores = 0;
        //solo le agregue el sufijo bak_ 
        $archivo = $_FILES['flSubirDocumento']['name'];
        $tipo = $_FILES['flSubirDocumento']['type'];
        $destino = "bak_" . $archivo;
        if (copy($_FILES['flSubirDocumento']['tmp_name'], $destino)){
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
            $FilasTotales=$objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            for ($i = 2; $i <= $FilasTotales; $i++) {//$FilasTotales el total aceptado es 1303
                $_DATOS_EXCEL[$i]['NroDocumento'] = $objPHPExcel->getActiveSheet()->getCell('A' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Suministro'] = $objPHPExcel->getActiveSheet()->getCell('B' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['FecEmiDoc'] = $objPHPExcel->getActiveSheet()->getCell('C' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['FecLimitCargo'] = $objPHPExcel->getActiveSheet()->getCell('D' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Tipo'] = $objPHPExcel->getActiveSheet()->getCell('E' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Zona'] = $objPHPExcel->getActiveSheet()->getCell('F' . $i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['PersonalID'] = $objPHPExcel->getActiveSheet()->getCell('G' . $i)->getCalculatedValue();
            }
            fnConsoleLog("Filas Detectadas: ".($FilasTotales-1));
            msg_verde("Archivo importado con exito, en total ".($FilasTotales-1)." registros Y $errores ERRORES");
        }else{
            msg_rojo("Necesitas primero importar el archivo");
        }
        $contadorguardados=0;
        $mensajeserrores="";
        $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
        foreach ($_DATOS_EXCEL as $campo => $valor) {
            if (!empty($valor['NroDocumento']) && !empty($valor['Suministro'])&& !empty($valor['FecEmiDoc'])&& !empty($valor['FecLimitCargo']) && !empty($valor['Tipo']) && !empty($valor['Zona']) && !empty($valor['Tipo'])) {
                $varIdTDD_Detalle=$cboDetalleTDD_ID;
                $varIdNotificador=(empty($valor['PersonalID'])?'null':$valor['PersonalID']);
                $varContratoID=$valor['Suministro'];
                $varNroDocumento=$valor['NroDocumento'];
                $varTipo=$valor['Tipo'];
                $varZona=$valor['Zona'];
                $FechaEmiDoc=$valor['FecEmiDoc'];
                $FechaEmiDocDE= "$FechaEmiDoc";
                //$FechaEmiDocUS=DateTime::createFromFormat("d.m.Y", $FechaEmiDocDE)->format("Y/m/d");//d.m.Y=06.12.2017
                $FechaEmiDocUS=DateTime::createFromFormat("d.m.Y", $FechaEmiDocDE);//d.m.Y=06.12.2017
                if (!$FechaEmiDocUS){
                    $mensajeserrores.="- La fecha de Emision del Documento no tiene el formato correcto(Nro Documento:".$valor['NroDocumento'].", Nro Sumistro: ".$valor['Suministro'].", Fecha Emision: ".$valor['FecEmiDoc'].", Fecha Limite: ".$valor['FecLimitCargo'].", Tipo: ".$valor['Tipo'].", Zona: ".$valor['Zona'].")<br>";
                }else{
                    $FechaEmiDocUS_1 = $FechaEmiDocUS->format("Y/m/d");
                }
                $FechaLimiteCargo=$valor['FecLimitCargo'];
                $FechaLimiteCargoDE="$FechaLimiteCargo";
                //$FechaLimiteCargoUS=DateTime::createFromFormat("d.m.Y", $FechaLimiteCargoDE)->format("Y/m/d");//d.m.Y=06.12.2017
                $FechaLimiteCargoUS=DateTime::createFromFormat("d.m.Y", $FechaLimiteCargoDE);//d.m.Y=06.12.2017 
                if (!$FechaLimiteCargoUS) {
                    $mensajeserrores.="- La fecha Limite de entrega de cargo del documento no tiene el formato correcto(Nro Documento:".$valor['NroDocumento'].", Nro Sumistro: ".$valor['Suministro'].", Fecha Emision: ".$valor['FecEmiDoc'].", Fecha Limite: ".$valor['FecLimitCargo'].", Tipo: ".$valor['Tipo'].", Zona: ".$valor['Zona'].")<br>";
                }else{
                    $FechaLimiteCargoUS_1=$FechaLimiteCargoUS->format("Y/m/d");
                }
                if ($FechaEmiDocUS && $FechaLimiteCargoUS) {//solo si las fechas tienen formato correcto hara la insercion
                    $sqlInsertar="call InsertarDocumentosTrabajo($varIdTDD_Detalle,$varIdNotificador,'$varContratoID',null,'$varNroDocumento',null,null,'$varTipo',null,'$varZona',null,null,'$FechaEmiDocUS_1',null,null,null,'$FechaLimiteCargoUS_1',null,1,null)";
                    $stmt = $ConexionSealDBComunicacionDispersa->prepare($sqlInsertar);
                    $rows = $stmt->execute();
                    if($rows > 0){
                        $contadorguardados+=1;
                    }else{
                        $mensajeserrores=$mensajeserrores."- ".$sqlInsertar."<br>";
                        echo "$mensajeserrores";
                    }
                }
            }else{
                $mensajeserrores=$mensajeserrores."- Debe insertar todos los campos obligatorios(Nro Documento:".$valor['NroDocumento'].", Nro Sumistro: ".$valor['Suministro'].", Fecha Emision: ".$valor['FecEmiDoc'].", Fecha Limite: ".$valor['FecLimitCargo'].", Tipo: ".$valor['Tipo'].", Zona: ".$valor['Zona'].")<br>";
            }
        }
        unlink($destino);
        if ($contadorguardados==($FilasTotales-1)) {//$FilasTotales-1, porque no empieza en la primera fila, sino desde la segun fila, porque la primera es la cabecera que no se importa.
            msg_verde("Registros importados correctamente.");
            fnCargaSimple("acdocumentos_lista.php","Mostrando Cambios...","#divCuerpoPrincipalACliente","#divMensajero");

        }else{
            msg_rojo("Por Alguna Razon Desconocida no se pudo guardar los siguientes registros(".($campo-1-$contadorguardados)."), pero si se guardaron los ($contadorguardados) primeros registros.<br>$mensajeserrores");
            msg_azul("Registros Importados: $contadorguardados, Contratos Sin importar: <strong>".($campo-1-$contadorguardados)."</strong>");
        }
        break;
    case 'ActualizarDocumentos':
        $txtDocumentoTrabajoID=coger_dato_externo("txtDocumentoTrabajoID");
        $cboDetalleTDD_ID=(coger_dato_externo("cboDetalleTDD_ID")==null?'null':coger_dato_externo("cboDetalleTDD_ID"));
        $txtNroDocumento=coger_dato_externo("txtNroDocumento");
        $txtNroSuministro=coger_dato_externo("txtNroSuministro");
        $txtFechaEmicionDoc=coger_dato_externo("txtFechaEmicionDoc");
        $txtFechaLimiteEntregaCSeal=coger_dato_externo("txtFechaLimiteEntregaCSeal");
        $txtTipo=coger_dato_externo("txtTipo");
        $txtZona=coger_dato_externo("txtZona");
        $cboPersonalID=coger_dato_externo("cboPersonalID");
        $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
        $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
        $sqlInsertar="call ModificarDocumentosTrabajo($txtDocumentoTrabajoID,$cboDetalleTDD_ID,$cboPersonalID,'$txtNroSuministro',null,'$txtNroDocumento',null,null,'$txtTipo',null,'$txtZona',null,null,'$txtFechaEmicionDoc',null,null,null,'$txtFechaLimiteEntregaCSeal',null,null,null)";
        echo $sqlInsertar;
        $stmt = $ConexionSealDBComunicacionDispersa->prepare($sqlInsertar);
        $rows = $stmt->execute();
        if( $rows > 0 ){
            msg_verde("Documento de trabajo actualizado");
            //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
            //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
            //echo "Respuesta: ".$stmt[]['errno'];
            echo "<script>$('$popNombreModal').modal('hide');</script>";
            fnCargaSimple("acdocumentos_lista.php","Mostrando Cambios...","#divListaAcDocumentos","#divMensajero");
        }else {
          msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro. Intentelo nuevamente");
        }
        break;
    case 'EliminarDocumentos':
        $txtDocumentoTrabajoID_e=coger_dato_externo("txtDocumentoTrabajoID_e");
        $popNombreModal=coger_dato_externo("popNombreModal");//Recoge el nombre del popup a cerrar de bootstrap 4.x
        $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
        $stmt = $ConexionSealDBComunicacionDispersa->prepare("call EliminarDocumentosTrabajo(:varDocumentosTrabajoID)");
        $rows = $stmt->execute(array(':varDocumentosTrabajoID'=>$txtDocumentoTrabajoID_e));
        if( $rows > 0 ){
            msg_verde("Documento de trabajo eliminado");
            //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
            //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
            //echo "Respuesta: ".$stmt[]['errno'];
            echo "<script>$('$popNombreModal').modal('hide');</script>";
            fnCargaSimple("acdocumentos_lista.php","Mostrando Cambios","#divListaAcDocumentos","#divMensajero");
        }else {
          msg_rojo("No se pudo eliminar este registro, verifica que no este vinculado a otros registros. Intentelo nuevamente");
        }
        break;
    case 'AsignarDocumentosJSON':
        $directions = json_decode(coger_dato_externo("json"));
        foreach ($directions as $DatosJson) {
            //echo "Contrato : ". $DatosJson->idTrabajador;
            $TrabajadorID=$DatosJson->idTrabajador;
            $ContratosListas=$DatosJson->contratos;
            $FechaActual=date("Y-m-d");
            $sqlAsignarPersonalDocumento="";
            foreach ($ContratosListas as $ListarContratos) {
                //echo $ListarContratos."<br>";
                $sqlAsignarPersonalDocumento.="call AsignarPersonalDocumentosTrabajo($ListarContratos,$TrabajadorID,'$FechaActual');";
            }
            $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
            $stmt = $ConexionSealDBComunicacionDispersa->prepare($sqlAsignarPersonalDocumento);
            $rows = $stmt->execute();
            //echo $sqlAsignarPersonalDocumento."<br>";
            ?>
            <script>
            /*Se tiene que utilizar este metodo porque hay error de comillas con la funcion fnConsoleLog y al enviar fechas */
                console.log("<?php echo $sqlAsignarPersonalDocumento; ?>");
            </script>
            <?php
            if( $rows > 0 ){
                msg_verde("Documentos de trabajo Asignados correctamente");
                //echo "<script type='text/javascript'>document.getElementById('$FormularioResetear').reset();
                //carga_simple('estadolocal_lista.php','#divPrincipal','#mensajes','Cargando...'); </script>";
                //echo "Respuesta: ".$stmt[]['errno'];
                //fnCargaSimple("acdocumentos_lista.php","Mostrando Cambios...","#divListaAcDocumentos","#divMensajero");
            }else {
                msg_rojo("No se pudo asignar todos los documentos, haz la busqueda nuevamente y verifica");
                $sqlAsignarPersonalDocumentoMSJ="";
                foreach ($ContratosListas as $ListarContratos) {
                    //echo $ListarContratos."<br>";
                    $sqlAsignarPersonalDocumentoMSJ.="call AsignarPersonalDocumentosTrabajo($ListarContratos,$TrabajadorID,'$FechaActual');<br>";
                }
                msg_amarillo($sqlAsignarPersonalDocumentoMSJ);
            }
            $ConexionSealDBComunicacionDispersa=null;
        }
        //var_dump($directions);
        break;
    case 'AsignarDocumentos1to1':
        $varDocumentosTrabajoID=coger_dato_externo("txtBuscarDocumentoTrabajo");
        $varPersonalID=coger_dato_externo("cboPersonal1");
        $FechaActual=date("Y-m-d");
        if (empty($varDocumentosTrabajoID)||empty($varPersonalID)) {
            msg_rojo("Debes ingresar un codigo interno de documento y el codigo del personal asignado");
            return;
        }
        $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
        $sqlAsignarPersonalDocumento="call AsignarPersonalDocumentosTrabajo($varDocumentosTrabajoID,$varPersonalID,'$FechaActual')";
        //fnConsoleLog("CP: $sqlAsignarPersonalDocumento");
        ?>
        <script>
            /*Se tiene que utilizar este metodo porque hay error de comillas con la funcion fnConsoleLog y al enviar fechas */
            console.log("<?php echo $sqlAsignarPersonalDocumento; ?>");
        </script>
        <?php

        $stmt = $ConexionSealDBComunicacionDispersa->prepare($sqlAsignarPersonalDocumento);
        $rows = $stmt->execute();
        if( $rows > 0 ){
            msg_verde("Documento de trabajo nro <b>$varDocumentosTrabajoID</b>  Asignado");
            ?>
            <script>
                $("#txtBuscarDocumentoTrabajo").val("");
                $("#txtBuscarDocumentoTrabajo").focus();
            </script>
            <?php
        }else {
          msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro. Intentelo nuevamente");
        }
        
        $ConexionSealDBComunicacionDispersa=null;
        break;
    case 'AsignarDocumentosVariosto1':
        $varDocumentosTrabajoID=coger_dato_externo("codigodocumento");
        $varPersonalID=coger_dato_externo("cboPersonalAsiganado");
        $FechaActual=date("Y-m-d");
        $count = count($varDocumentosTrabajoID);
        $sqlAsignarPersonalDocumento="";
        for ($i = 0; $i < $count; $i++) {
            //echo $varPersonalID." :: ".$varDocumentosTrabajoID[$i]."<br>";
            $sqlAsignarPersonalDocumento.="call AsignarPersonalDocumentosTrabajo(".$varDocumentosTrabajoID[$i].",$varPersonalID,'$FechaActual');";
        }
        $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
        $stmt = $ConexionSealDBComunicacionDispersa->prepare($sqlAsignarPersonalDocumento);
        $rows = $stmt->execute();
        if( $rows > 0 ){
            msg_verde("Documentos de trabajo Asignados en masa.");
            fnCargaSimple("acdocumentosasignarsincontrato.php","Mostrando Cambios...","#divCuerpoPrincipalACliente","#divMensajero");
        }else {
          msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro. Intentelo nuevamente");
        }
        $ConexionSealDBComunicacionDispersa=null;
        /*
        $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
        $sqlAsignarPersonalDocumento="call AsignarPersonalDocumentosTrabajo($varDocumentosTrabajoID,$varPersonalID,'$FechaActual')";
        //fnConsoleLog("CP: $sqlAsignarPersonalDocumento");

        $stmt = $ConexionSealDBComunicacionDispersa->prepare($sqlAsignarPersonalDocumento);
        $rows = $stmt->execute();
        if( $rows > 0 ){
            msg_verde("Documento de trabajo Asignado");
        }else {
          msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro. Intentelo nuevamente");
        }
        $ConexionSealDBComunicacionDispersa=null;*/
        break;
    case 'RegistrarCargo1to1':
        $varDocumentosTrabajoID=coger_dato_externo("txtBuscarDocumentoTrabajo");
        $varCodigoSeal=coger_dato_externo("cboCodigoSeal");
        $varEstado=coger_dato_externo("cboEstado");
        $FechaActual=date("Y-m-d");
        if (empty($varDocumentosTrabajoID)) {
            msg_rojo("Debes ingresar un codigo interno de documento para registrar cargo");
            return;
        }
        $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
        $sqlRegistrarCargoDocumento="call DocumentosTrabajoCodigoSealXId($varDocumentosTrabajoID,'$varCodigoSeal','$varEstado','$FechaActual')";
        //fnConsoleLog("CP: $sqlRegistrarCargoDocumento");//No funciona
        ?>
        <script>
            /*Se tiene que utilizar este metodo porque hay error de comillas con la funcion fnConsoleLog y al enviar fechas */
            console.log("<?php echo $sqlRegistrarCargoDocumento; ?>");
        </script>
        <?php

        $stmt = $ConexionSealDBComunicacionDispersa->prepare($sqlRegistrarCargoDocumento);
        $rows = $stmt->execute();
        if( $rows > 0 ){
            msg_verde("Documento nro <b>$varDocumentosTrabajoID</b> Registrado con Cargo");
            ?>
            <script>
                $("#txtBuscarDocumentoTrabajo").val("");
                $("#txtBuscarDocumentoTrabajo").focus();
            </script>
            <?php
        }else {
          msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro. Intentelo nuevamente");
        }
        
        $ConexionSealDBComunicacionDispersa=null;
        break;
    case 'RegistrarCargosEnMasa':
        $varDocumentosTrabajoID=coger_dato_externo("codigodocumento");
        $varCodigoSeal=coger_dato_externo("cboCodigoSeal");
        $varEstado=coger_dato_externo("cboEstado");
        $FechaActual=date("Y-m-d");
        $count = count($varDocumentosTrabajoID);
        $sqlRegistrarCargoDocumento="";
        for ($i = 0; $i < $count; $i++) {
            $sqlRegistrarCargoDocumento.="call DocumentosTrabajoCodigoSealXId(".$varDocumentosTrabajoID[$i].",'$varCodigoSeal','$varEstado','$FechaActual');";
        }
        ?>
        <script>
            /*Se tiene que utilizar este metodo porque hay error de comillas con la funcion fnConsoleLog y al enviar fechas */
            console.log("<?php echo $sqlRegistrarCargoDocumento; ?>");
        </script>
        <?php
        $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
        $stmt = $ConexionSealDBComunicacionDispersa->prepare($sqlRegistrarCargoDocumento);
        $rows = $stmt->execute();
        if( $rows > 0 ){
            msg_verde("Documentos de trabajo Asignados en masa.");
        }else {
          msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro. Intentelo nuevamente");
        }
        $ConexionSealDBComunicacionDispersa=null;
        /*
        $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
        $sqlAsignarPersonalDocumento="call AsignarPersonalDocumentosTrabajo($varDocumentosTrabajoID,$varPersonalID,'$FechaActual')";
        //fnConsoleLog("CP: $sqlAsignarPersonalDocumento");

        $stmt = $ConexionSealDBComunicacionDispersa->prepare($sqlAsignarPersonalDocumento);
        $rows = $stmt->execute();
        if( $rows > 0 ){
            msg_verde("Documento de trabajo Asignado");
        }else {
          msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro. Intentelo nuevamente");
        }
        $ConexionSealDBComunicacionDispersa=null;*/
        break;
    case 'EntregaSeal1to1':
        $varDocumentosTrabajoID=coger_dato_externo("txtBuscarDocumentoTrabajo");
        $varEstado=coger_dato_externo("cboEstado");
        $FechaActual=date("Y-m-d");
        if (empty($varDocumentosTrabajoID)) {
            msg_rojo("Debes ingresar un codigo interno de documento para registrar cargo");
            return;
        }
        $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
        $sqlRegistrarEntregaSeal="call DocumentosTrabajoEntregaSealXId($varDocumentosTrabajoID,'$varEstado','$FechaActual')";
        //fnConsoleLog("CP: $sqlRegistrarEntregaSeal");//No funciona
        ?>
        <script>
            /*Se tiene que utilizar este metodo porque hay error de comillas con la funcion fnConsoleLog y al enviar fechas */
            console.log("<?php echo $sqlRegistrarEntregaSeal; ?>");
        </script>
        <?php

        $stmt = $ConexionSealDBComunicacionDispersa->prepare($sqlRegistrarEntregaSeal);
        $rows = $stmt->execute();
        if( $rows > 0 ){
            msg_verde("Documento nro <b>$varDocumentosTrabajoID</b> guardado para entrega seal");
            ?>
            <script>
                $("#txtBuscarDocumentoTrabajo").val("");
                $("#txtBuscarDocumentoTrabajo").focus();
            </script>
            <?php
        }else {
          msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro. Intentelo nuevamente");
        }
        
        $ConexionSealDBComunicacionDispersa=null;
        break;
    case 'RegistrarEntregaSealEnMasa':
        $varDocumentosTrabajoID=coger_dato_externo("codigodocumento");

        $varEstado=coger_dato_externo("cboEstado");
        $FechaActual=date("Y-m-d");
        $count = count($varDocumentosTrabajoID);
        $sqlRegistrarEntregaSeal="";
        for ($i = 0; $i < $count; $i++) {
            $sqlRegistrarEntregaSeal.="call DocumentosTrabajoEntregaSealXId(".$varDocumentosTrabajoID[$i].",'$varEstado','$FechaActual');";
        }
        ?>
        <script>
            /*Se tiene que utilizar este metodo porque hay error de comillas con la funcion fnConsoleLog y al enviar fechas */
            console.log("<?php echo $sqlRegistrarEntregaSeal; ?>");
        </script>
        <?php
        $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
        $stmt = $ConexionSealDBComunicacionDispersa->prepare($sqlRegistrarEntregaSeal);
        $rows = $stmt->execute();
        if( $rows > 0 ){
            msg_verde("Documentos de trabajo guardado en Entrega Seal en masa.");
        }else {
          msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro. Intentelo nuevamente");
        }
        $ConexionSealDBComunicacionDispersa=null;
        /*
        $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
        $sqlAsignarPersonalDocumento="call AsignarPersonalDocumentosTrabajo($varDocumentosTrabajoID,$varPersonalID,'$FechaActual')";
        //fnConsoleLog("CP: $sqlAsignarPersonalDocumento");

        $stmt = $ConexionSealDBComunicacionDispersa->prepare($sqlAsignarPersonalDocumento);
        $rows = $stmt->execute();
        if( $rows > 0 ){
            msg_verde("Documento de trabajo Asignado");
        }else {
          msg_rojo("Por Alguna Razon Desconocida no se pudo guardar este registro. Intentelo nuevamente");
        }
        $ConexionSealDBComunicacionDispersa=null;*/
        break;
    case 'AgregarAReporte1to1':
        $varDocumentosTrabajoID=coger_dato_externo("txtBuscarDocumentoTrabajo");
        $FechaActual=date("Y-m-d");
        if (empty($varDocumentosTrabajoID)) {
            msg_rojo("Debes ingresar un codigo interno de documento agregar al reporte");
            return;
        }else{
            $_SESSION['codigosdocumentos'][] = $varDocumentosTrabajoID;
            msg_verde("Documento nro <b>$varDocumentosTrabajoID</b> agregado a reporte");
            ?>
            <script>
                $("#txtBuscarDocumentoTrabajo").val("");
                $("#txtBuscarDocumentoTrabajo").focus();
            </script>
            <?php
        }
        /*for($i=0;$i<count($_SESSION['codigosdocumentos']);$i++){
            echo $_SESSION['codigosdocumentos'][$i]."<br>";
        }*/
        break;
    case 'AgregarAReporteEnMasa':
        $varDocumentosTrabajoID=coger_dato_externo("codigodocumento");
        $FechaActual=date("Y-m-d");
        $count = count($varDocumentosTrabajoID);
        $sqlRegistrarEntregaSeal="";
        for ($i = 0; $i < $count; $i++) {
            //$sqlRegistrarEntregaSeal.="call DocumentosTrabajoEntregaSealXId(".$varDocumentosTrabajoID[$i].",'$varEstado','$FechaActual');";
            $_SESSION['codigosdocumentos'][] = $varDocumentosTrabajoID[$i];
        }
        msg_verde("Documentos agregados al reporte");
        /*for($i=0;$i<count($_SESSION['codigosdocumentos']);$i++){
            echo $_SESSION['codigosdocumentos'][$i]."<br>";
        }*/
        break;
    case 'VerReporteEnExcel':
        if (is_null($_SESSION['codigosdocumentos'])) {
            msg_rojo("Su reporte no tiene datos. agrege registros para generar datos");
        }else{
            ?>
            <script>
                //creo un hipervinculo y le hago click para descargar el archivo
                var a = document.createElement("a");
                //a.target = "_blank";
                a.href = "acdocumentoscargoexcel.php";
                a.download="download";
                a.click();
            </script>
            <?php
            msg_verde("Reporte Descargado!!!");
        }
        break;
	default:
		# code...
		break;
}
?>