<?php
session_start();

$fecha = date('Y-m-d');

echo "<head>";
header("Content-Type: application/ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Disposition: attachment; filename=Formato_Listado_Maestro_Documentos_" . $fecha . ".xls");
echo "</head>";

//Validación de ingreso
include("../verificaIngreso1.php");

//Conexión a la Base de Datos
include("../enlaceBD.php");
$conexion = conectar();

//Recupera Los datos de la búsqueda
$lstTematica = $_GET['t'];
$lstLote = $_GET['l'];
$lstRev = $_GET['r'];
$nombrePlano = $_GET['n'];
$descrPlano = $_GET['d'];
echo "tema".$lstTematica."<br>";
echo "lota".$lstLote."<br>";
echo "rev".$lstRev."<br>";
echo "nomb".$nombrePlano."<br>";
echo "desc".$descrPlano."<br>";

$sql_proy="select nombreProyecto from Proyectos where idProyecto=".$_SESSION["phsProyecto"];
$cur_proy=mssql_query($sql_proy);
if($datos_proy=mssql_fetch_array($cur_proy))
{
	$nom_proyect=$datos_proy[nombreProyecto];
}

//Búsqueda de los registros
$sqlA = " SELECT  A.idTematicaPadre, A.nombreTematica, B.numeroLote, B.nombreLote, 
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
if($lstTematica){
	$sqlA = $sqlA . " AND A.idTematica = " . $lstTematica . " ";
}
//Lotes
if($lstLote){
	$sqlA = $sqlA . " AND B.idLote = " . $lstLote . " ";
}
//Revisiones
if($lstRev){
	//$sqlA = $sqlA . " AND D.numeroRevision = " . $lstRev . " ";
	//$sqlA = $sqlA . " AND E.letraRevisionInterna = '" . $lstRev . "' ";
	$sqlA = $sqlA . " AND D.idRevisionInterna = '" . $lstRev . "' ";
} 

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

//Ordenamiento
$sqlA = $sqlA . " AND D.archivoDWG NOT LIKE '%.DWG'
				  ORDER BY A.idTematicaPadre ";
//FIN BÚSQUEDA


$cursorA = mssql_query($sqlA);
//echo $sqlA;
//echo ("<script>window.close();</script>");


?>

<html>
<head>
<title>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="http://www.ingetec.com.co/enlinea/mitu/css/estilo.css" TYPE="text/css">
<style type="text/css">
<!--
.Estilo2 {font-size: 8}
-->
</style>
</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="100%"  border="1" cellspacing="1">
  <tr>
    <td align="center" valign="middle" class="LetraIngetecForm Estilo3" width="145" height="49"><div align="center"><img src="http://www.ingetec.com.co/NuevaHojaTiempo/imagenes/logoIngetec.gif" width="140" height="49" align="absmiddle"></div></td>
    <td colspan="5" align="center" valign="middle" class="TituloFormato"><img src="http://www.ingetec.com.co/enlinea/mitu/images/ListaDocs.GIF" width="418" height="19" align="absmiddle"></td>
    <td colspan="2" align="center" valign="middle" class="LetraFormato">Formato PS2-1/2<br>
		<span class="Estilo2">(Rev. 1 – 2009-08-24)</span><br>
	Hoja ____ de ____</td>
  </tr>
  <tr>
    <td colspan="9" class="LetraFormato"><div align="left">Proyecto: <?php  echo strtoupper($nom_proyect); ?></div></td>
  </tr>
  
  <tr align="center" valign="middle">
    <td rowspan="2"><strong>CONSECUTIVO</strong></td>
    <td colspan="2"><strong>DOCUMENTO</strong></td>
    <td rowspan="2"><strong>REVISI&Oacute;N<br>
    No. </strong></td>
    <td rowspan="2"><strong>FECHA DE <br>
  APROBACI&Oacute;N </strong></td>
    <td rowspan="2"><strong>ORIGEN</strong></td>
    <td colspan="2"><strong>DEVOLUTIVO</strong></td>
    <td rowspan="2"><strong>OBSERVACIONES</strong></td>
  </tr>
  <tr>
    <td align="center" valign="middle"><strong>IDENTIFICACI&Oacute;N</strong></td>
    <td align="center" valign="middle"><strong>T&Iacute;TULO</strong></td>
    <td align="center" valign="middle"><strong>SI</strong></td>
    <td align="center" valign="middle"><strong>NO</strong></td>
  </tr>  
  <? while($regA = mssql_fetch_array($cursorA)){ ?>
  <tr>
    <td><? echo $regA[idPlano]; ?></td>
    <td><? echo $regA[numeroPlano]; ?></td>
    <td><? echo $regA[descripcionPlano]; ?></td>
    <td><? echo $regA[letraRevisionInterna]; ?></td>
    <td><? echo date("d/m/Y", strtotime($regA[fechaRevision])); ?></td>
    <td><? echo $regA[nombreOriginaMod]; ?></td>
    <td align="center">&nbsp;</td>
    <td align="center">X</td>
    <td>&nbsp;</td>
  </tr>
  <? } ?>
</table>

</body>
</html>