=== Hot News Manager ===
Contributors: Jorge Cerrejon Rubayo - In2Design (<a href="http://www.in2design.es">in2design.es</a>)
Donate link: http://www.in2design.es/en/donar/
Tags: noticia, noticias, noticiero, portada, hemeroteca, news, breaking, hot, frontpage, home, homepage, manager, management, admin, administration, highlight
Requires at least: 3.4
Tested up to: 4.1
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin will let the wordpress site administrator create and manage news items to be displayed at any page using shortcodes.

== Description ==

NOTA: Puedes leer la descrición en español en la lengüeta "Other Notes".

= Description =

This plugin has 2 sections, one to publish the hot news items at front page and old news items at any other page and other section to manage the entire system. 
The first is used directly by typing the proper shortcode wherever the administrator decides, and the second is a full management section at admin panel.

From now on, we will refer only to the management section.

The administrator will get a list of the current news in system, letting him change the news items or create new ones. The form is quite easy and simple, 
and offers a fully functional previewer to anticipate the outcome. Each news item will have (as a maximum of fields):

Most relevant fields:
* main title
* body
* date

Secondary fields:
* link to get more info (such as "read more" or "visit") with text, url and the place to be opened (self page or new tab).
* highlight; this will add a special border with shadow effect to make user focus on it.

The setup form will let the administrator manage:
* the number of news items to be displayed at the front page.
* the plugin will display the message/link "read old news", taking the user to a specific place where the old news should be displayed. This place
will own an unique post/page id that must be provided to the hot news management plugin.

In order to work properly, the plugin will create a special table in your wp database (that will be deleted if you uninstall the plugin. 
Deactivation won't delete the table). The plugin can't work without that table.

= Hot News Manager Plugin Needs Your Support =

It is hard to continue development and support for this free plugin without contributions from users like you. We don't want to charge you for using our plugins. If you find this plugin valuable for you please, consider making a donation. We will be able to improve our plugins and developing many more ones. 

= Supported languages =

This plugin comes in english and provides these other languages:

* spanish

== Descripción (SPA)==

NOTE: This is the spanish translation of the description.

Este plugin tiene dos secciones, una para publicar las noticias de portada en la página principal (o en cualquier otra a su elección) y otra sección para gestionar 
todo el sistema. La primera se puede utilizar directamente mediante la utilización del shortcode correspondiente allí donde decida el administrador del sitio, y la 
segunda es una completa sección de gestión dentro del panel de administración.

De ahora en adelante, nos referiremos tan solo a la sección de gestión.

El administrador obtiene un listado de las noticias actuales dentro del sistema, permitiendole modificarlas o crear otras nuevas. El formulario es sencillo,
y ofrece un previsualizador totalmente funcional para validar la noticia antes de publicarla. Cada noticia tendrá (como máximo de campos):

Los campos más importantes:
* título de la noticia
* cuerpo de la noticia
* fecha de la noticia

Campos secundarios:
* enlace a más información (tal como "leer más" o "visitanos") configurable con texto, url y ventana en la que abrirse (la propia ventana o una nueva).
* resalto; añadirá un reborde especial sombreado para destacar la noticia y centrar la atención del visitante.

El formulario de configuración permitirá al administrador gestionar:
* el número de noticias a mostrar en la página principal
* El plugin mostrará en enlace "Leer noticias antiguas", llevando al usuario al lugar donde se motrará la hemeroteca. Esta página tendrá su identificador 
único de página que deberemos proporcionar al gestor de noticias.

Para poder funcionar, el plugin creará una nueva tabla dentro de la base de datos de wordpress (que se eliminará si el plugin se desinstala. La desactivación
no eliminará la tabla). El plugin no puede funcionar sin dicha tabla.

= El plugin Hot News Manager Necesita tu ayuda =

Es difícil continuar desarrollando y dando soporte a nuestros plugins gratuitos sin usuarios que contribuyan. No queremos cobrar por nuestros plugins. Si este 
plugin es valioso para ti, por favor, considera hacer una donación. Con ello seguiremos mejorando nuestros plugins y creando muchos más.

== Installation ==

1. Download the plugin, unzip it and upload to the folder /wp-content/plugins/
2. Go to plugins section and activate "Hot News Manager Plugin"
3. Background process to create the news items table and the global variables will be executed

If you prefer, as an alternative, you can go to plugins section and follow the next steps:

1. Click on "add new",
2. in the search field type "hot news manager",
3. click on "install",

As an alternative, upload the downloaded plugin (.zip file) on the 'Add New' plugins screen in your WP admin area and activate.

Any installation procedure you choose should finally display a new option in your admin menu, "Hot news admin" where you can start working.

== Frequently Asked Questions ==

= What is "Page id where old news can be read"? =

You can display the current hot news using the first shortcode. This list will display only the last N news items (the value of N can be setup from admin panel). 
In order to show the old news you must use the second shortcode in at least one page (such as pressroom, newsroom, company news, so on.). This page will have 
it's own page_id, and you will have to indicate it to the plugin manager.

If this page is not created, "read old news" link won't be available.

The text for the link "read old news" can be customized through admin panel.

= Can I delete a news item? =

No. Freeware version has not this feature. Donors will get this capability and others usefull ones.

== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png
3. screenshot-3.png

== Changelog ==

= 1.1 =
* improved the printing of header/title for the news items section.

= 1.0 =
* First non-beta version (baseline for the next versions)

