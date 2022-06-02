<?php 

class Main {

  public function __construct(){
    require_once('../config/conexion.php');
    $c = new Conexion();
    $this->db = $c->getConexion();
    $this->productos = array();
  }

   public function getCliente($identificacion){
    $consulta = $this->db->prepare("SELECT identificacion FROM clientes WHERE identificacion=?");
    $consulta->execute([$identificacion]);
    $res = $consulta->fetchall();
    return $res;
  }

  public function GetDatosClientes($id){
    $consulta = $this->db->prepare("SELECT * FROM clientes WHERE identificacion=?");
    $consulta->execute([$id]);
    $res = $consulta->fetchall();
    echo json_encode($res);
  }

  public function GetClienteId($id){
    $consulta = $this->db->prepare("SELECT * FROM clientes WHERE id=?");
    $consulta->execute([$id]);
    $res = $consulta->fetchall();
    echo json_encode($res);
  }

  public function createCliente($identificacion,$nombre,$telefono,$email,$direccion){
    $consulta = $this->db->prepare(" INSERT INTO clientes (identificacion, nombre, telefono, email, direccion) VALUES (?,?,?,?,?)");
    $consulta->execute([$identificacion,$nombre,$telefono,$email,$direccion]);
    $res = $consulta->fetchall();
    return $res;
  }

  public function updateCliente($identificacion,$nombre,$telefono,$email,$direccion,$id){
    $consulta = $this->db->prepare("UPDATE clientes SET identificacion=?, nombre=?, telefono=?, email=?, direccion=? WHERE id=?");
    $consulta->execute([$identificacion,$nombre,$telefono,$email,$direccion,$id]);
    $res = $consulta->fetchall();
    return $res;
  }

 
}

$main = new Main();

if (isset($_GET['cliente'])) {
$res = $main->getCliente($_GET['cliente']);
  if(count($res)>0){
     $main->GetDatosClientes($_GET['cliente']);
    } else {
      echo json_encode(0);
    }

} else if (isset($_GET['identificacion'])) {
$resultado = $main->getCliente($_GET['identificacion']);
if(count($resultado)>0){
    $jsonData = 1;
  } else {
    $jsonData = 0;
  }
  echo json_encode($jsonData);

} elseif (isset($_POST['guardar'])) {
$main->createCliente($_POST['c_identificacion'],$_POST['c_nombre'],$_POST['c_telefono'],$_POST['c_email'],$_POST['c_direccion']);
echo "true";

} elseif (isset($_POST['idCliente'])) {
$main->GetClienteId($_POST['idCliente']);

} elseif (isset($_POST['update'])) {
$main->createCliente($_POST['up_identificacion'],$_POST['up_nombre'],$_POST['up_telefono'],$_POST['up_email'],
  $_POST['up_direccion'],$_POST['id']);
echo "true";

}



?>