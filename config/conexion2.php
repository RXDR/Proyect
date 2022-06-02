<?php
////////////////// CONEXION A LA BASE DE DATOS //////////////////
$host = 'localhost';
$basededatos = 'u917759325_bd';
$usuario = 'root';
$contraseña = '';

$con = new mysqli($host,$usuario,$contraseña,$basededatos);
if (mysqli_connect_errno()) {
    printf("Error de conexión: %s\n", mysqli_connect_error());
    exit();
}

?>