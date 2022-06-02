<?php

include("../config/conexion2.php");
$salida="";



 
if(isset($_POST['consulta'])){
    $q=$con->real_escape_string($_POST['consulta']);
    $query="SELECT SUM(valor_ingreso), facturas.monto FROM `ingresos` INNER JOIN facturas ON  ingresos.no_factura='$q' AND facturas.id='$q'";
   
    
}
   $resultado = $con->query($query);
    
    if($resultado->num_rows > 0){
        $salida.="<table>
       
        <tbody>
        ";
        while($fila = $resultado->fetch_assoc()){
            $salida.="<tr>
            <td class='text-text'>".$fila['no_factura']."</td>
            <td class='text-text'>".$fila['fecha_ingreso']."</td>
            <td class='text-text'>".$fila['valor_ingreso']."</td>
            
            
        </tr> </tbody>";
            
        }
    }else{
        $salida.="Abono pendiente";
    }
    echo $salida;
    

?>