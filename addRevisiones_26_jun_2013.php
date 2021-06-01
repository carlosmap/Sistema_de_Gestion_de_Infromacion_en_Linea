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
Daniel Felipe Renter�a Mart�nez
Planos
*/

//Inicializa las variables de sesi�n
session_start();

//Validaci�n de ingreso
include("../verificaIngreso1.php");

//Conexi�n a la Base de Datos
include("../enlaceBD.php");
$conexion = conectar();

//Origin� Modificaci�n
$sql1 = " SELECT * FROM TipoOriginaModificacion ";
$cursor1 = mssql_query($sql1);

//Clase Modificaci�n
$sql2 = " SELECT * FROM TipoClaseModificacion ";
$cursor2 = mssql_query($sql2);

/*
Listado de Revisiones
Busca la letra y el c�digo de la revisi�n m�s reciente
*/
$sql3a = " SELECT MAX(A.numeroRevision) AS elMaxNum, A.idRevisionInterna, B.letraRevisionInterna
FROM Revisiones A, ConsRevisionesInternas B
WHERE A.idRevisionInterna = B.idRevisionInterna ";
$sql3a = $sql3a . " AND A.idProyecto = " . $_SESSION["phsProyecto"] . " ";
$sql3a = $sql3a . " AND A.etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
$sql3a = $sql3a . " AND A.idTematica = " . $_SESSION["phsTematica"] . " ";
$sql3a = $sql3a . " AND A.idLote = " . $_SESSION["phsLote"] . " ";
$sql3a = $sql3a . " AND A.idPlano = " . $_SESSION["phsPlano"] . " ";
$sql3a = $sql3a . " GROUP BY A.idRevisionInterna, B.letraRevisionInterna ";
$sql3a = $sql3a . " ORDER BY elMaxNum DESC ";
//echo $sql3a . "<br>";
$cursor3a = mssql_query($sql3a);
if($reg3a = mssql_fetch_array($cursor3a)){
	$idRevisionActual = $reg3a['idRevisionInterna'];
	$letraRevisionActual = $reg3a['letraRevisionInterna'];
}

/*
Listado de Revisiones
Muestra solamente las revisiones que son superiores a la �ltima revisi�n puesta
*/
$sql3 = " SELECT * FROM ConsRevisionesInternas WHERE idRevisionInterna > " . $idRevisionActual;
//echo $sql3;
$cursor3 = mssql_query($sql3);

//Guardar: Planos
if($recarga == 2 ){
	
	$okGuardar = "Si";
	
	//Obtiene el M�ximo del n�mero de la revisi�n
	$sqlRev = " SELECT MAX(numeroRevision) elMax FROM Revisiones ";
	$sqlRev = $sqlRev . " WHERE idProyecto = " . $_SESSION["phsProyecto"] . " ";
	$sqlRev = $sqlRev . " AND etapaProyecto = " . $_SESSION["phsEtapa"] . " ";
	$sqlRev = $sqlRev . " AND idTematica = " . $_SESSION["phsTematica"] . " ";
	$sqlRev = $sqlRev . " AND idLote = " . $_SESSION["phsLote"] . " ";
	$sqlRev = $sqlRev . " AND idPlano = " . $_SESSION["phsPlano"] . " ";
	$cursorRev = mssql_query($sqlRev);
	if($regRev = mssql_fetch_array($cursorRev)){
		$revision = $regRev[elMax] + 1;
	}
	
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
	
	//Se obtiene la letra o n�mero de la carpeta para la revisi�n
	$sqlRev = " SELECT * FROM ConsRevisionesInternas WHERE idRevisionInterna = " . $consRevision;
	$cursorRev = mssql_query($sqlRev);
	if($regRev = mssql_fetch_array($cursorRev)){
		$letraRevision = $regRev['letraRevisionInterna'];
	}
	
	//Creaci�n de las Carpetas Correspondientes a la Tem�tica, al Lote de Trabajo y al Plano
	$path = "../PHSFiles";
	
	//Crea la carpeta del proyecto
	$path = $path . "/" . $_SESSION["phsProyecto"];
	if(is_dir($path) == false){
		if(mkdir($path,0777)){
//			echo "Directorio creado con �xito: " . $path . "<br>";
		}
		else{
//			echo "Error: No fu� posible crear el Directorio: " . $path . "<br>";
			exit();
		}
	}
	
	//Si es una subtem�tica, crea o verifica primero el directorio de la tem�tica principal
	if($_SESSION["phsTematica"] != $_SESSION["phsTematicaPadre"]){
		$path = $path . "/T" . $_SESSION["phsTematicaPadre"];
		if(is_dir($path) == false){
			if(mkdir($path,0777)){
//				echo "Directorio creado con �xito: " . $path . "<br>";
			}
			else{
//				echo "Error: No fu� posible crear el Directorio: " . $path . "<br>";
				exit();
			}
		}
	}
	
	//Crea el Directorio de la Tem�tica
	$path = $path . "/T" . $_SESSION["phsTematica"];
	if(is_dir($path) == false){
		if(mkdir($path,0777)){
//			echo "Directorio creado con �xito: " . $path . "<br>";
		}
		else{
//			echo "Error: No fu� posible crear el Directorio: " . $path . "<br>";
			exit();
		}
	}
	
	//Crea el Directorio de Lote de Trabajo
	$path = $path . "/" . $_SESSION["phsLote"];
	if(is_dir($path) == false){
		if(mkdir($path,0777)){
//			echo "Directorio creado con �xito: " . $path . "<br>";
		}
		else{
//			echo "Error: No fu� posible crear el Directorio: " . $path . "<br>";
			exit();
		}
	}
	
	//Creaci�n del Directorio de Plano
	$path = $path . "/" . $nombrePlano;
	if(is_dir($path) == false){
		if(mkdir($path,0777)){
//			echo "Directorio creado con �xito: " . $path . "<br>";
		}
		else{
//			echo "Error: No fu� posible crear el Directorio: " . $path . "<br>";
			exit();
		}
	}
	
	//Creaci�n del Path de Archivos de las Revisiones
	$path = $path . "/R" . $letraRevision;
	if(is_dir($path) == false){
		if(mkdir($path,0777)){
//			echo "Directorio creado con �xito: " . $path . "<br>";
		}
		else{
//			echo "Error: No fu� posible crear el Directorio: " . $path . "<br>";
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
//					echo "Archivo PDF se copi� en el servidor con exito <br>";
				}
			}
			else {
//				echo "El formato de archivo no es valido. Solo .pdf <br>";
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
				echo "Error al copiar el archivo <br>";
			}
			else {
				$copioarchivoFte = "SI";
//				echo "Archivo Fuente se copi� en el servidor con exito <br>";
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
	
	//Grabaci�n de la Revisi�n
	$sqlIn1 = " INSERT INTO Revisiones ( idProyecto, etapaProyecto, idTematica, idLote, idPlano, numeroRevision, idRevisionInterna,
	fechaRevision, archivoPDF, archivoDWG, numeroEntrega, idOriginaMod, itemsPago, idClaseMod, descripcionModificacion ) ";
	$sqlIn1 = $sqlIn1 . " VALUES ( ";
	$sqlIn1 = $sqlIn1 . " " . $_SESSION["phsProyecto"] . ", ";
	$sqlIn1 = $sqlIn1 . " " . $_SESSION["phsEtapa"] . ", ";
	$sqlIn1 = $sqlIn1 . " " . $_SESSION["phsTematica"] . ", ";
	$sqlIn1 = $sqlIn1 . " " . $_SESSION["phsLote"] . ", ";
	$sqlIn1 = $sqlIn1 . " " . $_SESSION["phsPlano"] . ", ";
	$sqlIn1 = $sqlIn1 . " " . $revision . ", ";
	$sqlIn1 = $sqlIn1 . " " . $consRevision . ", ";
	$sqlIn1 = $sqlIn1 . " '" . $fechaRevision . "', ";
	$sqlIn1 = $sqlIn1 . " '" . $archivoPDF_name . "', ";
	$sqlIn1 = $sqlIn1 . " '" . $archivoFte_name . "', ";
	$sqlIn1 = $sqlIn1 . " '" . $numeroEntrega . "', ";
	$sqlIn1 = $sqlIn1 . " " . $originaMod . ", ";
	$sqlIn1 = $sqlIn1 . " '" . $itemsPago . "', ";
	$sqlIn1 = $sqlIn1 . " " . $divisionModifica . ", ";
	$sqlIn1 = $sqlIn1 . " '" . $descrModifica . "' ";
	$sqlIn1 = $sqlIn1 . " ) ";
	$cursorIn1 = mssql_query($sqlIn1);
	if(trim($cursorIn1) == ""){
		$okGuardar = "No";
	}
	
	//echo $sqlIn1 ."<br>";
		
	if(trim($okGuardar) == "Si"){
		$cursorTran2 = mssql_query(" COMMIT TRANSACTION ");
		echo ("<script>alert('Grabaci�n realizada exitosamente.');</script>");
	}
	else{
		$cursorTran2 = mssql_query(" ROLLBACK TRANSACTION ");
		echo ("<script>alert('Error en la grabaci�n.');</script>");
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
		
		if(document.form1.archivoPDF.value == '' || document.form1.archivoFte.value == ''){
			error = 's';
			mensaje = mensaje + 'Los archivos PDF y Fuente son datos Obligatorios \n';
		}
		
		if(document.form1.fechaRevision.value == '' || document.form1.numeroEntrega.value == ''){
			error = 's';
			mensaje = mensaje + 'La fecha de Revisi�n y el N�mero de Entrega son datos Obligatorios \n';
		}
		
		if(document.form1.descrModifica.value == '' || document.form1.itemsPago.value == ''){
			error = 's';
			mensaje = mensaje + 'La descripci�n de la Modificaci�n y los Items de Pago son datos Obligatorios \n';
		}

		var extensiones_permitidas =".pdf"; 
		var archivo=document.form1.archivoPDF.value;
		var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
		
		if (extensiones_permitidas!=extension)
		{
			error = 's';							
			mensaje= mensaje+'Archivo PDF: El formato del archivo no es valido. Solo archivos PDF \n';
		}

		archivo=document.form1.archivoFte.value;
		extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
		
		if (".exe"==extension)
		{
			error = 's';							
			mensaje= mensaje+'Archivo Fuente: El formato del archivo no puede ser .EXE \n';
		}	
		

		//Verifica que la referencia seleccionada sea la que en teor�a es la siguiente. Si no es, pregunta al usuario
		var indice = parseInt(document.form1.consRevision.selectedIndex);
		var idRev = parseInt(document.form1.consRevision[indice].value);
		var letraRev = document.form1.consRevision[indice].text;
		var idRevAnt = parseInt(document.form1.revisionActual.value);
		var diferencia = idRev - idRevAnt;
		
		//letraRefActual
		
		if (error =='n'){
			//Si la revisi�n no es A � 0, le pregunta al usuario si est� seguro que desea guardar la revisi�n
			if(diferencia > 1){
				var mensaje = 'La revisi�n actual es ' + document.form1.letraRefActual.value + '.\n�Est� seguro que desea pasar este plano a la revisi�n ' + letraRev + '?';
				if(confirm(mensaje)){
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
          <td colspan="2" class="TituloTabla2">N&uacute;mero de Entrega</td>
          <td class="TxtTabla"><input name="numeroEntrega" type="text" class="CajaTexto" id="numeroEntrega" /></td>
        </tr>
        <tr>
          <td colspan="2" class="TituloTabla2">Or&iacute;gen de la Modificaci&oacute;n </td>
          <td class="TxtTabla">
		  <select name="originaMod" class="CajaTexto" id="originaMod">
		  <? while($reg1 = mssql_fetch_array($cursor1)){ ?>
		  	<option value="<? echo $reg1[idOriginaMod]; ?>"> <? echo $reg1[nombreOriginaMod]; ?> </option>
		  <? } ?>
          </select>		  </td>
        </tr>
        <tr>
          <td rowspan="2" class="TituloTabla2">Descripci&oacute;n Modificaciones </td>
          <td class="TituloTabla2">Clase Modificaci&oacute;n </td>
          <td class="TxtTabla">
		  <select name="divisionModifica" class="CajaTexto" id="divisionModifica">
		  <? while($reg2 = mssql_fetch_array($cursor2)){ ?>
		  	<option value="<? echo $reg2[idClaseMod] ?>"><? echo $reg2[nombreClaseMod]; ?></option>
		  <? } ?>
          </select>		  </td>
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
          <td colspan="3" align="right"><input name="letraRefActual" type="hidden" id="letraRefActual" value="<? echo $letraRevisionActual; ?>" />
		  <input name="revisionActual" type="hidden" id="revisionActual" value="<? echo $idRevisionActual; ?>" />            
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
