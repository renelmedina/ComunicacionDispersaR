<?php
class Conexion extends PDO {
   private $tipo_de_base = 'mysql';
   private $host = 'localhost';
   private $nombre_de_base = 'renelmed_servisoft';
   private $usuario = 'renelmed_servici';
   private $contrasena = '10461437449';
   public function __construct() {
      //Sobreescribo el método constructor de la clase PDO.
      try{
         parent::__construct($this->tipo_de_base.':host='.$this->host.';dbname='.$this->nombre_de_base, $this->usuario, $this->contrasena);
      }catch(PDOException $e){
         echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
         exit;
      }
   }
}
class PaginaPrincipal{
  private $direccionPagina;
  private $rutaImagenes;
  private $rutaJavaScript;
  private $rutaCss;
  //private $rutaFuentes;
  //private $rutaBootstrapComun;
  function __construct(){
    $this->direccionPagina="http://renel.com/accsac.com/Aplicaciones/seal/comunicaciondispersa";
    $this->rutaImagenes=$this->direccionPagina."/images/";
    $this->rutaJavaScript=$this->direccionPagina."/js/";
    $this->rutaCss=$this->direccionPagina."/css/";
    //$this->rutaFuentes=$this->direccionPagina."/fuentes/css/";
    //$this->rutaBootstrapComun=$this->direccionPagina."/bootstrap-3.3.4/";
  }
  public function favicon(){
    echo "<head><link rel='shortcut icon' type='image/x-icon' href='".$this->rutaImagenes."favicon.ico'></head>";
  }
  public function FrameworkModernos(){
   ?>
   <head>
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
      <script src="../js/acciones.js"></script>

   </head>
   <body>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
   </body>
   <?php
  }
  public function FrameworkComunes(){
   echo "<head>";
   echo "<script type='text/javascript' src='".$this->rutaJavaScript."jquery-1.11.1.js'></script>";
   echo "<script type='text/javascript' src='".$this->rutaBootstrapComun."js/bootstrap.js'></script>";
   echo "<link rel=stylesheet href='".$this->rutaBootstrapComun."css/bootstrap.css' type='text/css' media='screen'>";
   echo "</head>";
  }
  public function ArchivosEsenciales(){
    echo "<head>";
   //echo "<script type='text/javascript' src='https://code.jquery.com/jquery-3.2.1.slim.min.js'></script>";
    echo "<script type='text/javascript' src='".$this->rutaJavaScript."acciones.js'></script>";
    echo "<link rel=stylesheet href='".$this->rutaCss."estilos.css' type='text/css'>";
    echo "<link rel=stylesheet href='".$this->rutaCss."animate.css' type='text/css'>";
    echo "<meta charset='utf-8'>";
    echo "</head>";
  }
  public function CabeceraPagina(){
    ?>
      <div id="minimenu" width="800">
        <a href="#" onclick="crearfondodiv();crearpopupdiv('http://accsac.com/climatizacion/climatizacion.php?dato=chat')">
          <img src="http://accsac.com/images/chat-accsac.png" alt="" height="80" align="left" valing="middle">
        </a>
      <h3>Ll&aacute;manos +00-051-054-203689</h3>
      </div>
    <?php
  }
}
?>