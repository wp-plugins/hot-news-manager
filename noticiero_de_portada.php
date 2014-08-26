<?php
/*
* Plugin Name: Hot News Manager
* Description: Manage your own news items and display them at your front page or wherever you need. Easy management, easy publish and easy access to old news items.
* Version: 1.0
* Author: In2Design
* Author URI: http://www.in2design.es
*/

wp_enqueue_style('noticiero_de_portada_styles.css', plugins_url('/estilos/noticiero_de_portada_styles.css', __FILE__ ));

global $wpdb, $nombre_de_tabla, $idpagina_noticias_antiguas, $texto_pagina_noticias_antiguas;
$nombre_de_tabla = $wpdb->prefix . "noticias_de_portada";
$idpagina_noticias_antiguas = get_option('idpagina_noticias_antiguas', '0');
$texto_pagina_noticias_antiguas = get_option('texto_pagina_noticias_antiguas', '');

function ndport_dibuja_noticias_en_portada(){
	global $wpdb, $nombre_de_tabla, $idpagina_noticias_antiguas;
	$limite_noticias = get_option('numero_noticias_en_portada', '5');//este valor debe ser recogido de parametrización
	$noticias = $wpdb->get_results( "SELECT * FROM " . $nombre_de_tabla . " ORDER BY id DESC LIMIT " . $limite_noticias);

?>
	<div class="ndport_center_content3">
<?php
	
	foreach($noticias as $noticia){ 

		if ($noticia->flag_highlight){
			echo "<div class=\"ndport_news_box\">\n";
			echo 	"<div class=\"ndport_resPortada\">\n";
		} else {
			echo "<div class=\"leftbox_right\">\n";
			echo 	"<div class=\"ndport_news_box\">\n";
		}
		echo 			"<div class=\"ndport_date\">" . $noticia->fecha . "</div>\n";
		echo 			"<p class=\"ndport_news_title\">" . $noticia->titular . "</p>\n";
		echo 			"<p class=\"ndport_news_content\">" . $noticia->la_noticia . "</p>\n";
		
		if ($noticia->misma_ventana_enlace){
			$destino_navegacion = "_self";
		} else {
			$destino_navegacion = "_blank";
		}
		
		if ($noticia->flag_enlace){
			echo 		"<div class=\"ndport_news_read_more\"><a href=\"" . $noticia->url_enlace. "\" target=\"" . $destino_navegacion . "\">". $noticia->texto_enlace . "</a></div>\n";
		}
		echo		"</div><!-- ndport_resPortada o ndport_news_box-->";
		echo	"</div><!-- ndport_news_box o leftbox_right-->";
	} ?>

	</div>
<?php
	ndport_dibuja_enlace_hemeroteca();

}//final de ndport_dibuja_noticias_en_portada

add_shortcode('ndp_portada', 'ndport_dibuja_noticias_en_portada');

function ndport_dibuja_enlace_hemeroteca(){
	global $idpagina_noticias_antiguas, $texto_pagina_noticias_antiguas;
	if ($idpagina_noticias_antiguas > 0){?>
		<div style="text-align: right;">
			<a href="<?= get_site_url() ?>/?page_id=<?= $idpagina_noticias_antiguas ?>">
				<?php if ($texto_pagina_noticias_antiguas != "") {?>
					<?= $texto_pagina_noticias_antiguas ?>
				<?php } else { ?>
					<?= __('Read old news items', 'noticiero_de_portada') ?> &gt;&gt;&gt;
				<?php } ?>
			</a>
		</div>
<?php
	}//final de si hay hemeroteca
}//final de ndport_dibuja_enlace_hemeroteca

function ndport_dibuja_noticias_en_hemeroteca(){
	global $wpdb, $nombre_de_tabla;
	//$limite_noticias = get_option('numero_noticias_en_portada', '5');//este valor debe ser recogido de parametrización
	$noticias = $wpdb->get_results( "SELECT * FROM " . $nombre_de_tabla . " ORDER BY id DESC");

?>

<?php
	
	foreach($noticias as $noticia){ 

		if ($noticia->flag_highlight){
			echo "<div class=\"ndport_news_box\">\n";
			echo 	"<div class=\"ndport_resPortada\">\n";
		} else {
			echo "<div class=\"leftbox_right\">\n";
			echo 	"<div class=\"ndport_news_box\">\n";
		}
		echo 			"<div class=\"ndport_date\">" . $noticia->fecha . "</div>\n";
		echo 			"<p class=\"ndport_news_title\">" . $noticia->titular . "</p>\n";
		echo 			"<p class=\"ndport_news_content\">" . $noticia->la_noticia . "</p>\n";
		
		if ($noticia->misma_ventana_enlace){
			$destino_navegacion = "_self";
		} else {
			$destino_navegacion = "_blank";
		}
		
		if ($noticia->flag_enlace){
			echo 		"<div class=\"ndport_news_read_more\"><a href=\"" . $noticia->url_enlace. "\" target=\"" . $destino_navegacion . "\">". $noticia->texto_enlace . "</a></div>\n";
		}
		echo		"</div><!-- ndport_resPortada o ndport_news_box-->";
		echo	"</div><!-- ndport_news_box o leftbox_right-->";
	} ?>

<?php

}//final de ndport_dibuja_noticias_en_hemeroteca

add_shortcode('ndp_hemeroteca', 'ndport_dibuja_noticias_en_hemeroteca');

add_action('admin_menu', 'ndport_registrar_adminmenu' );

function ndport_registrar_adminmenu(){
	add_menu_page(__('Front Page News Items Administration', 'noticiero_de_portada'), __('Hot News Admin', 'noticiero_de_portada'), 'manage_options', 'menu_noticias_portada', 'ndport_cargar_panel_administracion', plugins_url('noticiero_de_portada/imagenes/icono_menu_admin.jpg'));
	add_submenu_page('menu_noticias_portada', __('Create News Item', 'noticiero_de_portada'), __('Create News Item', 'noticiero_de_portada'), 'manage_options', 'crear_modificar_noticias', 'ndport_cargar_form_crear_noticia');
	add_submenu_page('menu_noticias_portada', __('Hot News Setup', 'noticiero_de_portada'), __('Hot News Setup', 'noticiero_de_portada'), 'manage_options', 'configurar_noticias', 'ndport_cargar_form_parametros');
}//final de registrar_adminpage_noticias_portada

function ndport_cargar_panel_administracion(){
	include ('listado_admin_noticias_portada.php');
}//final de ndport_cargar_panel_administracion

function ndport_cargar_form_crear_noticia(){
	include ('formulario_de_noticias.php');
}//final de ndport_cargar_form_crear_noticia

function ndport_cargar_form_parametros(){
	include ('formulario_de_parametros_noticias.php');
}//final de ndport_cargar_form_crear_noticia

include('instala_noticias_de_portada.php');
register_activation_hook(__FILE__, 'ndport_instalar_plugin');

include('desinstala_noticias_de_portada.php');
register_uninstall_hook(__FILE__, 'ndport_desinstalar_plugin');

add_action('init', 'noticiero_de_portada_textdomain');
	
function noticiero_de_portada_textdomain(){
	load_plugin_textdomain('noticiero_de_portada', false, 'noticiero_de_portada/idiomas/');
}//final de noticiero_de_portada_textdomain	

?>
