<?php
/*
20091214
Daniel Felipe Rentería Martínez
Menú Administración PH Sogamoso: Perfiles
*/

//Inicializa las variables de sesión
session_start();

//Validación de ingreso
include("../verificaIngreso2.php");

//Conexión a la Base de Datos
include("../enlaceBD.php");
$conexion = conectar();

//Consulta: Perfiles
$sql1 = " SELECT * FROM Perfiles ";
$cursor1 = mssql_query($sql1);


?>


<html>
<head>
<title>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript">
window.name="winAdminPHS";
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>


</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="1024" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#276074">
  <tr>
    <td><table width="1024" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include ("bannerAdmin2.php");?></td>
      </tr>
    </table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr class="TituloTabla">
    <td>Proyecto Hidroel&eacute;ctrico Sogamoso - Sistema de Administraci&oacute;n </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" cellspacing="1">
      <tr align="center" class="TituloTabla2">
        <td colspan="5">Perfiles</td>
        </tr>
      <tr align="center" class="TituloTabla2">
        <td>Cod.</td>
        <td>Nombre Perfil </td>
        <td>Relativo a </td>
        <td width="1%">&nbsp;</td>
        <td width="1%">&nbsp;</td>
      </tr>
	  <? while($reg1 = mssql_fetch_array($cursor1)){ ?>
      <tr class="TxtTabla">
        <td align="center"><? echo $reg1['idPerfil']; ?></td>
        <td><? echo $reg1['nombrePerfil']; ?></td>
        <td><?
		if($reg1['relativoA'] == "1"){
			echo "Sistema";
		} else {
			echo "Proyectos";
		}
		?></td>
        <td><a href="#"><img src="../images/up.jpg" alt="Editar" width="19" height="17" border="0" onClick="MM_openBrWindow('upPerfiles.php?cualPerfil=<? echo $reg1['idPerfil'] ?>','','width=500,height=280')"></a></td>
        <td><a href="#"><img src="../images/del.gif" alt="Eliminar" width="14" height="13" border="0" onClick="MM_openBrWindow('delPerfiles.php?cualPerfil=<? echo $reg1['idPerfil']; ?>','','width=500,height=280')"></a></td>
      </tr>
      <? } ?>
    </table></td>
  </tr>
  <tr>
    <td align="right"><input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addPerfiles.php','','width=500,height=280')" value="Nuevo Perfil"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr class="copyr">
    <td>Desarrollado por INGETEC S.A. &copy; 2009 - Departamento de Sistemas </td>
  </tr>
</table>
</table>

</body>
</html>
