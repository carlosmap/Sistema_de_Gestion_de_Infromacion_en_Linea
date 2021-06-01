<?php
/*
02 de Septiembre 2011
Patricia Barón Manrique
Página de Inicio La Vegona
*/

//Inicializa las variables de sesión
session_start();

//Abre la conexión a la BD
include('enlaceBD.php');

//Establecer la conexión a la base de datos
$conexion = conectar();

if(trim($Usuario != "") AND trim($Clave != "") ){
	$sql2="Select * from Usuarios  ";
	$sql2=$sql2 . " where loginUsuario = '" . $Usuario . "' ";
	$sql2=$sql2 . " and claveUsuario = '" . $Clave . "' ";
	$sql2=$sql2 . " and esActivo = '1' ";
	$cursor2 = mssql_query($sql2);

	if ($reg2=mssql_fetch_array($cursor2)) {
		$_SESSION["phlvNombreUsuario"] = ucwords(strtolower($reg2['nombreUsuario'])) . " " . ucwords(strtolower($reg2['apellidoUsuario'])) ;
		$_SESSION["phlvPerfil"] = $reg2['idPerfil'];
		$_SESSION["phlvIdUsuario"] = $reg2['idUsuario'];
		echo "<script>location.href=\"menuPrincipal.php\"</script>";
	}
	else {
		echo ("<script>alert('El usuario no se encuentra registrado.');</script>");
		echo "<script>location.href=\"index.php\"</script>";
	}
	mssql_close ($conexion); 

}
?>

