<?php
defined('ABSPATH') or die("You can't be here");

wp_enqueue_style('noticiero_de_portada_admin_styles.css', plugins_url('/estilos/noticiero_de_portada_admin_styles.css', __FILE__ ));

global $numero_noticias_en_portada, $idpagina_noticias_antiguas, $texto_pagina_noticias_antiguas;
$idpagina_noticias_antiguas = 4;
$texto_pagina_noticias_antiguas = "";

if (isset($_POST["operacion"])){
		$operacion = $_POST["operacion"];
	} else {
		$operacion = "1";
	}

if ($operacion == "2"){
	if (isset($_POST["noticias_en_portada"]))
		$numero_noticias_en_portada = $_POST["noticias_en_portada"];
	if (isset($_POST["idpagina_noticias_antiguas"]))
		$idpagina_noticias_antiguas = $_POST["idpagina_noticias_antiguas"];
	if (isset($_POST["texto_pagina_noticias_antiguas"]))
		$texto_pagina_noticias_antiguas = $_POST["texto_pagina_noticias_antiguas"];

}//si estamos en fase 2, recupero del post

function ndport_recuperar_parametros(){
	global $numero_noticias_en_portada, $idpagina_noticias_antiguas, $texto_pagina_noticias_antiguas;
	$numero_noticias_en_portada = get_option('numero_noticias_en_portada', '5');
	$idpagina_noticias_antiguas = get_option('idpagina_noticias_antiguas', '0');
	$texto_pagina_noticias_antiguas = get_option('texto_pagina_noticias_antiguas', '');
}//final de recuperar_parametros

function ndport_guardar_parametros(){
	global $numero_noticias_en_portada, $idpagina_noticias_antiguas, $texto_pagina_noticias_antiguas;
	update_option('numero_noticias_en_portada', $numero_noticias_en_portada);
	update_option('idpagina_noticias_antiguas', $idpagina_noticias_antiguas);
	update_option('texto_pagina_noticias_antiguas', $texto_pagina_noticias_antiguas);
}//final de recuperar_parametros

?>
<?php	
function ndport_dibujar_formulario_parametros(){
	global $numero_noticias_en_portada, $idpagina_noticias_antiguas, $texto_pagina_noticias_antiguas;
?>
	<form name="ndport_formulario_parametros" id="ndport_formulario_parametros" method="post" action="<?= menu_page_url('configurar_noticias', false) ?>">
	<table>
		<thead class="ndport_cabecera_listado_simplificado">
			<tr>
				<td style="width: 30%"><?= __('Parameter', 'noticiero_de_portada') ?></td>
				<td style="width: 40%"><?= __('Value', 'noticiero_de_portada') ?></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?= __('News items to be displayed at front page', 'noticiero_de_portada') ?><div class="ndport_asteriscos_obligatoriedad">(*)</div></td>
				<td><input class="ndport_campo_formulario_noticia_de_portada" type="text" name="noticias_en_portada" id="noticias_en_portada" value="<?= $numero_noticias_en_portada ?>" /></td>
			</tr>
			<tr>
				<td><?= __('Page id where old news can be read', 'noticiero_de_portada') ?><div class="ndport_asteriscos_obligatoriedad">(*)</div></td>
				<td><input class="ndport_campo_formulario_noticia_de_portada" type="text" name="idpagina_noticias_antiguas" id="idpagina_noticias_antiguas" value="<?= $idpagina_noticias_antiguas ?>" /></td>
			</tr>
			<tr>
				<td><?= __('Text fot the link to navigate to old news', 'noticiero_de_portada') ?> <span class="ndport_texto_info">(<?= __('Empty means value by default', 'noticiero_de_portada') ?>)</span></td>
				<td><input class="ndport_campo_formulario_noticia_de_portada" type="text" name="texto_pagina_noticias_antiguas" id="texto_pagina_noticias_antiguas" value="<?= $texto_pagina_noticias_antiguas ?>" /></td>
			</tr>
		</tbody>
	</table>
		<input type="hidden" name="operacion" id="operacion" value="2" />
	</form>
	<br/>
	<a href="javascript:ndport_cancelar();" class="ndport_boton_accion"><?= __('Cancel', 'noticiero_de_portada') ?></a>&nbsp;
	<a href="javascript:ndport_continuar();" class="ndport_boton_accion"><?= __('Continue', 'noticiero_de_portada') ?></a>
<?php	
}//final de dibujar_formulario_parametros

function ndport_dibuja_retorno(){
?>
	<strong><?= __('Parameters have been saved', 'noticiero_de_portada') ?></strong>
	<br/><br/>
	<form name="formulario_retorno" id="formulario_retorno" method="post" action="<?= menu_page_url('menu_noticias_portada', false) ?>">
		<a href="javascript:document.getElementById('formulario_retorno').submit();" class="ndport_boton_accion"><?= __('Continue', 'noticiero_de_portada') ?></a>
	</form>
<?php
}//final de ndport_dibuja_retorno
?>
<script>

function ndport_cancelar(){
	document.getElementById('ndport_formulario_parametros').action = "<?= menu_page_url('menu_noticias_portada', false) ?>";
	document.getElementById('ndport_formulario_parametros').submit();
}//final de ndport_cancelar()

function ndport_continuar(){
	if (ndport_validar_formulario()){
		document.getElementById('ndport_formulario_parametros').action = "<?= menu_page_url('configurar_noticias', false) ?>";
		document.getElementById('ndport_formulario_parametros').submit();
	}
}//final de ndport_continuar()


function ndport_validar_formulario(){
	var errores = "0";
	var hayErrores = false;
	var msgError = "<?= __('Next errors have been found', 'noticiero_de_portada') ?>:\n\n";
	if (document.getElementById('noticias_en_portada').value==""){
		hayErrores = true; errores++;
		msgError = msgError + errores + ".- <?= __('You must provide the number of news items to display in the front page', 'noticiero_de_portada') ?>.\n";
	}
	if (hayErrores)
		alert(msgError);
	return !hayErrores;
}//final de ndport_validar_formulario()
</script>
<h2 class="ndport_titular_seccion"><?= __('Front Page News', 'noticiero_de_portada') ?></h2>
<?php
	if ($operacion == "1"){
		ndport_recuperar_parametros();
		ndport_dibujar_formulario_parametros();
	} else {
		ndport_guardar_parametros();
		ndport_dibuja_retorno();
	}

?>


