<?php


//Inicializa las variables de sesión
session_start();

//Validación de ingreso
include("../verificaIngreso2.php");

//Color del menú
$colorOVR = "#B7D2A8";
$ColorOUT = "#42A313";

?>


<html>
<head>
<title>::: Sistema de Gesti&oacute;n de Correspondencia :::</title>
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
        <td><?php include ("bannerAdmin.php");?></td>
      </tr>
    </table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr class="TituloTabla">
    <td> Sistema de Administraci&oacute;n </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" cellspacing="1">
      <tr align="center" class="TituloTabla2">
        <td colspan="2">Usuarios y Seguridad </td>
        </tr>
      <tr align="center" class="TxtTabla">
        <td width="50%" height="25"><a href="frmPerfiles.php" class="menu2">Perfiles de Usuario </a></td>
        <td width="50%"><a href="frmUsuarios.php" class="menu2">Usuarios</a></td>
      </tr>
      <tr align="center">
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr align="center" class="TituloTabla2">
        <td colspan="2">Proyectos y Usuarios</td>
        </tr>
      <tr align="center" class="TxtTabla">
        <td height="25"><a href="frmProyectos.php" class="menu2">Proyectos</a></td>
        <td height="25"><a href="frmUsuariosProyectos.php" class="menu2">Usuarios por Proyectos</a> </td>
      </tr>

<!--
      <tr align="center" class="TxtTabla">
        <td height="25"><a href="frmClaseMod.php" class="menu2">Tipo de Clases de Modificaci&oacute;n</a></td>
        <td height="25"><a href="frmOriginaMod.php" class="menu2">Tipo de Or&iacute;gen de Modificaciones</a></td>
      </tr>
-->

      <tr align="center" class="TxtTabla">
        <td height="25" class="menu2"><a href="frmClienteRemiDesProyecto.php" class="menu2">Entidades y participantes por Proyecto</a></td>
        <td height="25" class="menu2"><a href="frmDocumentoProyecto.php" class="menu2">Tipos de Documento por Proyecto</a></td>
      </tr>
      <tr align="center" class="TxtTabla">
        <td height="25">&nbsp;</td>
        <td height="25">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr class="copyr">
    <td>Desarrollado por INGETEC S.A. &copy; 2014 - Departamento de Sistemas </td>
  </tr>
</table>
</table>

</body>
</html>
