<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?
/*
20091216
Daniel Felipe Rentería Martínez
Planos
*/

//Inicializa las variables de sesión
session_start();

//Validación de ingreso
include("../verificaIngreso1.php");

//Manejo de Archivos
include("../manejoArchivos.php");

//Conexión a la Base de Datos
include("../enlaceBD.php");
$conexion = conectar();

//Datos de Parámetro
$sqlPar = " SELECT * FROM Planos ";
$sqlPar = $sqlPar . " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
$sqlPar = $sqlPar . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
$sqlPar = $sqlPar . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
$sqlPar = $sqlPar . " AND idLote = " . $cualLote . " ";
$sqlPar = $sqlPar . " AND idPlano = " . $cualPlano . " ";
$cursorPar = mssql_query($sqlPar);
if(isset($recarga) == false){
	if($regPar = mssql_fetch_array($cursorPar)){
		$nombrePlano = $regPar[numeroPlano];
		$descrPlano = $regPar[descripcionPlano];
	}
}

//Rutas de Archivos
//Si es una subtemática
if($_SESSION["phsTematica"] != $_SESSION["phsTematicaPadre"]){
	//$ruta = "/enlinea/quimbo/PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"]."/T".$_SESSION["phsTematica"]."/".$cualLote."/".$nombrePlano;
	//	$ruta = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"]."/T".$_SESSION["phsTematica"]."/".$cualLote."/".$nombrePlano;
	$ruta = "/enlinea/gestion/PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"]."/T".$_SESSION["phsTematica"]."/".$cualLote."/".$nombrePlano;
	

}
else{
	//$ruta = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematica"]."/".$cualLote."/".$nombrePlano;
		$ruta = "/enlinea/gestion/PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematica"]."/".$cualLote."/".$nombrePlano;
}
//echo $ruta."<br>";
//Guardar: Planos
if(isset($recarga) && trim($recarga) == "2" ){

	$cursorTran1 = mssql_query(" BEGIN TRANSACTION");
	
	//Borra las Comunicaciones de las Revisiones
	$sqlIn1 = " DELETE FROM ComunicacionesPorRevision ";
	$sqlIn1 = $sqlIn1 . " WHERE idProyecto =" . $_SESSION["phsProyecto"] . " ";
	$sqlIn1 = $sqlIn1 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn1 = $sqlIn1 . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlIn1 = $sqlIn1 . " AND idLote = " . $cualLote . " ";
	$sqlIn1 = $sqlIn1 . " AND idPlano = " . $cualPlano . " ";
	$cursorIn1 = mssql_query($sqlIn1);
	
	//Borra las Revisiones
	$sqlIn2 = " DELETE FROM Revisiones ";
	$sqlIn2 = $sqlIn2 . " WHERE idProyecto =" . $_SESSION["phsProyecto"] . " ";
	$sqlIn2 = $sqlIn2 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn2 = $sqlIn2 . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlIn2 = $sqlIn2 . " AND idLote = " . $cualLote . " ";
	$sqlIn2 = $sqlIn2 . " AND idPlano = " . $cualPlano . " ";
	$cursorIn2 = mssql_query($sqlIn2);	
	
	//Borra el Plano
	$sqlIn3 = " DELETE FROM Planos ";
	$sqlIn3 = $sqlIn3 . " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
	$sqlIn3 = $sqlIn3 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn3 = $sqlIn3 . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlIn3 = $sqlIn3 . " AND idLote = " . $cualLote . " ";
	$sqlIn3 = $sqlIn3 . " AND idPlano = " . $cualPlano . " ";
	$cursorIn3 = mssql_query($sqlIn3);
	
	if(trim($cursorIn1) != "" && trim($cursorTran1) != "" && trim($cursorIn2) != "" && trim($cursorIn3) != ""){
		$cursorTran2 = mssql_query(" COMMIT TRANSACTION ");
		if(trim($cursorTran2) != ""){
		
			//Se hace el borrado de las carpetas
			$path = $_SERVER['DOCUMENT_ROOT'].$ruta;
			if(is_dir($path)){
//				echo $path."<br>";
				delete_dir($path);
			}
//	echo $path;			
		
/*			echo ("<script>alert('Operación realizada exitosamente.');</script>");
*/
		}
	}
	else{
		$cursorTran2 = mssql_query(" ROLLBACK TRANSACTION ");
		if(trim($cursorTran2) != ""){
			echo ("<script>alert('Error en la Operación.');</script>");
		}
	}

	echo ("<script>window.close();MM_openBrWindow('menuPlanos.php?loteTrabajo=$cualLote','winSogamoso','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<title>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</title>
<script language="javascript">
<!--
function envia1(){
		var v1 = 's';
		var v2 = 's';
		var v3 = 's';
		var v4 = 's';
		var m1 = '';
		var m2 = '';
		var m3 = '';
		var m4 = '';
		var mensaje = '';
		
		if(document.form1.nombrePlano.value == '' || document.form1.descrPlano.value == ''){
			v1 = 'n';
			m1 = 'El Nombre y la Descripción del Plano son datos Obligatorios \n';
		}
				
		if ((v1=='s') && (v2=='s')  && (v3=='s') && (v4=='s')) {
			document.form1.recarga.value = "2";
			document.form1.submit();
		}
		else {
			mensaje = m1 + m2 + m3 + m4;
			alert (mensaje);
		}
	}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="TituloTabla">
		<td>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</td>
  </tr>
	
	<tr>
	  <td>
	  <form action="" method="post" enctype="multipart/form-data" name="form1">
	  <table width="100%" cellspacing="1">
        <tr>
          <td class="TituloTabla2">Nombre (N&uacute;mero) del Documento </td>
          <td class="TxtTabla"><input name="nombrePlano" type="text" class="CajaTexto" id="nombrePlano" value="<? echo $nombrePlano; ?>" readonly /></td>
        </tr>
        <tr>
          <td class="TituloTabla2">Descripci&oacute;n del Documento </td>
          <td class="TxtTabla"><input name="descrPlano" type="text" class="CajaTexto" id="descrPlano" value="<? echo $descrPlano; ?>" size="60" readonly /></td>
        </tr>
        

        <tr>
          <td colspan="2" align="center" class="Vinculos1">Advertencia: Al eliminar el Documento, se eliminar&aacute;n tambi&eacute;n todos los datos de sus REVISIONES 
tanto de la Base de Datos como del Sistema de Archivos.<br />
&iquest;Realmente desea eliminar este plano?</td>
        </tr>
        <tr>
          <td colspan="2" align="right"><input name="cualPlano" type="hidden" id="cualPlano" value="<? echo $cualPlano; ?>" />
            <input name="cualLote" type="hidden" id="cualLote" value="<? echo $cualLote; ?>" />
          <input name="recarga" type="hidden" id="recarga" value="2" />
            <input name="Submit" type="submit" class="Boton" value="Borrar" />
            <input name="Submit2" type="button" class="Boton" onClick="MM_callJS('window.close();')" value="Cancelar" /></td>
          </tr>
      </table>
	  </form>	  </td>
  </tr>
	<tr>
	  <td>&nbsp;</td>
  </tr>
	<tr class="copyr">
	  <td>Desarrollado por INGETEC S.A. &copy; 2009 - Departamento de Sistemas </td>
  </tr>
</table>

</body>
</html>
