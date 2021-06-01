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
Lotes de Trabajo
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
$sqlPar = " SELECT * FROM LotesTrabajo ";
$sqlPar = $sqlPar . " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
$sqlPar = $sqlPar . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
$sqlPar = $sqlPar . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
$sqlPar = $sqlPar . " AND idLote = " . $cualLote . " ";
$cursorPar = mssql_query($sqlPar);
if(isset($recarga) == false){
	if($regPar = mssql_fetch_array($cursorPar)){
		$numeroLote = $regPar[numeroLote];
		$nombreLote = $regPar[nombreLote];
	}
}

//echo $_SESSION["phsTematica"] . "<br>";
//echo $_SESSION["phsTematicaPadre"] . "<br>";

//Si es una subtemática
if($_SESSION["phsTematica"] != $_SESSION["phsTematicaPadre"]){
	//$ruta = "/enlinea/quimbo/PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"]."/T".$_SESSION["phsTematica"];
	//$ruta = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"]."/T".$_SESSION["phsTematica"];
	$ruta = "/enlinea/gestion/PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"] ."/T".$_SESSION["phsTematica"];
//	echo "1";
}
else{
	//$ruta = "/enlinea/quimbo/PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematica"];
	//$ruta = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematica"];
	$ruta = "/enlinea/gestion/PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"]; //."/T".$_SESSION["phsTematica"];
	
//	echo 2;
}
//echo $ruta . "<br>";

//exit;
//Guardar: Lotes de Trabajo
if(isset($recarga) && trim($recarga) == "1"){
	
	$cursorTran1 = mssql_query(" BEGIN TRANSACTION ");
	
	//Borra las Comunicaciones de las Revisiones
	$sqlIn1 = " DELETE FROM ComunicacionesPorRevision ";
	$sqlIn1 = $sqlIn1 . " WHERE idProyecto =" . $_SESSION["phsProyecto"] . " ";
	$sqlIn1 = $sqlIn1 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn1 = $sqlIn1 . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlIn1 = $sqlIn1 . " AND idLote = " . $cualLote . " ";
	$cursorIn1 = mssql_query($sqlIn1);
	
	//Borra las Revisiones
	$sqlIn2 = " DELETE FROM Revisiones ";
	$sqlIn2 = $sqlIn2 . " WHERE idProyecto =" . $_SESSION["phsProyecto"] . " ";
	$sqlIn2 = $sqlIn2 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn2 = $sqlIn2 . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlIn2 = $sqlIn2 . " AND idLote = " . $cualLote . " ";
	$cursorIn2 = mssql_query($sqlIn2);
	
	//Borra los Planos
	$sqlIn3 = " DELETE FROM Planos ";
	$sqlIn3 = $sqlIn3 . " WHERE idProyecto =" . $_SESSION["phsProyecto"] . " ";
	$sqlIn3 = $sqlIn3 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn3 = $sqlIn3 . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlIn3 = $sqlIn3 . " AND idLote = " . $cualLote . " ";
	$cursorIn3 = mssql_query($sqlIn3);
	
	//Borra el Lote de Trabajo	
	$sqlIn4 = " DELETE FROM LotesTrabajo ";
	$sqlIn4 = $sqlIn4 . " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
	$sqlIn4 = $sqlIn4 . " AND etapaProyecto =" . $_SESSION["phsEtapa"] . " ";
	$sqlIn4 = $sqlIn4 . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlIn4 = $sqlIn4 . " AND idLote = " . $cualLote . " ";
	$cursorIn4 = mssql_query($sqlIn4);
	
	if(trim($cursorTran1) != "" && trim($cursorIn1) != "" && trim($cursorIn2) != "" && trim($cursorIn3) != "" && trim($cursorIn4) != "" ){
		$cursorTran2 = mssql_query(" COMMIT TRANSACTION ");
		if(trim($cursorTran2) != ""){
		
			//Se hace el borrado de las carpetas
			$path = $_SERVER['DOCUMENT_ROOT'].$ruta."/".$cualLote;
	//		echo $path."<br>";
			if(is_dir($path)){
	//			echo $path."<br>";
				delete_dir($path);
			}
		
			echo ("<script>alert('Operación realizada exitosamente.');</script>");
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
		
		if(document.form1.nombrePerfil.value() == ''){
			v1 = 'n';
			m1 = 'El Nombre del Perfil es un dato Obligatorio \n';
		}
		
		if ((v1=='s') && (v2=='s')  && (v3=='s') && (v4=='s')) {
			document.form1.submit();
		}
		else {
			mensaje = m1 + m2 + m3 + m4;
			alert (mensaje);
		}
	}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
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
	  <form action="" method="post" name="form1" onSubmit="MM_validateForm('nombreLote','','R');return document.MM_returnValue">
	  <table width="100%" cellspacing="1">
        <tr>
          <td class="TituloTabla2">N&uacute;mero del Lote de Trabajo </td>
          <td class="TxtTabla"><input name="numeroLote" type="text" class="CajaTexto" id="numeroLote" value="<? echo $numeroLote; ?>" size="10" disabled="disabled" /></td>
        </tr>
        <tr>
          <td class="TituloTabla2">Nombre del Lote de Trabajo </td>
          <td class="TxtTabla"><input name="nombreLote" type="text" class="CajaTexto" id="nombreLote" value="<? echo $nombreLote; ?>" size="60" disabled="disabled" /></td>
        </tr>

        <tr>
          <td colspan="2" align="center" class="Vinculos1">Advertencia: Al eliminar el Lote de Trabajo, se eliminar&aacute;n tambi&eacute;n todos sus PLANOS Y REVISIONES 
tanto de la Base de Datos como del Sistema de Archivos.<br />
&iquest;Realmente desea eliminar este lote?</td>
        </tr>
        <tr>
          <td colspan="2" align="right"><input name="recarga" type="hidden" id="recarga" value="1" />
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
