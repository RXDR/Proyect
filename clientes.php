<?php
	/* Connect To Database*/
	require_once ("config/conexion2.php");//Contiene funcion que conecta a la base de datos
	require_once("session/perfil.php");
	$query_perfil=mysqli_query($con,"select * from perfil where id=1");
	$rw=mysqli_fetch_assoc($query_perfil);
	$tax= $rw['tax'];//% de iva o impuestos
?>
<html>
<head>
	<title>Clientes | <?php echo $rw['nombre_comercial'];?></title>
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
                    <strong>E-mail : </strong> <?php echo $rw['email'];?>
                    <br />
                    <strong>Teléfono :</strong> <?php echo $rw['telefono'];?> <br />
					<strong>Sitio web :</strong> <?php echo $rw['web'];?> 
                   
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <strong><?php echo $rw['nombre_comercial'];?></strong>
                    <br />
                    Dirección : <?php echo $rw['direccion'];?> 
                </div>
        	</div>

        	
        	
        	<hr/>
        	<h2>Clientes:</h2>

        	<div class="row pad-bottom  pull-right">
	            <div class="col-lg-12 col-md-12 col-sm-12">
	                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Crear Cliente</button>
	            </div>
	        </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped  table-hover"  id='detalle'>
                            <thead>
                                <tr>
									<th>Identificacion</th>
									<th class='text-left'>Nombre</th>
                                    <th class='text-left'>Direccion</th>
                                    <th class='text-left'>Telefono</th>
									<th class='text-left'>Email</th>
									<th class='text-right'></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
							$query=mysqli_query($con,"SELECT * FROM clientes ORDER BY id DESC");
							while($row=mysqli_fetch_array($query)){

                            ?>
                            <tr>
								<td><?php echo $row['identificacion'];?></td>
								<td class='text-left'><?php echo $row['nombre'];?></td>
								<td class='text-left'><?php echo $row['direccion'];?></td>
								<td class='text-left'><?php echo $row['telefono'];?></td>
								<td class='text-left'><?php echo $row['email'];?></td>
								<td class='text-right'><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal2" onclick="DateCliente(<?php echo $row['id'];?>)" > <span class="glyphicon glyphicon-pencil"></span></button> 
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

	<form class="form-horizontal" name="form_cliente" id="form_cliente" method="post">
		<!-- Modal -->
		<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Agregar cliente</h4>
			  </div>
			  <div class="modal-body">
				  <div class="row">
					<div class="col-md-6">
						<label>Identificacion</label>
						<input type="number" class="form-control" id="c_identificacion" name="c_identificacion" required="">
						<div id="id_res"> </div>
					</div>
					<div class="col-md-6">
						<label>nombre</label>
						<input type="text" class="form-control" id="c_nombre" name="c_nombre" required="">
					</div>
				  </div>

				  <div class="row">
				  	<div class="col-md-6">
						<label>Telefono</label>
					  	<input type="number" class="form-control" id="c_telefono" name="c_telefono" required="">
					</div>
					<div class="col-md-6">
						<label>Email</label>
						<input type="email" class="form-control" id="c_email" name="c_email" required="">
					</div>
				  </div>

				  <div class="row">
					<div class="col-md-12">
						<label>Direccion</label>
						<input type="text" class="form-control" id="c_direccion" name="c_direccion" required="">
					</div>
				  </div>
			  </div>

			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-info" id="agregar_cliente" >Guardar</button>
				<input type="hidden" name="guardar" id="guardar">
			  </div>

			</div>
		  </div>
		</div>
	</form>


	<form class="form-horizontal" name="form_Upcliente" id="form_Upcliente" method="post">
		<!-- Modal -->
		<div class="modal fade bs-example-modal-lg" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Actualizar cliente</h4>
			  </div>
			  <div class="modal-body">
				  <div class="row">
					<div class="col-md-6">
						<label>Identificacion</label>
						<input type="number" class="form-control" id="up_identificacion" name="up_identificacion" required="">
						<div id="id_res"> </div>
					</div>
					<div class="col-md-6">
						<label>nombre</label>
						<input type="text" class="form-control" id="up_nombre" name="up_nombre" required="">
					</div>
				  </div>

				  <div class="row">
				  	<div class="col-md-6">
						<label>Telefono</label>
					  	<input type="number" class="form-control" id="up_telefono" name="up_telefono" required="">
					</div>
					<div class="col-md-6">
						<label>Email</label>
						<input type="email" class="form-control" id="up_email" name="up_email" required="">
					</div>
				  </div>

				  <div class="row">
					<div class="col-md-12">
						<label>Direccion</label>
						<input type="text" class="form-control" id="up_direccion" name="up_direccion" required="">
					</div>
				  </div>
			  </div>

			  <input type="hidden" name="id" id="id" >

			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-info" id="Update_cliente" >Actualizar</button>
				<input type="hidden" name="update" id="update">
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

	 //consultar si ya existe un cliente
	$("#c_identificacion").on("keyup", function() {
	var id = $("#c_identificacion").val(); 
	  $.ajax({
	      url: 'ajax/cliente_json.php',
	      type: "GET",
	      data:{'identificacion':id},
	      dataType: "JSON",
	      success: function(respuesta){
	      	console.log(respuesta);
	        if(respuesta == 1){
	        $("#id_res").html('<p style="color:red;">Ya existe la ID '+ id);
	        $("#agregar_cliente").attr('disabled',true); //Desabilito el Botton
	        }else{
	        $("#id_res").html('');
	        $("#agregar_cliente").attr('disabled',false); //Habilito el Botton
	        }
	      }
	  });
	          
	});

	//Guardar cliente
	$("#agregar_cliente").click(function() {
		if(Reqcliente()) {
		    $.ajax({ 
		        type:"POST",
		        url: "ajax/cliente_json.php",
		        data: $('#form_cliente').serialize(),
			    success: function(respuesta){  
			        console.log(respuesta);
			        if(respuesta=="true"){ 
			            Swal.fire({
			              icon: 'success',
			              text: 'Ciente registrado con exito!',
			            })
			            $("#myModal").modal('hide');
			            $('#form_cliente')[0].reset();
			        } else {
			        	Swal.fire({
		                  icon: 'error',
		                  text: 'No se pudo registrar, berifica tu coneccion',
		                })
			        } 
			    }

			})
			return false 
		}         
	})

	//Guardar Usuarios
	$("#Update_cliente").click(function() {
		if(ReqclienteUp()){
		    $.ajax({ 
		        type:"POST",
		        url: "ajax/cliente_json.php",
		        data: $('#form_Upcliente').serialize(),
			    success: function(respuesta){  
			        console.log(respuesta);
			        if(respuesta=="true"){ 
			            Swal.fire({
			              icon: 'success',
			              text: 'Cliente Actualizado!',
			            })
			            $("#myModal2").modal('hide');
			            $('#detalle').load('clientes.php #detalle');
			        } else {
			        	Swal.fire({
		                  icon: 'error',
		                  text: 'No se pudo registrar, berifica tu coneccion',
		                })
			        }
			        
			    }

			})
			return false
		}  	        
	})

});


function DateCliente(argument) {

    $.ajax({
        type:'POST',
        url:'ajax/cliente_json.php',
        data:{'idCliente':argument},
        success: function(respuesta){
        	console.log(respuesta);
            var c =$.parseJSON(respuesta);
            $('#id').val(c[0][0]);
			$('#up_identificacion').val(c[0][1]);
            $('#up_nombre').val(c[0][2]);
            $('#up_telefono').val(c[0][3]);
            $('#up_email').val(c[0][4]);
            $('#up_direccion').val(c[0][5]);
                
        }
    });
    
    return false;
    
}

// Validación form cliente
function Reqcliente(){
   var state = true;
   var campos = $('input[type="number"][name="c_identificacion"]:required, input[type="text"][name="c_nombre"]:required, input[type="number"][name="c_telefono"]:required, input[type="email"][name="c_email"]:required, input[type="text"][name="c_direccion"]:required, .required');
   $(campos).each(function() {
      if($(this).val()==''){
         state = false;
         $(this).addClass('errorFld');
      }
   });
   return state;
}

// Validación form cliente
function ReqclienteUp(){
   var state = true;
   var campos = $('input[type="number"][name="up_identificacion"]:required, input[type="text"][name="up_nombre"]:required, input[type="number"][name="up_telefono"]:required, input[type="email"][name="up_email"]:required, input[type="text"][name="up_direccion"]:required, .required');
   $(campos).each(function() {
      if($(this).val()==''){
         state = false;
         $(this).addClass('errorFld');
      }
   });
   return state;
}


</script>


<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

</html>
