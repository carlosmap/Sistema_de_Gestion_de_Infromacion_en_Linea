<?php
/*
20091214
Patricia Bar�n Manrique
P�gina de Cierre La Vegona
*/

//Inicializa las variables de sesi�n
session_start();

$_SESSION["sesIdUsuario"] = "";
$_SESSION["sesNomApeUsuario"]="";
$_SESSION["sesPerfil"]="";


//session_unregister('ptUsr');
//session_unregister('ptPwd');

session_destroy();

/*echo ("<script>alert('Sesi�n Cerrada Correctamente.');</script>"); */
echo "<script>location.href=\"indexProy.php\"</script>";

?>

