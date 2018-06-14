<?php
require_once("../libreria.php");
//iniciarsession();
//verificarsession("Session cerrada del modulo de Accesos del Sistema");
//verificar_tecnico();
//$IdUsuario=$_SESSION["PersonalID"];
//$NombreUsuarioActual=$_SESSION["UsuarioSistema"];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Ubicacion de Punto</title>



    
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: verdana;
        font-size: 12px;
      }
      #DetallesLocal{
        width: 300px;
      }
      #map {
        height: 100%;
      }
      table{
        border: none;

      }
      table tr:hover td{
        background-color: #fff;
        color: black;
      }
      table td{
        border: none;
      }
    </style>
  </head>
  <body>
    
    <?php
    $paginaGaleriaFotos="galeriafotos.php?registronro=FotoLocal&IdLocal=$LocalID";
    ?>
    <script>
      var vartxtNombreLocal="Punto";
    

    //alert("Latitud:"+vartxtLatitud+"Longitud:"+vartxtLongitud);
function initMap() {
  var myLatLng = {lat: <?php echo coger_dato_externo("lat");?>, lng: <?php echo coger_dato_externo("lng");?>};

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 15,
    center: myLatLng
  });

  var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    title: 'Hello World!'
  });
}

    </script>
    <div id="map"></div>
    <div class="" style="position:fixed;bottom:0; width:50%; align: center;">
      <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyeNELJuURtBnMQR5Josan3KL7luObvlg&callback=initMap">
      </script>
     
     
    </div>
  </body>
</html>
