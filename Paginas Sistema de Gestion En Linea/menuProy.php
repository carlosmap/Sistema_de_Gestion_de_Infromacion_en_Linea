<?

//Inicializa las variables de sesión
session_start();

//Validación de ingreso
//include("verificaIngreso1.php");

//Conexión a la Base de Datos
include("enlaceBD.php");
include("verificaIngreso.php");
$conexion = conectar();


//Proyectos
if($_SESSION["phsPerfil"]==1)
{
	$sql_admin="select * from sogamoso.dbo.Proyectos";
	$valores_usuarios_proyectos=mssql_query($sql_admin);
	$label="Activos";
}
else
{
	$usarios_proyectos = "select proyectos.idProyecto,proyectos.nombreProyecto, proyectos.rutaProyecto from sogamoso.dbo.UsuariosVsProyectos as uVp
		inner join sogamoso.dbo.Proyectos as proyectos on uVp.idProyecto=proyectos.idProyecto 
		where idUsuario=".$_SESSION["phsIdUsuario"]." and proyectos.proyectoActivo=1";
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
		<td>
        <table width="100%">
        	<tr>
            	<td>
      
		<? if($_SESSION["phsPerfil"] == 1){ ?>
		  <img src="images/imgAdmin.gif" width="14" height="20"><a href="#" class="menu2" onClick="MM_openBrWindow('admin/menuAdmin.php','winAdminPHS','scrollbars=yes,resizable=yes,width=1028,height=768')">Sistema de Administraci&oacute;n</a>
		  <? } ?>
				</td>
        		<td align="right" > 
		<a href="#" class="menu2" onClick="MM_openBrWindow('ManualSistemaGestionInformacion_EnLinea.pdf','winAdminPHS','scrollbars=yes,resizable=yes,width=1028,height=768')">        
        	<img src="images/icoDetalleInf.gif" title="Ayuda"  width="14" height="20" >
        </a>    
		        </td>
             </tr>
            </table>
        </td>        
	  </tr>
	  
	  <tr>
	    <td>
		  <table width="60%" align="center" cellspacing="1">
			<tr class="TituloTabla2">
			  <td colspan=4>Proyectos <?php echo $label ?></td>
			</tr>
               
			<?php
			if($_SESSION["phsPerfil"]==1) //si el perfil del usuario es la de administrador
			{
			?>
                <tr class="TituloTabla2">
				  <td>Codigo</td>
                  <td>Nombre</td>
                  <td>Estado</td>  
                  <td></td>                  
				</tr>
			<?php	
				while($datos_usu_proyectos = mssql_fetch_array($valores_usuarios_proyectos))
				{ 
					if($datos_usu_proyectos[nombreProyecto]!="PH Sogamoso")
					{
					$cualProyecto=$datos_usu_proyectos[idProyecto];
			?>
            
					<tr align="center">                    
                    <td class="TxtTabla" value="<?php echo $datos_usu_proyectos[idProyecto]; ?>" name="cualProyecto" ><?php echo $datos_usu_proyectos[idProyecto]; ?></td>
                    
					  <td height="25" class="TxtTabla"><? echo $datos_usu_proyectos[nombreProyecto]; ?></td>
            		
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
					//Caso especial para el proyecto la vegona, y redirecciona a la pagina  cargaProyectovegona.php, para cargar las varibles de sesion del proyecto
					if($datos_usu_proyectos[idProyecto]==1138)
					{
						?>
						<td class="TxtTabla">
                        <input name="Submit" type="button" class="Boton" onClick="location.href='../<?php echo $datos_usu_proyectos[rutaProyecto]; ?>/control/cargaProyectovegona.php?cualProyecto=<? echo $datos_usu_proyectos[idProyecto]; ?>'" value="Control de Documentos">
                        </td>  
                        
                        <?
					}
					else
					{
					
                    	if($datos_usu_proyectos[rutaProyecto]!=null) 
						{
					?>

                        <td class="TxtTabla">
                        <input name="Submit" type="button" class="Boton" onClick="location.href='../<?php echo $datos_usu_proyectos[rutaProyecto]; ?>/control/cargaProyecto.php?cualProyecto=<? echo $datos_usu_proyectos[idProyecto]; ?>'" value="Control de Documentos">
                        </td>  

                                             
                  </tr>  
                    <?php
						}
						else   //si no tienen ruta, son proyectos nuevos y se direcciona a las paginas dde la aplicacion actual
						{
					?>
                        <td class="TxtTabla">
                        <input name="Submit" type="button" class="Boton" onClick="location.href='control/cargaProyectoProy.php?cualProyecto=<? echo $datos_usu_proyectos[idProyecto]; ?>'" value="Control de Documentos">
                        </td>  
					<?php	
						}
					}
				}
			}
			
			?>	
				
            <?php    
			} 
			else  //si es un perfil de usuario diferente
			{
				$proyectos_asignados=0;
				while($datos_usu_proyectos = mssql_fetch_array($valores_usuarios_proyectos))
				{ 
			?>
					<tr align="center">
					  <td height="25" class="TxtTabla">
                      	<? echo $datos_usu_proyectos[nombreProyecto]; ?>
                      </td>
                      <?php
//////////////////
					//identifica los proyectos nuevos, ya que estos tienen ruta=carpeta de destino , y se direcciona a la carpeta corresponidente de cada proyecto

					//Caso especial para el proyecto la vegona, y redirecciona a la pagina  cargaProyectovegona.php, para cargar las varibles de sesion del proyecto
					if($datos_usu_proyectos[idProyecto]==1138)
					{
						?>
						<td class="TxtTabla">
                        <input name="Submit" type="button" class="Boton" onClick="location.href='../<?php echo $datos_usu_proyectos[rutaProyecto]; ?>/control/cargaProyectovegona.php?cualProyecto=<? echo $datos_usu_proyectos[idProyecto]; ?>'" value="Control de Documentos">
                        </td>  
                        
                        <?
					}
					else
					{
					
	                    if($datos_usu_proyectos[rutaProyecto]!=null) 
						{
					?>

        	                <td class="TxtTabla">
                        <input name="Submit" type="button" class="Boton" onClick="location.href='../<?php echo $datos_usu_proyectos[rutaProyecto]; ?>/control/cargaProyecto.php?cualProyecto=<? echo $datos_usu_proyectos[idProyecto]; ?>'" value="Control de Documentos">
                        </td>  

                                             
                  </tr>  
                    <?php
						}
						else   //si no tienen ruta, quiere decir que  son proyectos nuevos y se direcciona a las paginas de la aplicacion actual
						{
					?>
                        <td class="TxtTabla">
                        <input name="Submit" type="button" class="Boton" onClick="location.href='control/cargaProyectoProy.php?cualProyecto=<? echo $datos_usu_proyectos[idProyecto]; ?>'" value="Control de Documentos">
                        </td>  
					<?php	
						}
					}
					?>
                  
                      
  				
                      
                      
      
                    </tr>  
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
	  
	  <tr class="copyr" align="center">
		<td>Desarrollado por INGETEC S.A. &copy; 2012 - Departamento de Sistemas </td>
	  </tr>	
	</table>
	
</td>
</tr>
</table>

<? mssql_close ($conexion); ?>
</body>
</html>
