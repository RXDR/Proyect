<?php
	/* Connect To Database*/
	require_once ("config/conexion2.php");//Contiene funcion que conecta a la base de datos
	require_once("session/perfil.php");
	$perfil=$_SESSION['perfil'];
	switch($perfil) {
		case 3;
			header('Location: impresiones.php');
		break;	
	}

	$query_perfil=mysqli_query($con,"select * from perfil where id=1");
	$rw=mysqli_fetch_assoc($query_perfil);
	$tax= $rw['tax'];//% de iva o impuestos

	$sql=mysqli_query($con, "select LAST_INSERT_ID(id) as last from facturas order by id desc limit 0,1 ");
	$rws=mysqli_fetch_array($sql);
	$numero=$rws['last']+1;

	
?>
<html>
<head>
    <title>Pedidos | <?php echo $rw['nombre_comercial'];?></title>
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

	   	 <div class="row ">
	   	 	<div class="col-lg-12">
	   	 		<h2>Detalles del cliente :</h2>
	   	 	</div> 
	   	 </div>

       <form  name="formBuscar" id="formBuscar"  method="post">
       	 <div class="row ">
       	 	<div class="col-lg-6">
			    <div class="input-group">
			      <input type="number" class="form-control" id="cliente" name="cliente" placeholder="No Identificacion" required="">
			      <span class="input-group-btn">
			        <button class="btn btn-default" id="buscar" name="buscar" type="button">Buscar</button>
			        <input name="buscar" type="hidden" />
			      </span>
			    </div>
			</div>
			<div class="col-lg-6 ">
        		<a href="#" id="userDropdown" role="button" data-toggle="modal" data-target="#myModal2" style="float:right;">+ Registrar Cliente</a> 
        	</div>
       	 </div>
       </form>


        <form class="form-horizontal" id="datos_factura" method="post" name="datos_factura">
            <div class="row ">
                <div class="col-lg-6 col-md-6 col-sm-6">
					<h4><strong>Nombre:</strong><input type="text" id="nombre" name="nombre" style="border:none;"  readonly></h4>
					<h4><strong>C.C/NIT:</strong><input type="text" id="idcliente" name="idcliente" style="border:none;" readonly></h4>
					<h4><strong>Direccion:</strong><input type="text" id="direccion" name="direccion" style="border:none;" readonly></h4>
					<h4><strong>E-mail:</strong><input type="text" id="email" name="email" style="border:none;" readonly></h4>
					<h4><strong>Teléfono:</strong><input type="text" id="telefono" name="telefono" style="border:none;" readonly></h4>
					<input id="id_vendedor" name="id_vendedor" type="hidden"  value="<?php echo $_SESSION['idvendedor'];?>" />
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <h2>Detalles del Pedido:</h2>
                    <h4><strong>Fecha:</strong> <?php echo date("d/m/Y");?></h4>
                    <h4><strong>Fecha De Entrega:</strong></h4>
                    <input type="datetime-local" class="form-control" id="fechae" name="fechae" required="">
                     <br/>
                    <textarea class="form-control" id="desfactura" name="desfactura" placeholder="Otros comentarios" ></textarea>
                </div>
            </div>

            <div class="row">
			<hr />
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped  table-hover"  id='detalle'>
                            <thead>
                                <tr>
                                    <th class='text-center'>Item</th>
									<th>Descripción</th>
									<th class='text-center'>Cantidad</th>
                                    <th class='text-right'>Precio unitario</th>
                                    <th class='text-right'>Total</th>
									<th class='text-right'></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            
								
							$vendedor = $_SESSION['idvendedor'];
							$query=mysqli_query($con,"select * from tmp where vendedor='$vendedor' order by id");
							$items=1;
							$suma=0;

							while($row=mysqli_fetch_array($query)){
								$total=$row['cantidad']*$row['precio'];
								$total=number_format($total,2,'.','');

                            ?>
                            <tr>
								<td class='text-center'><?php echo $items;?></td>
								<td><?php echo $row['descripcion'];?></td>
								<td class='text-center'><?php echo $row['cantidad'];?></td>
								<td class='text-right'><?php echo $row['precio'];?></td>
								<td class='text-right'><?php echo $total;?></td>
								<td class='text-right'><button type="button" class="btn btn-default" onclick="eliminar_item('<?php echo $row['id']; ?>')"> <span class="glyphicon glyphicon-trash"></span></button></td>
							</tr>
							
							<?php
								$items++;
								$suma+=$total;
							}
								$iva=$suma * ($tax / 100);
								$total_iva=number_format($iva,2,'.','');	
								$total=$suma + $total_iva;
							?>

							<tr>
								<td colspan='4' class='text-right'>
									NETO
								</td>
								<th class='text-right'>
									<?php echo number_format($suma,0);?>
								</th>
								<td></td>
							</tr>
							
							<tr>
								<td colspan='4' class='text-right'>
									IVA
								</td>
								<th class='text-right'>
									<?php echo number_format($total_iva,0);?>
								</th>
								<td></td>
							</tr>
							
							<tr>
								<td colspan='4' class='text-right'>
									TOTAL
								</td>
								<th class='text-right'>
									<?php echo number_format($total,0);?>
								<input type="hidden"  id="total" name="total"  value="<?php echo $total; ?>">
								</th>
								<td></td>
							</tr> 
                            </tbody>
							
                        </table>
                        <tr>
							<td colspan='6'>
								<button type="button" class="btn btn-info items" disabled data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span> Agregar Ítem</button>
							</td>
						</tr>
                    </div>
                </div>
            </div>

        
	       	<div class="row"> <hr /></div>
	        <div class="row pad-bottom  pull-right">
	            <div class="col-lg-12 col-md-12 col-sm-12">
	                <button type="submit" class="btn btn-success guardar" id="guardar_factura">Guardar factura</button>	                
	            </div>
	        </div>
		</form>

	</div>
</div>


	<form class="form-horizontal" name="form_item" id="form_item" method="post">
		<!-- Modal -->
		<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Nuevo Ítem</h4>
			  </div>
			  <div class="modal-body">
				  <div class="row">
					<div class="col-md-12">
						<label>Descripción del producto/servicio</label>
						<textarea class="form-control" id="descripcion" name="descripcion" required=""></textarea>
						<div id="desc_res"> </div>
					</div>
				  </div>

				  <div class="row">
					<div class="col-md-6">
						<label>Cantidad</label>
						<input type="number" min="1" class="form-control" id="cantidad" name="cantidad" value="1"  required="">
					</div>
						
					<div class="col-md-6">
						<label>Precio unitario</label>
					  	<input type="number" class="form-control" id="precio" name="precio" required="">
					  	<div id="precio_res"> </div>
					</div>
					<div id="precio_res"> </div>
				  </div>

					<input type="hidden" name="clientetmp" id="clientetmp" >
					<input type="hidden" name="vendedor" id="vendedor" value="<?php echo $_SESSION['idvendedor'];?>" readonly/>

			  </div>

			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-info" id="guardar_item" >Guardar</button>
				<input type="hidden" name="action" id="action" value="ajax">
			  </div>

			</div>
		  </div>
		</div>
	</form>


	<form class="form-horizontal" name="form_cliente" id="form_cliente" method="post">
		<!-- Modal -->
		<div class="modal fade bs-example-modal-lg" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

<?php  include('footer.php'); ?>
   
</body>
<script type="text/javascript">
$(document).ready(function() {

    //Buscar cliente
    $("#buscar").click(function() {
    	var cliente = $("#cliente").val();
    	if(Reqbuscar()){
            $.ajax({
                type:'GET',
                url:'ajax/cliente_json.php',
                data:{'cliente':cliente},
                success: function(respuesta){
                    console.log(respuesta);
                    if(respuesta==0){
		            	Swal.fire({
	                  icon: 'error',
	                  text: 'El cliente no se encuentra registrado',
	                })
		            } else {
		                $('#formBuscar')[0].reset();
                    	$('.items').prop('disabled',false);
                        var c =$.parseJSON(respuesta);
                        	$('#idcliente').val(c[0][1]);
                            $('#clientetmp').val(c[0][1]);
                            $('#nombre').val(c[0][2]);
                            $('#telefono').val(c[0][3]);
                            $('#email').val(c[0][4]);
                            $('#direccion').val(c[0][5]); 
		            }
                } 
            });
	        return false;
	     }

   	})

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
			            $("#myModal2").modal('hide');
			            $('#form_cliente')[0].reset();
			        } else {
			        	Swal.fire({
		                  icon: 'error',
		                  text: 'No se pudo registrar, Verifica tu conexion',
		                })
			        } 
			    }

			})
			return false 
		}         
	})

     //guardar item temp
    $("#guardar_item").click(function() {
    	// Validación de campos vacíos
		if(Reqitem()){
	        $.ajax({ 
	        type:"POST",
	        url: "ajax/items_json.php",
	        data:$('#form_item').serialize(),
	        success: function(respuesta){
	           console.log(respuesta);
	            if(respuesta=="true"){
	            	$("#myModal").modal('hide');
	            	$('#form_item')[0].reset();
	            	$('#detalle').load('pedidos.php #detalle');
	            } else {
	                Swal.fire({
	                  icon: 'error',
	                  text: 'No se pudo registrar, verifica tu conexion',
	                })
	            }     
	        }
	    	})
	        return false
	    }
    })


    //guardar factura 
    $("#guardar_factura").click(function() {
	var factura = [ <?php echo $numero; ?> ]
	var total = parseInt($("#total").val());
	var cliente = $("#nombre").val();
	if(Reqfactura()) {
		if (cliente.length==0){
		alert("No has ingresado ningun cliente");
		return false
		} else if (total==0){
		alert("No has ingresado ningun producto");
		return false
		} else {
    		 $.ajax({
				type: "POST",
				url: "ajax/insertfactura.php",
				data:$('#datos_factura').serialize(),
				success: function(respuesta){
					console.log(respuesta);
					if(respuesta==""){
						Swal.fire({
		                  icon: 'error',
		                  text: 'No se pudo registrar, verifica tu conexion',
		                })
			    	
				    } else{
				    	Swal.fire({
		                  icon: 'success',
		                  title: 'Orden No: ' + factura,
		                  text: 'registrada con exito',
		                })
		                $ ('#detalle').load('pedidos.php #detalle');
		                $('#datos_factura')[0].reset();
		                $('.items').prop('disabled',true);
				    }
					
				}
			});
		    return false;
		}
	}
    })

});
	//Borrar item
	function eliminar_item(id) {
	   $.ajax({
			type: "GET",
			url: "ajax/items_json.php",
			data: "action=ajax&id="+id,
			success: function(respuesta){
			console.log(respuesta);
			    if(respuesta=="true"){
			    	$ ('#detalle').load('pedidos.php #detalle');
			    } else{
			    	Swal.fire({
	                  icon: 'error',
	                  text: 'No se pudo registrar, verifica tu conexion',
	                })
			    }		
			}
		});
	    return false;  
	}

// Validación form buscar cliente
function Reqbuscar(){
   var state = true;
   var campos = $('input[type="number"][name="cliente"]:required, .required' );
   $(campos).each(function() {
      if($(this).val()==''){
         state = false;
         $(this).addClass('errorFld');
      }
   });
   return state;
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


// Validación buscar items
function Reqitem(){
   var state = true;
   var campos = $('textarea[name="descripcion"]:required, input[type="number"][name="precio"]:required, .required' );
   $(campos).each(function() {
      if($(this).val()==''){
         state = false;
         $(this).addClass('errorFld');
      }
   });
   return state;
}

// Validación form factura
function Reqfactura(){
   var state = true;
   var campos = $('input[type="datetime-local"][name="fechae"]:required, .required' );
   $(campos).each(function() {
      if($(this).val()==''){
         state = false;
         $(this).addClass('errorFld');
      }
   });
   return state;
}

		
</script>

</html>
