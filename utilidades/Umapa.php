<?php
require_once("../libreria.php");
require '../vendor/autoload.php';
    use vendor\PhpOffice\PhpSpreadsheet\Spreadsheet;
    use vendor\PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    //use vendor\PhpOffice\PhpSpreadsheet\Reader\Xlsx;
$cabecera=new PaginaPrincipal;
echo $cabecera->FrameworkModernos();
echo $cabecera->ArchivosEsenciales();
//$cabecera=new PaginaPrincipal;
//echo $cabecera->FrameworkModernos();
//echo $cabecera->ArchivosEsenciales();

$FechaInicio=coger_dato_externo("txtFechaInicio");
$FechaFin=coger_dato_externo("txtFechaFin");

$ArchivoImportado=$_FILES['flSubirDocumento']['name'];
if (!empty($_POST["hdValor"])) {
    //return;

    //cargamos el archivo al servidor con el mismo nombre
    $errores = 0;
    //solo le agregue el sufijo bak_ 
    $archivo = $_FILES['flSubirDocumento']['name'];
    $tipo = $_FILES['flSubirDocumento']['type'];
    //echo $tipo;
    //(strpos($filetipo, "gif")
    //return;
    try {
        $destino = "bak_" . $archivo;
        if (copy($_FILES['flSubirDocumento']['tmp_name'], $destino)){
            //echo "Archivo Cargado Con Éxito";
            fnConsoleLog("Archivo Cargado Con Éxito");
        }else{
            msg_rojo("Error Al Cargar el Archivo");
        }
        if (file_exists("bak_" . $archivo)) {
            //Acciones a realizar con el archivo importado
            //$reader;
            //$reader;
            if (strpos($tipo, "ms-excel")) {//*.xls
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                //$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }else if(strpos($tipo, "openxmlformats")){//*.xlsx
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }else{
                echo "Debes subir solo archivos excel";
                return;
            }
            //$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load("bak_" . $archivo);


            $worksheet = $spreadsheet->getActiveSheet();
            // Get the highest row and column numbers referenced in the worksheet
            $highestRow = $worksheet->getHighestRow(); // e.g. 10
            $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 5
            $textoJSON="[";
            //echo '<table>' . "\n";
            //for ($row = 1; $row <= $highestRow; ++$row) {
            for ($row = 2; $row <= $highestRow; ++$row) {

                //echo '<tr>' . PHP_EOL;
                /*for ($col = 1; $col <= 4; ++$col) {
                    $value = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                    //echo '<td>' . $value . '</td>' . PHP_EOL;

                }*/
                $textoJSON.="{position:new google.maps.LatLng(".(float)$worksheet->getCellByColumnAndRow(2, $row)->getValue().", ".(float)$worksheet->getCellByColumnAndRow(3, $row)->getValue()."),";
                $textoJSON.="type:'puntorojo',";
                $textoJSON.="label:'".$worksheet->getCellByColumnAndRow(1, $row)->getValue()."',"; 
                //$textoJSON.="label:'',";
                $textoJSON.="nombreMarcador:'".$worksheet->getCellByColumnAndRow(4, $row)->getValue()."',";
                $textoJSON.="suministroNro:'".$worksheet->getCellByColumnAndRow(1, $row)->getValue()."',";
                $textoJSON.="tipoDoc:'".$worksheet->getCellByColumnAndRow(5, $row)->getValue()."',";
                $textoJSON.="fechaE:'".$worksheet->getCellByColumnAndRow(6, $row)->getValue()."',";
                $textoJSON.="dato1:'".$worksheet->getCellByColumnAndRow(7, $row)->getValue()."',";
                $textoJSON.="dato2:'".$worksheet->getCellByColumnAndRow(8, $row)->getValue()."',";
                $textoJSON.="dato3:'".$worksheet->getCellByColumnAndRow(9, $row)->getValue()."',";
                $textoJSON.="dato4:'".$worksheet->getCellByColumnAndRow(10, $row)->getValue()."'";
                $textoJSON.="},";
                # creamos la copia
                $textoJSON2.="{position:new google.maps.LatLng(".(float)$worksheet->getCellByColumnAndRow(2, $row)->getValue().", ".(float)$worksheet->getCellByColumnAndRow(3, $row)->getValue()."),";
                $textoJSON2.="type:'puntorojo',";
                $textoJSON2.="label:'',";
                $textoJSON2.="nombreMarcador:'".$worksheet->getCellByColumnAndRow(4, $row)->getValue()."',";
                $textoJSON2.="suministroNro:'".$worksheet->getCellByColumnAndRow(1, $row)->getValue()."',";
                $textoJSON2.="tipoDoc:'".$worksheet->getCellByColumnAndRow(5, $row)->getValue()."',";
                $textoJSON2.="fechaE:'".$worksheet->getCellByColumnAndRow(6, $row)->getValue()."',";
                $textoJSON2.="dato1:'".$worksheet->getCellByColumnAndRow(7, $row)->getValue()."',";
                $textoJSON2.="dato2:'".$worksheet->getCellByColumnAndRow(8, $row)->getValue()."',";
                $textoJSON2.="dato3:'".$worksheet->getCellByColumnAndRow(9, $row)->getValue()."',";
                $textoJSON2.="dato4:'".$worksheet->getCellByColumnAndRow(10, $row)->getValue()."'";
                $textoJSON2.="},";
            }
            $textoJSON.="];";
            # duplicamos el Json
            $textoJSON2.="];";
            //echo '</table>' . PHP_EOL; 
        }
        unlink($destino);
    } catch (Exception $e) {
        echo 'Parece que estas subiendo un archivo corrupto(',  $e->getMessage(), ")\n";
        return;
    }
}else{
    //msg_rojo("---Debes de seleccionar un archivo $ArchivoImportado c".$_POST["hdValor"]);
}
//echo $textoJSON; 
?>
<div id="floating-panel">
    <form action="Umapa.php" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col"><!--class="col-lg-6"-->
                <div class="input-group">
                        <input type="file" name="flSubirDocumento">
                        <input type="submit" name="btnSubirArchivo" value="Subir Archivo">
                        <input type="hidden" name="hdValor" value="Este valor">
                    
                    <!--<span class="input-group-addon">Fecha Inicio</span>
                    <input type="date" name="txtFechaInicio" id="txtFechaInicio" value="<?php echo $FechaInicio; ?>">
                    <span class="input-group-addon">Fecha Fin:</span>
                    <input type="date" name="txtFechaFin" id="txtFechaFin" value="<?php echo $FechaFin; ?>">
                    <span class="input-group-btn">
                    <button class="btn btn-info" type="button" onclick="envio_general_forms('#frmBuscarPorFechas','acdocumentosasignar.php','#divCuerpoPrincipalACliente','#divEstadoAsiganciones','Buscando...');">Buscar</button>
                    </span>-->
                    <span class="input-group-addon">Herramientas:=></span>
                    
                        <input type="button" class='btn btn-outline-info btn-sm' name="btnDefault" value="Desplazamiento" onclick="fnMenu('ninguno');">
                        <input type="button" class='btn btn-outline-info btn-sm' name="btnSelecionarPuntos" value="Selecionar Contratos" onclick="fnMenu('seleccionarPuntos');">
                        <button type='button' class='btn btn-outline-success btn-sm' data-toggle='modal' onclick="fnpasarphp();">Guardar Asiganciones</button>
                        <!--<button type='button' class='btn btn-outline-success btn-sm' data-toggle='modal' onclick="fnGuardarEnBaseDatos();">Guardar Asiganciones</button>-->

                </div>
            </div>
        </div>
    </form>
    <div id="divEstadoAsiganciones"></div>

</div>
        <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
       #floating-panel {
        position: absolute;
        top: 10px;
        left: 10%;
        z-index: 5;
        background-color: transparent;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
        /*width: 100%;*/
      }
      #map {
        height: 100%;
        width: 100%;
        /*float: left;*/
      }
        .SubMenuOpcionesPolilinea{
            position: absolute;
            bottom: 10px;
            left: 100px;
            z-index: 1000;
            display: none;
        }
        .ulsubmenupolilinea {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 200px;
            background-color: #f1f1f1;
        }

        .ulsubmenupolilinea > li a {
            display: block;
            color: #000;
            padding: 8px 16px;
            text-decoration: none;
        }

        /* Change the link color on hover */
        .ulsubmenupolilinea > li a:hover {
            background-color: #555;
            color: white;
        }
        #asignaciones{
            width: 100%;
            /*float: left;*/
            clear: both;
            /*height: 100%;*/
        }

        .ulsubmenupolilinea li:hover > ul {
            display: block;
            left: 200px;
        }
        .ulsubmenupolilinea li > ul {
            display: none;
            position: absolute;
            background-color: #333;
            top: 0;
            list-style-type: none;
            /*left: -200px;*/
            min-width: 200px;*/
            width: 400px;
            z-index: -1;
            padding: 0;
            margin: 0;
            /*height: 100%;*/
        }
        .ulsubmenupolilinea li > ul li{
            margin: 0;
            padding: 0;
            left: 0;
        }
        .ulsubmenupolilinea li > ul li a{
            color: white;
        }
        .ulsubmenupolilinea li > ul li a:hover {
            background-color:grey;
            color: black;
        }

        #divCantidad{
            bottom: 10;
            right: 0;
            z-index: 10;
            position: fixed;
            background-color: rgb(150,150,150,0.5);
        }

        /*Estilos del tabmenu*/
        * {box-sizing: border-box}


        /* Style the tab */
        div.tab {
            float: left;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            width: 10%;
            /*height: 100%;*/
        }

        /* Style the buttons inside the tab */
        div.tab button {
            display: block;
            background-color: inherit;
            color: black;
            padding: 2px 16px;
            width: 100%;
            border: none;
            outline: none;
            text-align: left;
            cursor: pointer;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        div.tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current "tab button" class */
        div.tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            float: left;
            padding: 0px 2px;
            border: 1px solid #ccc;
            width: 90%;
            border-left: none;
            /*height: 100%;*/
        }
        .ulcontratos{
            width: 100%;
            /*border: solid 1px blue;*/
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        .liContratos{
            /*width: 10%;*/
            color: black;
            border: solid 1px black;
            float: left;
            display: block;
            text-align: center;
            font-size: 14;

        }
    </style>


    <div class="SubMenuOpcionesPolilinea" id="SubMenuOpcionesPolilinea">
        <ul class="ulsubmenupolilinea">
            <li><a href="">Asignar A...</a>
                <ul>
                    <li><a href='#' class='clPersonal' id='Cesar Quepuy'>Cesar Quepuy</a></li>
                    <li><a href='#' class='clPersonal' id='Jose Rivera'>Jose Rivera</a></li>
                    <li><a href='#' class='clPersonal' id='Michell'>Michell</a></li>
                    <li><a href='#' class='clPersonal' id='Rocio'>Rocio</a></li>
                    <li><a href='#' class='clPersonal' id='Juan'>Juan</a></li>
                    <li><a href='#' class='clPersonal' id='Felipe'>Felipe</a></li>
                    <li><a href='#' class='clPersonal' id='Motorizado1'>Motorizado1</a></li>
                    <li><a href='#' class='clPersonal' id='Motorizado2'>Motorizado2</a></li>

                    <li><a href='#' class='clPersonal' id='Motorizado3'>Motorizado3</a></li>

                    <li><a href='#' class='clPersonal' id='Motorizado4'>Motorizado4</a></li>

                    <li><a href='#' class='clPersonal' id='Motorizado5'>Motorizado5</a></li>

                    <?php
                    /*$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
                    $sqlListarSector="CALL ListarTodoAccesoLogin()";
                    $stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarSector);
                    $stmt->execute();
                    foreach($stmt as $ResultadoUsuarios) {
                        $AccesoLoginID=$ResultadoUsuarios['idAccesoLogin'];
                        $PersonalID=$ResultadoUsuarios['PersonalID'];
                        $Usuario=$ResultadoUsuarios['Usuario'];
                        $Password=$ResultadoUsuarios['Contrasenia'];
                        $TipoAcceso=$ResultadoUsuarios['TipoAcceso'];
                        $NombreCompleto=$ResultadoUsuarios['NombreCompleto'];
                        $ApellidoPaterno=$ResultadoUsuarios['ApellidoPaterno'];
                        $ApellidoMaterno=$ResultadoUsuarios['ApellidoMaterno'];

                        echo "<li><a href='#' class='clPersonal' id='$PersonalID'>$ApellidoPaterno $ApellidoMaterno $NombreCompleto</a></li>";
                    }*/
                    ?>
                    <!--<li>
                        <select name="" id="" style="margin: 1em;">
                            <option value="Trabajador1">Trabajador1</option>
                            <option value="Trabajador2">Trabajador2</option>
                            <option value="Trabajador3">Trabajador3</option>
                            <option value="Trabajador4">Trabajador4</option>
                            <option value="Trabajador5">Trabajador5</option>
                        </select>
                    </li>-->
                </ul>
                <li><a href="#" class="EliminarEsteElemento">Eliminar Seleccion</a></li>
            </li>
            <!--<li><a href="">Eliminar Seleccion</a></li>
            <li><a href="">Opcion1</a></li>
            <li><a href="">Opcion1</a></li>
            <li><a href="">Opcion1</a></li>-->
        </ul>
    </div>
    <div id="divSeleccionados"></div>
    <div id="map" onmousemove="Ubicaciondelmouse(event)">

    </div>
    <script>
        $(document).ready(function(){
           $(document).bind("contextmenu",function(e){
              return false;
           });
        });
    </script>
    <div id="divCantidad">
        Puntos seleccionados:
    </div>
    <div id="asignaciones">
            <!--Aqui se Genera el Menu Dinamicamente--> 
                <!--Aqui se Genera el contenido del Menu Dinamicamente, basado en divs--> 
    </div>
    <script>
        /*Comportamiento del tab*/
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById("divAgrupados"+cityName).style.display = "block";
            //$("#"+cityName).css("display","none");
            evt.currentTarget.className += " active";
        }
    var map;
    var features;//contiene los marcadores extraidos del BD
    var iconBase;
    var icons;
    var markers = [];//contiene 
    var MarcadoresSeleccionados= new Array();
    var Menu;
    var PoliniaSelecionador;
    var subMenuPolilineaOpciones;
    var PuntosSelecionados=[]
    var NombreAleatorio;//Nombre que se asigna temporalmente a una nueva polilinea
    var divMenuAgrupado;//Donde se crea el menu con sus asiganciones con los contratos agrupados.
    var divContenidoAgrupado;//donse se agrupan los contratos en diferentes div, luego este se inserta en la variable divMenuAgrupado
    var varMouseX;//Ubicacion X del puntero del mouse
    var varMouseY;//Ubicacion Y del puntero del mouse
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: new google.maps.LatLng(-16.401363333333, -71.540266666667),
          mapTypeId: 'roadmap'
        });

        
        //Tipos de iconos para los makers de google maps
        /*iconBase = 'https://maps.google.com/mapfiles/kml/shapes/';
        icons = {
          parking: {
            icon: iconBase + 'parking_lot_maps.png'
          },
          library: {
            icon: iconBase + 'library_maps.png'
          },
          info: {
            icon: iconBase + 'info-i_maps.png'
          },
          puntorojo:{
            icon: iconBase+'placemark_circle_highlight.png'
          }
        };*/
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
        //features = eval(<?php //echo json_encode($ListaContratos); ?>);
        features = eval(<?php echo json_encode($textoJSON); ?>);
        features2= eval(<?php echo json_encode($textoJSON2); ?>);
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
                dato4:dato4,
            });
            var contentString = '<div id="content">'+
            '<div id="siteNotice">'+
            '</div>'+
            '<h3>'+label+'</h3>'+
            '<div id="bodyContent">'+
            '<p><b>Item: </b>,'+nombreMarcador+'</p>'+
            '<p><b>Tipo: </b>,'+tipoDoc+'</p>'+
            '<p><b>Fecha Ejecucion: </b>,'+fechaE+'</p>'+
            '<p><b>Dato1: </b>,'+dato1+'</p>'+
            '<p><b>Dato2: </b>,'+dato2+'</p>'+
            '<p><b>Dato3: </b>,'+dato3+'</p>'+
            '<p><b>Dato4: </b>,'+dato4+'</p>'+
            
            '</div>'+
            '</div>';
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            marker.addListener('click',function () {
                infowindow.open(map, marker);
            });
            google.maps.event.addListener(map, 'click', function() {
            if (infowindow) {
                    infowindow.close();
                }
                //infowindow = new google.maps.InfoWindow();
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
    /*Funciones Externas*/
    //Funcion que maneja el menu de opciones del mapa
    function fnMenu(opcionMenu) {
        /*Menu de Opciones*/
        switch(opcionMenu) {
            case 'seleccionarPuntos':
                document.getElementById("SubMenuOpcionesPolilinea").style.display="none";
                NombreAleatorio=generarNombreAleatorio(5);
                PoliniaSelecionador=null;
                //MarcadoresSeleccionados=new Array();//La variable fue creada previamente
                //var path = PoliniaSelecionador.getPath();
                
                //map.addListener('click', addLatLng);
                map.addListener('click', function(e){
                    addLatLng(e);
                });
                DibujarPilininea();
                PoliniaSelecionador.addListener('dragend',fnModificarPuntos);
                PoliniaSelecionador.addListener('click',fnModificarPuntos);
                PoliniaSelecionador.addListener('rightclick',subMenuPolilinea);
                /*PoliniaSelecionador.addListener('rightclick',function(e){
                    
                    subMenuPolilinea(e);
                });*/
                //PoliniaSelecionador.addListener('dblclick',fnAsignarPolilinea);
                /////PoliniaSelecionador.addListener('dragend',fnModificarPuntos);
                //PoliniaSelecionador.addListener('mouseover',fnModificarPuntos);
                //PoliniaSelecionador.addListener('click',fnModificarPuntos);
                //PoliniaSelecionador.addListener('click',fnDatosPoligono);
                break;
            case 'ninguno':
                //Elimina el evento 'click' del mapa.
                MarcadoresSeleccionados=null;//La variable fue creada previamente
                google.maps.event.clearListeners(map, 'click');
                fnOcultarSubmenu();
                break;
            default:
                //code block
        }
    }
    //Funcion temporal, que mostraria datos del poligono(como los contratos estan dentro, a quien esta asignado). Est en desarollo
    function fnDatosPoligono(event) {
        alert(PoliniaSelecionador.NombrePolilinea);
    }
    //Vuelve a verificar si existen contratos dentro del poligono
    //y luego vuelve a crear el arreglo con los contratos encontrados
    function fnModificarPuntos(event) {
        PoliniaSelecionador=this;
        //MarcadoresSeleccionados, fuer previamente.
        MarcadoresSeleccionados=new Array();
        //features, corresponde al arreglo donde estan los markers(puntos/contratos)
        features.forEach(function(feature) {
            //containsLocation, verifica si existe un determinado punto dentro de un poligono containsLocation(posicion,poligono)
            if (google.maps.geometry.poly.containsLocation(feature.position, PoliniaSelecionador)) {
                MarcadoresSeleccionados.push([
                    feature.nombreMarcador,
                    feature.tipoDoc,
                    feature.fechaE,
                    feature.suministroNro,
                    feature.dato1,
                    feature.dato2,
                    feature.dato3,
                    feature.dato4
                ]);
            }
        });
        fnCantidadSelecionado(MarcadoresSeleccionados.length);
        var contadorIncoincidente=0;
        //Verificando que no haya el mismo ID para que no sea repetido
        for(var i = 0; i < PuntosSelecionados.length; i++){
            if(PuntosSelecionados[i].idTrabajador == PoliniaSelecionador.NombrePolilinea){
                PuntosSelecionados[i].contratos=MarcadoresSeleccionados;
            }else{
                contadorIncoincidente+=1;
            }
        }
        //Creando el menu de agrupamiento, con todo lo agrupado.
        fnRepresentarSeleccionado();
    }
    //Generador de nombre aleatorio, usado para la variable 'NombreAleatorio'
    function generarNombreAleatorio(longitud){
        var caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHIJKLMNPQRTUVWXYZ2346789";
        var NombreAleatorio = "";
        for (i=0; i<longitud; i++) NombreAleatorio += caracteres.charAt(Math.floor(Math.random()*caracteres.length));
        return NombreAleatorio;
    }
    //Inserta una nueva interseccion(punto/lado/) al poligono que se esta dibujando
    //addLatLng(event), el 'event', corresponde a la posicion del mouse, cuando se hizo click.
    function addLatLng(event) {
        
        MarcadoresSeleccionados=new Array();//La variable fue creada previamente
        var path = PoliniaSelecionador.getPath();
        // porque el path es un MVCArray, simplemente podemos agregar una nueva coordenada
        // Agregamos el nuevo nuevo.
        path.push(event.latLng);
        features.forEach(function(feature) {
            //containsLocation, verifica si existe un determinado punto dentro de un poligono containsLocation(posicion,poligono)
            if (google.maps.geometry.poly.containsLocation(feature.position, PoliniaSelecionador)) {
                MarcadoresSeleccionados.push([
                    feature.nombreMarcador,//0
                    feature.tipoDoc,//1
                    feature.fechaE,//2
                    feature.suministroNro,//3
                    feature.dato1,//4
                    feature.dato2,//5
                    feature.dato3,//6
                    feature.dato4//7
                ]);
            }
        });
        fnCantidadSelecionado(MarcadoresSeleccionados.length);
       //Verifica si previamente existe un poligono en el mapa, sino existe, añade esta primera.

       //var nomale=generarNombreAleatorio(5);
        if (PuntosSelecionados.length<=0) {
            //Renel
            PuntosSelecionados.push({
                idTrabajador:NombreAleatorio,//idTrabajador, corresponde al ID del trabajador asignado
                contratos:MarcadoresSeleccionados,//contratos, corresponde a los contratos que estan dentro del poligono
                NombrePolilinea:NombreAleatorio//NombrePolilinea, corresponde al nombre del poligono
            })
        }
        var contadorIncoincidente=0;// se utilizara para ver si ya existe un poligono(array) con el mismo nombre
        //Verificando que no haya el mismo ID para que no sea repetido
        for(var i = 0; i < PuntosSelecionados.length; i++){
            if(PuntosSelecionados[i].idTrabajador == NombreAleatorio){
                PuntosSelecionados[i].contratos=MarcadoresSeleccionados;
            }else{
                contadorIncoincidente+=1;//Si no coincide se incrementa en 1
            }
        }
        // si contadorIncoincidente es igual al tamaño del array, significa que no hay coincidencias, asi que inserta uno nuevo.
        if (contadorIncoincidente==PuntosSelecionados.length) {
            PuntosSelecionados.push({
                idTrabajador:NombreAleatorio,
                contratos:MarcadoresSeleccionados,
                NombrePolilinea:NombreAleatorio//NombrePolilinea, corresponde al nombre del poligono
            })
            contadorIncoincidente=0;
        }
        
        //funcion que representa todo lo agrupado en forma de menu(en la derecha)
        fnRepresentarSeleccionado();
    }
    //Permite dibujar el poligono en el mapa
    function DibujarPilininea() {
        //Estableciendo parametros(configuraciones) del poligono. La variable fue previamente declarada antes
        PoliniaSelecionador = new google.maps.Polygon({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            editable: true,
            draggable: true,
            icons: icons[features[i].type].icon,
            NombrePolilinea:NombreAleatorio,
            idTrabajador:NombreAleatorio
        });
        //Se coloca el poligono en el mapa
        PoliniaSelecionador.setMap(map);        
    }
    //Menu contextual que se abre al hacer click derecho en un poligono
    function subMenuPolilinea(event) {
        //hace que el menu contextual sea visible en la posicion del mouse
        document.getElementById("SubMenuOpcionesPolilinea").style.display="block";
        document.getElementById("SubMenuOpcionesPolilinea").style.top=varMouseY+"px";
        document.getElementById("SubMenuOpcionesPolilinea").style.left=varMouseX+"px";
        google.maps.event.clearListeners(map, 'click');
        //Se se hace click en el mapa el menu contextual se oculta
        map.addListener('click', function() {
            fnOcultarSubmenu();
        });
        var elem=this;//Es importante declara esta variable volcando el obbjeto poligono actual
        //.off(), es extremadamente importante para eliminar todos los eventos previos asignados a este boto
        //si se omite, dara la sensacion de que se hicieron varios click e ira aumentando cuando se haga mas clicks
        $(".clPersonal").off();
        //despues de eliminar todos los eventos a este boton, se le asigna el evento click
        $(".clPersonal").click(function() {
            //Se asigna el poligono(con los contratos que encierra) al personal seleccionado
            //alert(this.innerHTML);
            fnAsignarPolilinea(elem,elem.NombrePolilinea,this.id,this.innerHTML)
        });

        $(".EliminarEsteElemento").click(function() {
            /* Act on the event */
            elem.setMap(null);
            console.log("Intendo");
            for (var i = 0; i < PuntosSelecionados.length; i++) {
                console.log("RER "+ PuntosSelecionados[i].idTrabajador + " en "+elem.idTrabajador);
                if (PuntosSelecionados[i].idTrabajador == elem.idTrabajador) {
                    console.log("Eliminado "+ PuntosSelecionados[i].idTrabajador);
                    PuntosSelecionados.splice(i, 1);
                    //break;
                }
                

            }
            //Oculta el menu contextual
            fnOcultarSubmenu();
            //Muestra los cambios en el menu de la derecha
            fnRepresentarSeleccionado();
            //delete PuntosSelecionados[0];
        });
        

    }
    //el poligono selecionado se asigna a un trabjador con todos los contratos que estan dentro
    function fnAsignarPolilinea(elemento,idTrabajador,NuevoIDTrabajador,NombreTrabajador) {
        //obs: si se asigna dos polilineas al mismo trabajador, luego no se podra desvincular.
        for(var i = 0; i < PuntosSelecionados.length; i++){
            if(PuntosSelecionados[i].idTrabajador == idTrabajador){
                PuntosSelecionados[i].idTrabajador=NuevoIDTrabajador;
                PuntosSelecionados[i].NombrePolilinea=NombreTrabajador;
                elemento.NombrePolilinea=NuevoIDTrabajador;
            }
        }
        //Oculta el menu contextual
        fnOcultarSubmenu();
        //Muestra los cambios en el menu de la derecha
        fnRepresentarSeleccionado();
    }
    //Oculta el menu contextual
    function fnOcultarSubmenu() {
        document.getElementById("SubMenuOpcionesPolilinea").style.display="none";
    }
    //obtiene la posicion actual del mouse y le asigna las varibles
    function Ubicaciondelmouse(event) {
        varMouseX= event.clientX;
        varMouseY= event.clientY;
    }

    //Crea un menu agrupado por cada poligono con sus respectivos contratos, esto se ve reflejado en la parte de la derecha
    function fnRepresentarSeleccionado() {
        divMenuAgrupado="";//varible previamente declaro
        divContenidoAgrupado="";//varible previamente declaro
        var varContratosAgrupado="";
        for(var i = 0; i < PuntosSelecionados.length; i++){
            divMenuAgrupado+="<button class='tablinks' ondblclick=\"alert('"+PuntosSelecionados[i].idTrabajador+"');\" onclick=\"openCity(event, '"+PuntosSelecionados[i].idTrabajador+"');\" name='"+PuntosSelecionados[i].idTrabajador+"'>"+PuntosSelecionados[i].NombrePolilinea+"</button>";
            varContratosAgrupado="";
            PuntosSelecionados[i].contratos.forEach(function(word) {
                varContratosAgrupado=varContratosAgrupado+"<li class='liContratos'>"+word+"</li>";//Es importante el espacio en blanco al final del span para que se tabule autmaticamente
            });
            divContenidoAgrupado+="<div id='divAgrupados"+PuntosSelecionados[i].idTrabajador+"' style='display:none;' class='tabcontent'><h4>"+PuntosSelecionados[i].NombrePolilinea+"</h4><ul class='ulcontratos'>"+varContratosAgrupado+"</ul></div>"
        }
        //document.getElementById("divSeleccionados").innerHTML="<pre>"+JSON.stringify(PuntosSelecionados)+"</pre>";
        console.log(PuntosSelecionados);
        document.getElementById("asignaciones").innerHTML="<div class='tab' id='divAgrupados'>"+divMenuAgrupado+"</div>"+divContenidoAgrupado;
    }
    /*Funcion que envia todos los datos json a php para que lo guarde en la base de datos*/
    function fnGuardarEnBaseDatos() {
        $.ajax({
            type: "POST",
            url: 'acdocumentos_registro.php?registronro=AsignarDocumentosJSON',
            data: {json: JSON.stringify(PuntosSelecionados)},
            //dataType: 'json',
            //mientras enviamos el archivo
            beforeSend: function(){
                $("#divEstadoAsiganciones").html("Asignando documentos, espere...");
            },
            //una vez finalizado correctamente
            success: function(theResponse) {
                $("#divEstadoAsiganciones").html("Cargado Exitosa!");
                $("#divEstadoAsiganciones").html(theResponse);
            },
              //si ha ocurrido un error
            error: function(){
              $("#divEstadoAsiganciones").html("<strong>Error: </strong> Error de envio de datos, vuelve a intentarlo, si el problema persiste comunica al webmaster. este error es de comunicaion de datos con el servidor mediante tecnologia Ajax y Jquery");
            }
          });
        alert(JSON.stringify(PuntosSelecionados));
    }
    function fnpasarphp(){
        /*$.ajax({
        type: 'POST',
        url: 'Umapa.php',
        data: {json: JSON.stringify(PuntosSelecionados)},
        dataType: 'json',
        success: function(theResponse) {
                $("#divEstadoAsiganciones").html("Cargado Exitosa!");
                $("#divEstadoAsiganciones").html(theResponse);
            }
        });*/


        $.ajax({
            type: "POST",
            url: 'exportexcel.php?valor=1',
            data: {json: JSON.stringify(PuntosSelecionados)},
            //dataType: 'json',
            //mientras enviamos el archivo
            beforeSend: function(){
                $("#devuelto").html("Asignando documentos, espere...");
            },
            //una vez finalizado correctamente
            success: function(theResponse) {
                $("#devuelto").html("Cargado Exitosa!");
                
                location.href = "http://accsac.com/sistemas/seal/comunicaciondispersa/utilidades/ejemploti.xlsx";
                //window.open("http://accsac.com/sistemas/seal/comunicaciondispersa/utilidades/ejemploti.xlsx");
                //$a.remove();
            },
              //si ha ocurrido un error
            error: function(){
              $("#devuelto").html("<strong>Error: </strong> Error de envio de datos, vuelve a intentarlo, si el problema persiste comunica al webmaster. este error es de comunicaion de datos con el servidor mediante tecnologia Ajax y Jquery");
            }
          });
    }
    function fnCantidadSelecionado(cantidad) {
        document.getElementById("divCantidad").innerHTML=cantidad+" Puntos seleccionados.";
        // body...
    }
    </script>
    
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyeNELJuURtBnMQR5Josan3KL7luObvlg&callback=initMap">
    </script>

<div id="devuelto"></div>
<!--
<form action="your-server-side-code" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="pk_test_rKTHWTlDVri0LqOhv3lIk4Sh"
    data-amount="2563"
    data-name="RECAMEDI"
    data-description="Hosting"
    data-image="http://www.recamedi.com/wp-content/uploads/2017/10/cropped-recamedi-logo-300x70.png"
    data-locale="Es-es">
  </script>
</form>-->
