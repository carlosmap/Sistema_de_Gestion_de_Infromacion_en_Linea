<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?
/*
20091216
Daniel Felipe Rentería Martínez
Planos
*/

//Inicializa las variables de sesión
session_start();

//Validación de ingreso
include("../verificaIngreso1.php");

//Conexión a la Base de Datos
include("../enlaceBD.php");
$conexion = conectar();

//Datos de Parámetro
$sqlPar = " SELECT * FROM Revisiones ";
$sqlPar = $sqlPar . " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
$sqlPar = $sqlPar . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
$sqlPar = $sqlPar . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
$sqlPar = $sqlPar . " AND idLote = " . $_SESSION["phsLote"] . " ";
$sqlPar = $sqlPar . " AND idPlano = " . $_SESSION["phsPlano"] . " ";
$sqlPar = $sqlPar . " AND idRevision = " . $cualRevision . " ";
$cursorPar = mssql_query($sqlPar);
if(isset($recarga) == false){
	if($regPar = mssql_fetch_array($cursorPar)){
		$archivoPDFantes = $regPar[archivoPDF];
		$archivoDWGantes = $regPar[archivoDWG];
		$fechaRevision = date("m/d/Y", strtotime($regPar[fechaRevision]));
		$numeroEntrega = $regPar[numeroEntrega];
		$originaMod = $regPar[idOriginaMod];
		$divisionModifica = $regPar[idClaseMod];
		$revision = $regPar[numeroRevision];
		$descrModifica = $regPar[descripcionModificacion];
		$itemsPago = $regPar[itemsPago];
		$consRevision = $regPar[idRevisionInterna];
	}
}

//Originó Modificación
$sql1 = " SELECT * FROM TipoOriginaModificacion ";
$cursor1 = mssql_query($sql1);

//Clase Modificación
$sql2 = " SELECT * FROM TipoClaseModificacion ";
$cursor2 = mssql_query($sql2);

/*
Listado de Revisiones
Muestra solamente las revisiones que son superiores a la última revisión puesta
*/
$sql3 = " SELECT * FROM ConsRevisionesInternas WHERE idRevisionInterna = " . $consRevision;
$cursor3 = mssql_query($sql3);
if($reg3 = mssql_fetch_array($cursor3)){
	$consRevision = $reg3['idRevisionInterna'];
	$letraRevision = $reg3['letraRevisionInterna'];
}

//Guardar: Planos
if($recarga == 2 ){
	
	$okGuardar = "Si";
	
	//Obtiene el Nombre del Plano
	$sqlNom = " SELECT numeroPlano FROM Planos ";
	$sqlNom = $sqlNom . " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
	$sqlNom = $sqlNom . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlNom = $sqlNom . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlNom = $sqlNom . " AND idLote = " . $_SESSION["phsLote"] . " ";
	$sqlNom = $sqlNom . " AND idPlano = " . $_SESSION["phsPlano"] . " ";
	$cursorNom = mssql_query($sqlNom);
	if($regNom = mssql_fetch_array($cursorNom)){
		$nombrePlano = $regNom[numeroPlano];
	}
	
	//Creación de las Carpetas Correspondientes a la Temática, al Lote de Trabajo y al Plano
	$path = "../PHSFiles";
	
	//Crea la carpeta del proyecto
	$path = $path . "/" . $_SESSION["phsProyecto"];
	if(is_dir($path) == false){
		if(mkdir($path,0777)){
//			echo "Directorio creado con éxito: " . $path . "<br>";
		}
		else{
//			echo "Error: No fué posible crear el Directorio: " . $path . "<br>";
			exit();
		}
	}
	
	//Si es una subtemática, crea o verifica primero el directorio de la temática principal
	if($_SESSION["phsTematica"] != $_SESSION["phsTematicaPadre"]){
		$path = $path . "/T" . $_SESSION["phsTematicaPadre"];
		if(is_dir($path) == false){
			if(mkdir($path,0777)){
//				echo "Directorio creado con éxito: " . $path . "<br>";
			}
			else{
//				echo "Error: No fué posible crear el Directorio: " . $path . "<br>";
				exit();
			}
		}
	}
	
	//Crea el Directorio de la Temática
	$path = $path . "/T" . $_SESSION["phsTematica"];
	if(is_dir($path) == false){
		if(mkdir($path,0777)){
//			echo "Directorio creado con éxito: " . $path . "<br>";
		}
		else{
//			echo "Error: No fué posible crear el Directorio: " . $path . "<br>";
			exit();
		}
	}
	
	//Crea el Directorio de Lote de Trabajo
	$path = $path . "/" . $_SESSION["phsLote"];
	if(is_dir($path) == false){
		if(mkdir($path,0777)){
//			echo "Directorio creado con éxito: " . $path . "<br>";
		}
		else{
//			echo "Error: No fué posible crear el Directorio: " . $path . "<br>";
			exit();
		}
	}
	
	//Creación del Directorio de Plano
	$path = $path . "/" . $nombrePlano;
	if(is_dir($path) == false){
		if(mkdir($path,0777)){
//			echo "Directorio creado con éxito: " . $path . "<br>";
		}
		else{
//			echo "Error: No fué posible crear el Directorio: " . $path . "<br>";
			exit();
		}
	}
	
	//Creación del Path de Archivos de las Revisiones
	$path = $path . "/R" . $letraRevision;
	if(is_dir($path) == false){
		if(mkdir($path,0777)){
//			echo "Directorio creado con éxito: " . $path . "<br>";
		}
		else{
//			echo "Error: No fué posible crear el Directorio: " . $path . "<br>";
			exit();
		}
	}
	
	//Verifica si se puede escribir en el directorio
	if(is_writable($path)){

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

	
		//Carga de Archivo PDF
		//--------------------------------
		//Hace el upload del archivo
		if (trim($archivoPDF_name) != "")	{
			$archivoPDF_name=str_replace($carEspecial,$remplazar,$archivoPDF_name);
			$extension = explode(".",$archivoPDF_name);
			$num = count($extension)-1;
			//echo "Archivo Foto: ".$archivoPDF . "<br>" ;
			//echo "Archivo Foto - Nombre: ".$archivoPDF_name . "<br>" ;
			if (($extension[$num] == "pdf") OR ($extension[$num] == "PDF")) {
				if (!copy($archivoPDF, $path."/".$archivoPDF_name)) {
					$copioarchivoPDF = "NO";
					echo "Error al copiar el archivo <br>";
				}
				else {
					$copioarchivoPDF = "SI";
//					echo "Archivo PDF se copió en el servidor con exito <br>";
				}
			}
			else {
				echo "El formato de archivo no es valido. Solo .pdf <br>";
			}
		}
		//--------------------------------------	


		//Carga de Archivo DWG
		//--------------------------------
		//Hace el upload del archivo
		if (trim($archivoDWG_name) != "")	{
			$archivoDWG_name=str_replace($carEspecial,$remplazar,$archivoDWG_name);		
			$extension = explode(".",$archivoDWG_name);
			$num = count($extension)-1;
			//echo "Archivo Foto: ".$archivoDWG . "<br>" ;
			//echo "Archivo Foto - Nombre: ".$archivoDWG_name . "<br>" ;
			if (!copy($archivoDWG, $path."/".$archivoDWG_name)) {
				$copioarchivoDWG = "NO";
//				echo "Error al copiar el archivo <br>";
			}
			else {
				$copioarchivoDWG = "SI";
//				echo "Archivo Fuente se copió en el servidor con exito <br>";
			}
		}
		//--------------------------------------
	
	} else {
		echo "<script>alert('No es posible escribir el archivo en el directorio $path)'</script>";
		exit();
	}
	//Fin del IF -> IsWritable
	
	$cursorTran1 = mssql_query(" BEGIN TRANSACTION");
	if(trim($cursorTran1) == ""){
		$okGuardar = "No";
	}
	
	//Grabación de la Revisión
	$sqlIn1 = " UPDATE Revisiones SET ";
	$sqlIn1 = $sqlIn1 . " fechaRevision = '" . $fechaRevision . "', ";
	if(trim($archivoPDF_name) != ""){
		$sqlIn1 = $sqlIn1 . " archivoPDF = '" . $archivoPDF_name . "', ";
	}
	if (trim($archivoDWG_name) != ""){
		$sqlIn1 = $sqlIn1 . " archivoDWG = '" . $archivoDWG_name . "', ";
	}
	$sqlIn1 = $sqlIn1 . " numeroEntrega = '" . $numeroEntrega . "', ";
	$sqlIn1 = $sqlIn1 . " idOriginaMod = " . $originaMod . ", ";
	$sqlIn1 = $sqlIn1 . " itemsPago = '" . $itemsPago . "', ";
	$sqlIn1 = $sqlIn1 . " idClaseMod = " . $divisionModifica . ", ";
	$sqlIn1 = $sqlIn1 . " descripcionModificacion = '" . $descrModifica . "' ";
	$sqlIn1 = $sqlIn1 . " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
	$sqlIn1 = $sqlIn1 . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlIn1 = $sqlIn1 . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlIn1 = $sqlIn1 . " AND idLote = " . $_SESSION["phsLote"] . " ";
	$sqlIn1 = $sqlIn1 . " AND idPlano = " . $_SESSION["phsPlano"] . " ";
	$sqlIn1 = $sqlIn1 . " AND idRevision = " . $cualRevision . " ";
	$cursorIn1 = mssql_query($sqlIn1);
	if(trim($cursorIn1) == ""){
		$okGuardar = "No";
	}
	
//	echo $sqlIn1 ."<br>";
	//echo $sqlIn2 ."<br>";
	
	if(trim($okGuardar) == "Si"){
		$cursorTran2 = mssql_query(" COMMIT TRANSACTION ");
		
		//Elimina los archivos anteriores, si son diferentes
		if(trim($archivoPDF_name) != "" && $archivoPDF_name != $pdfAntes){
			unlink($path . "/" . $pdfAntes);
		}
		if(trim($archivoDWG_name) != "" && $archivoDWG_name != $fuenteAntes){
			unlink($path . "/" . $fuenteAntes);
		}
		
		echo ("<script>alert('Grabación realizada exitosamente.');</script>");
	}
	else{
		$cursorTran2 = mssql_query(" ROLLBACK TRANSACTION ");
		echo ("<script>alert('Error en la grabación.');</script>");
	}
	
	//exit;
	
	echo ("<script>window.close();MM_openBrWindow('menuRevisiones.php','winSogamoso','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<title>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</title>
<script language="JavaScript" src="calendar.js"></script>
<script language="javascript">
<!--
function envia1(){
		var error = 'n';
		var mensaje = '';
		
		if(document.form1.fechaRevision.value == '' || document.form1.numeroEntrega.value == ''){
			error = 's';
			mensaje = mensaje + 'La fecha de Revisión y el Número de Entrega son datos Obligatorios \n';
		}
		
		if(document.form1.descrModifica.value == '' || document.form1.itemsPago.value == ''){
			error = 's';
			mensaje = mensaje + 'La descripción de la Modificación y los Items de Pago son datos Obligatorios \n';
		}

		var extensiones_permitidas =".pdf"; 
		var archivo=document.form1.archivoPDF.value;
		var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
		
		if (extensiones_permitidas!=extension)
		{
			error = 's';							
			mensaje= mensaje+'Archivo PDF: El formato del archivo no es valido. Solo archivos PDF \n';
		}

		archivo=document.form1.archivoDWG.value;
		extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
		
		if (".exe"==extension)
		{
			error = 's';							
			mensaje= mensaje+'Archivo Fuente: El formato del archivo no puede ser .EXE \n';
		}	
		
		
		//Variables que verifican si hay diferencias entre los archivos fuentes o PDF de antes y nuevos
		var difPDF = 0;
		var difFte = 0;
		
		// Obtiene el nombre del Archivo que se va a subir en PDF
		if(document.form1.archivoPDF.value != ''){
			var nomArchivoPDF = document.form1.archivoPDF.value.split("\\");
			var itemsArchPDF = (nomArchivoPDF.length) - 1;
			var archivoPDFactual = (nomArchivoPDF[itemsArchPDF]);
			if(archivoPDFactual != document.form1.pdfAntes.value){
				difPDF = 1;
			}
		}
		
		// Obtiene el nombre del Archivo que se va a subir en Fuente
		if(document.form1.archivoDWG.value != ''){
			var nomArchivoFte = document.form1.archivoDWG.value.split("\\");
			var itemsArchFte = (nomArchivoFte.length) - 1;
			var archivoFteActual = (nomArchivoFte[itemsArchFte]);
			if(archivoFteActual != document.form1.fuenteAntes.value){
				difFte = 1;
			}
		}
		
		if (error =='n'){
			//Si la revisión no es A ó 0, le pregunta al usuario si está seguro que desea guardar la revisión
			if(difPDF != 0 || difFte != 0){
				if(confirm('Los nombres de los archivos PDF o Fuente son diferentes a los que existen actualmente.\nSi los reemplaza, los archivos anteriores serán eliminados.\n¿Está seguro de continuar?')){
					document.form1.recarga.value = 2;
					document.form1.submit();
				} 
			} else {
				document.form1.recarga.value = 2;
				document.form1.submit();
			}
		}
		else {
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
	  <td>
	  <form action="" method="post" enctype="multipart/form-data" name="form1">
	  <table width="100%" cellspacing="1">
        <tr>
          <td colspan="3" class="TituloTabla2">Datos de la Revisi&oacute;n </td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Revisi&oacute;n</td>
          <td class="TxtTabla">R<? echo $letraRevision; ?> <input name="consRevision" type="hidden" id="consRevision" value="<? echo $consRevision; ?>" /></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Archivo PDF </td>
          <td class="TxtTabla">
		  Archivo Anterior: <? echo $archivoPDFantes; ?>
		  <input name="pdfAntes" type="hidden" id="pdfAntes" value="<? echo $archivoPDFantes; ?>" /><br />
		  <input name="archivoPDF" type="file" class="CajaTexto" id="archivoPDF" size="60" /></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Archivo Fuente </td>
          <td class="TxtTabla">Archivo Anterior: <? echo $archivoDWGantes; ?>
		  <input name="fuenteAntes" type="hidden" id="fuenteAntes" value="<? echo $archivoDWGantes; ?>" /><br />
          <input name="archivoDWG" type="file" class="CajaTexto" id="archivoDWG" size="60" /></td></tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Fecha de Revisi&oacute;n </td>
          <td class="TxtTabla"><input name="fechaRevision" type="text" class="CajaTexto" id="fechaRevision" value="<? echo $fechaRevision; ?>" />
            <a href="javascript:cal.popup();"><img src="../images/cal.gif" width="16" height="16" border="0" /></a></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Entrega</td>
          <td class="TxtTabla"><input name="numeroEntrega" type="text" class="CajaTexto" id="numeroEntrega" value="<? echo $numeroEntrega; ?>" /></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Or&iacute;gen de la  Modificaci&oacute;n </td>
          <td class="TxtTabla">
		  <select name="originaMod" class="CajaTexto" id="originaMod">
		  <? 
		  while($reg1 = mssql_fetch_array($cursor1)){ 
		  	$selA = "";
		  	if($reg1[idOriginaMod] == $originaMod){
				$selA = "selected";
			}
		  ?>
		  	<option value="<? echo $reg1[idOriginaMod]; ?>" <? echo $selA; ?>> <? echo $reg1[nombreOriginaMod]; ?> </option>
		  <? } ?>
          </select>		  </td>
        </tr>
        <tr>
          <td rowspan="2" class="TituloTabla2">Descripci&oacute;n Modificaciones </td>
          <td class="TituloTabla2">Clase Modificaci&oacute;n </td>
          <td class="TxtTabla">
		  <select name="divisionModifica" class="CajaTexto" id="divisionModifica">
		  <? 
		  while($reg2 = mssql_fetch_array($cursor2)){ 
		  	$selB = "";
		  	if($reg2[idClaseMod] == $divisionModifica){
				$selB = "selected";
			}
		  ?>
		  	<option value="<? echo $reg2[idClaseMod] ?>" <? echo $selB; ?>><? echo $reg2[nombreClaseMod]; ?></option>
		  <? } ?>
          </select>		  </td>
        </tr>
        <tr>
          <td class="TituloTabla2">Descripci&oacute;n</td>
          <td class="TxtTabla"><input name="descrModifica" type="text" class="CajaTexto" id="descrModifica" value="<? echo $descrModifica; ?>" size="60" /></td>
        </tr>
        
        <tr>
          <td colspan="2" class="TituloTabla2">&Iacute;tems de Pago (Separados por Comas) </td>
          <td class="TxtTabla"><input name="itemsPago" type="text" class="CajaTexto" id="itemsPago" value="<? echo $itemsPago; ?>" size="60" /></td>
        </tr>

        <tr>
          <td colspan="3" align="right"><input name="revision" type="hidden" id="revision" value="<? echo $revision; ?>" />
          <input name="cualRevision" type="hidden" id="cualRevision" value="<? echo $cualRevision; ?>" />
          <input name="recarga" type="hidden" id="recarga" value="1" />
            <input name="Submit" type="button" class="Boton" value="Guardar" onClick="envia1()" /></td>
          </tr>
      </table>
	  </form>	  </td>
  </tr>
	<tr>
	  <td>&nbsp;</td>
  </tr>
	<tr class="copyr">
	  <td>Desarrollado por INGETEC S.A. &copy; 2009 - Departamento de Sistemas </td>
  </tr>
</table>

<script language="JavaScript">
		 var cal = new calendar2(document.forms['form1'].elements['fechaRevision']);
		 cal.year_scroll = true;
		 cal.time_comp = false;
</script>

</body>
</html>
