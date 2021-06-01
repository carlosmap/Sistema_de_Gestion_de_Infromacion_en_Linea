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

/*
Información de Proyectos Activos
*/
$sql1 =" SELECT * FROM Proyectos 
WHERE proyectoActivo = '1' ORDER BY nombreProyecto ";
$cursor1 = mssql_query($sql1);
if(isset($proyecto) == false){
	$cursor1ini = mssql_query($sql1);
	$reg1ini = mssql_fetch_array($cursor1ini);
	$proyecto = $reg1ini['idProyecto'];
}

/*
Usuarios Relacionados a los Proyectos
*/
$sql2 = " SELECT A.*, C.nombrePerfil
FROM Usuarios A, UsuariosVsProyectos B, Perfiles C
WHERE A.idUsuario = B.idUsuario
AND B.idPerfil = C.idPerfil
AND B.idProyecto = " . $proyecto;
$sql2 = $sql2 . " ORDER BY C.idPerfil, A.idUsuario ";
$cursor2 = mssql_query($sql2);




?>


<html>
<head>
<title>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript">
<!--
<!--
window.name="winAdminPHS";

//-->

function envia1(){
	document.form1.submit();
}

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
              <td width="25%" class="TituloTabla2">Proyecto</td>
              <td class="TxtTabla">
				  <select name="proyecto" class="CajaTexto" id="proyecto">
					  <? 
					  while ($reg1 = mssql_fetch_array($cursor1)) { 
					  	$selP = "";
					  	if($proyecto == $reg1['idProyecto']){
							$selP = "selected"; 
						}
					  ?>
						<option value="<? echo $reg1['idProyecto'] ?>" <? echo $selP; ?>> <? echo $reg1['nombreProyecto'] ?> </option>
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
        <td>Perfil</td>
        <td width="1%">&nbsp;</td>
        <td width="1%">&nbsp;</td>
        </tr>
	  <? while ($reg2 = mssql_fetch_array($cursor2)) { ?>
      <tr class="TxtTabla">
        <td><? echo $reg2['idUsuario']; ?></td>
        <td><? echo $reg2['nombreUsuario']; ?></td>
        <td><? echo $reg2['apellidoUsuario']; ?></td>
        <td><? echo $reg2['loginUsuario']; ?></td>
        <td><? echo $reg2['nombrePerfil']; ?></td>
        <td width="1%"><a href="#" onClick="MM_openBrWindow('upUsuariosProyectos.php?cualProyecto=<? echo $proyecto; ?>&cualUsuario=<? echo $reg2['idUsuario']; ?>','','scrollbars=yes,resizable=yes,width=600,height=180')"><img src="../images/up.jpg" alt="Editar" width="19" height="17" border="0"></a></td>
        <td width="1%"><a href="#" onClick="MM_openBrWindow('delUsuariosProyectos.php?cualProyecto=<? echo $proyecto; ?>&cualUsuario=<? echo $reg2['idUsuario']; ?>','','scrollbars=yes,resizable=yes,width=600,height=180')"><img src="../images/del.gif" alt="Eliminar" width="14" height="13" border="0" ></a></td>
        </tr>
	  <? } ?>
    </table>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right"><input name="Submit2" type="button" class="Boton" onClick="MM_openBrWindow('addUsuariosProyectos.php?cualProyecto=<? echo $proyecto; ?>','','scrollbars=yes,resizable=yes,width=600,height=180')" value="Asociar Usuarios al Proyecto"></td>
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
