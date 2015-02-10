<?php
defined('ABSPATH') or die("You can't be here");

function ndport_desinstalar_plugin() {

	global $wpdb;

	delete_option( 'ndport_aviso_donacion' );
	delete_option( 'idpagina_noticias_antiguas' );
	delete_option( 'numero_noticias_en_portada' );
	delete_option( 'ndport_db_version' );

	$nombre_de_tabla = $wpdb->prefix . "noticias_de_portada";

	$wpdb->query( "DROP TABLE IF EXISTS " . $nombre_de_tabla );

}//final de ndport_desinstalar_plugin

?>