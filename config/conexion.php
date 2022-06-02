<?php
class conexion {
	
	private $conexion;
		
	function __construct() {
		try{
			$this->conexion = new PDO( "mysql:host=localhost;dbname=u917759325_bd", "root", "");
			$this->conexion->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			//$this->conexion->exec("SET CHARACTER SET UTF8");
		}catch(Exception $e){
			die( print_r( $e->getMessage() ) );
		} 
	}
	
	function getConexion(){
		return $this->conexion;
	}
}
