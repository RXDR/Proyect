<?php 

class Main {

  public function __construct(){
    require_once('../config/conexion.php');
    $c = new Conexion();
    $this->db = $c->getConexion();
    $this->productos = array();
  }

  public function UpdateImpreso($observaciones,$impreso,$id){
    $consulta = $this->db->prepare("UPDATE facturas SET descripcion=?, impreso=? WHERE id=?");
    $consulta->execute([$observaciones,$impreso,$id]);
    $res = $consulta->fetchall();
    return $res;
  }
  public function AnularFactura($anular,$id){
    $consulta = $this->db->prepare("UPDATE facturas SET estado=? WHERE id=?");
    $consulta->execute([$anular,$id]);
    $res = $consulta->fetchall();
    return $res;
  }

}

$main = new Main();

if (isset($_POST['update_impresion'])) {
$main->UpdateImpreso($_POST['observaciones'],$_POST['impreso'],$_POST['no_factura']);
 echo "true";

} 
if (isset($_POST['anular'])) {
  $main->AnularFactura($_POST['anular'],$_POST['no_factura']);
   echo "true";
  
  }