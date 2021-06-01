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
Administración PH Sogamoso: Proyectos
*/

//Inicializa las variables de sesión
session_start();

//Validación de ingreso
include("../verificaIngreso2.php");

//Conexión a la Base de Datos
include("../enlaceBD.php");
$conexion = conectar();

/*
Proyectos Activos de la Hoja de Tiempo
*/
$sql1 = " SELECT * FROM HojaDeTiempo.dbo.Proyectos
WHERE id_estado = 2 order by (nombre)";
$cursor1 = mssql_query($sql1);


//Guardado de Datos
if($_POST["recarga"] == 1){

	$okGuardar = "Si";
	
	$cursorTran1 = mssql_query("BEGIN TRANSACTION");
	if(trim($cursorTran1) == ""){
		$okGuardar = "No";
	}
	
	/*
	Trae el Nombre del Proyecto de la Hoja de Tiempo
	*/
	$sqlIn1 = " SELECT nombre FROM HojaDeTiempo.dbo.Proyectos WHERE id_proyecto = " . $_POST["proyecto"];
	$cursorIn1 = mssql_query($sqlIn1);
	if($regIn1 = mssql_fetch_array($cursorIn1)){
		$nombreProyecto = ucwords(strtolower($regIn1['nombre']));
	}
	
	$sqlIn2 = " INSERT INTO Proyectos ( idProyecto, etapaProyecto, nombreProyecto, proyectoActivo  ) ";
	$sqlIn2 = $sqlIn2 . " VALUES ( ";
	$sqlIn2 = $sqlIn2 . " " . $_POST["proyecto"] . ", ";
	$sqlIn2 = $sqlIn2 . " " . $_POST["etapa"] . ", ";
	$sqlIn2 = $sqlIn2 . " '" . $nombreProyecto . "', ";
	$sqlIn2 = $sqlIn2 . " '1' ";
	$sqlIn2 = $sqlIn2 . " ) ";
	$cursorIn2 = mssql_query($sqlIn2);
	//echo $sqlIn2 . "<br>";
	if(trim($cursorIn2) == ""){
		$okGuardar = "No";
	}
	
	if($okGuardar == "Si"){
		$cursorTran2 = mssql_query(" COMMIT TRANSACTION ");
		echo "<script>alert('La grabación se realizó con éxito')</script>";
	} else {
		$cursorTran2 = mssql_query(" ROLLBACK TRANSACTION ");
		echo "<script>alert('Error en la grabación')</script>";
	}
	echo ("<script>window.close();MM_openBrWindow('frmProyectos.php','winAdminPHS','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");
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
//-->
</script>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="TituloTabla">
		<td>.: Sistema de Administraci&oacute;n - Proyectos :.</td>
  </tr>
	
	<tr>
	  <td>
	  <form action="" method="post" name="form1">
	  <table width="100%" cellspacing="1">
        <tr>
          <td width="25%" class="TituloTabla2">Nombre del Proyecto </td>
          <td class="TxtTabla"><select name="proyecto" class="CajaTexto" id="proyecto">
		  <? while($reg1 = mssql_fetch_array($cursor1)){ ?>
		  	<option value="<? echo $reg1['id_proyecto']; ?>"><? echo ucwords(strtolower($reg1['nombre'])); ?></option>
		  <? } ?>
          </select></td>
        </tr>

        <tr>
          <td colspan="2" align="right">
		  <input name="recarga" type="hidden" id="recarga" value="1" />
		  <input name="etapa" type="hidden" id="etapa" value="1" />
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
