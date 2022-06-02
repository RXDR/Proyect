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
    <title>Home | <?php echo $rw['nombre_comercial'];?></title>
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

		<div class="tarjeta">
		<a href="caja.php" class="card" title="Caja ingresar">
		<span class="tamaño">
		point_of_sale
		</span>
		</a>
		
		<a href="pedidos.php" class="card tercero" title="Pedidos ingresar">
		<span class="tamaño">
		fact_check
			</span>
			</a>

		<a href="#" class="card cuarto" title="Configuraciones ingresar">
		<span class="tamaño">
		settings
		</span>
		
		</a>

		<a href="clientes.php" class="card tercero" title="clientes ingresar">
		 <span class="tamaño">
			people
			</span>
			
		</a>

		<a href="egresos.php" class="card cuarto" title="Egresos.... ingresar" >
		<span class="tamaño" >
		attach_money
		</span>
		
		</a>

		<a href="reporte.php" class="card" title="Reportes ingresar">
		<span class="tamaño">
		receipt_long
			</span>
			
		</a>

		<a href="impresiones.php" class="card cuarto" title="Imprimir ingresar">
		<span class="tamaño">
		print
			</span>
			
		</a>
		<a href="usuarios.php" class="card " title="config Usuario">
		<span class="tamaño">
		manage_accounts
			</span>
			
		</a>
		</div>
		<hr/>

	</div>
</div>
</body>


<?php  include('footer.php'); ?>
   
</body>

</html>
