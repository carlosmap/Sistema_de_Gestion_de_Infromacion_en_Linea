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
	$sqlIn1 = " DELETE FROM Perfiles ";
	$sqlIn1 = $sqlIn1 . " WHERE idPerfil = " . $cualPerfil . " ";
	$cursorIn1 = mssql_query($sqlIn1);
	if(trim($cursorIn1) != ""){
		echo ("<script>alert('Operación realizada exitosamente.');</script>");
	}
	else{
		echo ("<script>alert('Error en la operación.');</script>");
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

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
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
	  <form action="" method="post" name="form1">
	  <table width="100%" cellspacing="1">
        <tr>
          <td class="TituloTabla2">Nombre del Perfil </td>
          <td class="TxtTabla"><input name="nombrePerfil" type="text" class="CajaTexto" id="nombrePerfil" value="<? echo $nombrePerfil; ?>" size="60" disabled="disabled" /></td>
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
            <select name="relativoA" class="CajaTexto" id="relativoA" disabled>
              <option value="1" <? echo $optS; ?>>Sistema</option>
              <option value="2" <? echo $optP; ?>>Proyectos</option>
          </select></td>
        </tr>

        <tr>
          <td colspan="2" align="center"><span class="menu2">&iquest;Est&aacute; seguro de eliminar la informaci&oacute;n de este registro? </span></td>
        </tr>
        <tr>
          <td colspan="2" align="right"><input name="recarga" type="hidden" id="recarga" value="1" />
            <input name="Submit" type="submit" class="Boton" value="Borrar" />
			<input name="Submit2" type="button" class="Boton" id="Submit2" onClick="MM_callJS('window.close();')" value="Cancelar" /></td>
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
