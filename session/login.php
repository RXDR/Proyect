<?php
session_start();
// *** Validate request to login to this site.
class Usuario{

  public function __construct(){
    require_once('../config/conexion.php');
    $c = new Conexion();
    $this->db = $c->getConexion();
    $this->productos = array();
  }

  public function getUsuarioLogin($email, $password){
    $consulta = $this->db->prepare(" SELECT * FROM usuarios WHERE email=? AND password=?");
    $consulta->execute([$email,md5($password)]);
    $res = $consulta->fetchAll();
    return $res;
  }

}

$bd = new Usuario();

if(isset($_POST['MM_insert'])){
  $res = $bd->getUsuarioLogin($_POST['email'],$_POST['password']);

    if(!empty($res[0])){
      $_SESSION['id'] = $res[0]['id'];
      $_SESSION['nombre'] = $res[0]['nombre'];
      $_SESSION['idvendedor'] = $res[0]['identificacion'];
      $_SESSION['perfil'] = $res[0]['perfil'];

      echo 1;

    } else {

      echo 2;

    }

}

?>
