<?php
require_once("../libreria.php");
//$cabecera=new PaginaPrincipal;
//echo $cabecera->FrameworkModernos();
//echo $cabecera->ArchivosEsenciales();
$FechaInicio=coger_dato_externo("txtFechaInicio");
$FechaFin=coger_dato_externo("txtFechaFin");
//echo "$FechaInicio :::: $FechaFin";
$ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
$sqlInsertar="call DocumentosTrabajo_BusquedaXFechaSinAsignarMapa2('$FechaInicio','$FechaFin')";
$stmt = $ConexionSealDBComunicacionDispersa->prepare($sqlInsertar);
$rows = $stmt->execute();
$ListaContratos=array();
$numeros=0;
echo "$sqlInsertar";
$textoJSON="[";
foreach($stmt as $ListaContratoss) {
    //$ListaContratos["features"]=$ListaContratoss;
    $Latitud=$ListaContratoss["Latitud"];
    $Longitud=$ListaContratoss["Longitud"];
    $NroContrato=$ListaContratoss["NroContrato"];
    $idDocumentosTrabajo=$ListaContratoss["idDocumentosTrabajo"];
    //fnConsoleLog($NroContrato);
    //$ListaContratos["features"].push(array('position' => , ););
    $numeros+=1;
    if (!empty($NroContrato) && !empty($Latitud) && !empty($Longitud)) {
        $ArrayContratos=array(
            //'position'=>array('lat'=>(float)$Longitud,'lng'=>(float)$Latitud),
            'position'=>'new google.maps.LatLng('.(float)$Latitud.', '.(float)$Longitud.')',
            "type"=>"puntoverde",
            "label"=>"$NroContrato",
            "nombreMarcador"=>"$idDocumentosTrabajo"
        );
        array_push($ListaContratos,$ArrayContratos);
        $textoJSON.="{position:new google.maps.LatLng(".(float)$Latitud.", ".(float)$Longitud."),";
        $textoJSON.="type:'puntoverde',";
        //$textoJSON.="label:'$NroContrato',";
        $textoJSON.="label:'',";    
        $textoJSON.="nombreMarcador:'$idDocumentosTrabajo'";
        $textoJSON.="},";
        /*if ($rows>$numeros) {
           $textoJSON.=",";
        }*/
    }
}
//echo json_encode($ListaContratos);
$textoJSON.="];";
//echo $textoJSON; 
?>


<form action="" name="frmBuscarPorFechas" id="frmBuscarPorFechas" action="" method="">
    <div class="row">
        <div class="col"><!--class="col-lg-6"-->
            <div class="input-group">
                <span class="input-group-addon">Fecha Inicio</span>
                <input type="date" name="txtFechaInicio" id="txtFechaInicio" value="<?php echo $FechaInicio; ?>">
                <span class="input-group-addon">Fecha Fin:</span>
                <input type="date" name="txtFechaFin" id="txtFechaFin" value="<?php echo $FechaFin; ?>">
                <span class="input-group-btn">
                <button class="btn btn-info" type="button" onclick="envio_general_forms('#frmBuscarPorFechas','acdocumentosasignar.php','#divCuerpoPrincipalACliente','#divEstadoAsiganciones','Buscando...');">Buscar</button>
                </span>
                <span class="input-group-addon">Herramientas:=></span>
                
                    <input type="button" class='btn btn-outline-info btn-sm' name="btnDefault" value="Desplazamiento" onclick="fnMenu('ninguno');">
                    <input type="button" class='btn btn-outline-info btn-sm' name="btnSelecionarPuntos" value="Selecionar Contratos" onclick="fnMenu('seleccionarPuntos');">
                    <button type='button' class='btn btn-outline-success btn-sm' data-toggle='modal' onclick="fnGuardarEnBaseDatos();">Guardar Asiganciones</button>
            </div>
        </div>
    </div>
</form>
<div id="divEstadoAsiganciones"></div>
        <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
        width: 90%;
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

        /*Estilos del tabmenu*/
        * {box-sizing: border-box}


        /* Style the tab */
        div.tab {
            float: left;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            /*width: 30%;*/
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
            width: 70%;
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
            width: 10%;
            color: black;
            border: solid 1px black;
            float: left;
            display: block;
            text-align: center;
            font-size: 10px;

        }
    </style>


    <div class="SubMenuOpcionesPolilinea" id="SubMenuOpcionesPolilinea">
        <ul class="ulsubmenupolilinea">
            <li><a href="">Asignar y eliminar ptos...</a>
                <ul>
                    <?php
                    $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
                    $sqlListarSector="CALL ListarTodoAccesoLogin()";
                    $stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarSector);
                    $stmt->execute();
                    foreach($stmt as $ResultadoUsuarios) {
                        $AccesoLoginID=$ResultadoUsuarios['idAccesoLogin'];
                        $PersonalID=$ResultadoUsuarios['PersonalID'];
                        $Usuario=$ResultadoUsuarios['Usuario'];
                        $Password=$ResultadoUsuarios['Contrasenia'];
                        $TipoAcceso=$ResultadoUsuarios['TipoAcceso'];
                        $NombreCompleto=$ResultadoUsuarios['NombresCompletos'];
                        

                        echo "<li><a href='#' class='clPersonal' id='$AccesoLoginID'>$NombreCompleto</a></li>";
                    }
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
            </li>
            <li><a href="#" class="Eseleccion">Eliminar Seleccion</a></li>
            <li><a href="#" class="Eseleccionpunto">Eliminar Seleccion/ Puntos</a></li>
            <li><a href="#" class="Ccolorpuntos">Cambiar color a puntos</a>
                <ul>
                    <li><a href='#' class='clColor'>Amarillo</a></li>
                    <li><a href='#' class='clColor'>Azul</a></li>
                    <li><a href='#' class='clColor'>Celeste</a></li>
                    <li><a href='#' class='clColor'>Morado</a></li>
                    <li><a href='#' class='clColor'>Rojo</a></li>
                    <li><a href='#' class='clColor'>Verde</a></li>

                </ul>
            </li>
            <!--<li><a href="#">Opcion1</a></li>-->
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
    var markers = [];//contiene todos los marcadores
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
          zoom: 10,
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
          puntoverde:{
            icon: iconBase+'puntoverdex9.png'
          }
        };
        /*var s = '{"nombre":"juan"}';
        var o = JSON.parse(s);
        var json = JSON.stringify(o);
        console.log(o);*/
        //Las posiciones(nro de contrato) que se cargaran dinamicamente
        //features = eval(<?php echo json_encode($ListaContratos); ?>);
        features = eval(<?php echo json_encode($textoJSON); ?>);
        /*features = [
          {
            position: new google.maps.LatLng(-33.91721, 151.22630),
            type: 'info',
            label: '1',
            nombreMarcador:'1'
          }, {
            position: new google.maps.LatLng(-33.91539, 151.22820),
            type: 'info',
            label: '2',
            nombreMarcador:'2'
          }, {
            position: new google.maps.LatLng(-33.91747, 151.22912),
            type: 'info',
            label: '3',
            nombreMarcador:'3'
          }, {
            position: new google.maps.LatLng(-33.91910, 151.22907),
            type: 'info',
            label: '4',
            nombreMarcador:'4'
          }, {
            position: new google.maps.LatLng(-33.91725, 151.23011),
            type: 'info',
            label: '5',
            nombreMarcador:'5'
          }, {
            position: new google.maps.LatLng(-33.91872, 151.23089),
            type: 'info',
            label: '6',
            nombreMarcador:'6'
          }, {
            position: new google.maps.LatLng(-33.91784, 151.23094),
            type: 'info',
            label: '7',
            nombreMarcador:'7'
          }, {
            position: new google.maps.LatLng(-33.91682, 151.23149),
            type: 'info',
            label: '8',
            nombreMarcador:'8'
          }, {
            position: new google.maps.LatLng(-33.91790, 151.23463),
            type: 'info',
            label: '9',
            nombreMarcador:'9'
          }, {
            position: new google.maps.LatLng(-33.91666, 151.23468),
            type: 'info',
            label: '10',
            nombreMarcador:'10'
          }, {
            position: new google.maps.LatLng(-33.916988, 151.233640),
            type: 'info',
            label: '11',
            nombreMarcador:'11'
          }, {
            position: new google.maps.LatLng(-33.91662347903106, 151.22879464019775),
            type: 'parking',
            label: '12',
            nombreMarcador:'12'
          }, {
            position: new google.maps.LatLng(-33.916365282092855, 151.22937399734496),
            type: 'parking',
            label: '13',
            nombreMarcador:'13'
          }, {
            position: new google.maps.LatLng(-33.91665018901448, 151.2282474695587),
            type: 'parking',
            label: '14',
            nombreMarcador:'14'
          }, {
            position: new google.maps.LatLng(-33.919543720969806, 151.23112279762267),
            type: 'parking',
            label: '15',
            nombreMarcador:'15'
          }, {
            position: new google.maps.LatLng(-33.91608037421864, 151.23288232673644),
            type: 'parking',
            label: '16',
            nombreMarcador:'16'
          }, {
            position: new google.maps.LatLng(-33.91851096391805, 151.2344058214569),
            type: 'parking',
            label: '17',
            nombreMarcador:'17'
          }, {
            position: new google.maps.LatLng(-33.91818154739766, 151.2346203981781),
            type: 'parking',
            label: '18',
            nombreMarcador:'18'
          }, {
            position: new google.maps.LatLng(-33.91727341958453, 151.23348314155578),
            type: 'library',
            label: '19',
            nombreMarcador:'19'
          },
        ];*/
        //Funcion que muestra todas las ubicaciones(Markers)
        MostrarMarcadores();
        /*Funciones Internas de la Clase*/
        //funcion que agregar un markador al mapa
        
        
    }
        //Ocultara todos los marcadores
        function OcultarMarcadores() {
            //MostrarMarcadores(null);
            EstablecerMarcadores(null);
        }
        
        // Eliminar todos los marcadores del array y oculta los marcadores. Dando la sencion de que se eliminaron
        //Aun se debe trabajar en esta funcion.
        function DeleteMarkers() {
            OcultarMarcadores();
            markers = [];//Limpiamos todos los marcadores
        }
        // Muestra todos los marcadores que estan en el array, en el mapa.
        function MostrarMarcadores() {
            EstablecerMarcadores(map);
            //setMapOnAll(map);
        }
        //Agrega todos los marcadores al mapa
        function EstablecerMarcadores(map) {
            for (var i in features) {//Hara un recorrido por todo el array
                if (features[i].hasOwnProperty('nombreMarcador')) {//Verifica si tiene la propiedad 'nombreMarcador'
                    AgregarMarcador(features[i].position,icons[features[i].type].icon,features[i].label,features[i].nombreMarcador,map);
                }
            }

        }
        function AgregarMarcador(position,icon,label,nombreMarcador,map){
            var marker = new google.maps.Marker({
                position: position,
                icon: icon,
                label: label,
                map: map,
                nombreMarcador:nombreMarcador
            });
            // cuando se haga doble click se eliminara del mapa y del array
            marker.addListener('dblclick', function() {
                marker.setMap(null);
                //falta implementar la eliminacion del array.

            });
            //Este array deberia de existir previamente
            markers.push(marker);
        }
        //muestra todos los markers en el mapa
        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
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
                map.addListener('click', addLatLng);
                DibujarPilininea();
                PoliniaSelecionador.addListener('rightclick',subMenuPolilinea);
                //PoliniaSelecionador.addListener('dblclick',fnAsignarPolilinea);
                PoliniaSelecionador.addListener('click',fnModificarPuntos);
                //PoliniaSelecionador.addListener('mouseover',fnModificarPuntos);
                //PoliniaSelecionador.addListener('click',fnModificarPuntos);
                //PoliniaSelecionador.addListener('click',fnDatosPoligono);
                break;
            case 'ninguno':
                //Elimina el evento 'click' del mapa.
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
                MarcadoresSeleccionados.push(feature.nombreMarcador);
                feature.type="puntoverde";
                console.log(markers.length +":OOOOO:" + feature.type)
            }else{
                feature.type="puntoceleste";
            }
        });
        DeleteMarkers();
        MostrarMarcadores();
        //MostrarMarcadores();
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
                MarcadoresSeleccionados.push(feature.nombreMarcador);
            }
        });
       //Verifica si previamente existe un poligono en el mapa, sino existe, añade esta primera.
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
            fnAsignarPolilinea(elem,elem.NombrePolilinea,this.id,this.innerHTML)

        });

        $(".Eseleccion").off();
        $(".Eseleccion").click(function() {
            //Para eliminar el cuadro de seleccion
            //alert(elem.idTrabajador);
            elem.setMap(null);
            console.log("Intendo");
            for (var i = 0; i < PuntosSelecionados.length; i++) {
                console.log("RER "+ PuntosSelecionados[i].idTrabajador + " en "+elem.idTrabajador);
                if (PuntosSelecionados[i].idTrabajador == elem.idTrabajador) {
                    console.log("Eliminado "+ PuntosSelecionados[i].idTrabajador);
                    PuntosSelecionados.splice(i, 1);
                    //break;
                    //delete PuntosSelecionados[i];
                }
                

            }
            console.log(PuntosSelecionados);
            //Oculta el menu contextual
            fnOcultarSubmenu();
            //Muestra los cambios en el menu de la derecha
            fnRepresentarSeleccionado();
            //delete PuntosSelecionados[0];
        });
        $(".Eseleccionpunto").off();
        $(".Eseleccionpunto").click(function() {
            //Para eliminar los puntos dentro de la seleccion
            /*position: new google.maps.LatLng(-33.91727341958453, 151.23348314155578),
            type: 'library',
            label: '19',
            nombreMarcador:'19'
            nombreMarcador:'$idDocumentosTrabajo'
            */
            alert(features[1].nombreMarcador);
        });
        $(".Ccolorpuntos").click(function() {
            //Para Cambiar colores de los puntos
        });
        $(".clColor").click(function() {
            //Para cambiar a un color especifico
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
                elemento.idTrabajador=NuevoIDTrabajador;//Esto es importante si no no se podra borrar
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
    </script>
    
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyeNELJuURtBnMQR5Josan3KL7luObvlg&callback=initMap">
    </script>

