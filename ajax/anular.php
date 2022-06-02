<?php 

class Main {

  public function __construct(){
    require_once('../config/conexion.php');
    $c = new Conexion();
    $this->db = $c->getConexion();
    $this->productos = array();
  }


  public function AnularFactura($id){
    $consulta = $this->db->prepare("UPDATE facturas SET estado=3 WHERE id=?");
    $consulta->execute([$id]);
    $res = $consulta->fetchall();
    return $res;
  }

}

$main = new Main();



if (isset($_POST['anular'])) {
  $main->AnularFactura($_POST['no_factura']);
   echo "true";
  
  }