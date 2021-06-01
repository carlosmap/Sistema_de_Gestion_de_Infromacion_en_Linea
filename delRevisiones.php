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
$sqlPar = " SELECT * FROM Revisiones ";
$sqlPar = $sqlPar . " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
$sqlPar = $sqlPar . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
$sqlPar = $sqlPar . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
$sqlPar = $sqlPar . " AND idLote = " . $_SESSION["phsLote"] . " ";
$sqlPar = $sqlPar . " AND idPlano = " . $_SESSION["phsPlano"] . " ";
$sqlPar = $sqlPar . " AND idRevision = " . $cualRevision . " ";
$cursorPar = mssql_query($sqlPar);
if(isset($recarga) == false){
	if($regPar = mssql_fetch_array($cursorPar)){
		$archivoPDFantes = $regPar[archivoPDF];
		$archivoDWGantes = $regPar[archivoDWG];
		$fechaRevision = date("m/d/Y", strtotime($regPar[fechaRevision]));
		$numeroEntrega = $regPar[numeroEntrega];
		$originaMod = $regPar[idOriginaMod];
		$divisionModifica = $regPar[idClaseMod];
		$revision = $regPar[numeroRevision];
		$descrModifica = $regPar[descripcionModificacion];
		$itemsPago = $regPar[itemsPago];
		$consRevision = $regPar[idRevisionInterna];
	}
}

//Originó Modificación
$sql1 = " SELECT * FROM TipoOriginaModificacion ";
$cursor1 = mssql_query($sql1);

//Clase Modificación
$sql2 = " SELECT * FROM TipoClaseModificacion ";
$cursor2 = mssql_query($sql2);

/*
Listado de Revisiones
Muestra solamente las revisiones que son superiores a la última revisión puesta
*/
$sql3 = " SELECT * FROM ConsRevisionesInternas WHERE idRevisionInterna = " . $consRevision;
$cursor3 = mssql_query($sql3);
if($reg3 = mssql_fetch_array($cursor3)){
	$consRevision = $reg3['idRevisionInterna'];
	$letraRevision = $reg3['letraRevisionInterna'];
}

//Guardar: Planos
if($recarga == 2 ){

	//Obtiene el Nombre del Plano
	$sqlNom = " SELECT numeroPlano FROM Planos ";
	$sqlNom = $sqlNom . " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
	$sqlNom = $sqlNom . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlNom = $sqlNom . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlNom = $sqlNom . " AND idLote = " . $_SESSION["phsLote"] . " ";
	$sqlNom = $sqlNom . " AND idPlano = " . $_SESSION["phsPlano"] . " ";
	$cursorNom = mssql_query($sqlNom);
	if($regNom = mssql_fetch_array($cursorNom)){
		$nombrePlano = $regNom[numeroPlano];
	}

	//Creación de las Carpetas Correspondientes a la Temática, al Lote de Trabajo y al Plano
	//Si es una subtemática
	if($_SESSION["phsTematica"] != $_SESSION["phsTematicaPadre"]){
		$ruta = "/enlinea/gestion/PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"]."/T".$_SESSION["phsTematica"]."/".$_SESSION["phsLote"]."/".$nombrePlano."/R".$letraRevision;
	}
	else{
		$ruta = "/enlinea/gestion/PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematica"]."/".$_SESSION["phsLote"]."/".$nombrePlano."/R".$letraRevision;
	}
	
	$cursorTran1 = mssql_query(" BEGIN TRANSACTION");
	
	//Borra las Comunicaciones de las Revisiones
	$sqlIn1 = " DELETE FROM ComunicacionesPorRevision ";
	$sqlIn1 = $sqlIn1 . " WHERE idProyecto =" . $_SESSION["phsProyecto"] . " ";
	$sqlIn1 = $sqlIn1 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn1 = $sqlIn1 . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlIn1 = $sqlIn1 . " AND idLote = " . $_SESSION["phsLote"] . " ";
	$sqlIn1 = $sqlIn1 . " AND idPlano = " . $_SESSION["phsPlano"] . " ";
	$sqlIn1 = $sqlIn1 . " AND idRevision = " . $cualRevision . " ";
	$cursorIn1 = mssql_query($sqlIn1);
	
	//Borrado de la Revisión
	$sqlIn2 = " DELETE FROM Revisiones ";
	$sqlIn2 = $sqlIn2 . " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
	$sqlIn2 = $sqlIn2 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn2 = $sqlIn2 . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlIn2 = $sqlIn2 . " AND idLote = " . $_SESSION["phsLote"] . " ";
	$sqlIn2 = $sqlIn2 . " AND idPlano = " . $_SESSION["phsPlano"] . " ";
	$sqlIn2 = $sqlIn2 . " AND idRevision = " . $cualRevision . " ";
	$cursorIn2 = mssql_query($sqlIn2);
	
	if(trim($cursorIn1) != "" && trim($cursorIn2) != "" && trim($cursorTran1) != ""){
		$cursorTran2 = mssql_query(" COMMIT TRANSACTION ");
		if(trim($cursorTran2) != ""){
			//Se hace el borrado de las carpetas
			$path = $_SERVER['DOCUMENT_ROOT'].$ruta;
			if(is_dir($path)){
//				echo $path."<br>";
				delete_dir($path);
			}
			echo ("<script>alert('Operación realizada exitosamente.');</script>");
		}
	}
	else{
		$cursorTran2 = mssql_query(" ROLLBACK TRANSACTION ");
		if(trim($cursorTran2) != ""){
			echo ("<script>alert('Error en la grabación.');</script>");
		}
	}
	echo ("<script>window.close();MM_openBrWindow('menuRevisiones.php','winSogamoso','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<title>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</title>
<script language="JavaScript" src="calendar.js"></script>
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
		
		if(document.form1.fechaRevision.value == '' || document.form1.numeroEntrega.value == ''){
			v3 = 'n';
			m3 = 'La fecha de Revisión y el Número de Entrega son datos Obligatorios \n';
		}
		
		if(document.form1.descrModifica.value == '' || document.form1.itemsPago.value == ''){
			v4 = 'n';
			m4 = 'La descripción de la Modificación y los Items de Pago son datos Obligatorios \n';
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
          <td colspan="3" class="TituloTabla2">Datos de la Revisi&oacute;n </td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Revisi&oacute;n</td>
          <td class="TxtTabla">R<? echo $letraRevision; ?>
              <input name="consRevision" type="hidden" id="consRevision" value="<? echo $consRevision; ?>" /></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Archivo PDF </td>
          <td class="TxtTabla">
		  Archivo Anterior: <? echo $archivoPDFantes; ?></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Archivo Fuente </td>
          <td class="TxtTabla">Archivo Anterior: <? echo $archivoDWGantes; ?></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Fecha de Revisi&oacute;n </td>
          <td class="TxtTabla"><input name="fechaRevision" type="text" class="CajaTexto" id="fechaRevision" value="<? echo $fechaRevision; ?>" disabled="disabled" />
            <a href="javascript:cal.popup();"><img src="../images/cal.gif" width="16" height="16" border="0" /></a></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">N&uacute;mero de Entrega</td>
          <td class="TxtTabla"><input name="numeroEntrega" type="text" class="CajaTexto" id="numeroEntrega" value="<? echo $numeroEntrega; ?>" disabled="disabled" /></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Or&iacute;gen de la Modificaci&oacute;n </td>
          <td class="TxtTabla">
		  <select name="originaMod" class="CajaTexto" id="originaMod" disabled="disabled">
		  <? 
		  while($reg1 = mssql_fetch_array($cursor1)){ 
		  	$selA = "";
		  	if($reg1[idOriginaMod] == $originaMod){
				$selA = "selected";
			}
		  ?>
		  	<option value="<? echo $reg1[idOriginaMod]; ?>" <? echo $selA; ?>> <? echo $reg1[nombreOriginaMod]; ?> </option>
		  <? } ?>
          </select>		  </td>
        </tr>
        <tr>
          <td rowspan="2" class="TituloTabla2">Descripci&oacute;n Modificaciones </td>
          <td class="TituloTabla2">Clase Modificaci&oacute;n </td>
          <td class="TxtTabla">
		  <select name="divisionModifica" class="CajaTexto" id="divisionModifica" disabled="disabled">
		  <? 
		  while($reg2 = mssql_fetch_array($cursor2)){ 
		  	$selB = "";
		  	if($reg2[idClaseMod] == $divisionModifica){
				$selB = "selected";
			}
		  ?>
		  	<option value="<? echo $reg2[idClaseMod] ?>" <? echo $selB; ?>><? echo $reg2[nombreClaseMod]; ?></option>
		  <? } ?>
          </select>		  </td>
        </tr>
        <tr>
          <td class="TituloTabla2">Descripci&oacute;n</td>
          <td class="TxtTabla"><input name="descrModifica" type="text" class="CajaTexto" id="descrModifica" value="<? echo $descrModifica; ?>" size="60" disabled="disabled" /></td>
        </tr>
        
        <tr>
          <td colspan="2" class="TituloTabla2">&Iacute;tems de Pago (Separados por Comas) </td>
          <td class="TxtTabla"><input name="itemsPago" type="text" class="CajaTexto" id="itemsPago" value="<? echo $itemsPago; ?>" size="60" disabled="disabled" /></td>
        </tr>

        <tr>
          <td colspan="3" align="center" class="Vinculos1">Advertencia: Al eliminar la Revisi&oacute;n, se eliminar&aacute;n tambi&eacute;n todos los datos de sus COMUNICACIONES 
tanto de la Base de Datos como del Sistema de Archivos.<br />
&iquest;Realmente desea eliminar esta revisi&oacute;n?</td>
        </tr>
        <tr>
          <td colspan="3" align="right"><input name="revision" type="hidden" id="revision" value="<? echo $revision; ?>" />
          <input name="cualRevision" type="hidden" id="cualRevision" value="<? echo $cualRevision; ?>" />
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

<script language="JavaScript">
		 var cal = new calendar2(document.forms['form1'].elements['fechaRevision']);
		 cal.year_scroll = true;
		 cal.time_comp = false;
</script>

</body>
</html>
