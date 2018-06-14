<?php
require_once("../libreria.php");
#Listando Tipo de Contrato
$ConexionSealDBGeneralidades_TC= new ConexionSealDBGeneralidades();
$sqlListarTipoContratos="CALL ListarTodoTipoContrato();";
$stmtTipoContratos=$ConexionSealDBGeneralidades_TC->prepare($sqlListarTipoContratos);
$stmtTipoContratos->execute();
$ListaTipoContrato=array();
foreach($stmtTipoContratos as $stmtListaTipoContratos) {
  $ListaTipoContrato[]=$stmtListaTipoContratos;
}
$ConexionSealDBGeneralidades_TC=null;
?>
<form action="" id="frmBuscarContratos" name="frmBuscarContratos" onsubmit="envio_general_forms('#frmBuscarContratos','contratos.php','#divPrincipal','#divMensajero','Buscando...');return false;">
  <div class="row">
    <div class="col"><!--class="col-lg-6"-->
      <div class="input-group">
        <span class="input-group-addon">Tipo Contrato</span>
        <select name="cboTipoContrato" id="cboTipoContrato" class="form-control">
          <option value="0">Todos</option>
          <?php
            foreach ($ListaTipoContrato as $LitaTipoContrato) {
              $idTipoContrato=$LitaTipoContrato["idTipoContrato"];
              $NombreTipo=$LitaTipoContrato["NombreTipo"];
              $DescripcionTipo=$LitaTipoContrato["DescripcionTipo"];
              echo "<option value='$idTipoContrato'>$NombreTipo</option>";
            }
          ?>
        </select>
        <span class="input-group-addon">Zona:</span>
        <select name="cboZonaId" id="cboZonaId" class="form-control">
          <option value="0">Todos</option>
          <?php
            $ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
            $sqlListarZonas="CALL ListarTodoZonas()";
            $stmt=$ConexionSealDBGeneralidades->prepare($sqlListarZonas);
            $stmt->execute();
            foreach($stmt as $ResultadoZonas) {
              $ZonaID=$ResultadoZonas['idZona'];
              $NombreZona=$ResultadoZonas['NombreZona'];
              $NroZona=$ResultadoZonas['NroZona'];
              echo "<option value='$ZonaID'>$NroZona - $NombreZona</option>";
            }
            $ConexionSealDBGeneralidades=null;
          ?>
        </select>
        <span class="input-group-addon">Sector:</span>
        <select name="cboSectorId" id="cboSectorId" class="form-control">
          <option value="0">Todos</option>
          <?php
            $ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
            $sqlListarSector="CALL ListarTodoSector()";
            $stmt=$ConexionSealDBGeneralidades->prepare($sqlListarSector);
            $stmt->execute();
            foreach($stmt as $ResultadoSector) {
              $SectorID=$ResultadoSector['idSector'];
              $NroSector=$ResultadoSector['NroSector'];
              $NombreSector=$ResultadoSector['NombreSector'];
              echo "<option value='$SectorID'>$NroSector - $NombreSector</option>";
            }
            $ConexionSealDBGeneralidades=null;
          ?>
        </select>
        <span class="input-group-addon">Libro:</span>
        <select name="cboLibroId" id="cboLibroId" class="form-control">
          <option value="0">Todos</option>
          <?php
          $ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
          $sqlListarLibros="CALL ListarTodoLibro()";
          $stmt=$ConexionSealDBGeneralidades->prepare($sqlListarLibros);
          $stmt->execute();
          foreach($stmt as $ResultadoLibros) {
            $LibroID=$ResultadoLibros['idLibro'];
            $NroLibro=$ResultadoLibros['NroLibro'];
            $NombreLibro=$ResultadoLibros['NombreLibro'];
            echo "<option value='$LibroID'>$NroLibro - $NombreLibro</option>";
          }
          $ConexionSealDBGeneralidades=null;
          ?>
        </select>
        <span class="input-group-addon">Hoja:</span>
        <input type="text" list="lstHojas">
        <datalist id="lstHojas">
          <?php
          $ConexionSealDBGeneralidades= new ConexionSealDBGeneralidades();
          $sqlListarHojas="CALL ListarTodoHojasXpaginas(0,200)";
          $stmt=$ConexionSealDBGeneralidades->prepare($sqlListarHojas);
          $stmt->execute();
          foreach($stmt as $Resultadohojas) {
            $HojaID=$Resultadohojas['idHoja'];
            $NroHoja=$Resultadohojas['NroHoja'];
            $NombreHoja=$Resultadohojas['NombreHoja'];
            $DescripcionHoja=$Resultadohojas['DescripcionHoja'];
            echo "<option value='$HojaID' label='$NroHoja - $NombreHoja'>";
          }
          $ConexionSealDBGeneralidades=null;
          ?>
        </datalist>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="input-group">
        <span class="input-group-addon">Buscar:</span>
        <input type="text" name="txtDatosBuscar" class="form-control" placeholder="Dato a Buscar">
        <select name="cboBuscarEn" id="cboBuscarEn" class="form-control">
          <option value="0">Todos</option>
          <option value="1">Nro Contrato</option>
          <option value="2">Nim</option>
          <option value="3">Cliente</option>
          <option value="4">Direccion</option>
          <option value="5">Sed</option>
          <option value="6">Longitud</option>
          <option value="7">Latitud</option>
        </select>
        <span class="input-group-btn">
          <button class="btn btn-info" type="button" onclick="envio_general_forms('#frmBuscarContratos','contratos_lista.php','#divListaContratos','#divMensajero','Buscando...');">Buscar</button>
        </span>
      </div>
    </div>
  </div>
</form>
<div id="divListaContratos">
  <?php require_once("contratos_lista.php"); ?>
</div>
<div class="card border-info text-center mb-4">
  <form name="frmImportarContratos" id="frmImportarContratos" method="post" enctype="multipart/form-data" onsubmit="return false;" >
  <div class="card-header bg-info">Actualizar Contratos en Bloque</div>
  <div class="card-body">
    <div class="row">
      <div class="col">
        <p>
          <img src="../images/contratosPlantilla.jpg" alt="Plantilla contrato seal acc" style="border: solid 1px black;" ><br>
          <a href="../plantillasxls/contratosPlantilla.xlsx" download>Descargar Plantilla</a>
        </p>
        Selecciona el tipo de contrato y sube el archivo correcto, para insertar o actualizar los contratos.
        <div class="input-group">
          <span class="input-group-addon">Tipo Contrato:</span>
          <select name="cboTipoContrato_a" id="cboTipoContrato_a" class="form-control">
            <?php
              foreach ($ListaTipoContrato as $LitaTipoContrato) {
                $idTipoContrato=$LitaTipoContrato["idTipoContrato"];
                $NombreTipo=$LitaTipoContrato["NombreTipo"];
                $DescripcionTipo=$LitaTipoContrato["DescripcionTipo"];
                echo "<option value='$idTipoContrato'>$NombreTipo</option>";
              }
            ?>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <div class="input-group">
          <input type="file" name="excel" class="form-control"/>
          <input type="hidden" class="btn btn-primary" value="upload" name="action" />
          <input type="hidden" name="registronro" value="ImportarContratos">
          <span class="input-group-btn">
            <button class="btn btn-info" type="button" onclick="envio_general_forms('#frmImportarContratos','contratos_registro.php','#divCuerpo','#divPieCard','Importando...');">Importar</button>
          </span>
        </div>
      </div>
    </div>
    </form>
    <div id="divPieCard"></div>
    <div id="divCuerpo"></div>
  </div>
</div>