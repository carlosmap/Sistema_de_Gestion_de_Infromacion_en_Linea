<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?
/*
20091214
Daniel Felipe Rentería Martínez
Adición de Perfiles de Usuario
*/

//Inicializa las variables de sesión
session_start();

//Validación de ingreso
include("../verificaIngreso2.php");

//Conexión a la Base de Datos
include("../enlaceBD.php");
$conexion = conectar();

$sql1 = " SELECT * FROM Perfiles WHERE idPerfil = " . $cualPerfil;
$cursor1 = mssql_query($sql1);
if(isset($recarga) == false){
	if($reg1 = mssql_fetch_array($cursor1)){
		$nombrePerfil = $reg1['nombrePerfil'];
		$relativoA = $reg1['relativoA'];
	}
}

if(isset($recarga) && trim($recarga) == "1"){
	$sqlIn1 = " UPDATE Perfiles SET ";
	$sqlIn1 = $sqlIn1 . " nombrePerfil = '" . $nombrePerfil . "', ";
	$sqlIn1 = $sqlIn1 . " relativoA = '" . $relativoA . "' ";
	$sqlIn1 = $sqlIn1 . " WHERE idPerfil = " . $cualPerfil . " ";
	$cursorIn1 = mssql_query($sqlIn1);
	if(trim($cursorIn1) != ""){
		echo ("<script>alert('Grabación realizada exitosamente.');</script>");
	}
	else{
		echo ("<script>alert('Error en la grabación.');</script>");
	}
	echo ("<script>window.close();MM_openBrWindow('frmPerfiles.php','winAdminPHS','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");
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
//-->
</script>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="TituloTabla">
		<td>.: Sistema de Administraci&oacute;n - Perfiles :.</td>
  </tr>
	
	<tr>
	  <td>
	  <form action="" method="post" name="form1" onSubmit="MM_validateForm('nombrePerfil','','R');return document.MM_returnValue">
	  <table width="100%" cellspacing="1">
        <tr>
          <td class="TituloTabla2">Nombre del Perfil </td>
          <td class="TxtTabla"><input name="nombrePerfil" type="text" class="CajaTexto" id="nombrePerfil" value="<? echo $nombrePerfil; ?>" size="60" /></td>
        </tr>
        <tr>
          <td class="TituloTabla2">Relativo a </td>
          <td class="TxtTabla">
		  <?
		  $optS = "";
		  $optP = "";
		  if($relativoA == "1"){
		  	$optS = "selected";
		  } else {
		  	$optP = "selected";
		  }
		  ?>
		  <select name="relativoA" class="CajaTexto" id="relativoA">
              <option value="1" <? echo $optS; ?>>Sistema</option>
              <option value="2" <? echo $optP; ?>>Proyectos</option>
          </select></td>
        </tr>

        <tr>
          <td colspan="2" align="right"><input name="recarga" type="hidden" id="recarga" value="1" />
            <input name="Submit" type="submit" class="Boton" value="Guardar" /></td>
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
