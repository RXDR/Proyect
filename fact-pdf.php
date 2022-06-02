<html>
  <head>
 
<title>Factura CentroColor</title>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors','off');
     include('meta.php') ?>
    <link rel="stylesheet" href="estylss.scss" type="text/css">
 </head>


<body style="background-color: #FFF !important;">
  <!--startprint-->
    <div class="container"><img src="assets/img/logo.png" width="300px"><br>
    <?php 
/* Connect To Database*/
require_once ("config/conexion2.php");//Contiene funcion que conecta a la base de datos


$id_cliente=$_POST['id_cliente'];
$no_factura=$_POST['no_factura'];

   if(isset($_POST['id_cliente'])){

    $query=mysqli_query($con,"SELECT clientes.nombre, clientes.direccion,ingresos.valor_ingreso, facturas.monto
    FROM clientes INNER JOIN facturas ON facturas.id ='$no_factura' INNER JOIN ingresos ON ingresos.no_factura = '$no_factura' AND     
    clientes.identificacion='$id_cliente'");   
    $tota=0;
   while($row=mysqli_fetch_array($query)){
    $tota = $tota + $row['valor_ingreso']; // Sumar variable $total + resultado de la consulta
    $nombre=$row['nombre'];
    $direccion=$row['direccion'];
    $monto=$row['monto'];
   }       
   $fechaActual = date('d-m-Y');
   
   
?>

  <table>
    <tr>
      <td>
    <br><b>No Orden:#<?php echo $no_factura;?></b> 
     </td>
    </tr>
    <tr>
      <td>
    <b>Fecha:<?php echo $fechaActual;?></b>
    </td>
    </tr>
    <tr>
      <td>
    <b>Nombre:<?php echo $nombre;?></b>
    </td>
    </tr>
    <tr>
      <td>
    <b>Id Cliente:<?php echo $id_cliente;?></b>
    </td>
    </tr>
    <tr>
      <td>
    <b>Direccion: <?php echo $direccion;?></b>
    </td>
    </tr>
    </table>
  </div>
  <?php } ?>
  <div class="container">
 
      <table class="table" style="width:60%; font-size: smaller;">
        <thead>
        <tr> <th style="text-align:center;border:0; background:#fe787c; color:white; height:30px; padding:0px; "> 
        <h4 >Productos</h4></th>
        </tr>
        <tr class="barra"> <th>Cantidad</th> <th>Producto</th> <th>Precio Unitario</th> <th>Total</th></tr>
        </thead>
        <tbody>
        <?php
          $query=mysqli_query($con,"SELECT * from detalle where id_factura = '$no_factura'");
          while($rw=mysqli_fetch_array($query)){
            $total=$rw['cantidad']*$rw['precio'];
								$total=number_format($total,2,'.','');
            ?>
        <tr>
          <td><?php echo $rw['cantidad'];?></td> <td><?php echo $rw['descripcion'];?></td> <td><?php echo $rw['precio'];?></td> 
          <td><?php echo $total;?></td>
          </tr>
          <?php } ?>
          <tr>
          <?php
         $query=mysqli_query($con,"SELECT * FROM ingresos where no_factura = '$no_factura'");
        
         $tota=0;
        while($row=mysqli_fetch_array($query)){
          $tota = $tota + $row['valor_ingreso']; // Sumar variable $total + resultado de la consulta
							
        ?>
        <?php } ?>
            <td colspan="4" style="text-align: right; font-weight:900"><br>MONTO: $<?php echo $monto;?></td>
            <tr>
            
            <td colspan="4" style="text-align: right; font-weight:900"><br>PENDIENTE: $<?php echo $monto-$tota;?></td>
          </tr>
          </tr>
          
        </tbody>
      
          
          
      </table>
      <table class="table" style="width:40%; float:down; font-size: smaller;">
     
      <thead>
      <tr> <th style="text-align:center;border:0; background:#fe787c; color:white; height:20px;padding:0px; ">
       <h4 >Abonos</h4></th>
      </tr>
      <tr class="barra"> <th>Valor</th> <th>Fecha</th></tr>
      </thead>
      <tbody>
        <?php
         $query=mysqli_query($con,"SELECT * FROM ingresos where no_factura = '$no_factura'");
        
         $tota=0;
        while($row=mysqli_fetch_array($query)){
          $tota = $tota + $row['valor_ingreso']; // Sumar variable $total + resultado de la consulta
							
        ?>
        <tr><td><?php echo $row['valor_ingreso'];?></td> <td><?php echo $row['fecha_ingreso'];?></td></tr>
        <?php } ?>
        
        <tr><td colspan="3" style="text-align: right; font-weight:900"><br>TOTAL: $<?php echo $tota;?></td></tr>
        
      </tbody>
      
        
      </table>
      <!--endprint-->
    </div>
    <div style="margin: auto; width:10vh; margin-top:-100px;">
    <input type = "button" value = "Imprimir" onClick = "printPage ()" class="bubbly-button">
 
  
  
  </div>
 <iframe id="printf" src="" width="0" height="0" frameborder="0"></iframe>
 </body>
</html>

 <script type="text/javascript">  
function printPage() {  
 // Obtener el código html de la página actual  
 var bodyhtml = window.document.body.innerHTML;  
              // Establecer el área de inicio de impresión y el área de finalización  
 var startFlag = "<!--startprint-->";  
 var endFlag = "<!--endprint-->";  
              // parte para imprimir  
 var printhtml = bodyhtml.substring(bodyhtml.indexOf(startFlag),   
         bodyhtml.indexOf(endFlag));  
              // genera e imprime ifrme  
 var f = document.getElementById('printf'); 
 f.contentDocument.write(printhtml);
 f.contentDocument.close();
 f.contentWindow.print();
}  
</script>

