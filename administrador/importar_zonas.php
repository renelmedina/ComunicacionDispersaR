<?php
require_once("../libreria.php");
?>

Selecciona el archivo a importar:
<form name="importa" id="frmimporta" method="post" action="importar_zonas.php" enctype="multipart/form-data" onsubmit="return false;" >
    <input type="file" name="excel" />
    <input type="hidden" value="upload" name="action" />
    <input type="hidden" name="registronro" value="ImportarZonas">
    <input type='button' name='enviar'  value="Importar" onclick="envio_general_forms('#frmimporta','zona_registro.php','#divMensajero','Importando Zonas...');" />
</form>
<!-- CARGA LA MISMA PAGINA MANDANDO LA VARIABLE upload -->
<?php

?>
</body>
</html>