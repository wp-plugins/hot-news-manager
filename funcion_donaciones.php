<?php
function ndport_dibuja_formulario_ppal(){
	echo "<form name=\"formulario_paypal\" id=\"formulario_paypal\" action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\" target=\"_top\">";
	echo "<input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">";
	echo "<input type=\"hidden\" name=\"hosted_button_id\" value=\"RP8DDP3KSTLH6\">";
	echo "</form>";
}//final de ndport_dibuja_formulario_ppal
?>