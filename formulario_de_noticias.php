<?php
defined('ABSPATH') or die("You can't be here");

wp_enqueue_style  ('noticiero_de_portada_admin_styles.css', plugins_url('/estilos/noticiero_de_portada_admin_styles.css', __FILE__ ));
wp_enqueue_script ('jquery-ui-datepicker');
wp_enqueue_style  ('noticiero_de_portada_jquery_theme.css', plugins_url('/estilos/noticiero_de_portada_jquery_theme.css', __FILE__ ));

//todo lo relacionado con la base de datos
global $wpdb, $nombre_de_tabla;
$nombre_de_tabla = $wpdb->prefix . "noticias_de_portada";
global $rows_affected;
//todo lo relacionado con los parámetros
global $id, $titular, $la_noticia, $fecha, $flag_enlace, $texto_enlace, $url_enlace, $misma_ventana_enlace, $flag_highlight;

//limite del tamaño de las noticias
global $caracteres_maximos_noticia;
$caracteres_maximos_noticia = 150;

if (isset($_POST["id"])){
		$id = $_POST["id"];
	} else {
		$id = "0";
	}
if ($id == "") $id = "0";

$operacion= $_POST["operacion"];
if ($operacion == "") $operacion = "0";

$titular = "";
$la_noticia = "";
$fecha = "";
$flag_enlace = 0;
$texto_enlace = "";
$url_enlace = "";
$misma_ventana_enlace = 1;
$flag_highlight = 0;

if ($operacion == 2){

	$titular = stripslashes($_POST["titular"]);
	$la_noticia = stripslashes($_POST["la_noticia"]);
	$fecha = $_POST["fecha"];
	$flag_enlace = $_POST["flag_enlace"];
	$texto_enlace = stripslashes($_POST["texto_enlace"]);
	$url_enlace = $_POST["url_enlace"];
	$misma_ventana_enlace = $_POST["misma_ventana_enlace"];
	$flag_highlight = $_POST["flag_highlight"];

	if ($id == "0"){
		ndport_crea_noticia();
			} else {
		ndport_modifica_noticia();
		}
	
} else {

	if ($id != "0"){

		$noticia = $wpdb->get_row( "SELECT * FROM " . $nombre_de_tabla . " WHERE id=" . $id);
		$titular = $noticia->titular;
		$la_noticia = $noticia->la_noticia;
		$fecha = $noticia->fecha;
		$flag_enlace = $noticia->flag_enlace;
		$texto_enlace = $noticia->texto_enlace;
		$url_enlace = $noticia->url_enlace;
		$misma_ventana_enlace = $noticia->misma_ventana_enlace;
		$flag_highlight = $noticia->flag_highlight;
		
	}//final de si se trata de modificar
	
}//final del control de operaciones
	
function ndport_dibuja_noticia_preview_creacion(){ ?>
						<div class="leftbox_right" id="preview_bloque">
							<div class="ndport_news_box" id="preview_organizador">
								<div class="ndport_date" id="preview_fecha"><small><?= __('Date', 'noticiero_de_portada') ?></small></div>
								<p class="ndport_news_title" id="preview_titular"><?= __('News Title', 'noticiero_de_portada') ?></p>
								<p class="ndport_news_content" id="preview_noticia"><?= __('News content', 'noticiero_de_portada') ?></p>
								<div class="ndport_news_read_more" id="preview_enlace" style="display: none;"><a href="#" target="_blank" id="preview_enlace_navegable" class="ndport_news_read_more_enlace" ><?= __('link', 'noticiero_de_portada') ?></a></div>
							</div>
						</div>
<?php
}//final de ndport_dibuja_noticia_preview_creacion

function ndport_dibuja_noticia_preview_modificacion(){ 

		global $id, $titular, $la_noticia, $fecha, $flag_enlace, $texto_enlace, $url_enlace, $misma_ventana_enlace, $flag_highlight;

					if ($flag_highlight) {?>
						<div class="ndport_news_box" id="preview_bloque">
							<div class="ndport_resPortada" id="preview_organizador">
<?php } else { ?>
						<div class="leftbox_right" id="preview_bloque">
							<div class="ndport_news_box" id="preview_organizador">
<?php } ?>
							
								<div class="ndport_date" id="preview_fecha"><?= $fecha ?></div>
								<p class="ndport_news_title" id="preview_titular"><?= $titular ?></p>
								<p class="ndport_news_content" id="preview_noticia"><?= $la_noticia ?></p>
								<?php if ($flag_enlace){ ?>
									<div class="ndport_news_read_more" id="preview_enlace"><a href="<?= $url_enlace ?>" target="_blank" id="preview_enlace_navegable" class="ndport_news_read_more_enlace" ><?= $texto_enlace ?></a></div>
								<?php } else { ?>
									<div class="ndport_news_read_more" id="preview_enlace" style="display: none;"><a href="#" target="_blank" id="preview_enlace_navegable" class="ndport_news_read_more_enlace" ></a></div>
								<?php } ?>
								
							</div>
						</div>
<?php
}//final de ndport_dibuja_noticia_preview_modificacion

function ndport_dibuja_formulario_avanzado(){

		global $id, $titular, $la_noticia, $fecha, $flag_enlace, $texto_enlace, $url_enlace, $misma_ventana_enlace, $flag_highlight;
		
		global $caracteres_maximos_noticia;
?>
<form id="formulario_de_accion" name="formulario_de_accion" method="post" action="">
	<table border="0" width="100%">
		<thead class="ndport_cabecera_listado_simplificado">
			<tr>
				<td style="width: 28%"><?= __('Field', 'noticiero_de_portada') ?></td>
				<td style="width: 35%"><?= __('Value', 'noticiero_de_portada') ?></td>
				<td style="width: 35%"><?= __('Preview', 'noticiero_de_portada') ?></td>
				<td style="width: 2%">&nbsp;</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="ndport_label_campo_formulario"><?= __('News Title', 'noticiero_de_portada') ?><div class="ndport_asteriscos_obligatoriedad">(*)</div></td>
				<td><input class="ndport_campo_formulario_noticia_de_portada" type="text" name="titular" id="titular" value="DDD" onBlur="ndport_actualizar_contenido_noticia(this.id, this.value);"/></td>
				<script>jQuery("#titular").val("<?= mysql_real_escape_string($titular) ?>");</script>
				<td rowspan="8" style="vertical-align: top; background-color: white;">
					<div class="center_content3">
						<h3>&nbsp;&nbsp;<strong><?= __('Hot News', 'noticiero_de_portada') ?></strong></h3>
						<?php if ($id == "0") {
									ndport_dibuja_noticia_preview_creacion();
								} else {
									ndport_dibuja_noticia_preview_modificacion();
								}?>						
					</div>

				</td>
				<td rowspan="8">&nbsp;</td>
			</tr>
			<tr>
				<td class="ndport_label_campo_formulario"><?= __('News content', 'noticiero_de_portada') ?><div class="ndport_asteriscos_obligatoriedad">(*)</div></td>
				<td><textarea class="ndport_campo_formulario_noticia_de_portada" name="la_noticia" id="la_noticia" rows="5" onBlur="ndport_actualizar_contenido_noticia(this.id, this.value);" onKeyUp="ndport_contar_caracteres(this)" ></textarea><div id="ndport_div_contador_caracteres"><?= __('Max length', 'noticiero_de_portada') ?> <?= $caracteres_maximos_noticia ?> <?= __('characters', 'noticiero_de_portada') ?>. <?= __('Remaining', 'noticiero_de_portada') ?>: <input type="text" id="ndport_contador_caracteres" class="ndport_contador_caracteres" value="<?= $caracteres_maximos_noticia - strlen($la_noticia) ?>" onFocus="ndport_liberar_foco_contador();"/></div></td>
				<script>jQuery("#la_noticia").val("<?= mysql_real_escape_string($la_noticia) ?>");</script>
			</tr>
			<tr>
				<td class="ndport_label_campo_formulario"><?= __('News date', 'noticiero_de_portada') ?><div class="ndport_asteriscos_obligatoriedad">(*)</div></td>
				<td><input class="ndport_fecha_noticia ndport_campo_formulario_noticia_de_portada" type="text" name="fecha" id="fecha" value="<?= $fecha ?>"  onChange="ndport_actualizar_contenido_noticia(this.id, this.value);"/></td>
			</tr>
			<tr>
				<td class="ndport_label_campo_formulario"><?= __('News with link', 'noticiero_de_portada') ?></td>
				<td><input class="ndport_campo_formulario_noticia_de_portada" type="checkbox" name="cb_flag_enlace" id="cb_flag_enlace" <?php if($flag_enlace=="1") echo "checked"; ?> onClick="ndport_cambiar_estado_noticia_tiene_enlace(this);" /></td>
			</tr>
			<tr>
				<td class="ndport_label_campo_formulario"><?= __('Link text', 'noticiero_de_portada') ?><div class="ndport_asteriscos_obligatoriedad" id="ndport_oblig_linktext" <?php if($flag_enlace!="1") echo "style=\"visibility: hidden\""; ?>>(*)</div></td>
				<td><input class="ndport_campo_formulario_noticia_de_portada" type="text" name="texto_enlace" id="texto_enlace" value="<?= $texto_enlace ?>"  onBlur="ndport_actualizar_contenido_noticia(this.id, this.value);"/></td>
			</tr>
			<tr>
				<td class="ndport_label_campo_formulario"><?= __('Link url', 'noticiero_de_portada') ?><div class="ndport_asteriscos_obligatoriedad" id="ndport_oblig_linkurl" <?php if($flag_enlace!="1") echo "style=\"visibility: hidden\""; ?>>(*)</div></td>
				<td><input class="ndport_campo_formulario_noticia_de_portada" type="text" name="url_enlace" id="url_enlace" value="<?= $url_enlace ?>"  onBlur="ndport_actualizar_contenido_noticia(this.id, this.value);"/></td>
			</tr>
			<tr>
				<td class="ndport_label_campo_formulario"><?= __('Link navigates in the same window', 'noticiero_de_portada') ?></td>
				<td><input class="ndport_campo_formulario_noticia_de_portada" type="checkbox" name="cb_misma_ventana_enlace" id="cb_misma_ventana_enlace" <?php if($misma_ventana_enlace=="1") echo "checked"; ?> onClick="ndport_cambiar_estado_enlace_abre_misma_ventana(this);" /></td>
			</tr>
			<tr>
				<td class="ndport_label_campo_formulario"><?= __('News with highlight', 'noticiero_de_portada') ?></td>
				<td><input class="ndport_campo_formulario_noticia_de_portada" type="checkbox" name="cb_flag_highlight" id="cb_flag_highlight" <?php if($flag_highlight=="1") echo "checked"; ?> onClick="ndport_cambiar_estado_noticia_tiene_highlight(this);" /></td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" name="id" id="id" value="<?= $id ?>" />
	<input type="hidden" id="operacion" name="operacion" value="2" />
	<input type="hidden" name="flag_enlace" id="flag_enlace" value="<?= $flag_enlace ?>" />
	<input type="hidden" name="misma_ventana_enlace" id="misma_ventana_enlace" value="<?= $misma_ventana_enlace ?>" />
	<input type="hidden" name="flag_highlight" id="flag_highlight" value="<?= $flag_highlight ?>" />
</form>
<br/>
<a href="javascript:cancelar();" class="ndport_boton_accion"><?= __('Cancel', 'noticiero_de_portada') ?></a>&nbsp;
<a href="javascript:continuar();" class="ndport_boton_accion"><?= __('Continue', 'noticiero_de_portada') ?></a>

<?php
}//final de dibuja_formulario_avanzado
?>

<script>

function cancelar(){
	document.getElementById('formulario_de_accion').action = "<?= menu_page_url('menu_noticias_portada', false) ?>";
	document.getElementById('formulario_de_accion').submit();
}//final de recargar_con_parametros()

function continuar(){
	if (ndport_validar_formulario()){
		ndport_limpiar_campos();
		document.getElementById('formulario_de_accion').action = "<?= menu_page_url('crear_modificar_noticias', false) ?>";
		document.getElementById('formulario_de_accion').submit();
	}
}//final de recargar_con_parametros()

function ndport_cambiar_estado_noticia_tiene_enlace(check){
	if (check.checked){
		document.getElementById('flag_enlace').value="1";
		document.getElementById('preview_enlace').style.display = "block";
		document.getElementById('ndport_oblig_linktext').style.visibility= "visible";
		document.getElementById('ndport_oblig_linkurl').style.visibility= "visible";
		} else {
		document.getElementById('flag_enlace').value="0";
		document.getElementById('preview_enlace').style.display = "none";
		document.getElementById('ndport_oblig_linktext').style.visibility= "hidden";
		document.getElementById('ndport_oblig_linkurl').style.visibility= "hidden";
		}
}//final de ndport_cambiar_estado_noticia_tiene_enlace

function ndport_cambiar_estado_enlace_abre_misma_ventana(check){
	if (check.checked){
		document.getElementById('misma_ventana_enlace').value="1";
		} else {
		document.getElementById('misma_ventana_enlace').value="0";
		}
}//final de ndport_cambiar_estado_enlace_abre_misma_ventana

function ndport_cambiar_estado_noticia_tiene_highlight(check){
	if (check.checked){
		document.getElementById('flag_highlight').value="1";
		document.getElementById('preview_bloque').className="ndport_news_box";
		document.getElementById('preview_organizador').className="ndport_resPortada";
		} else {
		document.getElementById('flag_highlight').value="0";
		document.getElementById('preview_bloque').className="leftbox_right";
		document.getElementById('preview_organizador').className="ndport_news_box";
		}
}//final de ndport_cambiar_estado_noticia_tiene_highlight

function ndport_validar_formulario(){
	var errores = "0";
	var hayErrores = false;
	var msgError = "<?= __('Next errors have been found', 'noticiero_de_portada') ?>:\n\n";
	if (document.getElementById('titular').value==""){
		hayErrores = true; errores++;
		msgError = msgError + errores + ".- <?= __('You must provide a TITLE for the news', 'noticiero_de_portada') ?>.\n";
	}
	if (document.getElementById('la_noticia').value==""){
		hayErrores = true; errores++;
		msgError = msgError + errores + ".- <?= __('You must provide the NEWS', 'noticiero_de_portada') ?>.\n";
	}
	if (document.getElementById('fecha').value==""){
		hayErrores = true; errores++;
		msgError = msgError + errores + ".- <?= __('You must provide the DATE of the news', 'noticiero_de_portada') ?>.\n";
	}
	if (document.getElementById('cb_flag_enlace').checked){
		if (document.getElementById('texto_enlace').value==""){
			hayErrores = true; errores++;
			msgError = msgError + errores + ".- <?= __('You must provide the TEXT of the LINK', 'noticiero_de_portada') ?>.\n";
		}
		if (document.getElementById('url_enlace').value==""){
			hayErrores = true; errores++;
			msgError = msgError + errores + ".- <?= __('You must provide the URL of the LINK', 'noticiero_de_portada') ?>.\n";
		}
	}//si hay enlace para la noticia
	if (hayErrores)
		alert(msgError);
	return !hayErrores;
}//final de ndport_validar_formulario

function ndport_limpiar_campos(){
	if (!document.getElementById('cb_flag_enlace').checked){
		document.getElementById('texto_enlace').value="";
		document.getElementById('url_enlace').value="";
	}//si no queremos enlace, vaciamos los campos innecesarios
}//final de ndport_limpiar_campos

function ndport_actualizar_contenido_noticia(elemento, contenido){
	if (contenido == "") return;

	var div_a_cambiar;
	switch(elemento.toLowerCase()){
		case "titular": div_a_cambiar = document.getElementById('preview_titular'); break;
		case "la_noticia": div_a_cambiar = document.getElementById('preview_noticia'); break;
		case "fecha": div_a_cambiar = document.getElementById('preview_fecha'); break;
		case "texto_enlace": div_a_cambiar = document.getElementById('preview_enlace_navegable'); break;
		case "url_enlace": div_a_cambiar = document.getElementById('preview_enlace_navegable'); break;
	}
	if (elemento.toLowerCase() != "url_enlace") {
		div_a_cambiar.innerHTML = contenido;
	} else {
		div_a_cambiar.href = contenido;
	}

}//final de actualizar_titular_noticia

	jQuery(document).ready(function(){
	jQuery('.ndport_fecha_noticia').datepicker({
		constrainInput: true, 
		autoSize: true,
		firstDay: 1, 
		dateFormat: 'dd.mm.y'
	});
});
	
function ndport_contar_caracteres(area_texto_controlada){
	var limite_caracteres = <?= $caracteres_maximos_noticia ?>;
	var longitudActual = area_texto_controlada.value.length;
	var caracteres_restantes = limite_caracteres - longitudActual;
	if (longitudActual >= limite_caracteres) {
		area_texto_controlada.value = area_texto_controlada.value.substring(0,limite_caracteres);
		jQuery('#ndport_contador_caracteres').val(0);
	} else {
		jQuery('#ndport_contador_caracteres').val(caracteres_restantes);
	}
	if (caracteres_restantes <= 5){
		jQuery('#ndport_contador_caracteres').removeClass('ndport_contador_caracteres').addClass('ndport_contador_caracteres_limite');
	} else {
		jQuery('#ndport_contador_caracteres').removeClass('ndport_contador_caracteres_limite').addClass('ndport_contador_caracteres');
	}
}//final de ndport_contar_caracteres

function ndport_liberar_foco_contador(){
	jQuery('#la_noticia').focus();
}//final de ndport_liberar_foco_contador()

</script>

<?php
function ndport_crea_noticia(){

	global $wpdb, $nombre_de_tabla, $rows_affected;
	global $id, $titular, $la_noticia, $fecha, $flag_enlace, $texto_enlace, $url_enlace, $misma_ventana_enlace, $flag_highlight;

	$rows_affected = $wpdb->insert( 
		$nombre_de_tabla, 
		array(
			'titular' => $titular, 
			'la_noticia' => $la_noticia, 
			'fecha' => $fecha, 
			'flag_enlace' => $flag_enlace,
			'texto_enlace' => $texto_enlace,
			'url_enlace' => $url_enlace,
			'misma_ventana_enlace' => $misma_ventana_enlace,
			'flag_highlight' => $flag_highlight
			),
		array(
			'%s', 
			'%s', 
			'%s', 
			'%d',
			'%s',
			'%s',
			'%d',
			'%d'
			)
		);//final de insert
	
}//ndport_crea_noticia

function ndport_modifica_noticia(){
	
	global $wpdb, $nombre_de_tabla, $rows_affected;
	global $id, $titular, $la_noticia, $fecha, $flag_enlace, $texto_enlace, $url_enlace, $misma_ventana_enlace, $flag_highlight;
	
	$rows_affected = $wpdb->update( 
		$nombre_de_tabla, 
		array(
			'titular' => $titular, 
			'la_noticia' => $la_noticia, 
			'fecha' => $fecha, 
			'flag_enlace' => $flag_enlace,
			'texto_enlace' => $texto_enlace,
			'url_enlace' => $url_enlace,
			'misma_ventana_enlace' => $misma_ventana_enlace,
			'flag_highlight' => $flag_highlight
			),
		array( 'id' => $id ),
		array(
			'%s', 
			'%s', 
			'%s', 
			'%d',
			'%s',
			'%s',
			'%d',
			'%d'
			),
		array( '%d' )
		);//final del update
	
}//final de ndport_modifica_noticia

function ndport_dibuja_retorno(){
?>
	<br/>
	<form name="formulario_retorno" id="formulario_retorno" method="post" action="<?= menu_page_url('menu_noticias_portada', false) ?>">
		<a href="javascript:document.getElementById('formulario_retorno').submit();" class="ndport_boton_accion"><?= __('Continue', 'noticiero_de_portada') ?></a>
	</form>
<?php
}//final de ndport_dibuja_retorno

?>
<h2 class="ndport_titular_seccion"><?= __('Front Page News', 'noticiero_de_portada') ?></h2>
<?php
if ($operacion != "2") {
		ndport_dibuja_formulario_avanzado(); 
	} else {
		if ($id == "0") {
			$accion_html_text = __('Create News Item', 'noticiero_de_portada');
		} else {
			$accion_html_text = __('Update News Item', 'noticiero_de_portada');
		}
		if ($rows_affected == 1){
			echo "<strong>" . __('Operation', 'noticiero_de_portada') . " <i>{$accion_html_text}</i> " . __('was successfully executed','noticiero_de_portada') ."</strong><br/>";
		} else {
			echo "<strong>" . __('Operation', 'noticiero_de_portada') . " <i>{$accion_html_text}</i> " . __('failed','noticiero_de_portada') ."</strong><br/>";
		}
		ndport_dibuja_retorno();
	}
?>
