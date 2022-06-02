<?php 

class Main {

  public function __construct(){
    require_once('../config/conexion.php');
    $c = new Conexion();
    $this->db = $c->getConexion();
    $this->productos = array();
  }

  public function RegistrarEgresos($valor,$concepto){
    $consulta = $this->db->prepare(" INSERT INTO egresos (valor, concepto, fecha_egreso) VALUES (?,?,now())");
    $consulta->execute([$valor,$concepto]);
    $res = $consulta->fetchall();
    return $res;
  }

}

$main = new Main();

if (isset($_POST['egreso'])) {
$main->RegistrarEgresos($_POST['valor'],$_POST['concepto']);
 echo "true";
} 