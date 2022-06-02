<?php
/* Modo debug */ 
error_reporting(E_ALL);
ini_set('display_errors','off');
	/* Connect To Database*/
	require_once ("config/conexion2.php");//Contiene funcion que conecta a la base de datos
	require_once("session/perfil.php");
    $perfil=$_SESSION['perfil'];
	
	switch($perfil) {

		case 2:

	  header('Location: pedidos.php');
		
		break;
		
		case 3;
			
			header('Location: impresiones.php');
		
		break;
		
		
		
		}
	$query_perfil=mysqli_query($con,"select * from perfil where id=1");
	$rw=mysqli_fetch_assoc($query_perfil);
	$tax= $rw['tax'];//% de iva o impuestos
?>
<html>
<head>
	<title>Reportes | <?php echo $rw['nombre_comercial'];?></title>
    <?php  include('meta.php'); ?>
</head>

<body>
	<?php  include('nav.php'); ?>

<div class="container outer-section" >
        <div id="print-area">

            <div class="row pad-top font-big">
                <div class="col-lg-4 col-md-4 col-sm-4">
                  <a href="#"> <img src="assets/img/logo.png" alt="Logo" /></a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <strong><?php echo $rw['nombre_comercial'];?></strong>
                    <br />
                    Dirección : <?php echo $rw['direccion'];?> 
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <strong>Usuarios : </strong> <?php echo $rw['email'];?>
                    <br />
                    <strong>Teléfono :</strong> <?php echo $rw['telefono'];?> <br />
					<strong>Sitio web :</strong> <?php echo $rw['web'];?> 
                   
                </div>
              
        	</div>
        	<hr />
            <table style="width: 80%;">
            <form>
                <tr>
                    <td>
                <h1>Búsqueda por Fecha</h1></td>
                </tr>
                <tr><td>Fecha comienzo: <br/> <br/>
                    <input type="date"  class="form-control" id="start_date" name="start_date"><br/> </td></tr>
                    <tr><td> Fecha final:<br/> <br/>
                    <input type="date"   class="form-control" id="end_date" name="end_date" ><br/> <br/></td></tr>
                   
                    <tr><td>
                    <input type="hidden" id="form_sent" name="form_sent" value="true">
                    <input type="submit" id="btn_submit" class="btn btn-success" value="Enviar"><br/>
                    </tr></td>   
            </form>
            <?php 

                
    $SDATE = $_GET['start_date'];
    $SSDATE = explode('/', $SDATE);
    $START_DATE = $SSDATE[0].$SSDATE[2].$SSDATE[1];
    $START_DATE1 = $SSDATE[0].$SSDATE[2].$SSDATE[1];
    
    
    $EDATE = $_GET['end_date'];
    $EEDATE = explode('/', $EDATE);
    $END_DATE = $EEDATE[0].$EEDATE[2].$EEDATE[1];
    $END_DATE1 = $EEDATE[0].$EEDATE[2].$EEDATE[1];
    


	              
	$consulta=mysqli_query($con,"SELECT SUM(monto)as ventas from `facturas` where fecha  BETWEEN '$START_DATE' AND '$END_DATE' AND estado != 3 ");
	$sql=mysqli_query($con,"SELECT SUM(valor_ingreso) as valor from ingresos WHERE fecha_ingreso BETWEEN '$START_DATE' AND '$END_DATE'");
	$sqli=mysqli_query($con,"SELECT SUM(valor) as valor from egresos WHERE fecha_egreso BETWEEN '$START_DATE' AND '$END_DATE'");                      
    $vent=mysqli_fetch_assoc($consulta);
	$ventas=$vent['ventas']; 
	$to=mysqli_fetch_assoc($sql);
   $total=$to['valor'];
    $tot=mysqli_fetch_assoc($sqli);
   $total1=$tot['valor'];

   $numeroFormateado = number_format($ventas, 0);
   $numeroFormateado1 = number_format($total, 0);
   $numeroFormateado2 = number_format($total1, 0);
   $deuda = number_format($ventas - $total);                       
  ?>
				<tr>
				<td><h2>Total: $<?php echo $numeroFormateado; ?></h2>
				<td style="text-align: right; float:right">
               <h2>Cartera:$<?php echo $deuda ?></h2></td>
			</td>
				</tr>
                <tr>
                <td><h2> Abonos:$<?php echo$numeroFormateado1 ?> </h2></td>
                <td style="text-align: right; float:right">
               <h2>Gastos:$-<?php echo $numeroFormateado2 ?></h2></td>
			    
                </tr>   
				
                
            </table>
           
            <hr />
            
            <br>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped  table-hover"  id='detalle'>
                            <thead>
                                <tr>
									<th>Orden</th>
									<th>Id Cliente</th>
                                    <th></th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
							$query=mysqli_query($con,"SELECT facturas.id, facturas.id_cliente, facturas.monto, clientes.nombre, clientes.identificacion FROM facturas INNER JOIN clientes ON facturas.id_cliente = clientes.identificacion AND estado!=3 ORDER BY facturas.id DESC ");
							while($row=mysqli_fetch_array($query)){

                            ?>
                            <tr>
								<td><?php echo $row['id'];?></td>
								<td class='text-left'><?php echo $row['id_cliente'];?></td>
								<td class='text-right'><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal"  onclick="DateFactura(<?php echo $row['id'];?>), refresca();"> <span class="glyphicon glyphicon-eye-open"></span></button> 
								</td>
							</tr>
							<?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row"><hr />
        
            <form  target="print_popup" 
      action="fact-pdf.php" class="form-horizontal" name="form_pago" id="form_pago" target="_blank" action="fact-pdf.php"
      method="post">
		<!-- Modal -->
		<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close" ><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Factura Cliente</h4>
			  </div>
			  <div class="modal-body">
				  <div class="row">
					<div class="col-md-12">
						<label>Cliente:</label><P id="nomCliente"> </P>
					</div>
				  </div>

				  <div class="row">
				  	<div class="col-md-6">
						<label>Factura No:</label>
						<input type="text" class="form-control" id="no_factura" name="no_factura" readonly="">
					</div>

					<div class="col-md-6">
						<label>ID Cliente:</label>
						<input type="text" class="form-control" id="id_cliente" name="id_cliente" readonly="">
					</div>
						
					<div class="col-md-6">
						<label>Valor Factura:</label>
					  	<input type="text" class="form-control Can_Produc"  id="monto" name="monto" readonly="">
						  
					</div>
					
				  </div>
			  </div>

			  <div class="modal-body">
			  	<div class="row">
			  		<div class="col-md-12">
			  			<input type="button"  class="btn btn-info" id="boton" value="Mostrar detalle" ></button>
						
						

			  		</div>

					<div class="col-md-12">
						<table class="table table-striped  table-hover">
                            <thead>
                                <tr>
                                    <th class='text-left'>No Factura</th>
									<th class='text-left'>Fecha</th>
									<th class='text-left'>Valor</th>
									<th class='text-left'>Tip.pago</th>
									
                                </tr>
                            </thead>
                             <tbody id="datos">
	                           
                            </tbody>
                        </table>

					</div>
					
				 </div>

				 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
			  </div>

			  <div class="modal-footer">
				<button type="button" class="btn btn-default" id="cerrar" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-info" id="guardar_ingreso" >Guardar</button>
				<button type="submit" class="btn btn-info" id="imprimir" >Imprimir</button>
				<input type="hidden" name="action" id="action" value="ajax">
			  </div>

			</div>
		  </div>
		</div>
	</form>




      </div>
      
</div>
<?php  include('footer.php'); ?>

		
 
</body>

<script>
  
$(document).ready( function () {
    $('#detalle').DataTable();
$("#fecha_reporte").change(function() {
	var fecha = $('#fecha_reporte').val();    
    $.ajax({ 
	        type:"POST",
	        url: "ajax/reporte-json.php",
	        data: {'fecha':fecha},
		    success: function(respuesta){  
		        console.log(respuesta);
		        if(respuesta==0){ 
                    
                            Swal.fire({
	                  icon: 'error',
	                  text: 'No se encontro registro',
	                })
                   
                 }else {
                    var c =$.parseJSON(respuesta);
                        	$('#total').val(c[0][1]);
                    
                         
		        }
		        
		    }

		})
			        
	})

})



function DateFactura(argument) {

$.ajax({
    type:'GET',
    url:'ajax/reporte_factura.php',
    data:{'orden':argument},
    success: function(respuesta){
        console.log(respuesta);
        var c =$.parseJSON(respuesta);
        $('#no_factura').val(c[0][0]);
        $('#id_cliente').val(c[0][3]);
        $('#monto').val(parseInt(c[0][6]));
        $('#nomCliente').html(c[0][12]);
            
    }
});

return false;

}
$(document).on('click','#boton',function(){
    var valor= $("#no_factura").val();
    if(valor != ""){
        buscar_datos(valor);
    }else{
        buscar_datos();
    }
    
});


$(buscar_datos());

function buscar_datos(consulta,no_factura){
    $.ajax({
        url: 'ajax/caja_json_abonos.php',
        type: 'POST',
        dataType:'html',
        data:{consulta:consulta,no_factura},  
    })
    .done(function(respuesta){
        $("#datos").html(respuesta);
    })
    .fail(function(){
        console.log("error");
    })
}


function refres() {
	$('#detalle').load('caja.php #detalle');
    return false;
}

function refresca() {
	$('#datos').load('caja.php #datos');
    return false;
}


// Validación de campos vacíos
function Reqingreso(){
   var state = true;
   var campos = $('input[type="number"][name="abono"]:required, .required');
   $(campos).each(function() {
      if($(this).val()==''){
         state = false;
         $(this).addClass('errorFld');
      }
   });
   return state;
}



</script>

<script>
$('.Can_Produc').keyup(function() {

var limite = parseInt($("#monto").val());
var nuevo_valor =  $(this).val();
var importe_total = 0;

$(".Can_Produc").each(
	function(index, value) {
		if ( $.isNumeric($(this).val()) ){
		  importe_total += parseInt($(this).val());
	   }
	}
  );
  
  $("#saldo").val(limite - importe_total);
});


$("#imprimir").click(function(event){
      
$('#form_pago').submit(); 
	  
      return false;
    });
	$("#print").click(function(event){
      
	  $('#form_pago').submit(); 
			
			return false;
		  });

$('#abono').keyup(function () {
 var abono=$('#abono').val();
 var monto=$('#monto').val();
 var total=parseInt(monto);
 var abo=parseInt(abono);

 if(abo > total){
	
	Swal.fire({
	icon: 'error',
	 text: 'El abono no puede ser mayor al saldo',
	 })
	$("#abono").val(100);
	
 }
 if(abo <= -1){
	
	Swal.fire({
	icon: 'error',
	 text: 'El abono no puede ser negativo',
	 })
	$("#abono").val(100);
	
 }
 if(abo <= 0){
	
	Swal.fire({
	icon: 'error',
	 text: 'El abono no puede ser negativo',
	 })
	$("#abono").val(100);
	
 }


});
$('#abono').change(function () {
	var abono=$('#abono').val();
 var monto=$('#monto').val();
 var total=parseInt(monto);
 var abo=parseInt(abono);

 if(abo > total){
	
	Swal.fire({
	icon: 'error',
	 text: 'El abono no puede ser mayor al saldo',
	 })
	$("#abono").val("");
	
 }
 if(abo <= -1){
	
	Swal.fire({
	icon: 'error',
	 text: 'El abono no puede ser negativo',
	 })
	$("#abono").val(0);
	
 }
});
$('#boton').click(function () {
	$("#abono").show();
});
$('#cerrar').click(function () {
	$('#nueva').load('caja.php #nueva');
});

</script>


<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

</html>
