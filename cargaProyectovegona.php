<?

/*
20091215
Patricia Barón Manrique
Carga de Proyectos
*/

//Inicializa las variables de sesión
session_start();

//Conexión a la Base de Datos
include("../enlaceBD.php");
$conexion = conectar();

$_SESSION["phlvProyecto"]=$cualProyecto;
//$_SESSION["phlvEtapa"]=
$_SESSION["phlvIdUsuario"]=$_SESSION["phsIdUsuario"];
$_SESSION["phlvPerfil"]=$_SESSION["phsPerfil"];
$_SESSION["phlvNombreUsuario"]=$_SESSION["phsNombreUsuario"];

if(isset($cualProyecto)){
	
	//Consulta
	$sql1 = " SELECT * FROM Proyectos WHERE idProyecto = " . $cualProyecto;
	$cursor1 = mssql_query($sql1);
	if($reg1 = mssql_fetch_array($cursor1)){
		$_SESSION["phlvProyecto"] = $reg1[idProyecto];
		$_SESSION["phlvEtapa"] = $reg1[etapaProyecto];
	}
	
	//Perfil de Proyecto, si es un usuario normal
	if($_SESSION["phlvPerfil"] == 2){
		$sqlPr = " SELECT idPerfil FROM UsuariosVsProyectos ";
		$sqlPr = $sqlPr . " WHERE idProyecto = " . $_SESSION["phlvProyecto"];
		$sqlPr = $sqlPr . " AND etapaProyecto = " . $_SESSION["phlvEtapa"];
		$sqlPr = $sqlPr . " AND idUsuario = " . $_SESSION["phlvIdUsuario"];
		$cursorPr = mssql_query($sqlPr);
		if($regPr = mssql_fetch_array($cursorPr)){
			$_SESSION["phlvPerfil"] = $regPr['idPerfil'];
		}
	}
	
	/*echo $sql1."<br>";
	echo $_SESSION["phlvProyecto"]."<br>";
	echo $_SESSION["phlvEtapa"]."<br>";
	exit;*/

	echo "<script>location.href='menuTematicas.php'</script>";
}
else{
	// ???
}
	

?>