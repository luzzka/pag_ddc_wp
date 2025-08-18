<?php
/*
Plugin Name: Convocatorias
Description: Plugin para la Gesti&oacute;n de Convocatorias en la DDC Cusco
Author: J. Villar
Author URI: http://www.facebook.com/ervija
Version: 1.0
*/

// function addMenu () {
// 	add_menu_page("Convocatorias", "Convocatorias", 4, "publica-convocatorias", "publica_convocatorias", "dashicons-groups");
// 	add_submenu_page("publica-convocatorias", "Publicar Convocatoria", "Publicar Convocatoria", 4, "anade-convocatoria", "anade_convocatoria");
// }
function addMenu () {
    // add_menu_page("Convocatorias", "Convocatorias", 4, "convocatorias", "publica_convocatorias", "dashicons-groups");
    add_menu_page("Convocatorias", "Convocatorias", 'manage_options', "convocatorias", "publica_convocatorias", plugins_url('convocatorias/icons/wwork.png', __FILE__), '10.000392854349');
    add_submenu_page("convocatorias", "Publicar Convocatoria", "Publicar Convocatoria", 'manage_options', "anade-convocatoria", "anade_convocatoria");
    add_submenu_page("convocatorias", "Editar Bases", "Editar Bases", 'manage_options', "editar-bases", "edita_bases");
}

function corrige_estilos() {
	echo '<script>
        window.addEventListener("load", function() {
            var wpc = document.getElementById("wpcontent");
            
            // wpc.clientHeight = document.body.clientHeight;
            wpc.style.height=document.body.clientHeight+"px";
            wpc.classList.add("formulario-convocatorias");
            
            //var children = wpc.querySelectorAll("#wpbody, #wpbody-content, #wpbody-content>div, iframe");
            var children = wpc.querySelectorAll("#wpbody, #wpbody-content, #wpbody-content:nth-child(2), iframe");
            for(var i=0; i<children.length; i++) {
                children[i].style.height="100%";
                if (i === 3){
                    children[i].style.height = null;
                }
            }            
            
            // quitar altura
            var v_clear = wpc.querySelector(".clear");
            v_clear.style.height = 0+"px";
            
            // quitar padding
            var v_clear = wpc.querySelector("#wpbody-content");
            v_clear.style.padding = 0+"px";
            
        }, false );        
    </script>';
}

function publica_convocatorias() {
	echo '
        <div style="height: 100%;">
            <iframe src="../wp-content/plugins/convocatorias/convocatorias/index.php" style="width: 100%;"></iframe>
        </div>
        ';

	corrige_estilos();
}

function anade_convocatoria() {

	echo '
        <div style="height: 100%;">
            <iframe src="../wp-content/plugins/convocatorias/convocatorias/crear.html" style="width: 100%;"></iframe>
        </div>
        ';
		
	corrige_estilos();
}

function edita_bases() {
    echo '
        <div style="height: 100%;">
            <iframe src="../wp-content/plugins/convocatorias/convocatorias/bases.php" style="width: 100%;"></iframe>
        </div>
        ';
    corrige_estilos();
}

add_action("admin_menu", "addMenu");

?>