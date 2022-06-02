<?php
class Main {

  public function __construct(){
    require_once('../config/conexion.php');
    $c = new Conexion();
    $this->db = $c->getConexion();
    $this->productos = array();
  }
  public function getCliente($fecha_reporte){
    $consulta = $this->db->prepare("SELECT SUM(valor_ingreso) FROM ingresos WHERE fecha_ingreso=?");
    $consulta->execute([$fecha_reporte]);
    $res = $consulta->fetchall();
    echo json_encode($res);
  }

  public function Validarfecha($fecha_reporte){
    $consulta = $this->db->prepare("SELECT * FROM ingresos WHERE fecha_ingreso=?");
    $consulta->execute([$fecha_reporte]);
    $res = $consulta->fetchall();
    echo json_encode($res);
  } 
  

}
$main = new Main();
if (isset($_POST['fecha_reporte'])) {
  $res=$main->getCliente($_POST['fecha_reporte']);
    if(count($res)>0){
       $main->Validarfecha($_POST['fecha_reporte']);
      } else {
        echo json_encode(0);
      }
    }

?>