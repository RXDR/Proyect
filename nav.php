<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="container " >

	<div class="row">
	  
	  <div class="col-md-12">
	  
	  <div id="header">
			<ul class="nav">
				<li><a href="index.php"><i class="fa fa-fw fa-home"></i>Inicio</a></li>
			
	
						
				<li><a href="#"><i class="fa fa-fw fa-user"></i><?php echo $_SESSION['nombre'];?></a>
					<ul>
						<li><a href=""><span class="material-icons">settings</span> Mi Cuenta</a></li>
						<li><a href="session/loguot.php"><span class="material-icons">exit_to_app</span>Cerrar sesión
            			</a></li>
						
					</ul>
				</li>
				
			</ul>
		</div>
	    <!-- End of Topbar -->
	


	  </div><!-- col -->
	</div><!-- End row -->

</div><!-- End container --><br>