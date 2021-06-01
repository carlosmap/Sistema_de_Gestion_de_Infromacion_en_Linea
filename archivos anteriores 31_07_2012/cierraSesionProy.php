<?php
/*
20091214
Patricia Barón Manrique
Página de Cierre La Vegona
*/

//Inicializa las variables de sesión
session_start();

$_SESSION["sesIdUsuario"] = "";
$_SESSION["sesNomApeUsuario"]="";
$_SESSION["sesPerfil"]="";


//session_unregister('ptUsr');
//session_unregister('ptPwd');

session_destroy();

/*echo ("<script>alert('Sesión Cerrada Correctamente.');</script>"); */
echo "<script>location.href=\"indexProy.php\"</script>";

?>

