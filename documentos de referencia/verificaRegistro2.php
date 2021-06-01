<?php
if (!session_is_registered('sesPerfilUsuario')){
#	echo "Unidad : ".$_SESSION["sesUnidadUsuario"]." PErfil : ".$_SESSION["sesPerfilUsuario"];
	echo "<script>alert('Acceso no permitido. Por favor ingrese con su usuario y password')</script>";
	echo "<script>location.href='../index.php'</script>";
}
?>