<?php
/*
20091214
Daniel Felipe Renter�a Mart�nez
P�gina de Cierre PH Sogamoso
*/

//Inicializa las variables de sesi�n
session_start();

$_SESSION["phsNombreUsuario"]="";
$_SESSION["phsPerfil"]="";
$_SESSION["phsProyecto"] = "";
$_SESSION["phsEtapa"] = "";
$_SESSION["phsTematica"] = "";
$_SESSION["phsTematicaPadre"] = "";
$_SESSION["phsLote"] = "";
$_SESSION["phsPlano"] = "";

session_destroy();

echo ("<script>alert('Sesi�n Cerrada Correctamente.');</script>");
echo "<script>location.href=\"index.php\"</script>";

?>

