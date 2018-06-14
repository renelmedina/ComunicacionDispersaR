<?php
require_once("../libreria.php");
$Usuario=coger_dato_externo("usuario");
$Password=coger_dato_externo("password");
//Variables de respuesta
$CodigoEstado=null;
$TextoEstado=null;
$CodigoPersonal=null;
$NombrePersonal=null;
$textorespuesta=null;
if (!empty($Usuario)&&!empty($Usuario)) {
  $Password=GenerarPassword($Password);
  //echo "$Password";
  #Parametros de seguridad
  $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
  $stmtScriptSQL=$ConexionSealDBComunicacionDispersa->prepare("CALL AccesoLogin(:usuario,:password)");
  $stmtScriptSQL->execute(array(
    ':usuario'=>$Usuario,
    ':password'=>$Password
  ));
  $num_rows_SQL = $stmtScriptSQL->rowCount();
  $DatoDevuelto="";
  if ($num_rows_SQL>0) {
    $CodigoEstado=1;
    $TextoEstado="Acceso Correcto";
    foreach($stmtScriptSQL as $ListaSQL) {
      $idAccesoLogin=$ListaSQL["idAccesoLogin"];
      $CodigoPersonal=$ListaSQL["PersonalID"];
      $Usuario=$ListaSQL["Usuario"];
      $Password=$ListaSQL["Password"];
      $TipoAcceso=$ListaSQL["TipoAcceso"];
      $NombrePersonal=$ListaSQL["NombrePersonal"];
    }
  }else{
    $CodigoEstado=2;//Significa Acceso Denegado, usuario y contraseña incorrecto
    $TextoEstado="Usuario o Contraseña Incorrectos...";
  }
  $dbConexionGeneral=null;
}
echo "<login>
  <estadologin codigoestado='$CodigoEstado' textoestado='$TextoEstado'/>
  <usuario codigopersonal='$idAccesoLogin' nombrepersonal='$NombrePersonal' />
  <textorespuesta>$TextoEstado</textorespuesta>
</login>";
?>