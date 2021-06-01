<?php
/*
20091214
Daniel Felipe Rentería Martínez
Temáticas
*/

//Inicializa las variables de sesión
session_start();

//Validación de ingreso

include("../verificaIngreso1.php");
include("../enlaceBD.php");

//Conexión a la Base de Datos

$conexion = conectar();

//Proyectos
$sql1 = " SELECT * FROM Proyectos WHERE idProyecto = " . $_SESSION["phsProyecto"] . " AND etapaProyecto = " . $_SESSION["phsEtapa"];
$cursor1 = mssql_query($sql1);
if($reg1 = mssql_fetch_array($cursor1)){
	$nombreProyecto = $reg1[nombreProyecto];
	$etapaProyecto = $reg1[etapaProyecto];
}

//Temáticas
$sql2 = " SELECT * FROM Tematicas WHERE idProyecto = " . $_SESSION["phsProyecto"] . " AND etapaProyecto = " . $_SESSION["phsEtapa"];
$sql2 = $sql2 . " AND idTematicaPadre = idTematica ";
$cursor2 = mssql_query($sql2);



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

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>


</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="1024" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#2E3605">
  <tr>
    <td><table width="1024" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include ("../bannerTematicas.php");?></td>
      </tr>
    </table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr class="TituloTabla">
    <td>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea - Temas ::: </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td><table width="60%" cellspacing="1">

      <tr>
        <td width="25%" class="TituloTabla2">Proyecto:</td>
        <td class="TxtTabla"><div class="menu2"><? echo $nombreProyecto; ?></div></td>
      </tr>
      <tr>
        <td class="TituloTabla2">Buscar Documentos:</td>
        <td class="TxtTabla">
		<input name="Submit3" type="button" class="Boton" onClick="MM_openBrWindow('frmListadoPlanos-1.php','','scrollbars=yes,resizable=yes,width=1024,height=768')" value="Lista de Documentos"></td>
      </tr>
    </table></td>
  </tr>
  <tr align="center">
    <td><table width="60%" cellspacing="1">
      <tr class="TituloTabla2">
        <td width="35%">Temas</td>
        <td colspan="2">Documentos</td>
        <td width="4%">&nbsp;</td>
        <td width="4%">&nbsp;</td>
        <td width="3%" colspan="2">&nbsp;</td>
      </tr>
	<? while($reg2 = mssql_fetch_array($cursor2)){ ?>
      <tr>
        <td class="TxtTabla">-&nbsp;<? echo $reg2['nombreTematica']; ?></td>
        
<?php
			$sql_cant_planos="select COUNT (*) as cant_planos from Planos where idProyecto=".$_SESSION["phsProyecto"]." and etapaProyecto=".$_SESSION["phsEtapa"]." and idTematica=".$reg2['idTematica'];
			$cursor_cant_planos=mssql_query($sql_cant_planos);
//			echo $sql_cant_planos;
			if($dato_cant_plano=mssql_fetch_array($cursor_cant_planos))
			{
				if($dato_cant_plano[cant_planos]==0)
				{
					$cant_plano=" ";
				//	$doc="";
				}
				else
				{
				 	$cant_plano="(".$dato_cant_plano[cant_planos].")";
				//	$doc="Documentos";
				}
			}
			

?>
        
        <td width="23%" align="right" class="TxtTabla" ><a href="#"><img src="../images/Mundo.gif" alt="Ver Lotes y Documentos" width="18" height="20" border="0" onClick="MM_goToURL('parent','cargaPlanos.php?cualTematica=<? echo $reg2['idTematica']; ?>');return document.MM_returnValue"></a></td><td width="31%" align="left" class="TxtTabla"><?php echo $cant_plano ?>  </td>
        

        
        <td align="center" class="TxtTabla">
		<? if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3 or $_SESSION["phsPerfil"] == 4){ ?>
		<a href="#"><img src="../images/imgAddItem.gif" alt="Agregar Subtema" width="20" height="20" border="0" onClick="MM_openBrWindow('addTematicasSub.php?padre=<? echo $reg2['idTematica']; ?>','','scrollbars=yes,resizable=yes,width=800,height=200')"></a>
		<? } ?>		</td>
        <td align="center" class="TxtTabla">
		<? if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3 or $_SESSION["phsPerfil"] == 4){ ?>
		<a href="#"><img src="../images/up.jpg" alt="Editar Tema" width="19" height="17" border="0" onClick="MM_openBrWindow('upTematicas.php?cualTematica=<? echo $reg2['idTematica']; ?>','','scrollbars=yes,resizable=yes,width=800,height=200')"></a>
		<? } ?>
		</td>
        <?php
			//Subtemáticas		
			$sql3 = " SELECT * FROM Tematicas WHERE idTematicaPadre = " . $reg2['idTematica'] . " AND idTematica <> idTematicaPadre ";
			$cursor3 = mssql_query($sql3);
			// con la variable $rows comprobamos que la Tematica no tenga subtematicas
			$rows=mssql_num_rows($cursor3);
		//	echo "<br> Filas: ".$rows."<br>";
			//si el valor es diferente de 0, indica que tiene subtematicas, y no habilita el boton para eliminar la tematica, hasta que se eliminen las subtematicas
			if($rows==0) 
			{
		?>
        
        <td width="3%" align="center" class="TxtTabla">
		<? if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3){ ?>
		<a href="#"><img src="../images/del.gif" alt="Eliminar Tema" width="14" height="13" border="0" onClick="MM_openBrWindow('delTematicas.php?cualTematica=<? echo $reg2['idTematica']; ?>','','scrollbars=yes,resizable=yes,width=800,height=200')"></a>
		<? 
				}
			} 
			else
			{
				echo " <td align='center' class='TxtTabla'></td>";
			}
		?>
		</td>
      </tr>
	  <?
		//Subtemáticas

		while($reg3 = mssql_fetch_array($cursor3)){

			$sql_cant_planos="select COUNT (*) as cant_planos from Planos where idProyecto=".$_SESSION["phsProyecto"]." and etapaProyecto=".$_SESSION["phsEtapa"]." and idTematica=".$reg3['idTematica'];
			$cursor_cant_planos=mssql_query($sql_cant_planos);
		//	echo $sql_cant_planos;
			if($dato_cant_plano=mssql_fetch_array($cursor_cant_planos))
			{
				if($dato_cant_plano[cant_planos]==0)
				{
					$cant_plano=" ";
				//	$doc="";
				}
				else
				{
				 	$cant_plano="(".$dato_cant_plano[cant_planos].")";
				//	$doc="Documentos";
				}				
				 
			}

		?>
      
      <tr>
        <td class="TxtTabla">&nbsp;&nbsp;&nbsp;-&nbsp;<? echo $reg3['nombreTematica']; ?></td>
        <td align="right" class="TxtTabla"><a href="#"><img src="../images/Mundo.gif" alt="Ver Lotes y Documentos" width="18" height="20" border="0" onClick="MM_goToURL('parent','cargaPlanos.php?cualTematica=<? echo $reg3['idTematica']; ?>');return document.MM_returnValue"></a></td><td align="left" class="TxtTabla"><?php echo $cant_plano?> </td>
        <td align="center" class="TxtTabla">&nbsp;</td>
  
        
        <td align="center" class="TxtTabla">
		<? if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3 or $_SESSION["phsPerfil"] == 4){ ?>
		<a href="#"><img src="../images/up.jpg" alt="Editar Subtema" width="19" height="17" border="0" onClick="MM_openBrWindow('upTematicas.php?cualTematica=<? echo $reg3['idTematica']; ?>','','scrollbars=yes,resizable=yes,width=800,height=200')"></a>
		<? } ?>
		</td>
        <td align="center" class="TxtTabla">
		<? if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3){ ?>
		<a href="#"><img src="../images/del.gif" alt="Eliminar Subtema" width="14" height="13" border="0" onClick="MM_openBrWindow('delTematicas.php?cualTematica=<? echo $reg3['idTematica']; ?>','','scrollbars=yes,resizable=yes,width=800,height=200')"></a>
		<? } ?>
		</td>
      </tr>
	  		<? } ?>
		<tr align="center">
        <td height="5" colspan="5" class="fondo"></td>
        </tr>
	  <? } ?>
      <tr align="center">
        <td colspan="5" align="right">
		<? if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3 or $_SESSION["phsPerfil"] == 4){ ?>
		<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addTematicas.php','','scrollbars=yes,resizable=yes,width=800,height=200')" value="Agregar">
		<? } ?>
		</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr class="copyr">
    <td>Desarrollado por INGETEC S.A. &copy; 2009 - Departamento de Sistemas </td>
  </tr>
</table>
</table>
<? mssql_close ($conexion); ?>
</body>
</html>
