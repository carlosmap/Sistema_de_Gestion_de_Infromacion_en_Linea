<?php
/*
20091215
Daniel Felipe Renteria Martínez
Menú Administración P.H. Sogamoso: Usuarios
*/

//Inicializa las variables de sesión
session_start();

//Validación de ingreso
include("../verificaIngreso2.php");

//Conexión a la Base de Datos
include("../enlaceBD.php");
$conexion = conectar();

//Trae la información de la clasificación de perfiles

$sql1 ="SELECT * FROM Perfiles WHERE relativoA = '1' ";
$sql1 = $sql1 . " ORDER BY idPerfil";
$cursor1 = mssql_query($sql1);

//Trae la información de los usuarios por perfil
$sql2=" SELECT U.*, P.nombrePerfil
	FROM Usuarios U, Perfiles P
	WHERE U.idPerfil = P.idPerfil ";
if (trim($claseP) == "") {
	$curIni = mssql_query($sql1);
	$regIni=mssql_fetch_array($curIni);
	$claseP = $regIni['idPerfil'] ;
}
$sql2=$sql2." AND U.idPerfil = '" . $claseP . "' ";
$sql2=$sql2." ORDER BY U.idUsuario ";
$cursor2 = mssql_query($sql2);



?>


<html>
<head>
<title>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript">
<!--
window.name="winAdminPHS";

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
</table>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla">Proyecto Hidroel&eacute;ctrico Sogamoso - Sistema de Administraci&oacute;n </td>
      </tr>
    </table>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    <table width="60%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="TituloTabla">Criterios de consulta </td>
          </tr>
        </table>
         
         
          <table width="100%"  border="0" cellspacing="1" cellpadding="0">
		   <form name="form1" method="post" action="">
            <tr>
              <td width="25%" class="TituloTabla2">Perfil</td>
              <td class="TxtTabla">
				  <select name="claseP" class="CajaTexto" id="claseP">
					  <? 
					  while ($reg1 = mssql_fetch_array($cursor1)) { 
					  	$selP = "";
					  	if($claseP == $reg1[idPerfil]){
							$selP = "selected"; 
						}
					  ?>
						<option value="<? echo $reg1[idPerfil]; ?>" <? echo $selP; ?>> <? echo $reg1[nombrePerfil]; ?> </option>
					  <? } ?>	
				  </select>
			  </td>
              <td width="5%" class="TxtTabla"><input name="Submit" type="submit" class="Boton" value="Consultar"></td>
            </tr>
			 </form>
            <tr>
              <td width="25%">&nbsp;</td>
              <td>&nbsp;</td>
              <td width="5%">&nbsp;</td>
            </tr>
          </table></td>
      </tr>
    </table>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla2">Usuarios</td>
      </tr>
    </table>
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr class="TituloTabla2">
        <td>Cod.</td>
        <td>Nombres</td>
        <td>Apellidos</td>
        <td>Usuario</td>
        <td>Clave</td>
        <td>Estado</td>
        <td>Perfil</td>
        <td width="1%">&nbsp;</td>
        </tr>
	  <?php while ($reg2=mssql_fetch_array($cursor2)) { ?>
      <tr class="TxtTabla">
        <td><?php echo $reg2[idUsuario] ?></td>
        <td><?php echo $reg2[nombreUsuario] ?></td>
        <td><?php echo $reg2[apellidoUsuario] ?></td>
        <td><?php echo $reg2[loginUsuario] ?></td>
        <td><?php echo $reg2[claveUsuario] ?></td>
        <td>
			<?php 
				if(trim($reg2[esActivo]) == "1"){
					$estado = "Activo";
				}
				else{
					$estado = "Inactivo";
				}
				echo $estado;
			 ?>		</td>
        <td><?php echo $reg2[nombrePerfil] ?></td>
        <td width="1%"><a href="#"><img src="../images/up.jpg" alt="Editar" width="19" height="17" border="0" onClick="MM_openBrWindow('upUsuarios.php?cualUsuario=<? echo $reg2[idUsuario] ?>','','width=800,height=400')" ></a></td>
        </tr>
	  <?php } ?>
    </table>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right"><input name="Submit2" type="button" class="Boton" onClick="MM_openBrWindow('addUsuarios.php','','width=800,height=400')" value="Nuevo"></td>
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
