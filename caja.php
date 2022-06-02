<?php
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
	<title>Caja | <?php echo $rw['nombre_comercial'];?></title>
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
                    <strong>E-mail : </strong> <?php echo $rw['email'];?>
                    <br />
                    <strong>Teléfono :</strong> <?php echo $rw['telefono'];?> <br />
					<strong>Sitio web :</strong> <?php echo $rw['web'];?> 
                   
                </div>
              
        	</div>

        	
        	
        	<hr/>
        	<h2>Caja</h2>

        	<div class="row pad-bottom  pull-right">
	            <div class="col-lg-12 col-md-12 col-sm-12">
	                <button type="submit" class="btn btn-success guardar" id="refres" onclick="location.reload();">Refres</button>
	            </div>
	        </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped  table-hover"  id='detalle'>
                            <thead>
                                <tr>
									<th>Orden</th>
									<th class='text-left'>Id Cliente</th>
                                    <th class='text-left'>Nombre</th>
                                    <th class='text-right'>Monto</th>
									<th class='text-right'>Vendedor</th>
									<th class='text-right'></th>
									
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
							$query=mysqli_query($con,"SELECT DISTINCT usuarios.nombre as nom ,facturas.id, facturas.id_cliente, facturas.monto, clientes.nombre, clientes.identificacion FROM facturas INNER JOIN clientes ON facturas.id_cliente = clientes.identificacion INNER JOIN usuarios ON facturas.id_vendedor =  usuarios.identificacion AND facturas.estado=0 ORDER BY facturas.id DESC ");
							while($row=mysqli_fetch_array($query)){

                            ?>
                            <tr>
								<td><?php echo $row['id'];?></td>
								<td class='text-left'><?php echo $row['id_cliente'];?></td>
								<td class='text-left'><?php echo $row['nombre'];?></td>
								<td class='text-right'><?php echo number_format($row['monto'],0);?></td>
								<td class='text-right'><?php echo $row['nom'];?></td>
								<td class='text-right'><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal"  onclick="DateFactura(<?php echo $row['id'];?>), refresca();"> <span class="glyphicon glyphicon-send"></span></button> 
								</td>
							</tr>
							<?php } ?>
                            </tbody>
                        </table>
						<div class="col-md-12 text-center">
						<ul class="pagination pagination-lg pager" id="developer_page"></ul>
						</div>
                    </div>
					
                </div>
            </div>
			
        </div>
	       	<div class="row"> <hr /></div>

	

</div>
 
      
<form  target="print_popup" 
      action="fact-pdf.php" class="form-horizontal" name="form_pago" id="form_pago" target="_blank" 
      method="post">
		<!-- Modal -->
		<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close" ><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Caja De Cobro</h4>
			
              		
			  </div>
			  <div class="modal-body">
			  <div style="float: right;">
						<label>Anular factura</label>
					  	<select name="anular"  class="form-control">
                          <option value="0">Seleccione</option>
                          <option value="3">Si</option>
                          <option value="0">No</option>
              			</select> <br/>
						  <input type="button" value="Anular" id="anu" class="btn btn-danger"/><br/>
              		</div>
						
			
				  <div class="row">
					<div class="col-md-12">
						<label>Cliente:</label><P 
						id="nomCliente"> </P>
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
					<div class="col-md-6">
						<label>Abono:</label>
					  	<input type="number" style="display:none" class="form-control" min="1" id="abono" name="abono" required="">
					</div>
					<div class="col-md-6">
						<label>Tipo de Pago:</label>
						<select  id="tipo" name="pago" class="form-control" required="" style="display:none" required="">
	                      <option value="">Seleccione</option>
						  <option value="Efectivo">EFECTIVO</option>
						  <option value="Nequi">NEQUI</option>
	                      <option value="Datafono">DATAFONO</option> 
						  <option value="Transferencia">TRANSFERENCIA</option>
						  <option value="No hubo pago">NO HUBO PAGO</option>
						  
	                       
	          			</select> 
					</div>
				  </div>
			  </div>

			  <div class="modal-body">
			  	<div class="row">

			  		<div class="col-md-12">
			  			<input type="button"  class="btn btn-info" id="boton" value="Mostrar abonos" ></button>
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

					<div class="col-md-6">
						<label>Habilitar Impresion</label>
					  	<select name="imprimir"  class="form-control" required="">
                          <option value="">Seleccione</option>
                          <option value="1">Si</option>
                          <option value="2">No</option>
              			</select> 
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
	
<?php  include('footer.php'); ?>

</body>




<script>
$(document).ready(function() {

	$("#cerrar").click(function() {
 		$('#form_pago')[0].reset();
	});
	$("#close").click(function() {
 		$('#form_pago')[0].reset();
	});
		
	$(document).ready( function () {
	    $('#detalle').DataTable();
	} );

//Actualizar Usuarios
$("#guardar_ingreso").click(function() {
	if(Reqingreso()){
	    $.ajax({ 
	        type:"POST",
	        url: "ajax/caja_json.php",
	        data: $('#form_pago').serialize(),
		    success: function(respuesta){  
		        console.log(respuesta);
		        if(respuesta=="true"){ 
		            Swal.fire({
		              icon: 'success',
		              text: 'Pago Efectuado!',
		            })
		            $('#detalle').load('caja.php #detalle');
		        } else {
		        	Swal.fire({
	                  icon: 'error',
	                  text: 'No se pudo registrar, verifica tu coneccion',
	                })
		        }
		        
		    }

		})
		return false 
		}         
	})

});


$("#anu").click(function() {
	    $.ajax({ 
	        type:"POST",
	        url: "ajax/anular.php",
	        data: $('#form_pago').serialize(),
		    success: function(respuesta){  
		        console.log(respuesta);
		        if(respuesta=="true"){ 
		            Swal.fire({
		              icon: 'success',
		              text: 'Factura anulada!',
		            })
		            $('#detalle').load('caja.php #detalle');
		        } else {
		        	Swal.fire({
	                  icon: 'error',
	                  text: 'Factura no anulada',
	                })
		        }
		        
		    }

		})
		return false 
		        
	})





function DateFactura(argument) {

    $.ajax({
        type:'GET',
        url:'ajax/caja_json.php',
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
   var campos = $('input[type="number"][name="abono"]:required,select[name="pago"]:required, .required');
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
	$("#tipo").show();
});
$('#cerrar').click(function () {
	$('#nueva').load('caja.php #nueva');
});
</script>




  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

</html>
