<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?
/*
20091215
Daniel Felipe Rentería Martínez
Temáticas
*/

//Inicializa las variables de sesión
session_start();

//Validación de ingreso
include("../verificaIngreso1.php");

//Manejo de Archivos y Directorios
include("../manejoArchivos.php");

//Conexión a la Base de Datos
include("../enlaceBD.php");
$conexion = conectar();

//Datos de Parámetro
$sqlPar = " SELECT * FROM Tematicas WHERE idProyecto = " . $_SESSION["phsProyecto"];
$sqlPar = $sqlPar . " AND etapaProyecto = " . $_SESSION["phsEtapa"];
$sqlPar = $sqlPar . " AND idTematica = " . $cualTematica;
$cursorPar = mssql_query($sqlPar);
if(isset($recarga) == false){
	if($regPar = mssql_fetch_array($cursorPar)){
		$nombreTematica = $regPar[nombreTematica];
		$temaPadre = $regPar[idTematicaPadre];
	}
}

//Si es una subtemática
if($temaPadre != $cualTematica){
	$ruta = "/enlinea/gestion/PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$temaPadre."/T";
	//echo $ruta."<br> $cualTematica ";
	//echo 1;
}
else{
	$ruta = "/enlinea/gestion/PHSFiles/" . $_SESSION["phsProyecto"] . "/T";
	//echo $ruta."<br> $cualTematica ";
	//echo 2;
}

//Eliminar: Temáticas
if(isset($recarga) && trim($recarga) == "1"){

/*Se hace el borrado de las carpetas
$path = $_SERVER['DOCUMENT_ROOT'].$ruta.$cualTematica;
echo $path."<br>";
if(is_dir($path)){
	delete_dir($path);
}
exit();*/

	$cursorTran1 = mssql_query(" BEGIN TRANSACTION ");
	
	//Borra las Comunicaciones de las Revisiones
	$sqlIn1 = " DELETE FROM ComunicacionesPorRevision ";
	$sqlIn1 = $sqlIn1 . " WHERE idProyecto =" . $_SESSION["phsProyecto"] . " ";
	$sqlIn1 = $sqlIn1 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn1 = $sqlIn1 . " AND idTematica = " . $cualTematica . " ";
	$cursorIn1 = mssql_query($sqlIn1);
	
	//Borra las Revisiones
	$sqlIn2 = " DELETE FROM Revisiones ";
	$sqlIn2 = $sqlIn2 . " WHERE idProyecto =" . $_SESSION["phsProyecto"] . " ";
	$sqlIn2 = $sqlIn2 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn2 = $sqlIn2 . " AND idTematica = " . $cualTematica . " ";
	$cursorIn2 = mssql_query($sqlIn2);
	
	//Borra los Planos
	$sqlIn3 = " DELETE FROM Planos ";
	$sqlIn3 = $sqlIn3 . " WHERE idProyecto =" . $_SESSION["phsProyecto"] . " ";
	$sqlIn3 = $sqlIn3 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn3 = $sqlIn3 . " AND idTematica = " . $cualTematica . " ";
	$cursorIn3 = mssql_query($sqlIn3);

	//Borra los Lotes de Trabajo
	$sqlIn4 = " DELETE FROM LotesTrabajo ";
	$sqlIn4 = $sqlIn4 . " WHERE idProyecto =" . $_SESSION["phsProyecto"] . " ";
	$sqlIn4 = $sqlIn4 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn4 = $sqlIn4 . " AND idTematica = " . $cualTematica . " ";
	$cursorIn4 = mssql_query($sqlIn4); 
	
	//Borra las Temáticas Asociadas o Subtemáticas
	$sqlIn5 = " DELETE FROM Tematicas ";
	$sqlIn5 = $sqlIn5 . " WHERE idProyecto =" . $_SESSION["phsProyecto"] . " ";
	$sqlIn5 = $sqlIn5 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn5 = $sqlIn5 . " AND idTematicaPadre = " . $cualTematica . " ";
	$cursorIn5 = mssql_query($sqlIn5);
/*
	delete FROM Tematicas
		WHERE idProyecto=1547
		AND etapaProyecto=1
		AND idTematicaPadre=178
*/	

	//echo "<br>".mssql_get_last_message()." cur 5<br> $cualTematica -".$_SESSION["phsProyecto"]." - ". $_SESSION["phsEtapa"] ;
	//Borra la Temática
	$sqlIn6 = " DELETE FROM Tematicas ";
	$sqlIn6 = $sqlIn6 . " WHERE idProyecto =" . $_SESSION["phsProyecto"] . " ";
	$sqlIn6 = $sqlIn6 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn6 = $sqlIn6 . " AND idTematica = " . $cualTematica . " ";
	$cursorIn6 = mssql_query($sqlIn6);
		
	//echo "<br> cur1tran: $cursorTran1 <br> cur1: $cursorIn1 <br> cur2: $cursorIn2 <br> cur3: $cursorIn3 <br> cur4: $cursorIn4 <br> cur5: $cursorIn5 <br> cur6: $cursorIn6 <br>";
	//echo mssql_get_last_message()."<br>".$_SESSION["phsEtapa"]; 
	
	if(trim($cursorTran1) != "" && trim($cursorIn1) != "" && trim($cursorIn2) != "" && trim($cursorIn3) != "" && trim($cursorIn4) != "" && trim($cursorIn5) != "" && trim($cursorIn6) != ""){
		$cursorTran2 = mssql_query(" COMMIT TRANSACTION ");
		if(trim($cursorTran2) != ""){
		
			//Se hace el borrado de las carpetas
			$path = $_SERVER['DOCUMENT_ROOT'].$ruta.$cualTematica;
			if(is_dir($path)){
		//		echo $path."<br>";
				delete_dir($path);
			}
		
//			echo ("<script>alert('Operación realizada exitosamente.');</script>");
		}
	}
	else{
		$cursorTran2 = mssql_query(" ROLLBACK TRANSACTION ");
		if(trim($cursorTran2) != ""){
			echo ("<script>alert('Error en la Operación.');</script>");
		}
	}

	echo ("<script>window.close();MM_openBrWindow('menuTematicas.php','winSogamoso','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");
}
//	echo $path."<br>";

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
		<td>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea ::: </td>
  </tr>
	
	<tr>
	  <td>
	  <form action="" method="post" name="form1" onSubmit="MM_validateForm('nombrePerfil','','R');return document.MM_returnValue">
	  <table width="100%" cellspacing="1">
        <tr>
          <td class="TituloTabla2">Nombre del Tema o Subtema</td>
          <td class="TxtTabla"><input name="nombreTematica" type="text" class="CajaTexto" id="nombreTematica" value="<? echo $nombreTematica; ?>" size="60" disabled="disabled" /></td>
        </tr>

        <tr>
          <td colspan="2" align="center" class="Vinculos1">Advertencia: Al eliminar esta tem&aacute;tica, se eliminar&aacute;n tambi&eacute;n todas sus SUBTEM&Aacute;TICAS, LOTES, PLANOS Y REVISIONES 
            tanto de la Base de Datos como del Sistema de Archivos. 
            &iquest;Realmente desea eliminar este tema?</td>
        </tr>
        <tr>
          <td colspan="2" align="right"><input name="temaPadre" type="hidden" id="temaPadre" value="<? echo $temaPadre; ?>" />
          <input name="recarga" type="hidden" id="recarga" value="1" />
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
