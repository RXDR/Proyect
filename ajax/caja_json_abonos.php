<?php
error_reporting(E_ALL);
ini_set('display_errors','off');
include("../config/conexion2.php");
$salida="";



 
if(isset($_POST['consulta'])){
  
 
    $q=$con->real_escape_string($_POST['consulta']);
    if(!isset($anular)){
        $anular =  $_POST['anular'];
        $query="UPDATE facturas SET estado='$anular' where id='$q'";
        $resultado = $con->query($query);
      }
    $sql="SELECT SUM(valor_ingreso) AS total  FROM `ingresos` WHERE no_factura='$q' ";
    $query2="SELECT monto  FROM `facturas` WHERE id='$q' ";
    
    $query="SELECT no_factura, valor_ingreso, tipo, fecha_ingreso FROM `ingresos` where no_factura='$q'";
   
}
$resultado1 = $con->query($sql);
$resultado2 = $con->query($query2);
   $resultado = $con->query($query);
   while($monto = $resultado2->fetch_assoc()){
$monto_total=$monto['monto']; 
   }
    
    if($resultado->num_rows > 0){
        
        while($fila = $resultado->fetch_assoc()){
            $salida.="<table>
            <tbody>
            <tr>
            <td class='text-text'>".$fila['no_factura']."</td>
            <td class='text-text'>".$fila['fecha_ingreso']."</td>
            <td class='text-text'>".$fila['valor_ingreso']."</td>
            <td class='text-text'>".$fila['tipo']."</td>
            
            
        </tr> 
        
        ";
            
        }

        
        while($total = $resultado1->fetch_assoc()){
            if($total['total'] == $monto_total){
                
                $query="UPDATE facturas SET estado= 1 where id='$q'";
                $resultado = $con->query($query);
                $salida.="
            
                <tr>
                <th></th>
                <th></th>
                <th>Total:</th><th class='text-text total' style='color:green' id='total'>"."$".$total['total']."</th>
                </tr>
                <tr>
                <th></th>
                <th></th>
                <th></th>
                <th style='color:green'>SALDO PAGO</th>
                </tr>
                </tbody>
                ";
                
            }else{
                $mora= $monto_total - $total['total'];

            $salida.="
            
            <tr>
                <th></th>
                <th></th>
                <th>Total:</th><th class='text-text total'  id='total'>"."$".$total['total']."</th>
                </tr>
                <tr>
            <tr>
            <th></th>
            <th></th>
            <th></th>
            <th style='color:red'>"."$".$mora." SALDO EN MORA</th>
            </tr>
            
            </tbody>
            ";
            }
        }

    }else{
        $salida.="Abono pendiente";
    }
    echo $salida;
    

?>