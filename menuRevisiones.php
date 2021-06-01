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

//Conexión a la Base de Datos
include("../enlaceBD.php");
$conexion = conectar();

//Proyectos
$sql1 = " SELECT * FROM Proyectos WHERE idProyecto = " . $_SESSION["phsProyecto"] . " AND etapaProyecto = " . $_SESSION["phsEtapa"];
$cursor1 = mssql_query($sql1);
if($reg1 = mssql_fetch_array($cursor1)){
	$nombreProyecto = $reg1[nombreProyecto];
	$etapaProyecto = $reg1[etapaProyecto];
}

//Temáticas
$sql2 = " SELECT * FROM Tematicas WHERE idProyecto = " . $_SESSION["phsProyecto"];
$sql2 = $sql2 . " AND etapaProyecto = " . $_SESSION["phsEtapa"];
$sql2 = $sql2 . " AND idTematica = " . $_SESSION["phsTematica"];
$cursor2 = mssql_query($sql2);
if($reg2 = mssql_fetch_array($cursor2)){
	$nombreTematica = $reg2[nombreTematica];
	if($reg2[idTematica] != $reg2[idTematicaPadre]){
		$sql2a = " SELECT nombreTematica FROM Tematicas WHERE idTematica = " . $reg2[idTematicaPadre];
		$cursor2a = mssql_query($sql2a);
		if($reg2a = mssql_fetch_array($cursor2a)){
			$nombreTemaPadre = $reg2a[nombreTematica];
		}
	}
}

// Lotes de Trabajo
$sql3 = " SELECT * FROM LotesTrabajo WHERE idProyecto = " . $_SESSION["phsProyecto"];
$sql3 = $sql3 . " AND etapaProyecto = " . $_SESSION["phsEtapa"];
$sql3 = $sql3 . " AND idTematica = " . $_SESSION["phsTematica"];
$sql3 = $sql3 . " AND idLote= " . $_SESSION["phsLote"];
$cursor3 = mssql_query($sql3);
if($reg3 = mssql_fetch_array($cursor3)){
	$nombreLote = $reg3[numeroLote] . " - " . $reg3[nombreLote];
}

//Planos
$sql4 = " SELECT * FROM Planos WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
$sql4 = $sql4 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
$sql4 = $sql4 . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
$sql4 = $sql4 . " AND idLote = " . $_SESSION["phsLote"] . " ";
$sql4 = $sql4 . " AND idPlano = " . $_SESSION["phsPlano"] . " ";
$cursor4 = mssql_query($sql4);
if($reg4 = mssql_fetch_array($cursor4)){
	$nombrePlano = $reg4[idPlano] . " - " . $reg4[numeroPlano];
	$numeroPlano = $reg4[numeroPlano];
}

//Revisiones
$sql5 = " SELECT A.*, B.nombreOriginaMod, C.nombreClaseMod, D.letraRevisionInterna
FROM Revisiones A, TipoOriginaModificacion B, TipoClaseModificacion C, ConsRevisionesInternas D
WHERE A.idProyecto = " . $_SESSION["phsProyecto"] . " ";
$sql5 = $sql5 . " AND A.etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
$sql5 = $sql5 . " AND A.idTematica = " . $_SESSION["phsTematica"] . " ";
$sql5 = $sql5 . " AND A.idLote = " . $_SESSION["phsLote"] . " ";
$sql5 = $sql5 . " AND A.idPlano = " . $_SESSION["phsPlano"] . " ";
$sql5 = $sql5 . " AND A.idOriginaMod = B.idOriginaMod ";
$sql5 = $sql5 . " AND A.idClaseMod = C.idClaseMod ";
$sql5 = $sql5 . " AND A.idRevisionInterna = D.idRevisionInterna ";
$cursor5 = mssql_query($sql5);

//Máximo de la Revisión (única que se puede eliminar)
$sql6 = " SELECT MAX(numeroRevision) elMax FROM Revisiones WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
$sql6 = $sql6 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
$sql6 = $sql6 . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
$sql6 = $sql6 . " AND idLote = " . $_SESSION["phsLote"] . " ";
$sql6 = $sql6 . " AND idPlano = " . $_SESSION["phsPlano"] . " ";
$cursor6 = mssql_query($sql6);
if($reg6 = mssql_fetch_array($cursor6)){
	$reviMax = $reg6[elMax];
}


?>


<html>
<head>
<title>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript">
<!--
window.name="winSogamoso";

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
        <td><?php include ("bannerRevisiones.php");?></td>
      </tr>
    </table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr class="TituloTabla">
    <td>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea - Revisiones de Documentos :::</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td><table width="60%" cellspacing="1">

      <tr>
        <td width="25%" class="TituloTabla2">Proyecto:</td>
        <td class="TxtTabla"><span class="menu2"><? echo $nombreProyecto; ?></span></td>
      </tr>
      <tr>
        <td class="TituloTabla2">Tema:</td>
        <td class="TxtTabla"><span class="menu2"><? 
			if(trim($nombreTemaPadre) != ""){
				echo $nombreTemaPadre . " ::: " .$nombreTematica; 
			}
			else{
				echo $nombreTematica; 
			}
		?></span></td>
      </tr>
      <tr>
        <td class="TituloTabla2">Lote de Trabajo:</td>
        <td class="TxtTabla"><span class="menu2"><? echo $nombreLote; ?></span></td>
      </tr>
      <tr>
        <td class="TituloTabla2">Documento:</td>
        <td class="TxtTabla"><span class="menu2"><? echo $nombrePlano; ?></span></td>
      </tr>
    </table> </td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
  </tr>
  <tr align="center" class="TituloTabla">
    <td align="left">::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea - Revisiones de Documentos :::</td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td><table width="100%" cellspacing="1">
      <tr class="TituloTabla2">
        <td rowspan="2">Id.</td>
        <td rowspan="2">N&uacute;mero de Revisi&oacute;n </td>
        <td rowspan="2">Fecha de Revisi&oacute;n </td>
        <td rowspan="2">Documento de Entrega </td>
        <td rowspan="2">Or&iacute;gen de Modicicaci&oacute;n</td>
        <td colspan="2">Descripci&oacute;n de Modificaciones </td>
        <td rowspan="2">Comunicaciones Revisi&oacute;n </td>
        <td rowspan="2">Archivo PDF </td>
        <td rowspan="2">Archivo Fuente </td>
        <td rowspan="2">&nbsp;</td>
        <td rowspan="2">&nbsp;</td>
      </tr>
      <tr class="TituloTabla2">
        <td>Clase</td>
        <td>Descripci&oacute;n</td>
      </tr>
	  <? while($reg5 = mssql_fetch_array($cursor5)){ ?>
      <tr class="TxtTabla">
        <td align="center"><? echo $reg5['idRevision']; ?></td>
        <td align="center">R<? echo $reg5['letraRevisionInterna']; ?></td>
        <td><? echo date("m/d/Y", strtotime($reg5['fechaRevision'])); ?></td>
        <td><? echo $reg5['numeroEntrega']; ?></td>
        <td><? echo $reg5['nombreOriginaMod']; ?></td>
        <td><? echo $reg5['nombreClaseMod']; ?></td>
        <td><? echo $reg5['descripcionModificacion']; ?></td>
        <td align="center"><input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('detalleComunicaciones.php?cualRevision=<? echo $reg5['idRevision']; ?>&n_revision=R<?php echo $reg5['letraRevisionInterna']; ?>','','width=800,height=600')" value="Detalle"></td>
		<?
		if($_SESSION["phsTematica"] == $_SESSION["phsTematicaPadre"]){
			$pathPDF = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematica"]."/".$_SESSION["phsLote"]."/".$numeroPlano."/R".$reg5['letraRevisionInterna']."/".$reg5['archivoPDF'];
			$pathDWG = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematica"]."/".$_SESSION["phsLote"]."/".$numeroPlano."/R".$reg5['letraRevisionInterna']."/".$reg5['archivoDWG'];
		} else {
			$pathPDF = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"] . "/T".$_SESSION["phsTematica"]."/".$_SESSION["phsLote"]."/".$numeroPlano."/R".$reg5['letraRevisionInterna']."/".$reg5['archivoPDF'];
			$pathDWG = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"] . "/T".$_SESSION["phsTematica"]."/".$_SESSION["phsLote"]."/".$numeroPlano."/R".$reg5['letraRevisionInterna']."/".$reg5['archivoDWG'];
		}
		?>
        <td align="center"><a href="#"><img src="../images/icoPDF.gif" width="18" height="18" border="0" onClick="MM_openBrWindow('<? echo $pathPDF; ?>','','width=800,height=600')"></a></td>
        <td align="center"><a href="#"><img src="../images/icoDWG.gif" width="18" height="18" border="0" onClick="MM_openBrWindow('<? echo $pathDWG; ?>','','width=800,height=600')"></a></td>
        <td width="1%">
		<? if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3 or $_SESSION["phsPerfil"] == 4){ ?>
		<a href="#"><img src="../images/up.jpg" width="19" height="17" border="0" onClick="MM_openBrWindow('upRevisiones.php?cualRevision=<? echo $reg5['idRevision']; ?>','','scrollbars=yes,resizable=yes,width=800,height=400')"></a>
		<? } ?>
		</td>		
        <td width="1%">
        <? //echo $reg5['numeroRevision']; 
		if($reg5['numeroRevision']!=1)
		{
		 if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3 or $_SESSION["phsPerfil"] == 4){ ?>
			<? if($reviMax == $reg5['numeroRevision'] && $reg5['numeroRevision'] != 0){ ?>
			<a href="#"><img src="../images/del.gif" width="14" height="13" border="0" onClick="MM_openBrWindow('delRevisiones.php?cualRevision=<? echo $reg5['idRevision']; ?>','','scrollbars=yes,resizable=yes,width=800,height=400')"></a>
			<? } ?>
		<? }		
		}
		
		?>
		</td>
      </tr>
	  <? } ?>
    </table></td>
  </tr>
  <tr>
    <td align="right">
	<? if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3 or $_SESSION["phsPerfil"] == 4){ ?>
	<input name="Submit2" type="button" class="Boton" onClick="MM_openBrWindow('addRevisiones.php','','scrollbars=yes,resizable=yes,width=800,height=400')" value="Agregar">
	<? } ?>
	</td>
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
