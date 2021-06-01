<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?php
/*
2010-11-10
Daniel Felipe Rentería Martínez
Menú Administración PH Sogamoso: Usuarios por Proyectos
*/

//Inicializa las variables de sesión
session_start();

//Validación de ingreso
include("../verificaIngreso2.php");

//Abre la conexión a la BD
include('../enlaceBD.php');

//Establecer la conexión a la base de datos
$conexion = conectar();

//Datos del Proyecto
$sql1 = " SELECT * FROM Proyectos WHERE idProyecto = " . $cualProyecto;
$cursor1 = mssql_query($sql1);
if($reg1 = mssql_fetch_array($cursor1)){
	$nombreProyecto = $reg1['nombreProyecto'];
	$etapaProyecto = $reg1['etapaProyecto'];
}

//Usuarios
$sql2 = " SELECT A.*, B.idPerfil AS perfilProyecto
FROM Usuarios A, UsuariosVsProyectos B
WHERE A.idUsuario = B.idUsuario ";
$sql2 = $sql2 . " AND A.idUsuario = " . $cualUsuario;
$sql2 = $sql2 . " AND B.idProyecto = " . $cualProyecto;
$cursor2 = mssql_query($sql2);
if($reg2 = mssql_fetch_array($cursor2)){
	$nombreUsuario = ucwords(strtolower($reg2['nombreUsuario'] . " " . $reg2['apellidoUsuario']));
	if(isset($recarga) == false){
		$claseP = $reg2['perfilProyecto'];
	}
}

//Perfiles
$sql3 = " SELECT * FROM Perfiles WHERE relativoA = '2' ";
$cursor3 = mssql_query($sql3);


//Guardado de Datos
if($recarga == 2){

	$okGuardar = "Si";
	
	$cursorTran1 = mssql_query("BEGIN TRANSACTION");
	if(trim($cursorTran1) == ""){
		$okGuardar = "No";
	}
	
	$sqlIn2 = " DELETE FROM UsuariosVsProyectos ";
	$sqlIn2 = $sqlIn2 . " WHERE idProyecto = " . $cualProyecto . " ";
	$sqlIn2 = $sqlIn2 . " AND etapaProyecto = " . $etapaProyecto . " ";
	$sqlIn2 = $sqlIn2 . " AND idUsuario = " . $cualUsuario . " ";
	$cursorIn2 = mssql_query($sqlIn2);
	//echo $sqlIn2 . "<br>";
	if(trim($cursorIn2) == ""){
		$okGuardar = "No";
	}
	
	if($okGuardar == "Si"){
		$cursorTran2 = mssql_query(" COMMIT TRANSACTION ");
		echo "<script>alert('La operación se realizó con éxito')</script>";
	} else {
		$cursorTran2 = mssql_query(" ROLLBACK TRANSACTION ");
		echo "<script>alert('Error en la operación')</script>";
	}
	echo ("<script>window.close();MM_openBrWindow('frmUsuariosProyectos.php?proyecto=" . $cualProyecto . "','winAdminPHS','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");
}

?>


<html>
<head>
<title>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript">
window.name="winAdminPIV";
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<SCRIPT language=JavaScript>
<!--


function mOvr(src,clrOver) {
    if (!src.contains(event.fromElement)) {
	  src.style.cursor = 'hand';
	  src.bgColor = clrOver;
	}
  }
  function mOut(src,clrIn) {
	if (!src.contains(event.toElement)) {
	  src.style.cursor = 'default';
	  src.bgColor = clrIn;
	}
  }
  function mClk(src) {
    if(event.srcElement.tagName=='TD'){
	  src.children.tags('A')[0].click();
    }
  }
//-->
</SCRIPT>
<SCRIPT language=JavaScript>
<!--
function envia1(){ 
//alert ("Entro a envia 1");
document.form1.recarga.value="1";
document.form1.submit();
}

function envia2(){ 
var v1,v2,v3, v4, i, CantCampos, msg1, msg2, msg3, msg4, mensaje;
v1='s';
v2='s';
v3='s';
v4='s';
msg1 = '';
msg2 = '';
msg3 = '';
msg4 = '';
mensaje = '';

//Valida que el campo Numero de Documento no esté vaciío
if (document.form1.Documento.value == '' ) {
	v1='n';
	msg1 = 'El Número de documento es obligatorio. \n'
}


//Valida que el campo Nombre  no esté vaciío
if (document.form1.Nombre.value == '' ) {
	v2='n';
	msg2 = 'El Nombre es obligatorio. \n'
}

//Valida que el campo Apellido no esté vaciío
if (document.form1.Apellido.value == '' ) {
	v3='n';
	msg3 = 'El Apellido es obligatorio. \n'
}

//Valida que el campo Nombre de Usuario no esté vaciío
if (document.form1.nombreUsuario.value == '' ) {
	v3='n';
	msg3 = 'El Nombre de Usuario es obligatorio. \n'
}

//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	if ((v1=='s') && (v2=='s')  && (v3=='s') && (v4=='s')) {
		document.form1.recarga.value="2";
		document.form1.submit();
	}
	else {
		mensaje = msg1 + msg2 + msg3 + msg4;
		alert (mensaje);
	}
	
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#276074">
  <tr>
    <td><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="TituloTabla">.: Sistema de Administraci&oacute;n - Usuarios :.</td>
          </tr>
        </table>
         
         
          <table width="100%"  border="0" cellspacing="1" cellpadding="0">
		   <form action="" method="post" name="form1">
            <tr>
              <td class="TituloTabla2">Proyecto</td>
              <td class="TxtTabla"><? echo $nombreProyecto; ?></td>
            </tr>
            <tr>
              <td class="TituloTabla2">Usuario</td>
              <td class="TxtTabla"><? echo $nombreUsuario; ?></td>
            </tr>
            <tr>
              <td class="TituloTabla2">Perfil dentro del Proyecto</td>
              <td class="TxtTabla">
			  <select name="claseP" class="CajaTexto" id="claseP" disabled>
                <? 
				while ($reg3 = mssql_fetch_array($cursor3)) { 
					$optP = "";
					if($claseP == $reg3['idPerfil']){
						$optP = "selected";
					}
				?>
                <option value="<? echo $reg3['idPerfil']; ?>" <? echo $optP; ?>><? echo $reg3['nombrePerfil']; ?></option>
                <? } ?>
              </select></td>
            </tr>
            <tr align="center">
              <td colspan="2" class="Vinculos1">&iquest;Est&aacute; seguro que desea eliminar la asociaci&oacute;n de este usuario con el proyecto? </td>
              </tr>
            <tr>
              <td width="25%">&nbsp;</td>
              <td align="right"><input name="recarga" type="hidden" id="recarga" value="2">
                <input name="Submit" type="submit" class="Boton" value="Borrar">
                <input name="Submit2" type="button" class="Boton" onClick="MM_callJS('window.close();')" value="Cancelar"></td>
              </tr>
			  </form>
          </table></td>
      </tr>
    </table>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="copyr">Desarrollado por INGETEC S.A. &copy; 2009 - Departamento de Sistemas </td>
  </tr>
</table>	</td>
  </tr>
</table>

</body>
</html>
