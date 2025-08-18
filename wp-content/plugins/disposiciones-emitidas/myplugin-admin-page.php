<?php
/*
Plugin Name: Disposiciones Emitidas DDC
Description: Plugin para la Gesti&oacute;n de Disposiciones Emitidas en la DDC Cusco
Author: J. Villar
Author URI: http://www.facebook.com/ervija
Version: 2.0
*/

function addMenu3 () {
    add_menu_page("Disposiciones Emitidas", "Disposiciones Emitidas", 4, "disposiciones-emitidas", "gestiona_disp_emitidas", "dashicons-clipboard");
    add_submenu_page("disposiciones-emitidas", "Agregar Disposición", "Agregar Disposición", 4, "anade-disposicion", "anade_disposicion");
}

function corrige_estilos3() {
    echo '<script>
    window.addEventListener("load", function () {
      var wpc = document.getElementById("wpcontent");
  
      // wpc.clientHeight = document.body.clientHeight;
      wpc.style.height = document.body.clientHeight + "px";
      wpc.classList.add("formulario-convocatorias");
      
      // var children = wpc.querySelectorAll(
      //   "#wpbody, #wpbody-content, #wpbody-content>div, iframe"
      // );
      
      var wpbody = wpc.querySelectorAll(
        "#wpbody, #wpbody-content"
      );
      for (var i = 0; i < wpbody.length; i++) {
        wpbody[i].style.height = "100%";
      }
      
      var children = wpc.querySelectorAll(
        "#wpbody-content>div"
      );
      for (var i = 0; i < children.length; i++) {
      
        if (i == 3) {
          children[i].style.height = "100%";
          break;
        }
      
        children[i].style.display = "none";
      
      }
      
      // quitar altura
      // var v_clear = wpc.querySelector(".clear");
      // v_clear.style.height = 0 + "px";
      
      // quitar padding
      var v_clear = wpc.querySelector("#wpbody-content");
      v_clear.style.padding = 0 + "px";
    }, false);
  </script>';
}

function gestiona_disp_emitidas() {
    echo '
        <div>
            <p style="font-size: 22px;">Nuevas Publicaciones deberán ir en la nueva Plataforma <a href="https://www.gob.pe/institucion/culturacusco/normas-legales" target="_blank">GOB.PE</a></p>
            <iframe src="../wp-content/plugins/disposiciones-emitidas/disposiciones-emitidas/index.php" style="width: 100%; height: 100%"></iframe>
        </div>
        ';

    corrige_estilos3();
}

function anade_disposicion() {
    echo '
        <div>
            <iframe src="../wp-content/plugins/disposiciones-emitidas/disposiciones-emitidas/crear.html" style="width: 100%;"></iframe>
        </div>
        ';

    corrige_estilos3();
}

add_action("admin_menu", "addMenu3");

?>