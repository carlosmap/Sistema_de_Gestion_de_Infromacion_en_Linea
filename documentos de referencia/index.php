<?php

	session_start();
	//ini_set('session.use_cookies',1);
	//ini_set('session.use_only_cookies');
	session_register('ptUsr');
	session_register('ptPwd');
	session_register('laUnidaddelUsuario');//La que vale en todo el sistema

//Variables de sesión usadas en la Hoja de tiempo
	session_register('id_proyecto');
 	session_register('id_division');
 	session_register('fi');
 	session_register('ff');
 	session_register('login');
 	session_register('clave'); 
 	session_register('usrBD');
 	session_register('nombreempleado');
 	session_register('apellidoempleado');
 	session_register('laUnidad');
 	session_register("ElCargoAdicional");
 	session_register("laLocalizacion");
 	session_register("dirProy");
 	session_register("pac");
 	session_register('MiUnidad');
 	session_register('esRevisor');
 	session_register('fiAprobacion');
 	session_register('ffAprobacion');
 	session_register('elQueAutoriza');//Se usa para grabar la unidad de la persona que autorizó a otra a revisar la hdet
 	session_register('perfilQueAutoriza');
 	session_register('Server_Path');//Almacena el path de los dierctorios donde grabará info en dir tree
	session_register('proyectoElegido'); //Almacena el proyecto que elige el usuario para ver los directorios
	session_register('ManCorProyectoElegido'); //Almacena el proyecto que elige el usuario para ver los directorios de la correspondencia
	session_register('idManCorProyectoElegido'); //Almacena el ID del proyecto que elige el usuario para ver los directorios de la correspondencia	
	session_register('tipo');//Almacena el nombre de la tabla para consultar en correspondencia. Se usa en consultacorrespondencia.php
	session_register('idcualProy'); //Almacena el id_proyecto del proyecto seleccionado en filtroProyectos.php
	session_register('sesUnidadUsuarioHT');//Almacena la session del usuario para poder simular el cambio de usuario en la hoja de tiempo 
	session_register('idActividad'); //Se usan en graba viaticos
	session_register('sesCategoriaUsuario');//Almacena la categoria del usuario 
	session_register('sesInvestigaNo');//Almacena No de la investigación de accidente o incidente
	session_register('sesProyLaboratorio'); // Sesión que almacena el id_proyecto del proyecto activo en el laboratorio
	
	session_register('sesAnalisisRiesgo'); // Sesión que se utiliza en análisis de riesgos por oficio
	
	//$_SESSION["laLocalizacion"];//Se usan en graba viaticos
	//$_SESSION["ElCargoAdicional"];//Se usan en graba viaticos
	
	$_SESSION["sesInscripcionBrigada"] = "";
	
	//1Oct2010
	//Sessión para definir cantidad de descuentos en la solicitud de anticipo
	$_SESSION["sesNumDescuentos"] = "2";
	
?>

<html>
<head>
<title>::: INGETEC S.A. :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="imagenes/icoIngetec.ico">
<LINK REL="stylesheet" HREF="css/estilo.css" TYPE="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><?php include ("BannerIngetec.php");?></td>
  </tr>
</table>

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">
	<table width="278" height="132"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td background="imagenes/ingLogin.gif">
		  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><img src="images/Pixel.gif" width="4" height="4"></td>
            </tr>
          </table>
		  <table width="80%"  border="0" cellspacing="1" cellpadding="0">
		  <form name= formulario action="index.php" method="post">
        <tr>
          <td width="30%" align="right" class="Encuesta">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          <td width="30%" align="right" class="Encuesta">Login:&nbsp;</td>
          <td><input name="lg" type="text" class="CajaTexto" id="lg" size="17"></td>
        </tr>
        <tr>
          <td width="30%" align="right" class="Encuesta">&nbsp;</td>
          <td width="30%" align="right" class="Encuesta">Password:&nbsp;</td>
          <td><input name="pass" type="password" class="CajaTexto" id="pass" size="17"></td>
        </tr>
        <tr align="right">
          <td colspan="3" ><input name="Submit" type="submit" class="Boton" value="Ingresar"></td>
          </tr>
        <tr align="right">
          <td colspan="3" class="Encuesta" >&iquest;Olvid&oacute; su clave?</td>
          </tr>
		  <input type=hidden name=accion value=seguir>
              </form>
    </table>		  </td>
        </tr>
      </table>
	</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="Encuesta">&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" valign="bottom"><img src="imagenes/logosCertificados.png" width="368" height="180"></td>
        </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="copyr"> powered by INGETEC S.A - 2007 </td>
  </tr>
</table>
</body>
</html>

<?php

//echo "aqui abre";
/*
///OJO***Para entrar mientras arreglan el servidor
if($accion == "seguir"){
echo "entro <br>";

	$ptUsr = $_POST['lg'];
	$ptPwd = $_POST['pass'];

//	$ptUsr = "grodrig";
//	$ptPwd = "131332";
	
	
//	echo "ptUsr-->" . $ptUsr . "<br>";
	
	//****Crear la sesión para la unidad del usuario y el perfil asignado
	include('conectaBD.php');
			
	//Establecer la conexión a la base de datos
	$conexion = conectar();
//	echo "Conexion-->" . $conexion . "<br>";
			
	//Verificar la existencia del usuario y encontrar la unidad
	@mssql_select_db("HojaDeTiempo",$conexion);
	$sql2="Select * from Usuarios  ";
	$sql2=$sql2 . " where email = '" . $ptUsr . "' ";
//	echo $sql2 . "<br>";
	$cursor2 = mssql_query($sql2);

	if ($reg2=mssql_fetch_array($cursor2)) {
		$_SESSION["sesUnidadUsuario"] = $reg2[unidad];
		$laUnidad = $_SESSION["sesUnidadUsuario"];
//		echo "sesUnidadUsuario-->" . $_SESSION["sesUnidadUsuario"] . "<br>";
		$_SESSION["nombreempleado"] = $reg2[nombre];
		$_SESSION["apellidoempleado"] = $reg2[apellidos];
		//Almacenar el login y password del usuario
		$_SESSION["sesLoginUsuario"] = $$ptUsr;
		$_SESSION["sesPassUsuario"] = $ptPwd;
		
		//Con la Unidad encontrar el perfil de usuario
		@mssql_select_db("GestiondeInformacionDigital",$conexion);
		$sql="Select * from PerfilUsuarios  ";
		$sql=$sql . " where unidad = " . $_SESSION["sesUnidadUsuario"];
		$cursor = mssql_query($sql);
	
		if ($reg=mssql_fetch_array($cursor)) {
			$_SESSION["sesPerfilUsuario"] = $reg[codPerfil];
		}
		else {
			echo ("<script>alert('El usuario no tiene un perfil asociado, por favor contacte al administrador del sistema');</script>");
			echo "<script>location.href=\"index.php\"</script>";
		}

	}
	else {
		echo ("<script>alert('El usuario no se encuentra registrado en la hoja de tiempo');</script>");
		echo "<script>location.href=\"index.php\"</script>";
	}
			
	mssql_close ($conexion); 

	//****
			
	echo "<script>location.href=\"indiceGeneral.php\"</script>";
}
exit();

///OJO***Cierra
*/


if($accion == "seguir"){
/*echo ("<script>alert('En mantenimiento por 1 hora');</script>");
exit;*/

$ldaphost = "192.168.1.3";
$ldapport = 389;
//$ptUsr = $lg;
//$ptPwd = $pass;
$ptUsr = $_POST['lg'];
$ptPwd = $_POST['pass'];


$ds = ldap_connect($ldaphost, $ldapport) or die("No se pudo conectar al Servidor $ldaphost");
if ($ds) {

	//$binddn = "uid=$ptUsr,ou=People,dc=ingetec,dc=com,dc=co";
        // Linea adicionada para trabajar con ldap version 3 
        // 24 Nov 2008 
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
     	$binddn = "uid=$ptUsr,ou=Users,dc=ingetec,dc=com,dc=co";
        echo " binddn =".$binddn;
        $ldapbind = ldap_bind($ds, $binddn, $ptPwd);
	if ($ldapbind) {
			//$sr=ldap_search($ds, "ou=People,dc=ingetec,dc=com,dc=co","uid=$ptUsr");
			$sr=ldap_search($ds, "ou=Users,dc=ingetec,dc=com,dc=co","uid=$ptUsr");
			$entry = ldap_first_entry($ds, $sr);
			$values = ldap_get_values($ds, $entry, "oxuserposition");
			$tipousuario=$values[0];
			$_SESSION['autentified'] = true;
			
			//****Crear la sesión para la unidad del usuario y el perfil asignado
			include('conectaBD.php');
			
			//Establecer la conexión a la base de datos
			$conexion = conectar();
			
			//Verificar la existencia del usuario y encontrar la unidad
			@mssql_select_db("HojaDeTiempo",$conexion);
			$sql2="Select * from Usuarios  ";
			$sql2=$sql2 . " where email = '" . $ptUsr . "' ";
			$sql2=$sql2 . "and retirado is null ";
			$cursor2 = mssql_query($sql2);

			if ($reg2=mssql_fetch_array($cursor2)) {
				$_SESSION["sesUnidadUsuario"] = $reg2[unidad];
				$laUnidad = $_SESSION["sesUnidadUsuario"];
				$_SESSION["sesNomApeUsuario"] = $reg2[nombre] . " " . $reg2[apellidos];
				//encuentra el nombre del paisano
				$_SESSION["nombreempleado"] = $reg2[nombre];
				$_SESSION["apellidoempleado"] = $reg2[apellidos];
				//Almacenar el login y password del usuario
				$_SESSION["sesLoginUsuario"] = $$ptUsr;
				$_SESSION["sesPassUsuario"] = $ptPwd;
				//Almaacenar la categoría del usuario
				$_SESSION["sesCategoriaUsuario"] = $reg2[id_categoria];
				
				//Con la Unidad encontrar el perfil de usuario
				@mssql_select_db("GestiondeInformacionDigital",$conexion);
				$sql="Select * from PerfilUsuarios  ";
				$sql=$sql . " where unidad = " . $_SESSION["sesUnidadUsuario"];

				$cursor = mssql_query($sql);

				if ($reg=mssql_fetch_array($cursor)) {
					$_SESSION["sesPerfilUsuario"] = $reg[codPerfil];
				}
				else {
					echo ("<script>alert('El usuario no tiene un perfil asociado, por favor contacte al administrador del sistemax $sql');</script>");
					echo "<script>location.href=\"index.php\"</script>";
				}

			}
			else {
/*				echo ("<script>alert('En Mantenimiento');</script>");			*/
				
				echo ("<script>alert('El usuario no se encuentra registrado en la hoja de tiempo');</script>");
				echo "<script>location.href=\"index.php\"</script>";
			}
			
			mssql_close ($conexion); 

			//****
/*			
			echo ("<script>alert('En Mantenimiento por 10 minutos');</script>");			
			echo "<script>location.href=\"index.php\"</script>";			
*/
/*			echo "<script>location.href=\"indiceGeneral.php\"</script>"; */
			//24Ago2011
			//Se creo el perfil para Agencia de Viajes = 28, si la persona que ingresa es agente de viaje no ve el Portal, 
			//sólo ve la página de consulta que también ve Janeth.
			//if ($_SESSION["sesPerfilUsuario"] != 28) {
			if (($_SESSION["sesPerfilUsuario"] != 28) AND ($_SESSION["sesPerfilUsuario"] != 29)) {
				echo "<script>location.href=\"indiceGeneral.php\"</script>";
			}
			else {
				//11Dic2011
				//Se creo el perfil para Responsable SISSOMA Firma Externa = 29, 
				//si la persona que Sissoma de otra firma (SEDIC) no ve el Portal, 
				//sólo ve la página de ingreso a las opciones de Sissoma correspondiente a otra firma
				if ($_SESSION["sesPerfilUsuario"] == 28) {
					echo "<script>location.href=\"Solicitudes/solPasajes3.php\"</script>";
				}
				if ($_SESSION["sesPerfilUsuario"] == 29) {
					echo "<script>location.href=\"sissoma/verBoletin.php\"</script>";
				}
			}
		}else {
			echo "<script>alert('No es posible autenticar, favor revisar usuario y clave !');</script>";
			echo "<SCRIPT LANGUAGE=\"JavaScript\">";
			echo "location.href=\"index.php\"";
			echo "</SCRIPT>";
		}
	}
}
?>

