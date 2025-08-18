<?php
/*
Plugin Name: DDC - Publicaciones
Description: Plugin para la Gesti&oacute;n de Publicaciones en la DDC Cusco
Author: J. Villar
Author URI: http://www.facebook.com/ervija
Version: 1.0
*/

function addMenu4 () {
    add_menu_page("DDC Publicaciones", "Publicaciones", 'manage_options', "ddc-publicaciones", "gestiona_ddc_publicaciones", "dashicons-clipboard");
    add_submenu_page("ddc-publicaciones", "Agregar Publicación", "Agregar Publicación", 'manage_options', "anade-publicacion", "anade_publicacion");
}

function gestiona_ddc_publicaciones() {
    echo '
        <div>
            <iframe src="../wp-content/plugins/ddc-publicaciones/ddc-publicaciones/index.php" style="width: 100%;"></iframe>
        </div>
        ';

    corrige_estilos2();
}

function anade_publicacion() {
    echo '
        <div>
            <iframe src="../wp-content/plugins/ddc-publicaciones/ddc-publicaciones/crear.php" style="width: 100%;"></iframe>
        </div>
        ';

    corrige_estilos2();
}

add_action("admin_menu", "addMenu4");

?>