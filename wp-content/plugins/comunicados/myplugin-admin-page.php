<?php
/*
Plugin Name: Comunicados DDC
Description: Plugin para la Gesti&oacute;n de Comunicados en la DDC Cusco
Author: J. Villar
Author URI: http://www.facebook.com/ervija
Version: 1.0
*/

function addMenu2 () {
    add_menu_page("Comunicados", "Comunicados", 4, "comunicados", "publica_comunicados", "dashicons-megaphone");
    add_submenu_page("comunicados", "Agregar Comunicado", "Agregar Comunicado", 4, "anade-comunicado", "anade_comunicado2");
}

function corrige_estilos2() {
    echo '<script>
        window.addEventListener("load", function() {
            var wpc = document.getElementById("wpcontent");
            
            // wpc.clientHeight = document.body.clientHeight;
            wpc.style.height=document.body.clientHeight+"px";
            wpc.classList.add("formulario-comunicados");
            
            var children = wpc.querySelectorAll("#wpbody, #wpbody-content, #wpbody-content>div, iframe");
            for(var i=0; i<children.length; i++) {
                children[i].style.height="100%";
                if (i == 2){
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

function publica_comunicados() {
    echo '
        <div style="height: 100%;">
            <iframe src="../wp-content/plugins/comunicados/comunicados/index.php" style="width: 100%;"></iframe>
        </div>
        ';

    corrige_estilos2();
}

function anade_comunicado2() {

    echo '
        <div style="height: 100%;">
            <iframe src="../wp-content/plugins/comunicados/comunicados/crear_comunicado.html" style="width: 100%;"></iframe>
        </div>
        ';

    corrige_estilos2();
}

add_action("admin_menu", "addMenu2");

?>