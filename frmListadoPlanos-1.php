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

//Paginación

$registrosPorPagina = 20;

if(isset($pagina) == false){
	$pagina = 1;
	$inicio = 0;
}
else{
	$inicio = $registrosPorPagina * ($pagina - 1);
}

//Proyectos
$sql1 = " SELECT * FROM Proyectos WHERE idProyecto = " . $_SESSION["phsProyecto"] . " AND etapaProyecto = " . $_SESSION["phsEtapa"];
$cursoR2 = mssql_query($sql1);
if($reg1 = mssql_fetch_array($cursoR2)){
	$nombreProyecto = $reg1[nombreProyecto];
	$etapaProyecto = $reg1[etapaProyecto];
}

//Temáticas
$sql2 = " SELECT * FROM TEMATICAS WHERE idProyecto = " . $_SESSION["phsProyecto"] . " AND etapaProyecto = " . $_SESSION["phsEtapa"];
$sql2 = $sql2 . " ORDER BY idTematicaPadre, idTematica ";
$cursor2 = mssql_query($sql2);

//Lotes de Trabajo
$sql3 = " SELECT * FROM LotesTrabajo ";
$sql3 = $sql3 . " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
$sql3 = $sql3 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
$sql3 = $sql3 . " AND idTematica = " . $lstTematica . " ";
$cursor3 = mssql_query($sql3);

//Revisiones
$sql4 = " SELECT MAX(numeroRevision) elMax FROM Revisiones ";
$sql4 = $sql4 . " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
$sql4 = $sql4 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
if(isset($lstTematica) && $lstTematica != "0" ){
	$sql4 = $sql4 . " AND idTematica = " . $lstTematica . " ";
}
if(isset($lstLote) && $lstLote!= "0"){
	$sql4 = $sql4 . " AND idLote = " . $lstLote . " ";
}
$cursor4 = mssql_query($sql4);
if($reg4 = mssql_fetch_array($cursor4)){
	$maxRevisiones = $reg4[elMax];
}

//if(trim($recarga) == "2"){
if ((trim($recarga) == "2") OR (trim($recarga) == "")) {
	if ($lstTematica <> $temaAnt) {
		$lstLote = 0;
	}

	$sqlA = " SELECT TOP " . $registrosPorPagina . " A.idTematicaPadre, A.nombreTematica, B.numeroLote, B.nombreLote, 
	C.numeroPlano, C.descripcionPlano, 	D.*, D1.nombreOriginaMod, D2.nombreClaseMod, E.letraRevisionInterna
	FROM Tematicas A, LotesTrabajo B, Planos C, Revisiones D, 
	TipoOriginaModificacion D1, TipoClaseModificacion D2, ConsRevisionesInternas E
	WHERE A.idProyecto = B.idProyecto
	AND A.etapaProyecto = B.etapaProyecto
	AND A.idTematica = B.idTematica
	AND B.idProyecto = C.idProyecto
	AND B.etapaProyecto = C.etapaProyecto
	AND B.idTematica = C.idTematica
	AND B.idLote = C.idLote
	AND C.idProyecto = D.idProyecto
	AND C.etapaProyecto = D.etapaProyecto
	AND C.idTematica = D.idTematica
	AND C.idLote = D.idLote
	AND C.idPlano = D.idPlano 
	AND D.idOriginaMod = D1.idOriginaMod
	AND D.idClaseMod = D2.idClaseMod
	AND D.idRevisionInterna = E.idRevisionInterna ";
	$sqlA = $sqlA . " AND A.idProyecto = " . $_SESSION["phsProyecto"];
	$sqlA = $sqlA . " AND A.etapaProyecto = " . $_SESSION["phsEtapa"];
	
	//Temáticas
	if($lstTematica != 0){
		$sqlA = $sqlA . " AND A.idTematica = " . $lstTematica . " ";
	}
	//Lotes
	if($lstLote != 0){
		$sqlA = $sqlA . " AND B.idLote = " . $lstLote . " ";
	}
	//Revisiones
	if($lstRev != ""){
		//$sqlA = $sqlA . " AND D.numeroRevision = " . $lstRev . " ";
		//$sqlA = $sqlA . " AND E.letraRevisionInterna = '" . $lstRev . "' ";
		$sqlA = $sqlA . " AND D.idRevisionInterna = '" . $lstRev . "' ";
	} 
	/*
	else{
		$sqlA = $sqlA . " AND E.letraRevisionInterna = ( SELECT MAX(numeroRevision) FROM Revisiones WHERE idProyecto = A.idProyecto 
		AND etapaProyecto = A.etapaProyecto AND idTematica = A.idTematica AND idLote = B.idLote ) ";
	}
	*/
	//Nombre o Descripción de Plano
	if(trim($nombrePlano) != "" and trim($descrPlano) == ""){
		$sqlA = $sqlA . " AND C.numeroPlano LIKE '%" . $nombrePlano . "%' ";
	}
	else if(trim($nombrePlano) == "" and trim($descrPlano) != ""){
		$sqlA = $sqlA . " AND C.descripcionPlano LIKE '%" . $descrPlano . "%' ";
	}
	else if(trim($nombrePlano) != "" and trim($descrPlano) != ""){
		$sqlA = $sqlA . " AND ( C.descripcionPlano LIKE '%" . $descrPlano . "%' OR C.numeroPlano LIKE '%" . $nombrePlano . "%' ) ";
	}
	
	//Paginado: Cálculo del Número de Registros
	$sqlB = str_replace(" TOP " . $registrosPorPagina . " ", " ", $sqlA);
	$cursorNumRegs = mssql_query($sqlB);
	$numeroRegistros = mssql_num_rows($cursorNumRegs);
	
	$sqlA = $sqlA . " AND D.idRevision NOT IN ( ";
	$sqlA = $sqlA . " SELECT TOP " . $inicio . " idRevision FROM Revisiones ";
	$sqlA = $sqlA . " WHERE idProyecto = " . $_SESSION["phsProyecto"];
	$sqlA = $sqlA . " AND etapaProyecto = " . $_SESSION["phsEtapa"];
	//Temáticas
	if($lstTematica != 0){
		$sqlA = $sqlA . " AND A.idTematica = " . $lstTematica . " ";
	}
	//Lotes
	if($lstLote != 0){
		$sqlA = $sqlA . " AND B.idLote = " . $lstLote . " ";
	}
	//Revisiones
	if($lstRev != ""){
		//$sqlA = $sqlA . " AND D.numeroRevision = " . $lstRev . " ";
		//$sqlA = $sqlA . " AND E.letraRevisionInterna = '" . $lstRev . "' ";
		$sqlA = $sqlA . " AND D.idRevisionInterna = '" . $lstRev . "' ";
	} 
	/*
	else{
		$sqlA = $sqlA . " AND D.numeroRevision = ( SELECT MAX(numeroRevision) FROM Revisiones WHERE idProyecto = A.idProyecto 
		AND etapaProyecto = A.etapaProyecto AND idTematica = A.idTematica AND idLote = B.idLote ) ";
	}
	*/
	//Nombre o Descripción de Plano
	if(trim($nombrePlano) != "" and trim($descrPlano) == ""){
		$sqlA = $sqlA . " AND C.numeroPlano LIKE '%" . $nombrePlano . "%' ";
	}
	else if(trim($nombrePlano) == "" and trim($descrPlano) != ""){
		$sqlA = $sqlA . " AND C.descripcionPlano LIKE '%" . $descrPlano . "%' ";
	}
	else if(trim($nombrePlano) != "" and trim($descrPlano) != ""){
		$sqlA = $sqlA . " AND ( C.descripcionPlano LIKE '%" . $descrPlano . "%' OR C.numeroPlano LIKE '%" . $nombrePlano . "%' ) ";
	}
	$sqlA = $sqlA . " ) ";
	
	//Ordenamiento
	$sqlA = $sqlA . " ORDER BY A.idTematicaPadre ";
	
	//echo $sqlA . "<br><br>" ;
	/*echo $sqlB . "<br>" ;
	echo $numeroRegistros;
	exit;*/
	
	$cursorA = mssql_query($sqlA);

}

//29Mar2011
//PBM
//Traer las revisiones segun los consecutivos finales
$sql6="select DISTINCT A.idRevisionInterna, B.letraRevisionInterna ";
$sql6=$sql6." from Revisiones A, ConsRevisionesInternas B ";
$sql6=$sql6." where A.idRevisionInterna = B.idRevisionInterna ";
$sql6=$sql6." AND A.idProyecto = "  . $_SESSION["phsProyecto"];
$sql6=$sql6." AND A.etapaProyecto = " . $_SESSION["phsEtapa"];
$cursor6 = mssql_query($sql6);

//echo "Lista=" . $lstTematica . "<br>";
//echo "Anterior=" . $temaAnt . "<br>";
?>


<html>
<head>
<title>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript">
window.name="winSogamoso";
</script>
<script language="javascript">
<!--
function envia1(){
		document.form1.recarga.value = "1";
		document.form1.submit();
	}
	
	function envia2(){
		document.form1.recarga.value = "2";
		document.form1.submit();
	}
	
	function envia3( pagina ){
		document.form1.recarga.value = "2";
		document.form1.pagina.value = pagina;
		document.form1.submit();
	}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#2E3605">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr class="TituloTabla">
    <td>Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea</td>
  </tr>
  
  <tr align="center">
    <td>
	<form action="" method="post" name="form1">
	<table width="70%" cellspacing="1">
      <tr>
        <td width="25%" class="TituloTabla2">Proyecto:</td>
        <td class="TxtTabla"><span class="menu2"><? echo $nombreProyecto; ?></span></td>
      </tr>
      <tr>
        <td class="TituloTabla2">Tema:</td>
        <td class="TxtTabla">
		<select name="lstTematica" class="CajaTexto" id="lstTematica" onChange="envia2()">
			<option value="0"> ::: Todas las Temáticas ::: </option>
		<? 
		while($reg2 = mssql_fetch_array($cursor2)){ 
			$selTema = "";
			if($reg2[idTematica] == $lstTematica){
				$selTema = "selected";
			}
		?>
			<option value="<? echo $reg2[idTematica]; ?>" <? echo $selTema; ?>> <? echo $reg2[nombreTematica]; ?> </option>
		<? } ?>
        </select>        </td>
      </tr>
      <tr>
        <td class="TituloTabla2">Lote de Trabajo: </td>
        <td class="TxtTabla">
		<select name="lstLote" class="CajaTexto" id="lstLote" onChange="envia2()">
			<option value="0"> ::: Todos los Lotes ::: </option>
		<? 
		while($reg3 = mssql_fetch_array($cursor3)){ 
			$selLote = "";
			if($reg3[idLote] == $lstLote){
				$selLote = "selected";
			}
		?>
			<option value="<? echo $reg3[idLote]; ?>" <? echo $selLote; ?>> <? echo $reg3[nombreLote]; ?> </option>
		<? } ?>
        </select>        </td>
      </tr>
      <tr>
        <td class="TituloTabla2">Revision:</td>
        <td class="TxtTabla"><select name="lstRev" class="CajaTexto" id="lstRev" onChange="envia2()" >
			<option value=""> ::: Todos las revisiones ::: </option>
		<? 
		while($reg6 = mssql_fetch_array($cursor6)){ 
			$selRevision = "";
			if($reg6[idRevisionInterna] == $lstRev){
				$selRevision = "selected";
			}
		?>
			<option value="<? echo $reg6[idRevisionInterna]; ?>" <? echo $selRevision; ?>> <? echo $reg6[letraRevisionInterna]; ?> </option>
		<? } ?>
        </select></td>
      </tr>
      <tr>
        <td class="TituloTabla2">Nombre (N&uacute;mero) del Documento:</td>
        <td class="TxtTabla"><input name="nombrePlano" type="text" class="CajaTexto" id="nombrePlano" value="<? echo $nombrePlano; ?>" size="60"></td>
      </tr>
      <tr>
        <td class="TituloTabla2">Descripci&oacute;n de Documento: </td>
        <td class="TxtTabla"><input name="descrPlano" type="text" class="CajaTexto" id="descrPlano" value="<? echo $descrPlano; ?>" size="60"></td>
      </tr>
      <tr>
        <td colspan="2" align="right" class="TxtTabla"><input name="temaAnt" type="hidden" id="temaAnt" value="<? echo $lstTematica; ?>">
        <input name="pagina" type="hidden" id="pagina" value="<? echo $pagina; ?>">
        <input name="recarga" type="hidden" id="recarga" value="1">
          <input name="Submit" type="button" class="Boton" onClick="envia2()" value="Consultar">
          <input name="Submit2" type="button" class="Boton" onClick="MM_callJS('window.close()')" value="Cerrar Ventana">
          <? //if ($_SESSION["phsIdUsuario"] == 11) { ?>
		  <input name="Submit3" type="button" class="Boton" onClick="MM_openBrWindow('frmListadoPlanos-1rpt1.php?t=<?=$_REQUEST['lstTematica'];?>&l=<?=$_REQUEST['lstLote'];?>&r=<?=$_REQUEST['lstRev'];?>&n=<?=$_REQUEST['nombrePlano'];?>&d=<?=$_REQUEST['descrPlano'];?>','wRPT1','scrollbars=yes,resizable=yes,width=500,height=400')" value="XLS planos">
		  <input name="Submit3" type="button" class="Boton" onClick="MM_openBrWindow('frmListadoPlanos-1rpt2.php?t=<?=$_REQUEST['lstTematica'];?>&l=<?=$_REQUEST['lstLote'];?>&r=<?=$_REQUEST['lstRev'];?>&n=<?=$_REQUEST['nombrePlano'];?>&d=<?=$_REQUEST['descrPlano'];?>','wRPT2','scrollbars=yes,resizable=yes,width=500,height=400')" value="XLS documentos">

		  <? //} ?>		  </td>
        </tr>
    </table>
	</form>	</td>
  </tr>
  
  
  <tr align="center">
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td><table width="100%" cellspacing="1">
      <tr class="TituloTabla2">
        <td rowspan="2">Tem&aacute;tica</td>
        <td rowspan="2">Lote de Trabajo </td>
        <td colspan="3">Documentos</td>
        <td colspan="8">Revisiones</td>
        </tr>
      <tr class="TituloTabla2">
        <td>Id.</td>
        <td>Plano No. </td>
        <td>Descripci&oacute;n</td>
        <td width="1%">PDF</td>
        <td width="1%">DWG</td>
        <td>Fecha</td>
        <td>N&uacute;mero</td>
        <td>Comunicaciones</td>
        <td>Documento Entrega </td>
        <td>Items Pago </td>
        <td>Descripci&oacute;n</td>
        </tr>
      <? while($regA = mssql_fetch_array($cursorA)){ ?>
	  <tr class="TxtTabla">
        <td><? echo $regA[nombreTematica]; ?></td>
        <td><? echo $regA[numeroLote] . " - " . $regA[nombreLote]; ?> </td>
        <td><? echo $regA[idPlano]; ?></td>
        <td><? echo $regA[numeroPlano]; ?></td>
        <td><? echo $regA[descripcionPlano]; ?></td>
		<? 
		if($regA[idTematicaPadre] != $regA[idTematica]){
			$path = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$regA[idTematicaPadre]."/T".$regA[idTematica]."/".$regA[idLote]."/".$regA[numeroPlano]."/R".$regA[letraRevisionInterna];
		}
		else{
			$path = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$regA[idTematica]."/".$regA[idLote]."/".$regA[numeroPlano]."/R".$regA[letraRevisionInterna];
		}
		?>
        <td align="center">
		<a href="#"><img src="../images/icoPDF.gif" width="18" height="18" border="0" onClick="MM_openBrWindow('<? echo $path."/".$regA[archivoPDF]; ?>','','width=800,height=600')"></a>		</td>
        <td align="center"><a href="#"><img src="../images/icoDWG.gif" width="18" height="18" border="0" onClick="MM_openBrWindow('<? echo $path."/".$regA[archivoDWG]; ?>','','width=800,height=600')"></a></td>
        <td align="center"><? echo date("d/m/Y", strtotime($regA[fechaRevision])); ?></td>
        <td align="center"><? 
		
		echo $regA[letraRevisionInterna]; 
		// echo $regA[numeroRevision]; 
		?></td>
        <td>
		<?
			//Comunicaciones de la Revisión 
			$sqlA1 = " SELECT * FROM ComunicacionesPorRevision ";
			$sqlA1 = $sqlA1 . " WHERE idProyecto = " . $regA[idProyecto] ." " ;
			$sqlA1 = $sqlA1 . " AND etapaProyecto = " . $regA[etapaProyecto] ." " ;
			$sqlA1 = $sqlA1 . " AND idTematica = " . $regA[idTematica] ." " ;
			$sqlA1 = $sqlA1 . " AND idLote = " . $regA[idLote] ." " ;
			$sqlA1 = $sqlA1 . " AND idPlano = " . $regA[idPlano] ." " ;
			$sqlA1 = $sqlA1 . " AND idRevision = " . $regA[idRevision] ." " ;
			$cursorA1 = mssql_query($sqlA1);
		?>
		<table width="100%" cellspacing="1" class="TxtTabla">
		<? while($regA1 = mssql_fetch_array($cursorA1)){ ?>
          <tr>
            <td><? echo $regA1[descripcionComunicacion]; ?></td>
            <td width="33%" align="center">(<a href="#"><img src="../images/ver.gif" width="16" height="16" border="0" onClick="MM_openBrWindow('<? echo $path."/".$regA1[archivoComunicacion]; ?>','','width=800,height=600')"></a>)</td>
          </tr>
		  <? } ?>
        </table>		</td>
        <td><? echo $regA[numeroEntrega]; ?></td>
        <td><? echo $regA[itemsPago]; ?></td>
        <td><? echo $regA[descripcionModificacion]; ?></td>
        </tr>
		<? } ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr class="TxtTabla">
    <td align="center">
	<?
	//Paginado de la Consulta
	$totalPaginas = ceil($numeroRegistros / $registrosPorPagina);
	//echo $totalPaginas . "  "  . $numeroRegistros . " " . $registrosPorPagina;

	/*for ($p=1; $p<= $totalPaginas; $p++) {
			echo "<a href='frmListadoPlanos-1.php?pagina=" . $p ."&recarga=2' class='menu2'>" . $p . "</a> | ";
	}*/
	
	//Modificado
	for ($p=1; $p<= $totalPaginas; $p++) {
			echo "<a href='#' onClick='envia3($p)' class='menu2'>" . $p . "</a> | ";
	}
	?>	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr class="copyr">
    <td>Desarrollado por INGETEC S.A. &copy; 2011- Departamento de Sistemas </td>
  </tr>
</table>
</table>

</body>
</html>