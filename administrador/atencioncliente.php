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
<style>
    #menu {
    padding: 0;
    margin: 0;
    border: 0;
    float: left; 
}

#menu ul, li {
      list-style: none;
     margin: 0;
      padding: 0; 
}

#menu ul {
      position: relative;
      z-index: 597;
      float: left; 
}

#menu ul li {
    float: left;
    min-height: 1px;
    line-height: 1em;
    vertical-align: middle; 
}

#menu ul li.hover,
#menu ul li:hover {
  position: relative;
  z-index: 599;
  cursor: default; 
}

#menu ul ul {
  visibility: hidden;
  position: absolute;
  top: 100%;
  left: 0;
  z-index: 598;
  width: 100%; 
}

#menu ul ul li {
  float: none; 
}

#menu ul li:hover > ul {
  visibility: visible; 
}

#menu ul ul {
  top: 0;
  left: 100%; 
}

#menu ul li {
  float: none;
  font-size: 12px;
}

#menu {
  width: 10%; 
}

#menu span, #menu a {
    display: inline-block;
    /*font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;*/
    text-decoration: none; 
}

#menu:after, #menu ul:after {
    content: '';
    display: block;
    clear: both; 
}

#menu ul, #menu li {
    width: 100%; 
}
#menu li {
    background: #dddddd;
}
#menu li:hover {
    background: #f6f6f6; 
}
#menu a {
    color: #666666;
    line-height: 160%;
    padding: 11px 28px 11px 5px;
    width: 100%; 
}
#menu ul ul li {
    background: #f6f6f6; 
}
#menu ul ul li:hover {
    background: #dddddd; 
}
#menu ul ul li:hover a {
    color: #666666; 
}
#menu ul ul li ul li {
    background: #dddddd; 
}
#menu ul ul li ul li:hover {
    background: #b7b7b7; 
}
#menu .has-sub {
    position: relative; 
}

#menu .has-sub:after, #menu .has-sub > ul > .has-sub:hover:after {
    content: '';
    display: block;
    width: 10px;
    height: 9px;
    position: absolute;
    right: 5px;
    top: 50%;
    margin-top: -5px;
    /*background-image: url(right.png);*/
}
#menu .has-sub > ul > .has-sub:after, #menu .has-sub:hover:after {
    /*background-image: url(right.png);*/
}
</style>
<div id="menu">
    <ul>
        <!--<li class="has-sub"><a title="" href="https://www.jose-aguilar.com/tienda/es/3-prestashop">Prestashop</a>
            <ul>
                <li class="has-sub"><a title="" href="https://www.jose-aguilar.com/tienda/es/6-módulos">Módulos</a>
                    <ul>
                        <li><a title="" href="https://www.jose-aguilar.com/tienda/es/12-administración">Administración</a></li>
                        <li><a title="" href="https://www.jose-aguilar.com/tienda/es/13-publicidad-y-marketing">Publicidad y Marketing</a></li>
                        <li><a title="" href="https://www.jose-aguilar.com/tienda/es/14-front-office">Front Office</a></li>
                        <li><a title="" href="https://www.jose-aguilar.com/tienda/es/15-importación-y-exportación">Importación y Exportación</a></li>
                        <li><a title="" href="https://www.jose-aguilar.com/tienda/es/16-pago">Pago</a></li>
                        <li><a title="" href="https://www.jose-aguilar.com/tienda/es/17-búsqueda-y-filtros">Búsqueda y filtros</a></li>
                        <li><a title="" href="https://www.jose-aguilar.com/tienda/es/18-precio-y-descuentos">Precio y Descuentos</a></li>
                        <li><a title="" href="https://www.jose-aguilar.com/tienda/es/19-seo">SEO</a></li>
                        <li><a title="" href="https://www.jose-aguilar.com/tienda/es/20-transporte-y-logística">Transporte y Logística</a></li>
                        <li><a title="" href="https://www.jose-aguilar.com/tienda/es/21-redes-sociales">Redes Sociales</a></li>
                        <li><a title="" href="https://www.jose-aguilar.com/tienda/es/22-gratis">GRATIS</a></li>
                    </ul>
                 </li>
                 <li><a title="" href="https://www.jose-aguilar.com/tienda/es/7-themes">Themes</a></li>
             </ul>
        </li>-->
        <li class="has-sub"><a title="" href="javascript:fnCargaSimple('acdocumentos.php','Cargando lista de documentos','#divCuerpoPrincipalACliente','#divMensajero');">Ver Documentos</a></li>
        <li class="has-sub"><a title="" href="javascript:fnCargaSimple('acdocumentossubir.php','Cargando modulo para subir plantilla','#divCuerpoPrincipalACliente','#divMensajero');">Subir Plantilla</a></li>
        <li class="has-sub"><a title="">Asignar Documentos</a>
          <ul>
                <li><a title="" href="javascript:fnCargaSimple('acdocumentosasignarsincontrato.php','Cargando documentos sin asignar, sin mapa','#divCuerpoPrincipalACliente','#divMensajero');">Sin Nro Contrato(Manual)</a></li>
                <li class="has-sub"><a title="" href="javascript:fnCargaSimple('acdocumentosasignar.php','Cargando documentos sin asignar, con mapa...','#divCuerpoPrincipalACliente','#divMensajero');">Con Nro Contrato</a></li>
             </ul>
        </li>
        <li class="has-sub"><a title="" href="javascript:fnCargaSimple('acdocumentoscargo.php','Cargando Cargos Documentos','#divCuerpoPrincipalACliente','#divMensajero');">Registrar Cargos</a></li>
        <li class="has-sub"><a title="" href="javascript:fnCargaSimple('acdomentosentregaseal.php','Cargando Cargos Documentos','#divCuerpoPrincipalACliente','#divMensajero');">Entrega Seal</a></li>
        <li class="has-sub"><a title="" href="javascript:fnCargaSimple('acdocumentosreporteseal.php','Cargando generador de reportes...','#divCuerpoPrincipalACliente','#divMensajero');">Reportes</a></li>

    </ul>
</div>
<div id="divCuerpoPrincipalACliente" style="border: solid 1px red;">  
    
</div>