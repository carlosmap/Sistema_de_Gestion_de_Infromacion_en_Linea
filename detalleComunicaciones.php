<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?
/*
20091215
Daniel Felipe Rentería Martínez
Temáticas
*/

//Inicializa las variables de sesión
session_start();

//Validación de ingreso
include("../verificaIngreso1.php");

//Manejo de Archivos
include("../manejoArchivos.php");

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
	$idplano=$reg4[idPlano];
}

//Revisiones
$sql5 = " SELECT * FROM Revisiones WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
$sql5 = $sql5 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
$sql5 = $sql5 . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
$sql5 = $sql5 . " AND idLote = " . $_SESSION["phsLote"] . " ";
$sql5 = $sql5 . " AND idPlano = " . $_SESSION["phsPlano"] . " ";
$sql5 = $sql5 . " AND idRevision = " . $cualRevision;
$cursor5 = mssql_query($sql5);
if($reg5 = mssql_fetch_array($cursor5)){
	$nombreRevision = "R".$reg5[numeroRevision];

	 //nombre del directorio, en donde se almacenaran las comunicaciones de la revision
	$comunicacion_revision=$n_revision."com";
}
//echo $n_revision."<br>".$nombreRevision."<br>";

//echo $comunicacion_revision."<br>";

//Ruta de Los Archivos
if($_SESSION["phsTematica"] != $_SESSION["phsTematicaPadre"]){
//	$ruta = "/enlinea/gestion/PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"]."/T".$_SESSION["phsTematica"]."/".$_SESSION["phsLote"]."/".$numeroPlano."/".$nombreRevision;
	$ruta = "/enlinea/gestion/PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"]."/T".$_SESSION["phsTematica"]."/".$_SESSION["phsLote"]."/".$numeroPlano."/".$n_revision."/".$comunicacion_revision;

}
else{
//	$ruta = "/enlinea/gestion/PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematica"]."/".$_SESSION["phsLote"]."/".$numeroPlano."/".$nombreRevision;
		$ruta = "/enlinea/gestion/PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematica"]."/".$_SESSION["phsLote"]."/".$numeroPlano."/".$n_revision."/".$comunicacion_revision;

}


	//$path = $path . "/" . $nombreRevision;
	
	/*
 */


//Subida y Grabación de la Comunicación
if(isset($recarga) && trim($recarga) == "1"){



	//Verifica que no exista un archivo de una cominucacion referenciado con el mismo nombre... Si existe... paila !!!
	$sqlComunucacion = " select count(*) AS siHay from ComunicacionesPorRevision where idPlano='".$idplano."' and idProyecto='".$_SESSION["phsProyecto"]."' and idRevision='".$cualRevision."' and archivoComunicacion='".$archivoCom_name."' ";
	$cursorComunucacion = mssql_query($sqlComunucacion);
	if($regComunucacion = mssql_fetch_array($cursorComunucacion)){
		if($regComunucacion[siHay] != 0){
			echo "<script>alert('Ya existe un archivo de una comunicación anterior con el mismo nombre. Por favor verifique')</script>";
			echo "<script>window.close()</script>";
			exit();
		}
	}

//echo "<br>---".$ruta."<br>";
	//Creación del Directorio de la revision
	if(is_dir($_SERVER['DOCUMENT_ROOT'].$ruta) == false){
		if(mkdir($_SERVER['DOCUMENT_ROOT'].$ruta,0777)){
//			echo "Directorio creado con éxito: " . $ruta . "<br>";
		}
		else{
			echo "<script>alert('Error \nNo fué posible crear el Directorio: " . $ruta ."')</script>";
			echo "<script>window.close()</script>";
			exit();
		}
	}

		
	//Carga de Archivo PDF
	//--------------------------------
	//Hace el upload del archivo
	if (trim($archivoCom_name) != "")	{


				$carEspecial = array( 'á', 'é', 'í', 'ó', 'ú', #1
									  'ä', 'ë', 'ï', 'ö', 'ü', #2
									  'à', 'è', 'ì', 'ò', 'ù', #3
									  'â', 'ê', 'î', 'ô', 'û', #4	MAY
									  'Á', 'É', 'Í', 'Ó', 'Ú', #5
									  'Ä', 'Ë', 'Ï', 'Ö', 'Ü', #6
									  'À', 'È', 'Ì', 'Ò', 'Ù', #7
									  'Â', 'Ê', 'Î', 'Ô', 'Û', #8
									  '%', '|', '°', '¬', '"', #9
									  '#', '$', '%', '&', '(', #10
									  ')', '=', '?', '¡',  #11
									  '¿', '+', '{', '}', '[', #12
									  ']', ':', ',', '@', '~', 'ñ', 'Ñ',"'" ,'´'  );

				$remplazar = array( 'a', 'e', 'i', 'o', 'u', #1
									'a', 'e', 'i', 'o', 'u', #2
									'a', 'e', 'i', 'o', 'u', #3
									'a', 'e', 'i', 'o', 'u', #4	MAY
									'A', 'E', 'I', 'O', 'U', #5
									'A', 'E', 'I', 'O', 'U', #6
									'A', 'E', 'I', 'O', 'U', #7
									'A', 'E', 'I', 'O', 'U', #8
									'-', '-', '-', '-', '-', #9
									'-', '-', '-', '-', '-', #10
									'-', '-', '-', '-', '-', #11
									'-', '-', '-',  '-', #12
									'-', '-', '-', '-', '-', 'n', 'N','','' );	

		$archivoCom_name=str_replace($carEspecial,$remplazar,$archivoCom_name);

		$extension = explode(".",$archivoCom_name);
		$num = count($extension)-1;
//		echo "Archivo : ".$archivoCom . "<br>" ;
//		echo "Archivo - Nombre: ".$archivoCom_name . "<br>" ;
//		echo "Archivo - Ruta Completa: ".$_SERVER['DOCUMENT_ROOT'].$ruta."/".$archivoCom_name;
		if (($extension[$num] == "pdf") OR ($extension[$num] == "PDF")) {
			if (!copy($archivoCom, $_SERVER['DOCUMENT_ROOT'].$ruta."/".$archivoCom_name)) {
				$copioarchivoCom = "NO";
	//			echo "Error al copiar el archivo <br>";
			}
			else {
				$copioarchivoCom = "SI";
//				echo "Archivo PDF se copió en el servidor con exito <br>";
			}
		}
		else {
//			echo "El formato de archivo no es valido. Solo .pdf <br>";
		}
	}
	//--------------------------------------	
	
	$cursorTran1 = mssql_query(" BEGIN TRANSACTION ");
	
	$sqlIn1 = " INSERT INTO ComunicacionesPorRevision ( idProyecto, etapaProyecto, idTematica, idLote, idPlano, idRevision, archivoComunicacion, descripcionComunicacion, fechaComunicacion ) ";
	$sqlIn1 = $sqlIn1 .  " VALUES ( ";
	$sqlIn1 = $sqlIn1 .  " " . $_SESSION["phsProyecto"] . ", ";
	$sqlIn1 = $sqlIn1 .  " " . $_SESSION["phsEtapa"] . ", ";
	$sqlIn1 = $sqlIn1 .  " " . $_SESSION["phsTematica"] . ", ";
	$sqlIn1 = $sqlIn1 .  " " . $_SESSION["phsLote"] . ", ";
	$sqlIn1 = $sqlIn1 .  " " . $_SESSION["phsPlano"] . ", ";
	$sqlIn1 = $sqlIn1 .  " " . $cualRevision . ", ";
	$sqlIn1 = $sqlIn1 .  " '" . $archivoCom_name . "', ";
	$sqlIn1 = $sqlIn1 .  " '" . $descrCom . "', ";
	$sqlIn1 = $sqlIn1 .  " '" . $pFecha . "' ";
	$sqlIn1 = $sqlIn1 .  " ) ";
	$cursorIn1 = mssql_query($sqlIn1);
//	echo "<br> $sqlIn1";
//	echo mssql_get_last_message(); 
	if(trim($cursorTran1) != "" && trim($cursorIn1) != "" ){
		$cursorTran2 = mssql_query(" COMMIT TRANSACTION ");
		if(trim($cursorTran2) != ""){
			echo ("<script>alert('Grabación realizada exitosamente.');</script>");
		}
	}
	else{
		$cursorTran2 = mssql_query(" ROLLBACK TRANSACTION ");
		if(trim($cursorTran2) != ""){
			echo ("<script>alert('Error en la grabación.');</script>");
		}
	}
	/*echo ("<script>window.close();MM_openBrWindow('menuRevisiones.php','winSogamoso','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");*/
}

//Elminación de la comunicación
if(isset($recarga) && trim($recarga) == "2"){

	$cursorTran1 = mssql_query(" BEGIN TRANSACTION ");
	
	$sqlNomCom = " SELECT archivoComunicacion FROM ComunicacionesPorRevision ";
	$sqlNomCom = $sqlNomCom .  " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
	$sqlNomCom = $sqlNomCom .  " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlNomCom = $sqlNomCom .  " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlNomCom = $sqlNomCom .  " AND idLote = " . $_SESSION["phsLote"] . " ";
	$sqlNomCom = $sqlNomCom .  " AND idPlano = " . $_SESSION["phsPlano"] . " ";
	$sqlNomCom = $sqlNomCom .  " AND idRevision = " . $cualRevision . " ";
	$sqlNomCom = $sqlNomCom .  " AND idComunicacion = " . $cualComunicacion . " ";
	$cursorNomCom = mssql_query($sqlNomCom);
	if($regNomCom = mssql_fetch_array($cursorNomCom)){
		$elArchivoCom = $regNomCom[archivoComunicacion];
	}
	
	$sqlIn1 = " DELETE FROM ComunicacionesPorRevision ";
	$sqlIn1 = $sqlIn1 .  " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
	$sqlIn1 = $sqlIn1 .  " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn1 = $sqlIn1 .  " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlIn1 = $sqlIn1 .  " AND idLote = " . $_SESSION["phsLote"] . " ";
	$sqlIn1 = $sqlIn1 .  " AND idPlano = " . $_SESSION["phsPlano"] . " ";
	$sqlIn1 = $sqlIn1 .  " AND idRevision = " . $cualRevision . " ";
	$sqlIn1 = $sqlIn1 .  " AND idComunicacion = " . $cualComunicacion . " ";
	$cursorIn1 = mssql_query($sqlIn1);
	
	if(trim($cursorTran1) != "" && trim($cursorIn1) != "" ){
		$cursorTran2 = mssql_query(" COMMIT TRANSACTION ");
		if(trim($cursorTran2) != ""){
			
			//Se hace el borrado del archivo de Comunicación
			$path = $_SERVER['DOCUMENT_ROOT'].$ruta."/".$elArchivoCom;
//			echo $path;
			unlink($path);
		
			echo ("<script>alert('Operación realizada exitosamente.');</script>");
		}
	}
	else{
		$cursorTran2 = mssql_query(" ROLLBACK TRANSACTION ");
		if(trim($cursorTran2) != ""){
			echo ("<script>alert('Error en la operación.');</script>");
		}
	}
/*	echo ("<script>window.close();MM_openBrWindow('menuRevisiones.php','winSogamoso','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");*/
	
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<title>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</title>

<script language="JavaScript" src="calendar.js"></script>
<script language="JavaScript">

</script>

<script language="javascript">
<!--


function envia1(){
		var v1 = 's';
		var v2 = 's';
		var v3 = 's';
		var v4 = 's';
		var m1 = '';
		var m2 = '';
		var m3 = '';
		var m4 = '';
		var mensaje = '';

	//	var extensiones_permitidas = new Array(".pdf",".doc",".docx",".odt"); 
		var extensiones_permitidas =".pdf"; 
		if(document.form1.archivoCom.value == ''){
			v1 = 'n';
			m1 = 'El Archivo de la Comunicación es un campo Obligatorio \n';
		}
		else
		{
			var archivo=document.form1.archivoCom.value;
			var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
			
	/*		permitida = false;
		    for (var i = 0; i < extensiones_permitidas.length; i++) 
			{
         		if (extensiones_permitidas[i] == extension) 
				{
			         permitida = true;
			         break;
		         }
	     	 } 			
			 if(!permitida)
			 {
				v1 = 'n';				
				m1='El archivo de la comunicación tiene que ser un documento .pdf, .doc, .docx, ó .odt ';				 
			 }

      */
			if (extensiones_permitidas!=extension)
			{
				v1 = 'n';				
				m1='El archivo de la comunicación tiene que ser un documento '+extensiones_permitidas;
			}
  	
		        
          
		}
		
		if(document.form1.descrCom.value == '')
		{
			v1 = 'n';
			m1 = 'La descripción de la Comunicación es un campo Obligatorio \n';
		}
		
		if(document.form1.pFecha.value == '')
		{
			v1 = 'n';
			m1 = 'La fecha de la Comunicación es un campo Obligatorio \n';
		}		
		
		
		if ((v1=='s') && (v2=='s')  && (v3=='s') && (v4=='s')) {
			document.form1.recarga.value = '1';
			document.form1.submit();
		}		
		else {
			mensaje = m1 + m2 + m3 + m4;
			alert (mensaje);
		}
	}
//-->
</script>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr class="TituloTabla">
		<td>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</td>
  </tr>
	
	<tr>
	  <td><table width="100%" cellspacing="1">
        <tr>
          <td width="25%" class="TituloTabla2">Proyecto</td>
          <td class="TxtTabla"><span class="menu2"><? echo $nombreProyecto; ?></span></td>
        </tr>
        <tr>
          <td class="TituloTabla2">Tema</td>
          <td class="TxtTabla"><span class="menu2">
            <? 
			if(trim($nombreTemaPadre) != ""){
				echo $nombreTemaPadre . " ::: " .$nombreTematica; 
			}
			else{
				echo $nombreTematica; 
			}
		?>
          </span></td>
        </tr>
        <tr>
          <td class="TituloTabla2">Lote de Trabajo </td>
          <td class="TxtTabla"><span class="menu2"><? echo $nombreLote; ?></span></td>
        </tr>
        <tr>
          <td class="TituloTabla2">Documento</td>
          <td class="TxtTabla"><span class="menu2"><? echo $nombrePlano; ?></span></td>
        </tr>
        <tr>
          <td class="TituloTabla2">Revisi&oacute;n</td>
          <td class="TxtTabla"><span class="menu2"><? echo $nombreRevision; ?></span></td>
        </tr>
        
      </table></td>
  </tr>
	<tr>
	  <td>&nbsp;</td>
  </tr>
	<tr>
	  <td>
	  <form action="" method="post" enctype="multipart/form-data" name="form1">
	  <table width="100%" cellspacing="1">
        <tr>
          <td colspan="2" class="TituloTabla2">Agregar una Comunicaci&oacute;n </td>
          </tr>
        <tr>
          <td class="TituloTabla2">Archivo de la Comunicaci&oacute;n </td>
          <td class="TxtTabla"><input name="archivoCom" type="file" class="CajaTexto" id="archivoCom" size="60"></td>
        </tr>
        <tr>
          <td class="TituloTabla2">Descripci&oacute;n de la Comunicaci&oacute;n </td>
          <td class="TxtTabla"><input name="descrCom" type="text" class="CajaTexto" id="descrCom" size="60" /></td>
        </tr>
        <tr>
          <td class="TituloTabla2">Fecha de la Comunicaci&oacute;n </td>
          <td class="TxtTabla"><input name="pFecha" type="text" class="CajaTexto" id="pFecha">
            <a href="javascript:cal.popup();"><img src="../images/cal.gif" alt="Calendario" width="16" height="16" border="0"></a></td>
        </tr>
        <tr>
          <td colspan="2" align="right"><input name="recarga" type="hidden" id="recarga" value="0" />
            <input name="cualRevision" type="hidden" id="cualRevision" value="<? echo $cualRevision; ?>" />
            <input name="Submit" type="button" class="Boton" onClick="envia1()" value="Guardar" /></td>
          </tr>
      </table>
	  </form>	  </td>
  </tr>
	<tr>
	  <td><?
		//Consulta de las Comunicaciones Asociadas a la Revisión
		$sqlCom = " SELECT * FROM ComunicacionesPorRevision WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
		$sqlCom = $sqlCom . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
		$sqlCom = $sqlCom . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
		$sqlCom = $sqlCom . " AND idLote = " . $_SESSION["phsLote"] . " ";
		$sqlCom = $sqlCom . " AND idPlano = " . $_SESSION["phsPlano"] . " ";
		$sqlCom = $sqlCom . " AND idRevision = " . $cualRevision . " ";
		$cursorCom = mssql_query($sqlCom);
	  ?></td>
  </tr>
	<tr>
	  <td><table width="100%" cellspacing="1">
        <tr class="TituloTabla2">
          <td colspan="4">Comunicaciones Asociadas a la Revision </td>
        </tr>
        <tr class="TituloTabla2">
          <td>Archivo</td>
          <td>Descripci&oacute;n</td>
          <td width="1%">Ver </td>
          <td width="1%">&nbsp;</td>
        </tr>
		<? 
			while($regCom = mssql_fetch_array($cursorCom)){ 
				if($_SESSION["phsTematica"] != $_SESSION["phsTematicaPadre"]){
					$rutaFile = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematicaPadre"]."/T".$_SESSION["phsTematica"]."/".$_SESSION["phsLote"]."/".$numeroPlano."/".$n_revision."/".$comunicacion_revision;
				} else {
					$rutaFile = "../PHSFiles/" . $_SESSION["phsProyecto"] . "/T".$_SESSION["phsTematica"]."/".$_SESSION["phsLote"]."/".$numeroPlano."/".$n_revision."/".$comunicacion_revision;
				}
		?>
        <tr class="TxtTabla">
          <td><? echo $regCom[archivoComunicacion]; ?></td>
          <td><? echo $regCom[descripcionComunicacion]; ?></td>
        

          <td align="center"><a href="#"><img src="../images/ver.gif" width="16" height="16" border="0" onClick="MM_openBrWindow('<? echo $rutaFile."/".$regCom[archivoComunicacion]; ?>','','width=800,height=600')"></a></td>
          <td align="center"><a onClick="if(confirm('¿Desea eliminar la comunicación <? echo $regCom[descripcionComunicacion]; ?>?')){ return true; } else{ return false; }" href="detalleComunicaciones.php?recarga=2&cualComunicacion=<? echo $regCom[idComunicacion]; ?>&cualRevision=<? echo $cualRevision; ?>&comunicacion_revision=<? echo $comunicacion_revision; ?>&n_revision=<? echo $n_revision; ?>">
          
        <?php  if($_SESSION["phsPerfil"] == 1 or $_SESSION["phsPerfil"] == 3 or $_SESSION["phsPerfil"] == 4)
			 { ?>
          <img src="../images/del.gif" width="18" height="13" border="0">
          <? } ?>
          </a></td>
        </tr>
		<? } ?>
      </table></td>
  </tr>
	<tr>
	  <td>&nbsp;</td>
  </tr>
	<tr class="copyr">
	  <td>Desarrollado por INGETEC S.A. &copy; 2009 - Departamento de Sistemas </td>
  </tr>
</table>

<script language="JavaScript">
		 var cal = new calendar2(document.forms['form1'].elements['pFecha']);
		 cal.year_scroll = true;
		 cal.time_comp = false;		 		 
</script>
</body>
</html>
