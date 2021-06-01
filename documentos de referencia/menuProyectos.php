<?php
/*
20091214
Patricia Barón Manrique
Menú Administración La Vegona
*/

//Inicializa las variables de sesión
session_start();

//Validación de ingreso
include("../verificaIngreso1.php");

//Conexión a la Base de Datos
include("../enlaceBD.php");
$conexion = conectar();

//Proyectos
$sql1 = " SELECT * FROM Proyectos WHERE proyectoActivo = '1' ";
if($_SESSION["phlvPerfil"] != 1){
	$sql1 = $sql1 . " AND idProyecto IN ( ";
	$sql1 = $sql1 . " SELECT idProyecto FROM UsuariosVsProyectos WHERE idUsuario = " . $_SESSION["phlvIdUsuario"];
	$sql1 = $sql1 . " ) ";
}
$cursor1 = mssql_query($sql1);


?>


<html>
<head>
<title>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript">
window.name="winSogamoso";
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
        <td><?php include ("bannerProyectos.php");?></td>
      </tr>
    </table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr class="TituloTabla">
    <td>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea - Proyectos </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td><table width="60%" cellspacing="1">
      <tr class="TituloTabla2">
        <td>Proyectos Activos </td>
        </tr>
	<? while($reg1 = mssql_fetch_array($cursor1)){ ?>
      <tr align="center">
        <td height="25" class="TxtTabla"><a href="cargaProyecto.php?cualProyecto=<? echo $reg1[idProyecto] ?>" class="menu2"><? echo $reg1[nombreProyecto]; ?></a></td>
        </tr>
	<? } ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr class="copyr">
    <td>INGETEC S.A. &copy; 2011 - Departamento de Sistemas </td>
  </tr>
</table>
</table>

</body>
</html>
