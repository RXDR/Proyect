<?php

include("../config/conexion2.php");
$salida="";


$query="SELECT no_factura, valor_ingreso, fecha_ingreso FROM `ingresos` INNER JOIN facturas on facturas.id_cliente='ingresos.id_cliente' AND facturas.id=ingresos.no_factura";
 
if(isset($_POST['consulta'])){
    $q=$_POST['consulta'];
    
    $query="SELECT detalle.cantidad, detalle.descripcion, facturas.impresion, facturas.descripcion as obs  FROM `detalle` INNER JOIN facturas ON  detalle.id_factura='$q' and facturas.id='$q'";
}
   $resultado = $con->query($query);
    
    if($resultado->num_rows > 0){
    
        $salida.="<table>
       
        <tbody>
        ";
        while($fila = $resultado->fetch_assoc()){
          $impresion="No habilitado";
          $b=1;
          $impre=$fila['impresion'];
          if($impre == $b){
            $impresion="habilitado";
          }
            $salida.="<tr>
            <td class='text-text'>".$fila['cantidad']."</td>
            <td class='text-text'>".$fila['descripcion']."</td>
            <td class='text-text'>".$impresion."</td>
        </tr> </tbody>";
            
        }
    }else{
        $salida.="Abono pendiente";
    }
    echo $salida;
    

?>