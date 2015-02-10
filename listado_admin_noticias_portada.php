<?php
defined('ABSPATH') or die("You can't be here");

wp_enqueue_style('noticiero_de_portada_admin_styles.css', plugins_url('/estilos/noticiero_de_portada_admin_styles.css', __FILE__ ));

global $wpdb;
global $noticias_de_portada;
global $nombre_de_tabla;
global $ndport_aviso_donacion;

$nombre_de_tabla = $wpdb->prefix . "noticias_de_portada";
$ndport_aviso_donacion = get_option("ndport_aviso_donacion", "5");

function ndport_contar_noticias_de_portada(){
	global $wpdb, $nombre_de_tabla, $noticias_de_portada;
	$noticias_de_portada = $wpdb->get_var("SELECT COUNT(*) FROM " . $nombre_de_tabla);
}//final de ndport_contar_noticias_de_portada()


function ndport_dibuja_formulario_navegacion(){ ?>
	<form name="ndport_nueva_accion" id="ndport_nueva_accion" method="post" action="<?= menu_page_url('crear_modificar_noticias', false) ?>">
		<input type="hidden" name="id" id="id" value="" />
		<input type="hidden" name="operacion" id="operacion" value="1" />
	</form>
<?php } //final de ndport_dibuja_formulario_navegacion

function ndport_dibuja_listado_administrativo_noticias(){
	
	global $wpdb;
	global $nombre_de_tabla;
	$noticias = $wpdb->get_results( "SELECT * FROM " . $nombre_de_tabla . " ORDER BY id DESC");

?>
<table class="wp-list-table widefat fixed pages" cellspacing="0" style="width: 99%">
<thead class="ndport_cabecera_listado_simplificado">
	<tr>
		<th id="title" class="ndport_columna_titular_listado_simplificado" style="" scope="col">
			<?= __('Title', 'noticiero_de_portada') ?>
		</th>
		<th id="description" class="ndport_columna_noticia_listado_simplificado" style="" scope="col">
			<?= __('The news', 'noticiero_de_portada') ?>
		</th>
		<th id="date" class="ndport_columna_fecha_listado_simplificado sortable desc" style="" scope="col">
			<a href="#">
				<span><?= __('Date', 'noticiero_de_portada') ?></span>
				<span class="sorting-indicator"></span>
			</a>
		</th>
	</tr>
</thead>
<tfoot class="ndport_cabecera_listado_simplificado">
	<tr>
		<th id="title" class="ndport_columna_titular_listado_simplificado" style="" scope="col">
			<?= __('Title', 'noticiero_de_portada') ?>
		</th>
		<th id="description" class="ndport_columna_noticia_listado_simplificado" style="" scope="col">
			<?= __('The news', 'noticiero_de_portada') ?>
		</th>
		<th id="date" class="ndport_columna_fecha_listado_simplificado sortable desc" style="" scope="col">
			<a href="#">
				<span><?= __('Date', 'noticiero_de_portada') ?></span>
				<span class="sorting-indicator"></span>
			</a>
		</th>
	</tr>
</tfoot>
<tbody id="the-list">

<?php
$control_pijama = TRUE;
foreach ($noticias as $noticia){
	if ($control_pijama){
		$control_pijama = FALSE;
?>
	<tr id="noticia<?= $noticia->id ?>" class="alternate iedit" valign="top">
<?php	} else {
		$control_pijama = TRUE; ?>
	<tr id="noticia<?= $noticia->id ?>" class="iedit" valign="top">

<?php
	}//final de si pijama
?>
		<td><a href="#" onClick="ndport_modificar_noticia(<?= $noticia->id ?>)"><?= $noticia->titular ?></a></td>
		<td><a href="#" onClick="ndport_modificar_noticia(<?= $noticia->id ?>)"><?= $noticia->la_noticia ?></a></td>
		<td><a href="#" onClick="ndport_modificar_noticia(<?= $noticia->id ?>)"><?= $noticia->fecha ?></a></td>
	</tr>

<?php
	}//final del foreach
?>	
</tbody>
</table>
<?php }//ndport_dibuja_listado_administrativo_noticias

function ndport_dibuja_propiedad(){ 
	global $noticias_de_portada, $ndport_aviso_donacion; ?>
	<div class="ndport_ordenacion_creado_por">
	<div id="ndport_madeby"><p class="ndport_plugin_creado_por"><?= __('This plugin has been developed by', 'noticiero_de_portada') ?>: <a href="http://www.in2design.es" target="_blank" class="ndport_plugin_creado_por_nosotros">In2Design</a>.</p></div>
<?php	if ($noticias_de_portada > $ndport_aviso_donacion){ ?>
	<div id="ndport_please_donate" onclick="ndport_inicia_donacion();" style="cursor: pointer; ">
			<p class="ndport_texto_donaciones"><img class="alignright" width="85" height="40" src="<?= plugins_url('/imagenes/btn_donar_tarjetado_en.png', __FILE__ ) ?>"/>
			<?= __("We don't want to charge you for using our plugins. If you find this plugin valuable for you please, consider making a donation. We will be able to improve our plugins and developing many more ones", 'noticiero_de_portada') ?>.
			</p>
	</div>
<?php
	}//final de si hay aviso
?>
	<div id="ndport_visit_us"><p class="ndport_enlace_donaciones"><?= __('Visit us, make comments and request more plugins at','noticiero_de_portada') ?> <a href="http://www.in2design.es" target="_blank" class="ndport_enlace_donaciones_web">http://www.in2design.es</a></p></div>
<?php
}//final de ndport_dibuja_propiedad

require_once('funcion_donaciones.php');

?>



<?php
	ndport_contar_noticias_de_portada();
?>

<script>
	function ndport_crear_noticia(){
		document.getElementById('ndport_nueva_accion').submit();
	}//final de ndport_crear_noticia
	function ndport_modificar_noticia(id_noticia_editable){
		document.getElementById('id').value = id_noticia_editable;
		document.getElementById('ndport_nueva_accion').submit();
	}//final de ndport_modificar_noticia
	function ndport_inicia_donacion(){
		document.getElementById('formulario_paypal').submit();
	}//final de ndport_inicia_donacion
</script>	
<div class="ndport_ordenacion_titular_seccion">
	<h2 class="ndport_titular_seccion"><?= __('Front Page News', 'noticiero_de_portada') ?> <a href="javascript:ndport_crear_noticia();" class="ndport_boton_accion"><?= __('Create news item', 'noticiero_de_portada') ?></a></h2>
	<p class="ndport_contador_noticias"><?= __('There are currently', 'noticiero_de_portada') ?> <strong><?= $noticias_de_portada ?></strong> <?= __('news items', 'noticiero_de_portada') ?>.</p>
</div>
<?= ndport_dibuja_propiedad(); ?>
</div>
<?php
	ndport_dibuja_formulario_navegacion();
	ndport_dibuja_formulario_ppal();
	ndport_dibuja_listado_administrativo_noticias();
?>
<br/>
<a href="javascript:ndport_crear_noticia();" class="ndport_boton_accion"><?= __('Create news item', 'noticiero_de_portada') ?></a>
<p class="ndport_como_usar_shortcodes"><?= __('To enable the hot news viewer, just add the', 'noticiero_de_portada') ?> <i>shortcode</i> <code>[ndp_portada]</code> <?= __('wherever you need', 'noticiero_de_portada') ?>.<br/>
<?= __('To enable the old news viewer, just add the', 'noticiero_de_portada') ?> <i>shortcode</i> <code>[ndp_hemeroteca]</code> <?= __('wherever you need', 'noticiero_de_portada') ?>.</p>
