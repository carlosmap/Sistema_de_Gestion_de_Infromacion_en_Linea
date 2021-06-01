<?php
function conectar(){
//		if (!($CONECTADO=@mssql_connect("sqlservidor","12974","1373")))	{
		if (!($CONECTADO=@mssql_connect("sqlservidor","12974","1373")))	{
			return 0;
			exit();
		}
		if (!@mssql_select_db("GestiondeInformacionDigital",$CONECTADO)) {
			exit();
		}
		return $CONECTADO;
	}


function conectarMySql(){
	if (!($conexionMySql=@mysql_connect("192.168.30.18:3306","root", "pl42imaf"))) {
		echo "No se conecta";
		return 0;
		exit();
	}
	if (!@mysql_select_db("pcontrol",$conexionMySql)) {
		exit();
	}
	return $conexionMySql;
}

function conectarCorrespondencia(){
	if (!($conectado = @mssql_connect("sqlservidor", "12974", "1373"))){
		return 0;
		exit();
	}
	if (!@mssql_select_db("SisCorrespondencia", $conectado)) {
		exit();
	}
	return $conectado;
}

?>