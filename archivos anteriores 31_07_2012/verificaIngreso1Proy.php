<?php

/*
20091215
Daniel Felipe Renter�a Mart�nez
Validaci�n de Sesi�n: Men� principal
*/

if (!session_is_registered('sesPerfil')){
	echo "<script>alert('Acceso no permitido. Por favor ingrese con su usuario y password')</script>";
	echo "<script>location.href='indexProy.php'</script>";
}
?>