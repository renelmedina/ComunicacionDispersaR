<?php
require_once("libreria.php");
function fnMensajeRojo($Mensaje){
  echo "<div class='divRojo'>$Mensaje</div>";
}
$Usuario=null;
$Password=null;
if (isset($_POST["usuario"])&&isset($_POST["password"])) {
  $Usuario=$_POST["usuario"];
  $Password=GenerarPassword($_POST["password"]);
  #Parametros de seguridad
  //echo "token correcto";
  if (empty($Usuario)||empty($Password)) {
    msg_rojo("Debes llenar los datos usuario y contraseña");
    return;
  }else{
    $ConexionSealDBComunicacionDispersa= new ConexionSealDBComunicacionDispersa();
    $stmtScriptSQL=$ConexionSealDBComunicacionDispersa->prepare("CALL AccesoLogin(:usuario,:password)");
    $stmtScriptSQL->execute(array(
      ':usuario'=>$Usuario,
      ':password'=>$Password
    ));
		$num_rows_SQL = $stmtScriptSQL->rowCount();
		$DatoDevuelto="";
		if ($num_rows_SQL>0) {
      foreach($stmtScriptSQL as $ListaSQL) {
        $idAccesoLogin=$ListaSQL["idAccesoLogin"];
        $CodigoPersonal=$ListaSQL["PersonalID"];
        $Usuario=$ListaSQL["Usuario"];
        $Password=$ListaSQL["Password"];
        $TipoAcceso=$ListaSQL["TipoAcceso"];
        $NombrePersonal=$ListaSQL["NombrePersonal"];
        $NombreAcceso=$ListaSQL["NombreAcceso"];
        $UrlDestino=$ListaSQL["UrlDestino"];
      }
      #Iniciado varibles de session
      session_start();
      $_SESSION["PersonalID"]=$CodigoPersonal;
      $_SESSION["UsuarioSistema"]=$NombrePersonal;
      $_SESSION["TipoAcceso"]=$TipoAcceso;
      //$_SESSION["TipoAccesoNombre"]=fnTipoUsuario($TipoAcceso);
      $_SESSION["AccesoSistemaID"]=$idAccesoLogin;
      $_SESSION["UrlDestino"]=$UrlDestino;
      
      redirigir($UrlDestino);

      /*$TipoUsuario=fnTipoUsuario($_SESSION["TipoAcceso"]);
      switch ($TipoUsuario) {
        case 'Administrador':
          redirigir("administrador");
          break;
        case 'Logistica':
          //fnMensajeRojo("Aun no hemos implementado el modulo para personal Logistica");
          redirigir("logistica");
          break;
        case 'Supervisor/Asistente':
          # code...
          //fnMensajeRojo("Aun no hemos implementado el modulo para personal Supervidor/Asistente");
          redirigir("supervisor");
          break;
        case 'Tecnico':
          # code...
          //fnMensajeRojo("Aun no hemos implementado el modulo para personal Tecnico");
          redirigir("tecnico");
          break;
        default:
          fnMensajeRojo("Al parecer tus datos de acceso no tienen vinculo al sistema.");
          break;
      }*/
      //echo "Tipo Usuario:".$TipoUsuario;
      //redirigir("$urlpagina");
      msg_verde("Acceco Correcto -".$UrlDestino);
		}else{
			msg_rojo("Usuario y/o contraseña incorrectos");
		}
		$dbConexionGeneral=null;
  }
  
}else {
  msg_rojo("Parametros Incorrectos");
}
?>
