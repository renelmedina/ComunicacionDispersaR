<?php
require_once("../libreria.php");
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$varCodDocumentoTrabajo=(coger_dato_externo("txtCodDocumentoTrabajo")==null?0:coger_dato_externo("txtCodDocumentoTrabajo"));
$varPaginasMostrar=300;//cantidad de registros a mostrar
#Variables recogidas
$varDocumentosTrabajoID=(coger_dato_externo("varDocumentosTrabajoID")==null?0:coger_dato_externo("varDocumentosTrabajoID"));
$varNotificadorID=(coger_dato_externo("varNotificadorID")==null?0:coger_dato_externo("varNotificadorID"));
$varFechaInicial=(coger_dato_externo("varFechaInicial")==null?'':coger_dato_externo("varFechaInicial"));
$varFechaFinal=(coger_dato_externo("varFechaFinal")==null?'':coger_dato_externo("varFechaFinal"));
$varEstadoSeal=(coger_dato_externo("varEstadoSeal")==null?'0':coger_dato_externo("varEstadoSeal"));
$varDatoBuscar=(coger_dato_externo("varDatoBuscar")==null?'':coger_dato_externo("varDatoBuscar"));
$varBuscarEn=(coger_dato_externo("varBuscarEn")==null?'0':coger_dato_externo("varBuscarEn"));
$varPaginaActual=(coger_dato_externo("varPaginaActual")==null?1:coger_dato_externo("varPaginaActual"));

#Contando la cantidad total de la busqueda en la tabla contrato
$sqlCantidad="CALL VisitasCampo_Buscar_Cantidad($varDocumentosTrabajoID,'$varNotificadorID','$varFechaInicial','$varFechaFinal','$varEstadoSeal','$varDatoBuscar','$varBuscarEn')";
$stmtCantidad= $ConexionSealDBComunicacionDispersa->prepare($sqlCantidad);
$stmtCantidad->execute();
$ListaCantidadSolicitud=array();
foreach($stmtCantidad as $CantidadSolicitud) {
  $ListaCantidadSolicitud[]=$CantidadSolicitud;
}
$PaginasTotales=ceil($ListaCantidadSolicitud[0]["total"]/$varPaginasMostrar);//Ceil redondea un numero, funcion de php
$ConexionSealDBComunicacionDispersa=null;//cerramos la conexion

//Artilugio para poner la cantidad de paginas
$pagina_actual2=($varPaginaActual-1)*$varPaginasMostrar;

#Haciendo Busqueda en la tabla contratos, con Limit, para que este paginado
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
//$sqlListarContratos="CALL VisitasCampo_VerXIdDocumento($varCodDocumentoTrabajo)";
$sqlListarContratos="call VisitasCampo_Buscar($varDocumentosTrabajoID,'$varNotificadorID','$varFechaInicial','$varFechaFinal','$varEstadoSeal','$varDatoBuscar','$varBuscarEn',$pagina_actual2,$varPaginasMostrar)";
//echo $sqlListarContratos;

/*
* //SP de ejemplo
* call VisitasCampo_Buscar(0,'0','','','0','','0',0,50)
* //SP con los campos completos
* call VisitasCampo_Buscar(varDocumentosTrabajoID,varNotificadorID,'varFechaInicial','varFechaFinal','varEstadoSeal','varDatoBuscar','varBuscarEn',varPaginaActual,varPaginasMostrar)

*/
//echo $sqlListarContratos."<br>";
$stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarContratos);
set_time_limit(60);
$stmt->execute();
$ListaDocumentosTrabajoBusqueda=array();
foreach($stmt as $stmtListaDocumentosTrabajoBusquedas) {
  $ListaDocumentosTrabajoBusqueda[]=$stmtListaDocumentosTrabajoBusquedas;
}
$ConexionSealDBComunicacionDispersa=null;//cerramos la conexion



$modo=coger_dato_externo("modo");
if ($modo=="descarga") {
  #Script para descargar todas la fotos de laa busqueda
  $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
  $sqlListarFotos="CALL VisitasCampo_Buscar_VerFotos($varDocumentosTrabajoID,$varNotificadorID,'$varFechaInicial','$varFechaFinal','$varEstadoSeal','$varDatoBuscar','$varBuscarEn')
  ";
  $stmtFotos=$ConexionSealDBComunicacionDispersa->prepare($sqlListarFotos);
  $stmtFotos->execute();
  $ListaFotos=array();

  $zip=new ZipArchive;
  $NombreArchviZip="../zipgenerados/Fotos_".date("d").date("m").date("Y")."-".date("h").date("i").date("s").".zip";
  if ($zip->open($NombreArchviZip,ZipArchive::CREATE)===TRUE) {
    # code...
    foreach($stmtFotos as $stmtFotosss) {
      //$ListaFotos[]=$stmtFotosss;
      $zip->addFile($stmtFotosss["RutaFoto"],basename($stmtFotosss["RutaFoto"]));
    }
    $zip->close();
  }
  $ConexionSealDBComunicacionDispersa=null;
}
//modo=descarga
?>

<div id="divPrincipaltablaVisitas">
  <?php
    //Mostrando total de registro en la pagina

  echo "Registros Encontrados: ".$ListaCantidadSolicitud[0]["total"];
  ?>
  <!-- Cuerpo del la Tabla -->
  <div class="tabla_azul" style="width: 100%;">
        <table>
          <tr>
            <th>Nro</th>
            <th>Suministro</th>
            <th>Nro Doc</th>
            <th>Tipo</th>
            <th>Notificador</th>

            <th>FechaAsignado</th>
            <th>Fecha Ejecutado</th>
            <th>Codigo Seal</th>
            <th>DNI Recepcion</th>
            <th>Parentesco</th><!--Tipo de contrato-->
            <th>Lectura Medidor</th>
            <th> <a href="#map">GPS</a></th>
            <th>Fotos
              <?php
                if ($modo=="descarga") {
                  echo "<a class='btn btn-info btn-sm active' href='".$NombreArchviZip."'>descargar</a>";
                }
              ?>
              
            </th>
            <th>Observaciones</th>
          </tr>
        <?php
        $textoJSON="[";
        foreach($ListaDocumentosTrabajoBusqueda as $ResultadoDocumentosTrabajo) {
          $idVisitasCampo=$ResultadoDocumentosTrabajo["idVisitasCampo"];
      		$DocumentosTrabajoID=$ResultadoDocumentosTrabajo["DocumentosTrabajoID"];
          $ContratoID=$ResultadoDocumentosTrabajo["ContratoID"];
          $NroSuministro2=$ResultadoDocumentosTrabajo["NroSuministro"];
          $Tipo=$ResultadoDocumentosTrabajo["Tipo"];
          $NroDocumento=$ResultadoDocumentosTrabajo["NroDocumento"];
      		$IdNotificador=$ResultadoDocumentosTrabajo["IdNotificador"];
          $NotificadorNombre=$ResultadoDocumentosTrabajo["NotificadorNombre"];
      		$FechaAsignado=$ResultadoDocumentosTrabajo["FechaAsignado"];
      		$FechaEjecutado=$ResultadoDocumentosTrabajo["FechaEjecutado"];
      		$Estado=$ResultadoDocumentosTrabajo["Estado"];
      		$EstadoSeal=$ResultadoDocumentosTrabajo["EstadoSeal"];
      		$NombreRecepcionador=$ResultadoDocumentosTrabajo["NombreRecepcionador"];
      		$DNIRecepcionador=$ResultadoDocumentosTrabajo["DNIRecepcionador"];
      		$Parentesco=$ResultadoDocumentosTrabajo["Parentesco"];
      		$LecturaMedidor=$ResultadoDocumentosTrabajo["LecturaMedidor"];
      		$LatitudVisita=$ResultadoDocumentosTrabajo["LatitudVisita"];
      		$LongitudVisita=$ResultadoDocumentosTrabajo["LongitudVisita"];
      		$Observaciones=$ResultadoDocumentosTrabajo["Observaciones"];
      		
          echo "<tr>";
          echo "<td>$idVisitasCampo</td>";
          if (empty($ContratoID)) {
            echo "<td>$NroSuministro2</td>";
          }else{
            echo "<td>$ContratoID</td>";
          }
          echo "<td>$NroDocumento</td>";
          echo "<td>$Tipo</td>";

          echo "<td>$NotificadorNombre</td>";
          echo "<td>$FechaAsignado</td>";
          echo "<td>$FechaEjecutado</td>";
          echo "<td>$EstadoSeal</td>";
          echo "<td>$DNIRecepcionador</td>";
          echo "<td>$Parentesco</td>";
          echo "<td>$LecturaMedidor</td>";
          echo "<td><a target='_blank' href='mapaxuno.php?lat=$LatitudVisita&lng=$LongitudVisita'>GPS</a></td>";
          echo "<td>";
            $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
            $stmt2=$ConexionSealDBComunicacionDispersa->prepare("call VisitasCampo_VerFotoXIdVisita($idVisitasCampo)");
            set_time_limit(60);
            $stmt2->execute();
            
            foreach($stmt2 as $stmtListaDocumentosTrabajoBusquedas) {
              echo "<a target='_blank' href='".$stmtListaDocumentosTrabajoBusquedas["RutaFoto"]."'><img src='".$stmtListaDocumentosTrabajoBusquedas["RutaFoto"]."'alt='' width='50'></a> ";
              
            }
            $ConexionSealDBComunicacionDispersa=null;//cerramos la conexion
          echo "</td>";
          echo "<td>$Observaciones</td>";
          
          //para enviar lso
          /*echo "<td>
                  <button type='button' class='btn btn-outline-info btn-sm' data-toggle='modal' data-target='#popDocumentosModal' data-documentotrabajoid='$idDocumentosTrabajo' data-tdddetalleid='$IdTDD_Detalle' data-documentonro='$NroDocumento' data-suministronro='$NroContrato' data-fechaemision='$FechaEmisionDoc' data-fechalimite='$FechaLimiteCargo' data-tipo2='$Tipo' data-zonanombre='$Zona' data-personalid='$IdNotificador'>M</button>
                  <button type='button' class='btn btn-outline-danger btn-sm' data-toggle='modal' data-target='#popEliminarDocumentos' data-documentotrabajoid_e='$idDocumentosTrabajo' data-documentonro_e='$NroDocumento' data-suministronro_e='$NroContrato' data-tipo2_a='$Tipo'>E</button>
          </td>";*/
          echo "</tr>";
          $textoJSON.="{position:new google.maps.LatLng(".(float)$LatitudVisita.", ".(float)$LongitudVisita."),";
          $textoJSON.="type:'puntorojo',";
          $textoJSON.="label:'',"; 
          //$textoJSON.="label:'',";
          $textoJSON.="nombreMarcador:'',";
          $textoJSON.="suministroNro:'',";
          $textoJSON.="tipoDoc:'',";
          $textoJSON.="fechaE:'',";
          $textoJSON.="dato1:'',";
          $textoJSON.="dato2:'',";
          $textoJSON.="dato3:'',";
          $textoJSON.="dato4:''";
          $textoJSON.="},";
        }
        $textoJSON.="];";
        ?>
        </table>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyeNELJuURtBnMQR5Josan3KL7luObvlg&callback=initMap">
</script>
<style>
  #map {
        height: 100%;
        width: 100%;
        /*float: left;*/
      }
</style>
<script>
    var features;// = eval(<?php echo json_encode($textoJSON); ?>);
    var map;
    var iconBase;
    var icons;
    var markers = [];//contiene
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: new google.maps.LatLng(-16.401363333333, -71.540266666667),
          mapTypeId: 'roadmap'
        });
        //Tipos de iconos para los makers de google maps
        iconBase = 'http://accsac.com/sistemas/seal/comunicaciondispersa/images/iconos/';
        icons = {
          puntorojo:{
            icon: iconBase+'puntorojox9.png'
          },
          puntoamarillo:{
            icon: iconBase+'puntoamarillox9.png'
          },
          puntoazul:{
            icon: iconBase+'puntoazulx9.png'
          },
          puntoceleste:{
            icon: iconBase+'puntocelestex9.png'
          },
          puntomorado:{
            icon: iconBase+'puntomoradox9.png'
          },
          puntover:{
            icon: iconBase+'puntoverdex9.png'
          }
        };
        var s = '{"nombre":"juan"}';
        var o = JSON.parse(s);
        var json = JSON.stringify(o);
        console.log(o);
        //Las posiciones(nro de contrato) que se cargaran dinamicamente
        //features = eval(<?php echo json_encode($ListaContratos); ?>);
        features = eval(<?php echo json_encode($textoJSON); ?>);
        
        //Funcion que muestra todas las ubicaciones(Markers)
        MostrarMarcadores();
        /*Funciones Internas de la Clase*/
        //funcion que agregar un markador al mapa
        function AgregarMarcador(position,icon,label,nombreMarcador,tipoDoc,fechaE,dato1,dato2,dato3,dato4,map){
            var marker = new google.maps.Marker({
                position: position,
                icon: icon,
                label: label,
                map: map,
                nombreMarcador:nombreMarcador,
                tipoDoc:tipoDoc,
                fechaE:fechaE,
                dato1:dato1,
                dato2:dato2,
                dato3:dato3,
                dato4:dato4
            });
            //Este array deberia de existir previamente
            markers.push(marker);
            // cuando se haga doble click se eliminara del mapa y del array
            marker.addListener('dblclick', function() {
                marker.setMap(null);
                //falta implementar la eliminacion del array.

            });
        }
        //Agrega todos los marcadores al mapa
        function EstablecerMarcadores(map) {
            for (var i in features) {//Hara un recorrido por todo el array
                if (features[i].hasOwnProperty('nombreMarcador')) {//Verifica si tiene la propiedad 'nombreMarcador'
                    AgregarMarcador(
                        features[i].position,
                        icons[features[i].type].icon,
                        features[i].label,
                        features[i].nombreMarcador,
                        features[i].tipoDoc,
                        features[i].fechaE,
                        features[i].dato1,
                        features[i].dato2,
                        features[i].dato3,
                        features[i].dato4,
                        map);
                }
            }
        }
        //Ocultara todos los marcadores
        function OcultarMarcadores() {
            MostrarMarcadores(null);
        }
        // Muestra todos los marcadores que estan en el array, en el mapa.
        function MostrarMarcadores() {
            EstablecerMarcadores(map);
        }
        // Eliminar todos los marcadores del array y oculta los marcadores. Dando la sencion de que se eliminaron
        //Aun se debe trabajar en esta funcion.
        function DeleteMarkers() {
            OcultarMarcadores();
            markers = [];
        }
    }
</script>
  </div>
  <!--Paginado-->
  <?php
  # Paginado

  $PaginaNavega="acdocumentos_visitacampo_lista.php?varDocumentosTrabajoID=$varDocumentosTrabajoID&varNotificadorID=$varNotificadorID&varFechaInicial=varFechaInicial&varFechaFinal=$varFechaFinal&varEstadoSeal=$varEstadoSeal&varDatoBuscar=$varDatoBuscar&varBuscarEn=$varBuscarEn";
  $PaginaAnterior=($varPaginaActual>0?$varPaginaActual-1:1);
  $PAnterior=$PaginaNavega."&varPaginaActual=$PaginaAnterior";
  $PaginaSiguiente=($varPaginaActual<$PaginasTotales?$varPaginaActual+1:$PaginasTotales);
  $PSiguiente=$PaginaNavega."&varPaginaActual=$PaginaSiguiente";
  //echo "$PSiguiente";
  ?>
  <nav aria-label="navPaginado">
    <ul class="pagination justify-content-center">
      <?php
      $verificar1raPagina=($varPaginaActual<=1?"disabled":"");
      echo "<li class='page-item $verificar1raPagina'><a class='page-link' href=\"javascript:fnCargaSimple('$PAnterior','Cargando pagina $PaginaAnterior...','#divPrincipaltablaVisitas','#divMensajero');\">Anterior</a></li>";
      for ($i=1; $i <=$PaginasTotales ; $i++) {
        if ($varPaginaActual!=$i) {
          $PaginaNavega.="&varPaginaActual=$i";
          echo "<li class='page-item'><a class='page-link' href=\"javascript:fnCargaSimple('$PaginaNavega','Cargando pagina $i...','#divPrincipaltablaVisitas','#divMensajero');\">$i</a></li>";
        }else {
          echo "<li class='page-item active'><span class='page-link'>$i</span></li>";
        }
      }
      $verificarUltimaPagina=($varPaginaActual>=$PaginasTotales?"disabled":"");
      echo "<li class='page-item $verificarUltimaPagina'><a class='page-link' href=\"javascript:fnCargaSimple('$PSiguiente','Cargando pagina $PaginaSiguiente...','#divPrincipaltablaVisitas','#divMensajero');\">Siguiente</a></li>";
      ?>
    </ul>
  </nav>
</div>
<!--Popup Para Actualizar Datos-->
<div id="map">
  
</div>
