<?php 

class Main {

  public function __construct(){
    require_once('../config/conexion.php');
    $c = new Conexion();
    $this->db = $c->getConexion();
    $this->productos = array();
  }

  public function facturaId($id){
		$consulta = $this->db->prepare("SELECT * FROM facturas JOIN clientes ON identificacion = id_cliente  WHERE facturas.id=?");
		$consulta->execute([$id]);
		$res = $consulta->fetchall();
        echo json_encode($res);
	}

   public function RegistrarIngresos($factura,$cliente,$valor){
    $consulta = $this->db->prepare(" INSERT INTO ingresos (no_factura, id_cliente, valor_ingreso, fecha_ingreso ) VALUES (?,?,?,now())");
    $consulta->execute([$factura,$cliente,$valor]);
    $res = $consulta->fetchall();
    return $res;
  }

   public function UpdateImpresion($condicion,$id){
    $consulta = $this->db->prepare("UPDATE facturas SET impresion=? WHERE id=?");
    $consulta->execute([$condicion,$id]);
    $res = $consulta->fetchall();
    return $res;
  }

}

$main = new Main();

if (isset($_GET['orden'])) {
$main->facturaId($_GET['orden']);

} elseif (isset($_POST['abono'])) {
$main->RegistrarIngresos($_POST['no_factura'],$_POST['id_cliente'],$_POST['abono']);
$main->UpdateImpresion($_POST['imprimir'],$_POST['no_factura']);
 echo "true";

} 

?>