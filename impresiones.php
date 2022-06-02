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
	}
	$query_perfil=mysqli_query($con,"select * from perfil where id=1");
	$rw=mysqli_fetch_assoc($query_perfil);
	$tax= $rw['tax'];//% de iva o impuestos
?>
<html>
<head>
	<title>Impresiones | <?php echo $rw['nombre_comercial'];?></title>
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
            
            <br>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped  table-hover"  id='nueva'>
                            <thead>
                                <tr>
									<th>Orden</th>
									<th>Id Cliente</th>
                                    <th>Nombre</th>
                                    <th>Observaciones</th>
                                    <th>Impreso</th>
									<th>Vendedor</th>
									<th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
							$query=mysqli_query($con,"SELECT usuarios.nombre AS nom, facturas.id, facturas.id_cliente, facturas.descripcion, facturas.impreso, clientes.nombre FROM facturas INNER JOIN clientes ON clientes.identificacion = facturas.id_cliente INNER JOIN usuarios ON facturas.id_vendedor=usuarios.identificacion WHERE facturas.impresion = 1 ORDER BY facturas.id DESC ");
							while($row=mysqli_fetch_array($query)){

                            ?>
                            <tr>
								<td><?php echo $row['id'];?></td>
								<td class='text-left'><?php echo $row['id_cliente'];?></td>
								<td class='text-left'><?php echo $row['nombre'];?></td>
								<td class='text-left'><?php echo $row['descripcion'];?></td>
                                <td class='text-left'><?php echo $row['impreso'];?></td>
								<td class='text-left'><?php echo $row['nom'];?></td>
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
        </div>
      </div>
      
</div>


      
	<form class="form-horizontal" name="form_impresion" id="form_impresion" method="post">
		<!-- Modal -->
		<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close" ><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Detalles Impresion</h4>
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
				  </div>
			  </div>

			  <div class="modal-body">
			  	<div class="row">
			  		<div class="col-md-12">
			  			<input type="button"  class="btn btn-info" id="boton" value="Ver pedido" ></button>
			  		</div>

					<div class="col-md-12">
						<table class="table table-striped  table-hover">
                            <thead>
                                <tr>
									<th class='text-left'>Cantidad</th>
									<th class='text-left'>Productos</th>
                                    <th class='text-left'>Imprimir</th>
                                </tr>
                            </thead>
                             <tbody id="datos">
	                           
                            </tbody>
                        </table>

                    <div class="col-md-12">
						<label>Observaciones</label>
						<textarea class="form-control" id="observaciones" name="observaciones" required=""></textarea>
					</div>

					<div class="col-md-6">
						<label>Impreso</label>
					  	<select name="impreso"  class="form-control" required="">
	                      <option value="">Seleccione</option>
	                      <option value="Si">Si</option>
	                      <option value="No">No</option>
	                      <option value="Parcial">Parcial</option>
	          			</select> 
				</div>

					</div>
					
				 </div>

				 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
			  </div>

			  <div class="modal-footer">
				<button type="button" class="btn btn-default" id="cerrar" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-info" id="impresion_obs" >Guardar</button>
				<input type="hidden" name="update_impresion" >
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
	    $('#nueva').DataTable();
	} );

//Actualizar Usuarios
$("#impresion_obs").click(function() {
	if(ReqUp()){
	    $.ajax({ 
	        type:"POST",
	        url: "ajax/impresion_obs.php",
	        data: $('#form_impresion').serialize(),
		    success: function(respuesta){  
		        console.log(respuesta);
		        if(respuesta=="true"){ 
		            Swal.fire({
		              icon: 'success',
		              text: 'Guardado Con Exito!',
		            })
		            $('#detalle').load('impresiones.php #detalle');
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
			$('#observaciones').val(c[0][4]);
			$('#monto').val(c[0][6]);
			$('#nomCliente').html(c[0][13]);
                
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
        url: 'ajax/impresion_json.php',
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
	$('#detalle').load('impresiones.php #detalle');
    return false;
}

function refresca() {
	$('#datos').load('impresiones.php #datos');
    return false;
}


// Validación de campos vacíos
function ReqUp(){
   var state = true;
   var campos = $('textarea:required, select:required, .required');
   $(campos).each(function() {
      if($(this).val()==''){
         state = false;
         $(this).addClass('errorFld');
      }
   });
   return state;
}

$('#cerrar').click(function () {
	location.reload();
});

</script>



<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

</html>
