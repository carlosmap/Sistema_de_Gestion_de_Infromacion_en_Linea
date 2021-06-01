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

//Datos de Parámetro: Proyecto
$sqlPar = " SELECT * FROM Proyectos WHERE idProyecto = " . $_GET["cualProyecto"];
$cursorPar = mssql_query($sqlPar);
if(isset($recarga) == false){
	if($regPar = mssql_fetch_array($cursorPar)){
		$nombreProyecto = $regPar['nombreProyecto'];
		$proyectoActivo = $regPar['proyectoActivo'];
	}
}

//Guardado de Datos
if($_POST["recarga"] == 1){
	
	$okGuardar = "Si";
	
	$cursorTran1 = mssql_query("BEGIN TRANSACTION");
	if(trim($cursorTran1) == ""){
		$okGuardar = "No";
	}
	
	$sqlIn1 = " UPDATE Proyectos SET ";
	$sqlIn1 = $sqlIn1 . " proyectoActivo = '" . $_POST["proyectoActivo"] ."' ";
	$sqlIn1 = $sqlIn1 . " WHERE idProyecto = " . $_GET["cualProyecto"] ." ";
	$sqlIn1 = $sqlIn1 . " AND etapaProyecto = " . $_POST["etapa"] ." ";
	$cursorIn1 = mssql_query($sqlIn1);
	//echo $sqlIn1 . "<br>";
	if(trim($cursorIn1) == ""){
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
		<td>.: Sistema de Administraci&oacute;n - Proyectos :.</td>
  </tr>
	
	<tr>
	  <td>
	  <form action="" method="post" name="form1" onSubmit="MM_validateForm('nombrePerfil','','R','etapa','','RisNum');return document.MM_returnValue">
	  <table width="100%" cellspacing="1">
        <tr>
          <td width="25%" class="TituloTabla2">Nombre del Proyecto </td>
          <td class="TxtTabla"><? echo $nombreProyecto; ?></td>
        </tr>
        <tr>
          <td class="TituloTabla2">Estado del Proyecto </td>
          <td class="TxtTabla">
		  <?
		  $optS = "";
		  $optN = "";
		  if($proyectoActivo == 1){
		  	$optS = "selected";
		  } else {
		  	$optN = "selected";
		  }
		  ?>
		  <select name="proyectoActivo" class="CajaTexto" id="proyectoActivo">
            <option value="1" <? echo $optS; ?>>Activo</option>
            <option value="0" <? echo $optN; ?>>Inactivo</option>
          </select></td>
        </tr>

        <tr>
          <td colspan="2" align="right"><input name="recarga" type="hidden" id="recarga" value="1" />
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
