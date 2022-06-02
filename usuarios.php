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
	<title>Usuarios | <?php echo $rw['nombre_comercial'];?></title>
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
        	<h2>Usuarios:</h2>

        	<div class="row pad-bottom  pull-right">
	            <div class="col-lg-12 col-md-12 col-sm-12">
	                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Crear Usuario</button>
	            </div>
	        </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped  table-hover"  id='detalle'>
                            <thead>
                                <tr>
									<th class='text-left'>Identificacion</th>
                                    <th class='text-left'>Nombre</th>
                                    <th class='text-left'>Correo</th>
                                    <th class='text-left'>Contraseña</th>
                                    <th class='text-left'>Perfil</th>
									<th class='text-right'></th>
									<th class='text-right'></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
							$query=mysqli_query($con,"SELECT * FROM usuarios ORDER BY id DESC");
							while($row=mysqli_fetch_array($query)){

                            ?>
                            <tr>
								<td class='text-left'><?php echo $row['identificacion'];?></td>
								<td class='text-left'><?php echo $row['nombre'];?></td>
								<td class='text-left'><?php echo $row['email'];?></td>
								<td class='text-left'>*******</td>
								<td class='text-left'><?php echo $row['perfil'];?></td>
								<td class='text-right'><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal2"  onclick="DateUsuario(<?php echo $row['id'];?>)" ><span class="glyphicon glyphicon-pencil"></span></button>
								</td>
								<td class='text-right'><button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal3"  onclick="DatePass(<?php echo $row['id'];?>)" ><span class="glyphicon glyphicon-Asterisk"></span></button>
								</td>
							</tr>
							<?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row"><hr /></div>


    <form class="form-horizontal" name="form_usuario" id="form_usuario" method="post">
	<!-- Modal -->
	<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">

		

		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Nuevo Usuario</h4>
		  </div>

		  <div class="modal-body">
			  <div class="row">
				<div class="col-md-6">
					<label>Nombre</label>
					<input type="text" class="form-control" id="nombre" name="nombre" required="">
				</div>
					
				<div class="col-md-6">
					<label>Identificacion</label>
				  	<input type="number" class="form-control" id="id_usuario" name="id_usuario" required="">
					<div id="id_res"> </div>
				</div>
				<div class="col-md-6">
					<label>Email</label>
				  	<input type="email" class="form-control" id="email" name="email" required="">
				  	<div id="email_res"> </div>
				</div>

				<div class="col-md-6">
					<label>Contraseña</label>
				  	<input type="password" class="form-control" id="password" name="password" required=""> 
				</div>
			  </div>

			  <div class="row">
				<div class="col-md-6">
					<label>Perfil</label>
				  	<select name="perfil"  class="form-control" required="">
                      <option value="">Seleccione</option>
                      <option value="1">Administrador</option>
                      <option value="2">Vendedor</option>
                      <option value="3">Impresiones</option>
          			</select> 
				</div>
			  </div>

			</div>
			
		  	<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-info" id="guardar_usuario" >Guardar</button>
				<input type="hidden" name="guardar" id="guardar" >
		  	</div>

		 </div>
		</div>
	  </div>
	</form>
	


	<form class="form-horizontal" name="form_usuario_up" id="form_usuario_up" method="post">
		<!-- Modal -->
		<div class="modal fade bs-example-modal-lg" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">

			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Actualizar Usuario</h4>
			  </div>

			  <div class="modal-body">
				  <div class="row">
					<div class="col-md-6">
						<label>Nombre</label>
						<input type="text" class="form-control" id="nombre_up" name="nombre_up" required="">
					</div>
						
					<div class="col-md-6">
						<label>Identificacion</label>
					  	<input type="number" class="form-control" id="id_usuario_up" name="id_usuario_up" required="">
						  
					</div>
					<div class="col-md-12">
						<label>Email</label>
					  	<input type="email" class="form-control" id="email_up" name="email_up" required="">
					</div>
				  </div>

				  <div class="row">
					<div class="col-md-6">
						<label>Perfil</label>
					  	<select name="perfil_up"  class="form-control">
                          <option id="perfil_up">Seleccione</option>
                          <option value="1">Administrador</option>
                          <option value="2">Vendedor</option>
                          <option value="3">Impresiones</option>
              			</select> 
					</div>
				  </div>

				</div>

				<input type="hidden" name="id" id="id" >
				

			  	<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-info" id="update_usuario" >Actualizar</button>
					<input type="hidden" name="update" id="update" >
			  	</div>

			 </div>
			</div>
		  </div>
	</form>


	<form class="form-horizontal" name="form_pass" id="form_pass" method="post">
		<!-- Modal -->
		<div class="modal fade bs-example-modal-lg" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">

			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Actualizar Contraseña</h4>
			  </div>

			 	<div class="modal-body">

				 	<div class="row">
						<div class="col-md-12">
							<label>Usuario:</label><P id="nombre_user"> </P>
						</div>
				  	</div>

				  	<div class="row">
						<div class="col-md-6">
							<label>Nueva Contraseña</label>
							<input type="password" class="form-control" id="password_up" name="password_up" required="">
						</div>
				  	</div>

				</div>

				<input type="hidden" name="id_user" id="id_user" >
				

			  	<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-info" id="update_password" >Actualizar</button>
					<input type="hidden" name="updatePass" id="updatePass" >
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
$(document).ready(function() {

	//consultar Usuarios
	$("#id_usuario").on("keyup", function() {
	var cedula = $("#id_usuario").val(); 
	  $.ajax({
	      url: 'ajax/usuario_json.php',
	      type: "GET",
	      data:{'cedula':cedula},
	      dataType: "JSON",
	      success: function(respuesta){
	      	console.log(respuesta);
	        if(respuesta == 1){
	        $("#id_res").html('<p style="color:red;">Ya existe la ID '+ cedula);
	        $("#guardar_usuario").attr('disabled',true); //Desabilito el Botton
	        }else{
	        $("#id_res").html('');
	        $("#guardar_usuario").attr('disabled',false); //Habilito el Botton
	        }
	      }
	  });
	          
	});

	//consultar email
	$("#email").on("keyup", function() {
	var email = $("#email").val(); 
	  $.ajax({
	      url: 'ajax/usuario_json.php',
	      type: "GET",
	      data:{'email':email},
	      dataType: "JSON",
	      success: function(respuesta){
	      	console.log(respuesta);
	        if(respuesta == 1){
	        $("#email_res").html('<p style="color:red;">Ya existe el email '+ email);
	        $("#guardar_usuario").attr('disabled',true); //Desabilito el Botton
	        }else{
	        $("#email_res").html('');
	        $("#guardar_usuario").attr('disabled',false); //Habilito el Botton
	        }
	      }
	  });
	          
	});


	//Guardar Usuarios
	$("#guardar_usuario").click(function() {
		if(ReqUsuarios()){
		    $.ajax({ 
		        type:"POST",
		        url: "ajax/usuario_json.php",
		        data: $('#form_usuario').serialize(),
			    success: function(respuesta){  
			        console.log(respuesta);
			        if(respuesta=="true"){ 
			            Swal.fire({
			              icon: 'success',
			              text: 'Usuario Registrado!',
			            })
			            $("#myModal").modal('hide');
			            $('#form_usuario')[0].reset();
			            $('#detalle').load('usuarios.php #detalle');
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
	$("#update_usuario").click(function() {
		if(ReqUsuariosUp()){
		    $.ajax({ 
		        type:"POST",
		        url: "ajax/usuario_json.php",
		        data: $('#form_usuario_up').serialize(),
			    success: function(respuesta){  
			        console.log(respuesta);
			        if(respuesta=="true"){ 
			            Swal.fire({
			              icon: 'success',
			              text: 'Usuario Actualizado!',
			            })
			            $("#myModal2").modal('hide');
			            $('#detalle').load('usuarios.php #detalle');
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
	$("#update_password").click(function() {
		if(ReqPass()){
		    $.ajax({ 
		        type:"POST",
		        url: "ajax/usuario_json.php",
		        data: $('#form_pass').serialize(),
			    success: function(respuesta){  
			        console.log(respuesta);
			        if(respuesta=="true"){ 
			            Swal.fire({
			              icon: 'success',
			              text: 'Contraseña Actualizada!',
			            })
			            $("#myModal3").modal('hide');
			            $('#detalle').load('usuarios.php #detalle');
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


})


function DateUsuario(argument) {

    $.ajax({
        type:'POST',
        url:'ajax/usuario_json.php',
        data:{'idUsuario':argument},
        success: function(respuesta){
        	console.log(respuesta);
            var c =$.parseJSON(respuesta);
            $('#id').val(c[0][0]);
			$('#nombre_up').val(c[0][1]);
            $('#id_usuario_up').val(c[0][2]);
            $('#email_up').val(c[0][3]);
            $('#perfil_up').val(c[0][5]);
                
        }
    });
    
    return false;
    
}

function DatePass(argument) {
    $.ajax({
        type:'POST',
        url:'ajax/usuario_json.php',
        data:{'idUsuario':argument},
        success: function(respuesta){
        	console.log(respuesta);
            var c =$.parseJSON(respuesta);
            $('#id_user').val(c[0][0]);
			$('#nombre_user').html(c[0][1]);  
        }
    });
    return false;  
}

// Validación de campos vacíos
function ReqUsuarios(){
   var state = true;
   var campos = $('input[type="text"][name="nombre"]:required, input[type="number"][name="id_usuario"]:required, input[type="email"][name="email"]:required, input[type="password"][name="password"]:required, select[name="perfil"]:required, .required' );
   $(campos).each(function() {
      if($(this).val()==''){
         state = false;
         $(this).addClass('errorFld');
      }
   });
   return state;
}

// Validación de campos vacíos
function ReqUsuariosUp(){
   var state = true;
   var campos = $('input[type="text"][name="nombre_up"]:required, input[type="number"][name="id_usuario_up"]:required, input[type="email"][name="email_up"]:required, .required' );
   $(campos).each(function() {
      if($(this).val()==''){
         state = false;
         $(this).addClass('errorFld');
      }
   });
   return state;
}

// Validación de campos vacíos
function ReqPass(){
   var state = true;
   var campos = $('input[type="password"][name="password_up"]:required, .required' );
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
