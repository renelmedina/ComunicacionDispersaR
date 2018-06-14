<?php
require_once("../libreria.php");

?>
<!DOCTYPE html>
<html>
<head>
<style>
/* Style the tab */
.tab {
    overflow: hidden;
    border: 1px solid #ccc;
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
    background-color: inherit;
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
}
</style>
</head>
<body>
<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">AC/ Facturacion / C</button>
  <button class="tablinks" onclick="openCity(event, 'Paris')">Contrastes</button>
  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Grandes Clientes</button>
</div>

<div id="London" class="tabcontent">
  <h4>Atencion al cliente / Facturacion / Cobranza y Morosidad</h4>
  <a href="../plantillasxls/acPlantilla.xlsx" download="PlantillaAc">Descargar Plantilla</a><br>
  <img src="../images/acPlantilla.jpg" alt="Plantilla ac" style="border: solid 1px black;" >
  <div>
    <h1>Subir Plantilla</h1>
    <form action="" name="frmImportarAtencionC" id="frmImportarAtencionC">
      <select name="cboDetalleTDD_ID" id="cboDetalleTDD_ID">
      <?php
      $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
      $sqlListarSector="CALL ListarTodoTDD_Detalle(0)";
      $stmt=$ConexionSealDBComunicacionDispersa->prepare($sqlListarSector);
      $stmt->execute();
      foreach($stmt as $ResultadoTipoDocumento) {
        $DetalleTDD_ID=$ResultadoTipoDocumento['DetalleTDD_ID'];
        $AreaID=$ResultadoTipoDocumento['AreaID'];
        $AreaNombre=$ResultadoTipoDocumento['AreaNombre'];
        $TipoDocumentoID=$ResultadoTipoDocumento['TipoDocumentoID'];
        $NombreTD=$ResultadoTipoDocumento['NombreTD'];
        $NombreTDD=$ResultadoTipoDocumento['NombreTDD'];
        $DescripcionTDD=$ResultadoTipoDocumento['DescripcionTDD'];
        $ImagenReferencialTDDD=$ResultadoTipoDocumento['ImagenReferencialTDDD'];
        echo "<option value='$DetalleTDD_ID'>$AreaNombre :: $NombreTD :: $NombreTDD</option>";
      }
      ?>
      </select>
      <input type="file" name="flSubirDocumento">
      <input type="hidden" name="registronro" value="ImportarAC">
      <input type="button" value="Subir Plantilla" onclick="envio_general_forms('#frmImportarAtencionC','acdocumentos_registro.php','#divCuerpoDocumentos','#divPieImportar','Importando...');">
    </form>
    <div id="divPieImportar"></div>
    <div id=divCuerpoDocumentos></div>
  </div>
</div>

<div id="Paris" class="tabcontent">
  <h3>Contrastes</h3>
  <p>Contrastes</p> 
</div>

<div id="Tokyo" class="tabcontent">
  <h3>Grandes Clientes</h3>
  <p>Grandes Clientes</p>
</div>

<script>
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
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
     
</body>
</html> 
