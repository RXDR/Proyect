<?php 

class Main {

  public function __construct(){
    require_once('../config/conexion.php');
    $c = new Conexion();
    $this->db = $c->getConexion();
    $this->productos = array();
  }

  public function selectUsuario($id){
    $consulta = $this->db->prepare("SELECT * FROM usuarios WHERE id=?");
    $consulta->execute([$id]);
    $res = $consulta->fetchall();
    echo json_encode($res);
  }

  public function getUsuario($identificacion){
    $consulta = $this->db->prepare("SELECT identificacion FROM usuarios WHERE identificacion=?");
    $consulta->execute([$identificacion]);
    $res = $consulta->fetchall();
    return $res;
  }
  public function getEmail($email){
    $consulta = $this->db->prepare("SELECT email FROM usuarios WHERE email=?");
    $consulta->execute([$email]);
    $res = $consulta->fetchall();
    return $res;
  }

  public function createUsuarios($nombre,$identificacion,$email,$password,$perfil){
    $consulta = $this->db->prepare(" INSERT INTO usuarios (nombre, identificacion, email, password, perfil) VALUES (?,?,?,?,?)");
    $consulta->execute([$nombre,$identificacion,$email,md5($password),$perfil]);
    $res = $consulta->fetchall();
    return $res;
  }

  public function updateUsuario($nombre,$identificacion,$email,$perfil,$id){
    $consulta = $this->db->prepare("UPDATE usuarios SET nombre=?, identificacion=?, email=?, perfil=? WHERE id=?");
    $consulta->execute([$nombre,$identificacion,$email,$perfil,$id]);
    $res = $consulta->fetchall();
    return $res;
  }
  public function updatePass($password,$id){
    $consulta = $this->db->prepare("UPDATE usuarios SET password=? WHERE id=?");
    $consulta->execute([md5($password),$id]);
    $res = $consulta->fetchall();
    return $res;
  }


}

$main = new Main();

if (isset($_POST['idUsuario'])) {
$main->selectUsuario($_POST['idUsuario']);

} elseif (isset($_POST['guardar'])) {
$main->createUsuarios($_POST['nombre'],$_POST['id_usuario'],$_POST['email'],$_POST['password'],$_POST['perfil']);
echo "true";

} elseif (isset($_POST['update'])) {
$main->updateUsuario($_POST['nombre_up'],$_POST['id_usuario_up'],$_POST['email_up'],$_POST['perfil_up'],$_POST['id']);
echo "true";

} elseif (isset($_POST['updatePass'])) {
$main->updatePass($_POST['password_up'],$_POST['id_user']);
echo "true";

}  else if (isset($_GET['cedula'])) {
$resultado = $main->getUsuario($_GET['cedula']);
if(count($resultado)>0){
    $jsonData = 1;
  } else {
    $jsonData = 0;
  }
  echo json_encode($jsonData);

} else if (isset($_GET['email'])) {
$resultado = $main->getEmail($_GET['email']);
if(count($resultado)>0){
    $jsonData = 1;
  } else {
    $jsonData = 0;
  }
  echo json_encode($jsonData);

}





?>