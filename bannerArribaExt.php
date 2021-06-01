

<table width="100%"   border="0" cellspacing="0" cellpadding="0">
  <tr>       
    <td colspan=2><img src="images/bannerSogamoso.jpg" > </td>
  </tr>
   
    <tr  class="copyr">
  		<td align="left">Bienvenido, <? echo $_SESSION["phsNombreUsuario"]; ?></td>
        <td align="right" width="15%">
	<? 
		//Fecha
		$zDia = date("d");
		$zMes = date("m");
		$zAno = date("Y");
		$lMes = "";
		switch ($zMes) {
			case 1:
				$lMes = "Enero";
				break;
			case 2:
				$lMes = "Febrero";
				break;
			case 3:
				$lMes = "Marzo";
				break;
			case 4:
				$lMes = "Abril";
				break;
			case 5:
				$lMes = "Mayo";
				break;
			case 6:
				$lMes = "Junio";
				break;
			case 7:
				$lMes = "Julio";
				break;
			case 8:
				$lMes = "Agosto";
				break;
			case 9:
				$lMes = "Septiembre";
				break;
			case 10:
				$lMes = "Octubre";
				break;
			case 11:
				$lMes = "Noviembre";
				break;
			case 12:
				$lMes = "Diciembre";
				break;
		}
		echo $zDia . " de " . $lMes . " de " . $zAno;
		?>
	</td>   
    </tr>
    
  <tr class="fondo">
	  <td align="right" colspan="2" class="menu2"><a href="cierraSesion.php" class="menu2"><img src="images/close.gif" width="17" height="17" border="0" />Cerrar Sesi&oacute;n</a></td>
  </tr>  
</table>








