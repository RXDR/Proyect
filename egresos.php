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
	<title>Egresos | <?php echo $rw['nombre_comercial'];?></title>
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
        	<h2>Egresos:</h2>

        	<div class="row pad-bottom  pull-right">
	            <div class="col-lg-12 col-md-12 col-sm-12">
	                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Crear Egreso</button>
	            </div>
	        </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped  table-hover"  id='detalle'>
                            <thead>
                                <tr>
									<th>Orden</th>
									<th class='text-left'>valor</th>
                                    <th class='text-left'>Concepto</th>
									<th class='text-right'>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
							$query=mysqli_query($con,"SELECT * FROM egresos ORDER BY id_egreso ");
							while($row=mysqli_fetch_array($query)){

                            ?>
                            <tr>
								<td><?php echo $row['id_egreso'];?></td>
								<td class='text-left'><?php echo number_format($row['valor']);?></td>
								<td class='text-left'><?php echo $row['concepto'];?></td>
								<td class='text-right'><?php echo $row['fecha_egreso'];?></td>
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
      action="fact-pdf.php" class="form-horizontal" name="form_egreso" id="form_egreso" method="post">
		<!-- Modal -->
		<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close" ><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Caja De Egresos</h4>
			  </div>
			  <div class="modal-body">

				  <div class="row">
				  	<div class="col-md-6">
						<label>Valor:</label>
						<input type="number" class="form-control" id="valor" name="valor" required="">
					</div>
				  </div>

				  <div class="row">
					<div class="col-md-12">
						<label>Concepto</label>
						<textarea class="form-control" id="concepto" name="concepto" required=""></textarea>
					</div>
				  </div>

				<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

			  </div>

			  <div class="modal-footer">
				<button type="button" class="btn btn-default" id="cerrar" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-info" id="guardar_egreso" >Guardar / Imprimir</button>
				<input type="hidden" name="egreso" id="egreso">
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
 		$('#form_egreso')[0].reset();
	});
	$("#close").click(function() {
 		$('#form_egreso')[0].reset();
	});
		
	$(document).ready( function () {
	    $('#detalle').DataTable();
	} );

//Actualizar Usuarios
$("#guardar_egreso").click(function() {
	if(Reqingreso()){
	    $.ajax({ 
	        type:"POST",
	        url: "ajax/egresos_json.php",
	        data: $('#form_egreso').serialize(),
		    success: function(respuesta){  
		        console.log(respuesta);
		        if(respuesta=="true"){ 
		            Swal.fire({
		              icon: 'success',
		              text: 'Egreso Efectuado!',
		            })
		            $('#detalle').load('egresos.php #detalle');
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


function refres() {
	$('#detalle').load('caja.php #detalle');
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

<script src="http://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

</html>
