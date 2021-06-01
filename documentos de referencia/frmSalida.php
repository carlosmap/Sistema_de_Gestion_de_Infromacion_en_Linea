<?php
session_start();
//Libera la sesión del proyecto seleccionado
	session_destroy();
	$_SESSION["sesProyectoSelec"] = "";
	$_SESSION["sesNombreProyecto"] = "" ;
	$_SESSION["sesUnidadUsuario"] = "";
	$_SESSION["sesPerfilUsuario"] = "";
	$_SESSION["sesNomApeUsuario"] = "";
	$_SESSION["sesInvestigaNo"] = "";
	
	//ini_set('session.use_cookies',1);
	//ini_set('session.use_only_cookies');
	session_unregister('ptUsr');
	session_unregister('ptPwd');
	session_unregister('laUnidaddelUsuario');//La que vale en todo el sistema

//Variables de sesión usadas en la Hoja de tiempo
	session_unregister('id_proyecto');
 	session_unregister('id_division');
 	session_unregister('fi');
 	session_unregister('ff');
 	session_unregister('login');
 	session_unregister('clave'); 
 	session_unregister('usrBD');
 	session_unregister('nombreempleado');
 	session_unregister('apellidoempleado');
 	session_unregister('laUnidad');
 	session_unregister("ElCargoAdicional");
 	session_unregister("laLocalizacion");
 	session_unregister("dirProy");
 	session_unregister("pac");
 	session_unregister('MiUnidad');
 	session_unregister('esRevisor');
 	session_unregister('fiAprobacion');
 	session_unregister('ffAprobacion');
 	session_unregister('elQueAutoriza');//Se usa para grabar la unidad de la persona que autorizó a otra a revisar la hdet
 	session_unregister('perfilQueAutoriza');
 	session_unregister('Server_Path');//Almacena el path de los dierctorios donde grabará info en dir tree
	session_unregister('proyectoElegido'); //Almacena el proyecto que elige el usuario para ver los directorios
	session_unregister('ManCorProyectoElegido'); //Almacena el proyecto que elige el usuario para ver los directorios de la correspondencia
	session_unregister('tipo');//Almacena el nombre de la tabla para consultar en correspondencia. Se usa en consultacorrespondencia.php
	session_unregister('idcualProy'); //Almacena el id_proyecto del proyecto seleccionado en filtroProyectos.php
	session_unregister('sesUnidadUsuarioHT');//Almacena la session del usuario para poder simular el cambio de usuario en la hoja de tiempo 
	session_unregister('idActividad'); //Se usan en graba viaticos
	
	session_unregister('sesProyLaboratorio'); //Se deshabilita la sesión de Proyecto de Laboratorio
	
	session_unregister('sesAnalisisRiesgo'); // Sesión que se utiliza en análisis de riesgos por oficio
	
	$_SESSION["sesInscripcionBrigada"] = "";
	$_SESSION["sesNumDescuentos"] = "";
	
	//$_SESSION["laLocalizacion"];//Se usan en graba viaticos
	//$_SESSION["ElCargoAdicional"];//Se usan en graba viaticos

	echo ("<script>alert('Usted ha cerrado su sesión de trabajo.');</script>");
	echo "<script>location.href=\"index.php\"</script>";

?>

