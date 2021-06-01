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

// Lotes de Trabajo [Combo]
$sql3a = " SELECT * FROM LotesTrabajo WHERE idProyecto = " . $_SESSION["phsProyecto"];
$sql3a = $sql3a . " AND etapaProyecto = " . $_SESSION["phsEtapa"];
$sql3a = $sql3a . " AND idTematica = " . $_SESSION["phsTematica"];
$cursor3a = mssql_query($sql3a);
if(isset($loteTrabajo) == false){
	$cursor3ini = mssql_query($sql3a);
	$reg3ini = mssql_fetch_array($cursor3ini);
	$loteTrabajo = $reg3ini['idLote'];
}

// Lotes de Trabajo
$sql3 = " SELECT * FROM LotesTrabajo WHERE idProyecto = " . $_SESSION["phsProyecto"];
$sql3 = $sql3 . " AND etapaProyecto = " . $_SESSION["phsEtapa"];
$sql3 = $sql3 . " AND idTematica = " . $_SESSION["phsTematica"];
$sql3 = $sql3 . " AND idLote = " . $loteTrabajo;
$cursor3 = mssql_query($sql3);

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

<table width="1024" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#276074">
  <tr>
    <td><table width="1024" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include ("bannerPlanos.php");?></td>
      </tr>
    </table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr class="TituloTabla">
    <td>Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td><table width="60%" cellspacing="1">
	<form name="form1" method="post" action="">
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
        <td class="TituloTabla2">Lote de Trabajo: </td>
        <td class="TxtTabla">
          <select name="loteTrabajo" class="CajaTexto" id="loteTrabajo">
		  <? 
		  while($reg3a = mssql_fetch_array($cursor3a)){
		  	$optLT = "";
			if($loteTrabajo == $reg3a['idLote']){
				$optLT = "selected";
			}
		  ?>
		  <option value="<? echo $reg3a['idLote']; ?>" <? echo $optLT; ?>><? echo $reg3a['numeroLote'] . " - " . $reg3a['nombreLote']; ?></option>
		  <? } ?>
          </select>
        </td>
      </tr>
      <tr align="right">
        <td colspan="2" class="TxtTabla"><input name="Submit3" type="submit" class="Boton" value="Consultar"></td>
        </tr>
	  </form>
    </table> </td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
  </tr>
  <tr align="center" class="TituloTabla">
    <td align="left">::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea - Lotes y Documentos :::</td>
  </tr>
  <tr align="center">
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td><table width="100%" cellspacing="1">
	<? while($reg3 = mssql_fetch_array($cursor3)){ ?>
      <tr>
        <td width="25%" class="TituloTabla2">Lote de Trabajo: </td>
        <td class="TxtTabla"><span class="menu2"><? echo $reg3['numeroLote'] . " - " . $reg3['nombreLote']; ?></span></td>
        <td width="1%" class="TxtTabla">
		<? if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3 or $_SESSION["phsPerfil"] == 4){ ?>
		<a href="#"><img src="../images/up.jpg" alt="Editar Lote" width="19" height="17" border="0" onClick="MM_openBrWindow('upLotesTrabajo.php?cualLote=<? echo $reg3['idLote']; ?>','','scrollbars=yes,resizable=yes,width=800,height=200')"></a>
		<? } ?>
		</td>
        <td width="1%" class="TxtTabla">
		<? if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3 )//or $_SESSION["phsPerfil"] == 4)
		{ ?>
		<a href="#"><img src="../images/del.gif" alt="Eliminar Lote" width="14" height="13" border="0" onClick="MM_openBrWindow('delLotesTrabajo.php?cualLote=<? echo $reg3['idLote']; ?>','','scrollbars=yes,resizable=yes,width=800,height=200')"></a>
		<? } ?>		</td>
      </tr>
      <tr>
        <td colspan="4" class="fondo">
		<?
		//Planos
		$sql4 = " SELECT * FROM Planos WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
		$sql4 = $sql4 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
		$sql4 = $sql4 . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
		$sql4 = $sql4 . " AND idLote = " . $reg3['idLote'] . " ";
		$cursor4 = mssql_query($sql4);
		?>
		<table width="100%" cellspacing="1">
          <tr class="TituloTabla2">
            <td>Id. Documento </td>
            <td>Documento No. </td>
            <td>Descripci&oacute;n</td>
            <td>Archivo PDF </td>
            <td>Archivo Fuente </td>
            <td>Hist&oacute;rico de Revisiones</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
		  <? while($reg4 = mssql_fetch_array($cursor4)){ ?>
          <tr class="TxtTabla">
            <td align="center"><? echo $reg4['idPlano']; ?></td>
            <td><? echo $reg4['numeroPlano']; ?></td>
            <td><? echo $reg4['descripcionPlano']; ?></td>
			<?
				//Trae el número de Última Revisión, para mostrar los archivos PDF y DWG
				$sql5 = " SELECT MAX(A.numeroRevision) AS elMax, A.archivoPDF, A.archivoDWG, B.letraRevisionInterna
				FROM Revisiones A, ConsRevisionesInternas B
				WHERE A.idRevisionInterna = B.idRevisionInterna ";
				$sql5 = $sql5 . " AND A.idProyecto = " . $_SESSION["phsProyecto"] . " ";
				$sql5 = $sql5 . " AND A.etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
				$sql5 = $sql5 . " AND A.idTematica = " . $_SESSION["phsTematica"] . " ";
				$sql5 = $sql5 . " AND A.idLote = " . $reg3['idLote'] . " ";
				$sql5 = $sql5 . " AND A.idPlano = " . $reg4['idPlano'] . " ";
				$sql5 = $sql5 . " GROUP BY A.archivoPDF, A.archivoDWG, B.letraRevisionInterna ORDER BY elMax DESC ";
				$cursor5 = mssql_query($sql5);
				if($reg5 = mssql_fetch_array($cursor5)){
					if($_SESSION["phsTematica"] == $_SESSION["phsTematicaPadre"]){
						$pathPDF = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematica"]."/".$reg3['idLote']."/".$reg4['numeroPlano']."/R".$reg5['letraRevisionInterna']."/".$reg5['archivoPDF'];
						$pathDWG = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematica"]."/".$reg3['idLote']."/".$reg4['numeroPlano']."/R".$reg5['letraRevisionInterna']."/".$reg5['archivoDWG'];
					}
					else{
						$pathPDF = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"]."/T".$_SESSION["phsTematica"]."/".$reg3['idLote']."/".$reg4['numeroPlano']."/R".$reg5['letraRevisionInterna']."/".$reg5['archivoPDF'];
						$pathDWG = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"]."/T".$_SESSION["phsTematica"]."/".$reg3['idLote']."/".$reg4['numeroPlano']."/R".$reg5['letraRevisionInterna']."/".$reg5['archivoDWG'];
					}
				}
			?>
            <td align="center"><a href="#"><img src="../images/icoPDF.gif" alt="Archivo PDF" width="18" height="18" border="0" onClick="MM_openBrWindow('<? echo $pathPDF; ?>','','scrollbars=yes,resizable=yes,width=800,height=600')"></a></td>
            <td align="center"><a href="#"><img src="../images/icoDWG.gif" alt="Archivo DWG" width="18" height="18" border="0" onClick="MM_openBrWindow('<? echo $pathDWG; ?>','','scrollbars=yes,resizable=yes,width=800,height=600')"></a></td>
            <td align="center"><a href="#" onClick="MM_goToURL('parent','cargaRevPlanos.php?cualLote=<? echo $reg3['idLote']; ?>&amp;cualPlano=<? echo $reg4['idPlano']; ?>');return document.MM_returnValue"><img src="../images/imgRevision.gif" alt="Ver Historial de Revisiones" width="19" height="20" border="0"></a>              </td>
            <td width="1%">
			<? if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3 or $_SESSION["phsPerfil"] == 4){ ?>
			<a href="#"><img src="../images/up.jpg" alt="Editar Documento" width="19" height="17" border="0" onClick="MM_openBrWindow('upPlanos.php?cualLote=<? echo $reg3['idLote']; ?>&cualPlano=<? echo $reg4['idPlano']; ?>','','scrollbars=yes,resizable=yes,width=800,height=200')"></a>
			<? } ?>
			</td>
            <td width="1%">
			<? if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3 or $_SESSION["phsPerfil"] == 4){ ?>
			<a href="#"><img src="../images/del.gif" alt="Eliminar Documento" width="14" height="13" border="0" onClick="MM_openBrWindow('delPlanos.php?cualLote=<? echo $reg3['idLote']; ?>&cualPlano=<? echo $reg4['idPlano']; ?>','','scrollbars=yes,resizable=yes,width=800,height=200')"></a>
			<? } ?>
			</td>
          </tr>
		  <? } ?>
          <tr class="TxtTabla">
            <td colspan="8" align="right">
			<? if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3 or $_SESSION["phsPerfil"] == 4){ ?>
			<input name="Submit2" type="button" class="Boton" onClick="MM_openBrWindow('addPlanos.php?cualLote=<? echo $reg3['idLote']; ?>','','scrollbars=yes,resizable=yes,width=800,height=400')" value="Agregar">
			<? } ?>
			</td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4" class="fondo">&nbsp;</td>
        </tr>
	  <? } ?>
      <tr align="center">
        <td colspan="4" align="right">
		<? if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3 or $_SESSION["phsPerfil"] == 4){ ?>
		<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addLotesTrabajo.php','','scrollbars=yes,resizable=yes,width=800,height=200')" value="Nuevo Lote de Trabajo">
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

</body>
</html>
