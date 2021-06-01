<?php

/*
20091215
Daniel Felipe Rentería Martínez
Validación de Sesión: Menú principal
*/

if (!session_is_registered('sesPerfil')){
	echo "<script>alert('Acceso no permitido. Por favor ingrese con su usuario y password')</script>";
	echo "<script>location.href='indexProy.php'</script>";
}
?>