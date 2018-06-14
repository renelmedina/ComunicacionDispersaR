<?php
require_once("../libreria.php");
//$cabecera=new PaginaPrincipal;
//echo $cabecera->FrameworkModernos();
//echo $cabecera->ArchivosEsenciales();
$FechaInicio=coger_dato_externo("txtFechaInicio");
$FechaFin=coger_dato_externo("txtFechaFin");
$varPersonal=coger_dato_externo("cboPersonalB");
//echo "$FechaInicio :::: $FechaFin";
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$sqlBuscar="call DocumentosTrabajo_BusquedaXFechaSinEntregaSeal('$FechaInicio','$FechaFin',$varPersonal)";
///echo "$sqlBuscar";
$stmt = $ConexionSealDBComunicacionDispersa->prepare($sqlBuscar);
$rows = $stmt->execute();
$ListaContratos=array();
foreach($stmt as $ListaContratoss){
    $ListaContratos[]=$ListaContratoss;
}
$ConexionSealDBComunicacionDispersa=null;
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$sqlListarSector="CALL ListarTodoAccesoLogin()";
$stmtListaUsuarios=$ConexionSealDBComunicacionDispersa->prepare($sqlListarSector);
$stmtListaUsuarios->execute();
$ListaUsuarios=array();
foreach($stmtListaUsuarios as $ResultadoUsuarios) {
    $ListaUsuarios[]=$ResultadoUsuarios;
}
$ConexionSealDBComunicacionDispersa=null;
/*$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$sqlListarSector="CALL ListarTodoAccesoLogin()";
$stmtListaUsuarios=$ConexionSealDBComunicacionDispersa->prepare($sqlListarSector);
$stmtListaUsuarios->execute();
$ListaUsuarios=array();
foreach($stmtListaUsuarios as $ResultadoUsuarios) {
    $ListaUsuarios[]=$ResultadoUsuarios;
}
$ConexionSealDBComunicacionDispersa=null;*/
?>
<fieldset>
    <legend>Agregar a reporte 1 a 1:</legend>
    <form action="" name="frmGenerarReporte1to1" id="frmGenerarReporte1to1" onsubmit="envio_general_forms('#frmGenerarReporte1to1','acdocumentos_registro.php','#divEstadoRegistroCargo','#divEstadoRegistroCargo','RegistrandoCargo...');return false;">
        <div class="btn-group" role="group" aria-label="Basic example">
            <span class="input-group-addon">Codigo Interno Documento:</span>
            <input type="text" class="form-control" name="txtBuscarDocumentoTrabajo" id="txtBuscarDocumentoTrabajo" onKeyPress="return soloNumeros(event)">
            <input type="hidden" name="registronro" value="AgregarAReporte1to1">
            <button type="button" class="btn btn-info" onclick="envio_general_forms('#frmGenerarReporte1to1','acdocumentos_registro.php','#divEstadoRegistroCargo','#divEstadoRegistroCargo','Registrando Cargo...')">Agregar a Reporte</button>
        </div>
    </form>
</fieldset>
<div id="divEstadoRegistroCargo"></div>
<fieldset>
    <legend>Agregar a reporte en masa:</legend>
    <form action="" name="frmBuscarPorFechas" id="frmBuscarPorFechas" action="" method="">
        <div class="row">
            <div class="col"><!--class="col-lg-6"-->
                <div class="input-group">
                    <span class="input-group-addon">Fecha Inicio</span>
                    <input type="date" name="txtFechaInicio" id="txtFechaInicio" value="<?php echo $FechaInicio; ?>">
                    <span class="input-group-addon">Fecha Fin:</span>
                    <input type="date" name="txtFechaFin" id="txtFechaFin" value="<?php echo $FechaFin; ?>">
                    <span class="input-group-addon">Personal:</span>
                    <select name="cboPersonalB" id="cboPersonalB" class="form-control">
                        <option value="0">Todos</option>
                        <?php
                        foreach($ListaUsuarios as $ResultadoUsuarios) {
                            $AccesoLoginID=$ResultadoUsuarios['idAccesoLogin'];
                            $PersonalID=$ResultadoUsuarios['PersonalID'];
                            $Usuario=$ResultadoUsuarios['Usuario'];
                            $Password=$ResultadoUsuarios['Contrasenia'];
                            $TipoAcceso=$ResultadoUsuarios['TipoAcceso'];
                            $NombreAcceso=$ResultadoUsuarios['NombreAcceso'];
                            $NombreCompleto=$ResultadoUsuarios['NombresCompletos'];
                            //echo "<li><a href='#' class='clPersonal' id='$PersonalID'>$ApellidoPaterno $ApellidoMaterno $NombreCompleto</a></li>";
                            echo "<option value='$AccesoLoginID'";
                            if ($varPersonal==$AccesoLoginID) {
                                echo " selected";
                            }
                            echo ">$NombreCompleto</option>";
                        }
                        ?>
                    </select>
                    <span class="input-group-btn">
                    <button class="btn btn-info" type="button" onclick="envio_general_forms('#frmBuscarPorFechas','acdocumentosreporteseal.php','#divCuerpoPrincipalACliente','#divEstadoRegistroCargo','Buscando...');">Buscar</button>
                  </span>
                </div>
            </div>
        </div>
    </form>
    <form action="" name="frmAgregarReporteEnMasa" id="frmAgregarReporteEnMasa">
        <div class="input-group">
            <button class="btn btn-info" type="button" onclick="envio_general_forms('#frmAgregarReporteEnMasa','acdocumentos_registro.php?registronro=AgregarAReporteEnMasa','#divEstadoRegistroCargo','#divEstadoRegistroCargo','Registrando...');">Agregar a reporte</button>
            <!--<a href="javascript:fnCargaSimple('acdocumentoscargoexcel.php','Descargando reporte...','#divEstadoRegistroCargo','#divEstadoRegistroCargo');" target="_blank">
            <button class="btn btn-success" type="button" onclick="">Ver reporte</button></a>-->
            <button class="btn btn-success" type="button" onclick="envio_general_forms('#frmAgregarReporteEnMasa','acdocumentos_registro.php?registronro=VerReporteEnExcel','#divEstadoRegistroCargo','#divEstadoRegistroCargo','Registrando...');">Descargar reporte</button>
        </div>
        <div class="tabla_azul" style="width: 85%;">
            <table>
                <tr>
                    <th onclick="seleccionar_todo('frmAgregarReporteEnMasa')"><input type="checkbox" value="0" name="chkSeleccionar">Sel</th>
                    <th>Codigo</th>
                    <th>Nro Documento</th>
                    <th>Nro Suministro</th>
                    <th>Tipo</th>
                    <th>Asignado A</th>
                    <th>Fecha Emision</th>
                    <th>F. Limite Seal</th>
                    <th>Estado</th>
                    <th>Cod. S.</th>
                    <th>Acciones</th>
                </tr>
                <?php
                foreach($ListaContratos as $ListaContratosss) {
                    //$ListaContratos["features"]=$ListaContratosss;
                    $idDocumentosTrabajo=$ListaContratosss["idDocumentosTrabajo"];
                    $NroContrato=$ListaContratosss["NroContrato"];
                    $IdTDD_Detalle=$ListaContratosss["IdTDD_Detalle"];
                    $NombreTDDD=$ListaContratosss["NombreTDDD"];
                    $Tipo=$ListaContratosss["Tipo"];
                    $IdNotificador=$ListaContratosss["IdNotificador"];
                    $NotificadorNombre=$ListaContratosss["NotificadorNombre"];
                    $NroDocumento=$ListaContratosss["NroDocumento"];
                    $Zona=$ListaContratosss["Zona"];
                    $Sector=$ListaContratosss["Sector"];
                    $FechaEmisionDoc=$ListaContratosss["FechaEmisionDoc"];
                    $FechaTrabajo=$ListaContratosss["FechaTrabajo"];
                    $FechaAsignacion=$ListaContratosss["FechaAsignacion"];
                    $FechaEjecucion=$ListaContratosss["FechaEjecucion"];
                    $FechaLimiteCargo=$ListaContratosss["FechaLimiteCargo"];
                    $FechaEntregaASeal=$ListaContratosss["FechaEntregaASeal"];
                    $Estado=$ListaContratosss["Estado"];
                    $NombreEstado=$ListaContratosss["NombreEstado"];
                    $CodigoSeal=$ListaContratosss["CodigoSeal"];
                    $NombreCodigoSeal=$ListaContratosss["NombreCodigoSeal"];
                    //fnConsoleLog($NroContrato);
                    //$ListaContratos["features"].push(array('position' => , ););
                    echo "<tr>";
                    echo "<td><label><input type='checkbox' name='codigodocumento[]' value='$idDocumentosTrabajo'></label></td>";
                    echo "<td onclick='fnSeleccionar(this.parentNode)'>$idDocumentosTrabajo</td>";
                    echo "<td onclick='fnSeleccionar(this.parentNode)'>$NroDocumento</td>";
                    echo "<td onclick='fnSeleccionar(this.parentNode)'>$NroContrato</td>";
                    echo "<td onclick='fnSeleccionar(this.parentNode)'>$Tipo</td>";
                    echo "<td onclick='fnSeleccionar(this.parentNode)'>$IdNotificador::$NotificadorNombre</td>";
                    echo "<td onclick='fnSeleccionar(this.parentNode)'>$FechaEmisionDoc</td>";
                    echo "<td onclick='fnSeleccionar(this.parentNode)'>$FechaLimiteCargo</td>";
                    echo "<td onclick='fnSeleccionar(this.parentNode)'>$NombreEstado</td>";
                    echo "<td onclick='fnSeleccionar(this.parentNode)'>$CodigoSeal.$NombreCodigoSeal</td>";
                    echo "<td onclick='fnSeleccionar(this.parentNode)'></td>";
                    echo "</tr>";
                }
                $ConexionSealDBComunicacionDispersa=null;
                ?>
        </table>
    </div>
    </form>
</fieldset>
<script>
    function fnSeleccionar(obj) {
        //alert(obj);
        if($(obj).find("input[name='codigodocumento[]']").prop('checked')) {
            $(obj).find("input[name='codigodocumento[]']").prop( "checked", false );
        }else{
            $(obj).find("input[name='codigodocumento[]']").prop( "checked", true );
        }
    }
    function seleccionar_todo(Nombreformulario){ 
        for (i=0;i<document.getElementById(Nombreformulario).elements.length;i++){
            if(document.getElementById(Nombreformulario).elements[i].type == "checkbox"){    
                document.getElementById(Nombreformulario).elements[i].checked=document.getElementById(Nombreformulario).chkSeleccionar.checked;
            }
        }
    }
    /*console.log("%c !Detente¡","color: red; font-size: 30px;");
    console.log("%c Esta funcion del navegador esta pensado para desarrolladores. Si alguien te dijo que copiando y pegando codigo en este lugar podrias ´HACKEAR´ alguna cuenta, te ha estafado, por favor si no eres desarrollador no sigas ni hagas nada mas por tu seguridad","color: black; font-size: 15px;");*/
</script>
