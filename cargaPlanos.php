<?

/*
20091215
Daniel Felipe Rentería Martínez
Carga de las Temáticas
*/

//Inicializa las variables de sesión
session_start();

//Conexión a la Base de Datos
include("../enlaceBD.php");
$conexion = conectar();

if(isset($cualTematica)){
	
	//Consulta
	$sql1 = " SELECT * FROM Tematicas WHERE idProyecto = " . $_SESSION["phsProyecto"] ." ";
	$sql1 = $sql1 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " AND idTematica = " . $cualTematica;
	$cursor1 = mssql_query($sql1);
	if($reg1 = mssql_fetch_array($cursor1)){
		$_SESSION["phsTematica"] = $reg1[idTematica];
		$_SESSION["phsTematicaPadre"] = $reg1[idTematicaPadre];
	}
	
	/*
	echo $sql1."<br>";
	echo $_SESSION["phsTematica"]."<br>";
	exit;
	*/
	
	echo "<script>location.href='menuPlanos.php'</script>";
}
else{
	// ???
}
	

?>