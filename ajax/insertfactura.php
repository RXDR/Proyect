<?php
require_once ("../config/conexion2.php");

if(isset($_POST['idcliente'])){
    //datos id
    $idcliente = $_POST['idcliente'];
    $idvendedor = $_POST['id_vendedor'];
    //datos factura
    $fechae = $_POST['fechae'];
    $des = $_POST['desfactura'];

    $query_perfil=mysqli_query($con,"select * from perfil where id=1");
    $rw=mysqli_fetch_assoc($query_perfil);
    $tax= $rw['tax'];//% de iva o impuestos
    
    $sql=mysqli_query($con, "select LAST_INSERT_ID(id) as last from facturas order by id desc limit 0,1 ");
    $rws=mysqli_fetch_array($sql);
    $numero=$rws['last']+1;
      
    $query=mysqli_query($con,"select * from tmp where cliente='$idcliente'");
    $items=1;
    $suma=0;
    while($row=mysqli_fetch_array($query)){
    $total=$row['cantidad']*$row['precio'];
    $total=number_format($total,2,'.','');
    
    if ($items%2==1){
        $clase_tr="inpar";
    } else{
        $clase_tr='';
    }

    $items++;
    $suma+=$total;
    $detalle=mysqli_query($con,"INSERT INTO `detalle` (`id`, `descripcion`, `cantidad`, `precio`, `id_factura`,`id_cliente`) 
    VALUES (NULL, '".$row['descripcion']."', '".$row['cantidad']."', '".$row['precio']."', '$numero', '".$_POST['idcliente']."');");
    }
    $iva=$suma * ($tax / 100);
    $total_iva=number_format($iva,2,'.','');    
    $total=$suma + $total_iva;
    $sql="INSERT INTO `facturas` (`fecha_entrega`, `id_cliente`, `descripcion`, `iva`,  `monto`, `saldo`, `id_vendedor`) VALUES ('$fechae', '$idcliente', '$des','$total_iva', '$total', '$total', '$idvendedor');";
    $save=mysqli_query($con,$sql);

    $delete="DELETE FROM tmp WHERE cliente=$idcliente";
    if (mysqli_query($con, $delete)) {
        echo "true";
    }
}
?> 

