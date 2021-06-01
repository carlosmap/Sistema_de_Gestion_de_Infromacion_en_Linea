<?

/*
20091215
Daniel Felipe Rentería Martínez
Carga de Proyectos
*/

//Inicializa las variables de sesión
session_start();

//Conexión a la Base de Datos
include("../enlaceBD.php");
$conexion = conectar();
//$cualProyecto=$_POST["cualProyecto"];
//echo  $datos_usu_proyectos[idProyecto];
//echo $cualProyecto;


if(isset($cualProyecto)){
	
	//Consulta
	$sql1 = " SELECT * FROM Proyectos WHERE idProyecto = " . $cualProyecto;
	$cursor1 = mssql_query($sql1);
	if($reg1 = mssql_fetch_array($cursor1)){
		$_SESSION["phsProyecto"] = $reg1[idProyecto];
		$_SESSION["phsEtapa"] = $reg1[etapaProyecto];
	}
	
	//Perfil de Proyecto, si es un usuario normal
	if($_SESSION["phsPerfil"] == 2){
		$sqlPr = " SELECT idPerfil FROM UsuariosVsProyectos ";
		$sqlPr = $sqlPr . " WHERE idProyecto = " . $_SESSION["phsProyecto"];
		$sqlPr = $sqlPr . " AND etapaProyecto = " . $_SESSION["phsEtapa"];
		$sqlPr = $sqlPr . " AND idUsuario = " . $_SESSION["phsIdUsuario"];
		$cursorPr = mssql_query($sqlPr);
		if($regPr = mssql_fetch_array($cursorPr)){
			$_SESSION["phsPerfil"] = $regPr['idPerfil'];
		}
	}
	
	/*echo $sql1."<br>";
	echo $_SESSION["phsProyecto"]."<br>";
	echo $_SESSION["phsEtapa"]."<br>";
	exit;*/
//	echo " -- ".$_SESSION["phsProyecto"]." - ".$_SESSION["phsEtapa"]." id usuario: ".$_SESSION["phsIdUsuario"]." perfil ".$_SESSION["phsPerfil"];
/*	echo "<script>alert('hola');</script>";  */
	echo "<script>location.href='menuTematicas.php'</script>"; 
}
else{
	// ???
	echo "no entro";
}
	

?>