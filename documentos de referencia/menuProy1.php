<?php
	session_start();
	$_SESSION["sesUnidadUsuario"] = "";
	$_SESSION["sesNomApeUsuario"] = "";
	$_SESSION["nombreempleado"] = "";
	$_SESSION["apellidoempleado"] = "";
	$_SESSION["sesPerfilUsuario"] = "";
?>

<html>
<head>
<title>::: INGETEC S.A. :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include ("bannerArribaExt.php");?></td>
  </tr>
</table>

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
	<table width="278" height="132"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td >
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="TituloUsuario">Validaci&oacute;n del usuario </td>
            </tr>
            <tr>
              <td><img src="../images/Pixel.gif" width="4" height="4"></td>
            </tr>
          </table>
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
          </table>
		  <table width="80%"  border="0" cellspacing="1" cellpadding="0">
		  <form name="formulario" action="index.php" method="post">
        <tr>
          <td width="30%" align="right" class="Encuesta">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td width="30%" align="right" class="Encuesta">Login:&nbsp;</td>
          <td><input name="lg" type="text" class="CajaTexto" id="lg" size="17"></td>
        </tr>
        <tr>
          <td width="30%" align="right" class="Encuesta">&nbsp;</td>
          <td width="30%" align="right" class="Encuesta">Password:&nbsp;</td>
          <td><input name="pass" type="password" class="CajaTexto" id="pass" size="17"></td>
        </tr>
        <tr align="right">
          <td colspan="3" ><input name="Submit" type="submit" class="Boton" value="Ingresar"></td>
          </tr>
        <tr align="right">
          <td colspan="3" class="Encuesta" >&nbsp;</td>
          </tr>
		  <input type="hidden" name="accion" value="seguir">
          </form>
    </table>		  
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td height="5" class="TituloUsuario"> </td>
            </tr>
          </table></td>
        </tr>
      </table>
	</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="Encuesta"><strong>Certificado de Gesti&oacute;n de la calidad <br>
      ISO  900 1:2008<br>
      NTC-ISO 900 1:2008<br>
      OHSAS 18001<br>
      ISO 14001
    </strong></td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" valign="bottom">&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;           <img src="images/logoIQNet2.gif" width="72" height="72">&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<img src="images/logoISO2.png" width="72" height="123">&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<img src="images/LogoOHSAS18001.gif" width="75" height="123">&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<img src="images/LogoISO14001.gif" width="75" height="123"></td>
        </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="copyr"> powered by INGETEC S.A - 2011</td>
  </tr>
</table>
</body>
</html>

<?php

if($accion == "seguir"){

echo $accion;

$ptUsr = $_POST['lg'];
$ptPwd = $_POST['pass'];
			
//****Crear la sesión para la unidad del usuario y el perfil asignado
include('../conectaBD.php');

//Establecer la conexión a la base de datos
$conexion = conectar();

//Variable para determinar si el usuario se encuentra registrado como interno o como externo
$estaRegistrado = "No";

/*
Redirecciona de acuerdo a si el usuario existe o no
*/

//Busca al Cliente en caso que sea Externo EN LA BASE DE CLIENTES DE LABORATORIO
$sql3 = " SELECT * FROM ClientesLaboratorio ";
$sql3 = $sql3 . " WHERE nomUsuario = '" . $ptUsr ."' ";
$sql3 = $sql3 . " AND pswUsuario = '" . $ptPwd . "' ";
$sql3 = $sql3 . " AND estado = 'A' ";

$cursor3 = mssql_query($sql3);
if($reg3 = mssql_fetch_array($cursor3)){

	$_SESSION["sesUnidadUsuario"] = $reg3[unidadCliente];
	$_SESSION["sesNomApeUsuario"] = $reg3[nombre] . " " . $reg3[apellidos];
	//encuentra el nombre del paisano
	$_SESSION["nombreempleado"] = $reg3[nombre];
	$_SESSION["apellidoempleado"] = $reg3[apellidos];
	//Almacenar el login y password del usuario
//	$_SESSION["sesLoginUsuario"] = $ptUsr;
//	$_SESSION["sesPassUsuario"] = $ptPwd;

	$estaRegistrado = "Si";
}
else{
	$estaRegistrado = "No";
}

if($estaRegistrado == "Si"){
	echo "<script language=\"JavaScript\">";
	echo "location.href=\"sisLabProyectosExt.php\"";
	echo "</script>";
} else { 
	echo "<script>alert('No es posible autenticar, favor revisar usuario y clave !');</script>";
	echo "<SCRIPT LANGUAGE=\"JavaScript\">";
	echo "location.href=\"index.php\"";
	echo "</SCRIPT>";
}

}

?>