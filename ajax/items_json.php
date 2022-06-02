<?php

$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

class Main {

  public function __construct(){
    require_once('../config/conexion.php');
    $c = new Conexion();
    $this->db = $c->getConexion();
    $this->productos = array();
  }

  public function createItems($descripcion,$cantidad,$precio,$clientetmp,$vendedor){
    $consulta = $this->db->prepare(" INSERT INTO tmp (descripcion, cantidad, precio, cliente, vendedor) VALUES (?,?,?,?,?)");
    $consulta->execute([$descripcion,$cantidad,$precio,$clientetmp,$vendedor]);
    $res = $consulta->fetchall();
    return $res;
  }
  public function deleteItems($id){
    $consulta = $this->db->prepare("DELETE FROM tmp WHERE id=?");
    $consulta->execute([$id]);
    $res = $consulta->fetchall();
    return $res;
  }

 } 

$main = new Main();

if (isset($_POST['descripcion'])) {
$main->createItems($_POST['descripcion'],$_POST['cantidad'],$_POST['precio'],$_POST['clientetmp'],$_POST['vendedor']);
echo "true";

} else if($action == 'ajax'){

	if (isset($_REQUEST['id'])){
	$main->deleteItems($_REQUEST['id']);
	echo "true";
	}
  
}



