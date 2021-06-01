<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?php
/*
20091215
Daniel Felipe Rentería Martínez
Menú Administración PH Sogamoso: Usuarios
*/

//Inicializa las variables de sesión
session_start();

//Abre la conexión a la BD
include('../enlaceBD.php');

//Validación de ingreso
include("../verificaIngreso2.php");

//Establecer la conexión a la base de datos
$conexion = conectar();

//Datos de Parámetro: Usuario
$sqlPar = " SELECT * FROM Usuarios WHERE idUsuario = " . $cualUsuario;
$cursorPar = mssql_query($sqlPar);
if(isset($recarga) == false){
	if($regPar = mssql_fetch_array($cursorPar)){
		$Nombre = $regPar['nombreUsuario'];
		$Apellido = $regPar['apellidoUsuario'];
		$nombreUsuario = $regPar['loginUsuario'];
		$contraUsuario = $regPar['claveUsuario'];
		$estado = $regPar['esActivo'];
		$claseP = $regPar['idPerfil'];
	}
}

//Perfiles
$sql1 = " SELECT * FROM Perfiles WHERE relativoA = '1' ";
$cursor1 = mssql_query($sql1);

//Grabación del Usuario
if (trim($recarga)=="2") {
	
	$qry = " UPDATE Usuarios SET ";	
	$qry = $qry . " loginUsuario = '".$nombreUsuario."', " ;
	$qry = $qry . " claveUsuario = '".$contraUsuario."', " ;
	$qry = $qry . " nombreUsuario = '".$Nombre."', " ;
	$qry = $qry . " apellidoUsuario = '".$Apellido."', " ;
	$qry = $qry . " idPerfil = ".$claseP.", " ;
	$qry = $qry . " esActivo = '".$estado."' " ;
	$qry = $qry . " WHERE idUsuario = " . $cualUsuario ;
	
	$cursorIn = mssql_query($qry) ;
	if  (trim($cursorIn) != "") {
		echo ("<script>alert('La Grabación se realizó con éxito.');</script>");
	} 
	else {
		echo ("<script>alert('Error durante la grabación');</script>");
	};
	echo ("<script>window.close();MM_openBrWindow('frmUsuarios.php?claseP=$claseP','winAdminPHS','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");
};


?>


<html>
<head>
<title>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<SCRIPT language=JavaScript>
<!--
function mOvr(src,clrOver) {
    if (!src.contains(event.fromElement)) {
	  src.style.cursor = 'hand';
	  src.bgColor = clrOver;
	}
  }
  function mOut(src,clrIn) {
	if (!src.contains(event.toElement)) {
	  src.style.cursor = 'default';
	  src.bgColor = clrIn;
	}
  }
  function mClk(src) {
    if(event.srcElement.tagName=='TD'){
	  src.children.tags('A')[0].click();
    }
  }

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es obligatorio.\n'; }
  } if (errors) alert('Validación:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</SCRIPT>
<SCRIPT language=JavaScript>
<!--


function envia1(){ 
//alert ("Entro a envia 1");
document.form1.recarga.value="1";
document.form1.submit();
}

function envia2(){ 
var v1,v2,v3, v4, i, CantCampos, msg1, msg2, msg3, msg4, mensaje;
v1='s';
v2='s';
v3='s';
v4='s';
msg1 = '';
msg2 = '';
msg3 = '';
msg4 = '';
mensaje = '';

//Valida que el campo Numero de Documento no esté vaciío
if (document.form1.Documento.value == '' ) {
	v1='n';
	msg1 = 'El Número de documento es obligatorio. \n'
}


//Valida que el campo Nombre  no esté vaciío
if (document.form1.Nombre.value == '' ) {
	v2='n';
	msg2 = 'El Nombre es obligatorio. \n'
}

//Valida que el campo Apellido no esté vaciío
if (document.form1.Apellido.value == '' ) {
	v3='n';
	msg3 = 'El Apellido es obligatorio. \n'
}

//Valida que el campo Nombre de Usuario no esté vaciío
if (document.form1.nombreUsuario.value == '' ) {
	v3='n';
	msg3 = 'El Nombre de Usuario es obligatorio. \n'
}

//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	if ((v1=='s') && (v2=='s')  && (v3=='s') && (v4=='s')) {
		document.form1.recarga.value="2";
		document.form1.submit();
	}
	else {
		mensaje = msg1 + msg2 + msg3 + msg4;
		alert (mensaje);
	}
	
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#276074">
  <tr>
    <td><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="TituloTabla">.: Sistema de Administraci&oacute;n - Usuarios :.</td>
          </tr>
        </table>
         
         
          <table width="100%"  border="0" cellspacing="1" cellpadding="0">
		   <form action="" method="post" name="form1" onSubmit="MM_validateForm('Nombre','','R','Apellido','','R','nombreUsuario','','R','contraUsuario','','R');return document.MM_returnValue">
            <tr>
              <td class="TituloTabla2">Nombres</td>
              <td class="TxtTabla"><input name="Nombre" type="text" class="CajaTexto" id="Nombre" value="<? echo $Nombre ?>" size="70"></td>
              </tr>
            <tr>
              <td class="TituloTabla2">Apellidos</td>
              <td class="TxtTabla"><input name="Apellido" type="text" class="CajaTexto" id="Apellido" value="<? echo $Apellido ?>" size="70"></td>
            </tr>
			<tr>
              <td class="TituloTabla2">Usuario</td>
			  <td class="TxtTabla"><input name="nombreUsuario" type="text" class="CajaTexto" id="nombreUsuario" value="<? echo $nombreUsuario ?>" size="70" maxlength="15" readonly></td>
			  </tr>
			<tr>
              <td class="TituloTabla2">Contrase&ntilde;a</td>
			  <td class="TxtTabla"><input name="contraUsuario" type="password" class="CajaTexto" id="contraUsuario" value="<? echo $contraUsuario; ?>" size="70"></td>
			  </tr>
			<tr>
			  <td class="TituloTabla2">Estado</td>
			  <td class="TxtTabla">
			  <?
			  	if($estado == "1"){
					$selA = "selected";
					$selI = "";
				}
				else{
					$selA = "";
					$selI = "selected";
				}
			  ?>
			  <select name="estado" class="CajaTexto" id="estado">
			    <option value="1" <? echo $selA; ?>>Activo</option>
			    <option value="0" <? echo $selI; ?>>Inactivo</option>
			    </select>
			  </td>
			  </tr>
			<tr>
              <td width="25%" class="TituloTabla2">Perfil</td>
              <td class="TxtTabla">
			  <select name="claseP" class="CajaTexto" id="claseP">
			  <?php 
			  while ($reg1 = mssql_fetch_array($cursor1)) { 
			  	$selP = "";
			  	if($claseP == $reg1[idPerfil]){
					$selP = "selected";
				}
			  ?>
                <option value="<? echo $reg1[idPerfil]; ?>" <? echo $selP; ?>><? echo $reg1[nombrePerfil]; ?></option>
			  <? } ?>	
              </select></td>
              </tr>
            
			
            <tr>
              <td width="25%">&nbsp;</td>
              <td align="right"><input name="recarga" type="hidden" id="recarga" value="2">
                <input name="Submit" type="submit" class="Boton" value="Grabar"></td>
              </tr>
			  </form>
          </table></td>
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
