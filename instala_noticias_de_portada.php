<?php
defined('ABSPATH') or die("You can't be here");

function ndport_instalar_plugin(){

	global $ndport_db_version;
	$ndport_db_version = "1.0";

	global $wpdb;

	$nombre_de_tabla = $wpdb->prefix . "noticias_de_portada";

	$sql = "
		CREATE TABLE {$nombre_de_tabla} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			titular varchar(128) NOT NULL,
			la_noticia varchar(255) NOT NULL,
			fecha varchar(8) NOT NULL,
			flag_enlace tinyint(1) NOT NULL DEFAULT '0',
			texto_enlace varchar(32) DEFAULT NULL,
			url_enlace varchar(128) DEFAULT NULL,
			misma_ventana_enlace tinyint(1) DEFAULT '1',
			flag_highlight tinyint(1) NOT NULL DEFAULT '0',
			PRIMARY KEY (id)
		) 	ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
	";
	
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	
	add_option( "ndport_db_version", $ndport_db_version );
	add_option( "numero_noticias_en_portada", "5" );
	add_option( "idpagina_noticias_antiguas", "0" );
	add_option( "ndport_aviso_donacion", "3" );
	
}//final de ndport_instalar_plugin
?>