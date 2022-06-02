include("./config/conexion.php");

if(isset($_POST[id_cliente])){
    $id_cliente = $_POST[id_cliente];
    $query=mysqli_query($con,SELECT clientes.nombre, clientes.direccion,detalle.cantidad,detalle.descripcion,detalle.precio,ingresos.valor_ingreso,ingresos.fecha_ingreso,facturas.monto FROM clientes INNER JOIN facturas ON clientes.identificacion = facturas.id_cliente INNER JOIN detalle ON detalle.id_factura = facturas.id INNER JOIN ingresos ON ingresos.no_factura = facturas.id'");
							while($row=mysqli_fetch_array($query))
}