<?php
/*
Plugin Name: Convocatorias 2
Description: Plugin para administrar la sección de convocatorias virtuales
Author: DDC-Cusco - AFIT
Author URI: http://www.culturacusco.gob.pe/
Version: 1.0
*/

function addMenu_c () {
  add_menu_page("Convocatorias2", "Convocatorias2", 4, "convocatorias2", "f_convocatorias", "dashicons-megaphone");
//	add_submenu_page("convocatorias2", "Editar Bases", "Editar Bases", 'manage_options', "editar-bases", "edita_bases_c");
}

function corrige_estilos_c() {
    echo '<script>
        window.addEventListener("load", function() {
            var wpc = document.getElementById("wpcontent");
            
            wpc.style.height=document.body.clientHeight+"px";
            wpc.classList.add("formulario-convocatorias2");
            
            var children = wpc.querySelectorAll("#wpbody, #wpbody-content, #wpbody-content>div,#wpbody-content>div>div, iframe");
            for(var i=0; i<children.length; i++) {
                children[i].style.height="100%";
                if (i == 3){
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

function f_convocatorias() {
    echo '<div>
            <iframe src="../wp-content/plugins/convocatorias2/convocatorias2/index.php" style="width: 100%;"></iframe>
        </div>';

		corrige_estilos_c();
}

function edita_bases_c() {
	echo '
        <div style="height: 100%;">
            <iframe src="../wp-content/plugins/convocatorias2/convocatorias2/bases.php" style="width: 100%;"></iframe>
        </div>
        ';
	corrige_estilos_c();
}

add_action("admin_menu", "addMenu_c");

?>