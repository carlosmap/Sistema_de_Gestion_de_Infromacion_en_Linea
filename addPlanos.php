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

//Originó Modificación
$sql1 = " SELECT * FROM TipoOriginaModificacion "; 
$cursor1 = mssql_query($sql1);

//Clase Modificación
$sql2 = " SELECT * FROM TipoClaseModificacion ";
$cursor2 = mssql_query($sql2);

//Listado de Revisiones
$sql3 = " SELECT * FROM ConsRevisionesInternas ";
$cursor3 = mssql_query($sql3);

//Guardar: Planos
if(trim($recarga) == "2" ){
	
	$okGuardar = "Si";

	//Verifica que no exista un plano con el mismo nombre... Si existe... paila !!!
	$sqlV = " SELECT COUNT(*) AS siHay FROM Planos WHERE idProyecto=" . $_SESSION["phsProyecto"] . " and numeroPlano = '" . $nombrePlano . "' ";
//echo $sqlV."<br>".mssql_get_last_message()." <br>";
	$cursorV = mssql_query($sqlV);
	if($regV = mssql_fetch_array($cursorV)){
		if($regV[siHay] != 0){
			echo "<script>alert('Ya existe un plano con ese nombre asignado. Por favor verifique')</script>";
			echo "<script>window.close()</script>";
			exit();
		}
	}

	//Se obtiene el Valor del ID del Plano
	$sqlId = " SELECT COALESCE(MAX(idPlano),0) AS elId FROM Planos WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
	$sqlId = $sqlId . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlId = $sqlId . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$cursorId = mssql_query($sqlId);
	if($regId = mssql_fetch_array($cursorId)){
		$idPlano = $regId[elId] + 1;
	}
	
	//Se obtiene la letra o número de la carpeta para la revisión
	$sqlRev = " SELECT * FROM ConsRevisionesInternas WHERE idRevisionInterna = " . $consRevision;
	$cursorRev = mssql_query($sqlRev);
	if($regRev = mssql_fetch_array($cursorRev)){
		$letraRevision = $regRev['letraRevisionInterna'];
	}
	
	//Creación de las Carpetas Correspondientes a la Temática, al Lote de Trabajo y al Plano
	$path = "../PHSFiles";
	
	//Crea la carpeta del proyecto
	$path = $path . "/" . $_SESSION["phsProyecto"];
	if(is_dir($path) == false){
		if(mkdir($path,0777)){
			//echo "Directorio creado con éxito: " . $path . "<br>";
		}
		else{
			echo "<script>alert('Error \nNo fué posible crear el Directorio: " . $path ."')</script>";
			echo "<script>window.close()</script>";
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
				echo "<script>alert('Error \nNo fué posible crear el Directorio: " . $path ."')</script>";
				echo "<script>window.close()</script>";
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
			echo "<script>alert('Error \nNo fué posible crear el Directorio: " . $path ."')</script>";
			echo "<script>window.close()</script>";
			exit();
		}
	}
	
	//Crea el Directorio de Lote de Trabajo
	$path = $path . "/" . $cualLote;
	if(is_dir($path) == false){
		if(mkdir($path,0777)){
//			echo "Directorio creado con éxito: " . $path . "<br>";
		}
		else{
			echo "<script>alert('Error \nNo fué posible crear el Directorio: " . $path ."')</script>";
			echo "<script>window.close()</script>";
			exit();
		}
	}
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
									  ']', ':', ',', '@', '~', 'ñ', 'Ñ',"'"   );

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
									'-', '-', '-', '-', '-', 'n', 'N','' );	
	
	$nombrePlano=str_replace('/',' ',$nombrePlano);
	$nombrePlano=str_replace($carEspecial,$remplazar,$nombrePlano);
//	$nombrePlano=str_replace("\"",' ',$nombrePlano);
	//Creación del Directorio de Plano
	$path = $path . "/" . $nombrePlano;
//echo "<br>pphat ".$path."<br>" ;
	if(is_dir($path) == false){
		if(mkdir($path,0777)){
//			echo "Directorio creado con éxito: " . $path . "<br>";
		}
		else{
			echo "<script>alert('Error \nNo fué posible crear el Directorio: " . $path ."')</script>";
			echo "<script>window.close()</script>";
			exit();
		}
	}
//echo "*************** <br>"	;
	//Creación del Path de Archivos de las Revisiones
	$path = $path . "/R" . $letraRevision;
	if(is_dir($path) == false){
		if(mkdir($path,0777)){
//			echo "Directorio creado con éxito: " . $path . "<br>";
		}
		else{
			echo "<script>alert('Error \nNo fué posible crear el Directorio: " . $path ."')</script>";
			echo "<script>window.close()</script>";
			exit();
		}
	}
	
//	echo "Ruta Completa: " . $path . "<br>";
	//exit;
	
	//Verifica si se puede escribir en el directorio
	if(is_writable($path)){
	
			


		//Carga de Archivo PDF
		//--------------------------------
		//Hace el upload del archivo
		if (trim($archivoPDF_name) != "")	{
			$extension = explode(".",$archivoPDF_name);
			$num = count($extension)-1;
			//echo "Archivo Foto: ".$archivoPDF . "<br>" ;
			//echo "Archivo Foto - Nombre: ".$archivoPDF_name . "<br>" ;
			if (($extension[$num] == "pdf") OR ($extension[$num] == "PDF")) {
				if (!copy($archivoPDF, $path."/".$archivoPDF_name)) {
					$copioarchivoPDF = "NO";
					echo "<script>alert('Error al copiar el archivo PDF')</script>";
					echo "<script>window.close()</script>";
					exit();
				}
				else {
					$copioarchivoPDF = "SI";
//					echo "Archivo PDF se copió en el servidor con exito <br>";
					$archivoPDF_name2=str_replace($carEspecial,$remplazar,$archivoPDF_name);
	
					rename($path."/".$archivoPDF_name, $path."/".$archivoPDF_name2);
				}
			}
			else {
				echo "<script>alert('Archivo PDF: El formato de archivo no es valido. Solo archivos PDF')</script>";
				echo "<script>window.close()</script>";
				exit();
			}
		}
		//--------------------------------------	
		
		//Carga de Archivo DWG
		//--------------------------------
		//Hace el upload del archivo


		if (trim($archivoFte_name) != "")	{
			$extension = explode(".",$archivoFte_name);
			$num = count($extension)-1;
			//echo "Archivo Foto: ".$archivoFte . "<br>" ;
			//echo "Archivo Foto - Nombre: ".$archivoFte_name . "<br>" ;			
			if (!copy($archivoFte, $path."/".$archivoFte_name)) {
				$copioarchivoFte = "NO";
				echo "<script>alert('Error al copiar el archivo')</script>";
				echo "<script>window.close()</script>";
				exit();
			}
			else {
				$copioarchivoFte = "SI";

				#$quitarguion = str_replace( $carEspecial, $remplazar, $cadenados );
				$archivoFte_name2=str_replace($carEspecial,$remplazar,$archivoFte_name);

				rename($path."/".$archivoFte_name, $path."/".$archivoFte_name2);
//				echo "Archivo Fuente se copió en el servidor con exito <br>";
			}
		}
		//--------------------------------------
	
	} else {
		echo "<script>alert('No es posible escribir el archivo en el directorio \n". $path . "')</script>";
		echo "<script>window.close()</script>";
		exit();
	}
	//Fin del IF -> IsWritable
	
	$cursorTran1 = mssql_query(" BEGIN TRANSACTION");
	if(trim($cursorTran1) == ""){
		$okGuardar = "No";
	}
	
	//Grabación del Plano
	$sqlIn1 = " INSERT INTO Planos ( idProyecto, etapaProyecto, idTematica, idLote, idPlano, numeroPlano, descripcionPlano ) ";
	$sqlIn1 = $sqlIn1 . " VALUES ( ";
	$sqlIn1 = $sqlIn1 . " " . $_SESSION["phsProyecto"] . ", ";
	$sqlIn1 = $sqlIn1 . " " . $_SESSION["phsEtapa"] . ", ";
	$sqlIn1 = $sqlIn1 . " " . $_SESSION["phsTematica"] . ", ";
	$sqlIn1 = $sqlIn1 . " " . $cualLote . ", ";
	$sqlIn1 = $sqlIn1 . " " . $idPlano . ", ";
	$sqlIn1 = $sqlIn1 . " '" . $nombrePlano . "', ";
	$sqlIn1 = $sqlIn1 . " '" . $descrPlano . "' ";
	$sqlIn1 = $sqlIn1 . " ) ";
	$cursorIn1 = mssql_query($sqlIn1);
	if(trim($cursorIn1) == ""){
		$okGuardar = "No";
	}
	
	//Grabación de la Revisión
	$sqlIn2 = " INSERT INTO Revisiones ( idProyecto, etapaProyecto, idTematica, idLote, idPlano, numeroRevision, idRevisionInterna,
	fechaRevision, archivoPDF, archivoDWG, numeroEntrega, idOriginaMod, itemsPago, idClaseMod, descripcionModificacion ) ";
	$sqlIn2 = $sqlIn2 . " VALUES ( ";
	$sqlIn2 = $sqlIn2 . " " . $_SESSION["phsProyecto"] . ", ";
	$sqlIn2 = $sqlIn2 . " " . $_SESSION["phsEtapa"] . ", ";
	$sqlIn2 = $sqlIn2 . " " . $_SESSION["phsTematica"] . ", ";
	$sqlIn2 = $sqlIn2 . " " . $cualLote . ", ";
	$sqlIn2 = $sqlIn2 . " " . $idPlano . ", ";
	$sqlIn2 = $sqlIn2 . " 1, ";
	$sqlIn2 = $sqlIn2 . " " . $consRevision . ", ";
	$sqlIn2 = $sqlIn2 . " '" . $fechaRevision . "', ";
	$sqlIn2 = $sqlIn2 . " '" . $archivoPDF_name2 . "', ";
	$sqlIn2 = $sqlIn2 . " '" . $archivoFte_name2 . "', ";
	$sqlIn2 = $sqlIn2 . " '" . $numeroEntrega . "', ";
	$sqlIn2 = $sqlIn2 . " " . $originaMod . ", ";
	$sqlIn2 = $sqlIn2 . " '" . $itemsPago . "', ";
	$sqlIn2 = $sqlIn2 . " " . $divisionModifica . ", ";
	$sqlIn2 = $sqlIn2 . " '" . $descrModifica . "' ";
	$sqlIn2 = $sqlIn2 . " ) ";
	$cursorIn2 = mssql_query($sqlIn2);
	if(trim($cursorIn2) == ""){
		$okGuardar = "No";
	}
	
//	echo $sqlIn1 ."<br>";
//	echo $sqlIn2 ."<br> ------------  ".mssql_get_last_message();
		
	if(trim($okGuardar) == "Si" ){
		$cursorTran2 = mssql_query(" COMMIT TRANSACTION ");
		echo ("<script>alert('Grabación realizada exitosamente.');</script>");
	}
	else{
		$cursorTran2 = mssql_query(" ROLLBACK TRANSACTION ");
		echo ("<script>alert('Error en la grabación.');</script>");
	}
	
	//exit;
	echo ("<script>window.close();MM_openBrWindow('menuPlanos.php?loteTrabajo=$cualLote','winSogamoso','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');
 </script>");
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
		
		if(document.form1.nombrePlano.value == '' || document.form1.descrPlano.value == ''){
			error = 's';
			mensaje = mensaje + 'El Nombre y la Descripción del Documento son datos Obligatorios \n';
		}
		
		if(document.form1.archivoPDF.value == '' || document.form1.archivoFte.value == ''){
			error = 's';
			mensaje = mensaje + 'Los archivos PDF y Fuente son datos Obligatorios \n';
		}
		
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
			mensaje='Archivo PDF: El formato de archivo no es valido. Solo archivos PDF \n';
		}		

		archivo=document.form1.archivoFte.value;
		extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
		
		if (".exe"==extension)
		{
			error = 's';							
			mensaje= mensaje+'Archivo Fuente: El formato del archivo no puede ser .EXE \n';
		}	
		
		if (error =='n'){
			//Si la revisión no es A ó 0, le pregunta al usuario si está seguro que desea guardar la revisión
			if(document.form1.consRevision.selectedIndex != 0 && document.form1.consRevision.selectedIndex != 26){
				if(confirm('La revisión del plano no es A ó 0. ¿Está seguro de continuar?')){
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
          <td colspan="2" class="TituloTabla2">Nombre (N&uacute;mero) del Documento</td>
          <td class="TxtTabla"><input name="nombrePlano" type="text" class="CajaTexto" id="nombrePlano" size="85" maxlength="80" />
            <br />
          (Por favor, antes de guardar verifique que el nombre de documento sea correcto) </td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Descripci&oacute;n del Documento </td>
          <td class="TxtTabla"><textarea name="descrPlano" cols="60" class="CajaTexto" id="descrPlano"></textarea></td>
        </tr>
        <tr>
          <td height="5" colspan="3" class="fondo"></td>
        </tr>
        <tr>
          <td colspan="3" class="TituloTabla2">Datos del Documento (Primera Revisi&oacute;n) </td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Revisi&oacute;n</td>
          <td class="TxtTabla"><select name="consRevision" class="CajaTexto" id="consRevision">
		  <? while($reg3 = mssql_fetch_array($cursor3)){ ?>
		  	<option value="<? echo $reg3['idRevisionInterna']; ?>"><? echo $reg3['letraRevisionInterna']; ?></option>
		  <? } ?>
          </select></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Archivo PDF </td>
          <td class="TxtTabla"><input name="archivoPDF" type="file" class="CajaTexto" id="archivoPDF" size="60" /></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Archivo Fuente </td>
          <td class="TxtTabla"><input name="archivoFte" type="file" class="CajaTexto" id="archivoFte" size="60" /></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Fecha de Revisi&oacute;n </td>
          <td class="TxtTabla"><input name="fechaRevision" type="text" class="CajaTexto" id="fechaRevision" />
            <a href="javascript:cal.popup();"><img src="../images/cal.gif" width="16" height="16" border="0" /></a></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2"> N&uacute;mero de Entrega</td>
          <td class="TxtTabla"><input name="numeroEntrega" type="text" class="CajaTexto" id="numeroEntrega" /></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Or&iacute;gen de la  Modificaci&oacute;n </td>
          <td class="TxtTabla">
		  <select name="originaMod" class="CajaTexto" id="originaMod">
		  <? while($reg1 = mssql_fetch_array($cursor1)){ ?>
		  	<option value="<? echo $reg1['idOriginaMod']; ?>"> <? echo $reg1['nombreOriginaMod']; ?> </option>
		  <? } ?>
          </select>
		  </td>
        </tr>
        <tr>
          <td rowspan="2" class="TituloTabla2">Descripci&oacute;n Modificaciones </td>
          <td class="TituloTabla2">Clase Modificaci&oacute;n </td>
          <td class="TxtTabla">
		  <select name="divisionModifica" class="CajaTexto" id="divisionModifica">
		  <? while($reg2 = mssql_fetch_array($cursor2)){ ?>
		  	<option value="<? echo $reg2['idClaseMod'] ?>"><? echo $reg2['nombreClaseMod']; ?></option>
		  <? } ?>
          </select>
		  </td>
        </tr>
        <tr>
          <td class="TituloTabla2">Descripci&oacute;n</td>
          <td class="TxtTabla"><input name="descrModifica" type="text" class="CajaTexto" id="descrModifica" size="60" /></td>
        </tr>
        
        <tr>
          <td colspan="2" class="TituloTabla2">&Iacute;tems de Pago (Separados por Comas) </td>
          <td class="TxtTabla"><input name="itemsPago" type="text" class="CajaTexto" id="itemsPago" size="60" /></td>
        </tr>

        <tr>
          <td colspan="3" align="right"><input name="cualLote" type="hidden" id="cualLote" value="<? echo $cualLote; ?>" />
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
