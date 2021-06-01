<?

//Inicializa las variables de sesión
session_start();

//Validación de ingreso
//include("verificaIngreso1.php");

//Conexión a la Base de Datos
include("enlaceBD.php");
include("verificaIngreso1Proy.php");
$conexion = conectar();

//Proyectos
if($_SESSION["sesPerfil"]==1)
{
	$sql_admin="select * from sogamoso.dbo.Proyectos";
	$valores_usuarios_proyectos=mssql_query($sql_admin);
	$label="Activos";
}
else
{
	$usarios_proyectos = "select proyectos.idProyecto,proyectos.nombreProyecto from sogamoso.dbo.UsuariosVsProyectos as uVp
		inner join sogamoso.dbo.Proyectos as proyectos on uVp.idProyecto=proyectos.idProyecto 
		where idUsuario=".$_SESSION["sesIdUsuario"]." and proyectos.proyectoActivo=1";
   $valores_usuarios_proyectos= mssql_query($usarios_proyectos);
}

?>


<html>
<head>
<title>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="css/estilo.css" TYPE="text/css">
<script language="JavaScript">
window.name="winSogamoso";
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>


</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="1024" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#2E3605">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
        <td><?php include ("bannerArribaExt.php");?></td>
      </tr>
	  
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	  
	  <tr class="TituloTabla">
		<td>::: Sistema de Gesti&oacute;n de Informaci&oacute;n en L&iacute;nea - Proyectos </td>
	  </tr>
	  
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	  
	  <tr>
	    <td>
		  <table width="60%" align="center" cellspacing="1">
			<tr class="TituloTabla2">
			  <td colspan=3>Proyectos <?php echo $label ?></td>
			</tr>
               
			<?php
			if($_SESSION["sesPerfil"]==1) //si el perfil del usuario es la de administrador
			{
			?>
                <tr class="TituloTabla2">
				  <td>Codigo</td>
                  <td>Nombre</td>
                  <td>Estado</td>                  
				</tr>
			<?php	
				while($datos_usu_proyectos = mssql_fetch_array($valores_usuarios_proyectos))
				{ 	
			?>
					<tr align="center">                    
                    <td class="TxtTabla"><?php echo $datos_usu_proyectos[idProyecto]; ?></td>
                    
					  <td height="25" class="TxtTabla"><a href="cargaProyecto.php?p=<?=$datos_usu_proyectos[idProyecto];?>" class="menu2"><? echo $datos_usu_proyectos[nombreProyecto]; ?></a></td>
            		
            <?php		
					if($datos_usu_proyectos[proyectoActivo]==1)
					{
			?>
            		       <td class="TxtTabla"><?php echo "Activo"; ?></td>
			<?php	
					}
					else
					{
							echo  "<td class='TxtTabla'>Inactivo</td>";
					}
				}
			
			?>	
				</tr>
            <?php    
			} 
			else  //si es un perfil de usuario diferente
			{
				$proyectos_asignados=0;
				while($datos_usu_proyectos = mssql_fetch_array($valores_usuarios_proyectos))
				{ 
			?>
					<tr align="center">
					  <td height="25" class="TxtTabla"><a href="cargaProyecto.php?p=<?=$datos_usu_proyectos[idProyecto];?>" class="menu2"><? echo $datos_usu_proyectos[nombreProyecto]; ?></a></td>
            <? 
					$proyectos_asignados=1;
				} 
				//por si el usuario esta activo, pero no tiene proyectos asignados
				if($proyectos_asignados==0)
				{
					echo "<tr class='TxtTabla'><td align='center'>No hay proyectos asignados</td></tr>";
				}
			}
			?>     			
            
         
		  </table>
		</td>
	  </tr>
	  
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	  
	  <tr class="copyr">
		<td>Desarrollado por INGETEC S.A. &copy; 2012 - Departamento de Sistemas </td>
	  </tr>	
	</table>
	
</td>
</tr>
</table>

</body>
</html>
