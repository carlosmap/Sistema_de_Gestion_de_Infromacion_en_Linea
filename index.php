<?php
	session_start();
/*	
*/	
?>

<html>
<head>
<title>::: INGETEC S.A. :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="css/estilo.css" TYPE="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="1024" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#2E3605">
<tr>
<td>
<table border="0" align="center" cellpadding="0" cellspacing="0" >

  <tr>
    <td ><?php include ("bannerArriba.php");?></td>
  </tr>
<tr>
	<td>

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
             <!-- <td><img src="../images/Pixel.gif" width="4" height="4"></td> -->
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

</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="Encuesta">&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" valign="bottom"><img src="images/logosCertificados.png" width="368" height="180"></td>
        </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="TituloUsuario" align="center"> powered by INGETEC S.A - 2011</td>
  </tr>
</table>
</td></tr></table>
</td></tr>
</table>
</body>
</html>

<?php

	if($accion == "seguir")
	{

		echo $accion;
		
		$ptUsr = $_POST['lg'];
		$ptPwd = $_POST['pass'];
			
		//****Crear la sesión para la unidad del usuario y el perfil asignado
		include('enlaceBD.php');

		//Establecer la conexión a la base de datos
		$conexion = conectar();
	
		//Variable para determinar si el usuario se encuentra registrado como interno o como externo
		$estaRegistrado = "No";

		/*
			Redirecciona de acuerdo a si el usuario existe o no
		*/

		//Busca al Cliente en caso que sea Externo EN LA BASE DE CLIENTES DE LABORATORIO
		

		$sql3 = " select * from sogamoso.dbo.Usuarios as usuarios 
				  where usuarios.loginUsuario='".$ptUsr."' and usuarios.claveUsuario='".$ptPwd."' and esActivo=1 ";
		$cursor3 = mssql_query($sql3);
		echo mssql_get_last_message();
		if($reg3 = mssql_fetch_array($cursor3))
		{
			$_SESSION["phsNombreUsuario"] = ucwords(strtolower($reg3['nombreUsuario'])) . " " . ucwords(strtolower($reg3['apellidoUsuario'])) ;
			$_SESSION["phsPerfil"] = $reg3['idPerfil'];
			$_SESSION["phsIdUsuario"] = $reg3['idUsuario'];
			$estaRegistrado = "Si";
			
			$_SESSION["phsProyecto"] = "";
			$_SESSION["phsEtapa"] = "";
			$_SESSION["phsTematica"] = "";
			$_SESSION["phsTematicaPadre"] = "";
			$_SESSION["phsLote"] = "";
			$_SESSION["phsPlano"] = "";
		}
		else
		{
			$estaRegistrado = "No";
		}

		if($estaRegistrado == "Si")
		{
			echo "<script language=\"JavaScript\">";
			echo "location.href=\"menuProy.php\"";
			echo "</script>";
		
		} 
	
		else 
		{ 
			echo "<script>alert('No es posible autenticar. Por favor revisar usuario y clave !');</script>";
			echo "<SCRIPT LANGUAGE=\"JavaScript\">";
			echo "location.href=\"index.php\"";
			echo "</SCRIPT>";
		}

	}

?>
<? mssql_close ($conexion); ?>