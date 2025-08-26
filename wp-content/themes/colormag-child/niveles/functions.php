<?php
/*----------------------------------------------------------------*/
/*---------------------------   register post type ---------------------*/
/*----------------------------------------------------------------*/

// Register Custom Post Type
function subdireccion_post_type() {

    $labels = array(
        'name'                  => 'Sub direcciones',
        'singular_name'         => 'Sub dirección',
        'menu_name'             => 'Sub direcciones',
        'name_admin_bar'        => 'Sub dirección',
        'archives'              => 'Archivos sub direcciones',
        'parent_item_colon'     => 'Parent sub dirección',
        'all_items'             => 'Todas las sub direcciones',
        'add_new_item'          => 'Agregar nueva sub dirección',
        'add_new'               => 'Agregar nuevo',
        'new_item'              => 'Agregar nueva sub dirección',
        'edit_item'             => 'Editar sub dirección',
        'update_item'           => 'Actualizar sub dirección',
        'view_item'             => 'Ver sub dirección',
        'search_items'          => 'Buscar sub dirección',
        'not_found'             => 'No encontrado',
        'not_found_in_trash'    => 'No encontrado en la papelera',
        'featured_image'        => 'Imagen destacada',
        'set_featured_image'    => 'Poner imagen destacada',
        'remove_featured_image' => 'Quitar imagen destacada',
        'use_featured_image'    => 'Usar como imagen destacada',
        'insert_into_item'      => 'Insertar en la sub dirección',
        'uploaded_to_this_item' => 'Actualizar a la sub dirección',
        'items_list'            => 'Lista de sub direcciones',
        'items_list_navigation' => 'Lista de navegación',
        'filter_items_list'     => 'Filtrar sub direcciones',
        );
    $args = array(
        'labels'                => $labels,
        'description'              => '',
        'hierarchical'          => true,
        'has_archive'           => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        "map_meta_cap"          => true,
        'exclude_from_search'   => false,
        "rewrite" => array( "slug" => "mksubdireccion", "with_front" => false ),
        'query_var' => true,
        "supports" => array( "title", "editor", "thumbnail","author", "custom-fields", "page-attributes" ),
        );
    register_post_type( 'mksubdireccion', $args );

}
add_action( 'init', 'subdireccion_post_type', 0 );

function area_post_type() {

    $labels = array(
        'name'                  => 'Areas',
        'singular_name'         => 'Area',
        'menu_name'             => 'Areas',
        'name_admin_bar'        => 'Area',
        'archives'              => 'Archivos areas',
        'parent_item_colon'     => 'Parent area',
        'all_items'             => 'Todas las areas',
        'add_new_item'          => 'Agregar nueva area',
        'add_new'               => 'Agregar nuevo',
        'new_item'              => 'Agregar nueva area',
        'edit_item'             => 'Editar area',
        'update_item'           => 'Actualizar area',
        'view_item'             => 'Ver area',
        'search_items'          => 'Buscar area',
        'not_found'             => 'No encontrado',
        'not_found_in_trash'    => 'No encontrado en la papelera',
        'featured_image'        => 'Imagen destacada',
        'set_featured_image'    => 'Poner imagen destacada',
        'remove_featured_image' => 'Quitar imagen destacada',
        'use_featured_image'    => 'Usar como imagen destacada',
        'insert_into_item'      => 'Insertar en la area',
        'uploaded_to_this_item' => 'Actualizar la area',
        'items_list'            => 'Lista de areas',
        'items_list_navigation' => 'Lista de navegación',
        'filter_items_list'     => 'Filtrar areas',
        );
    $args = array(
        'labels'                => $labels,
        'description'              => '',
        'hierarchical'          => false,
        "has_archive" => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        "map_meta_cap"          => true,
        'exclude_from_search'   => false,
        "rewrite" => array( "slug" => "/post/%subdirecciones_name%", "with_front " => false ),
        'query_var' => true,
        "supports" => array( "title", "editor", "thumbnail","author", "custom-fields", "page-attributes" ),
        );
    register_post_type( 'mkarea', $args );

}
add_action( 'init', 'area_post_type', 0 );

function noticia_post_type() {

    $labels = array(
        'name'                  => 'Noticias',
        'singular_name'         => 'Noticia',
        'menu_name'             => 'Noticias',
        'name_admin_bar'        => 'Noticia',
        'archives'              => 'Archivos noticias',
        'parent_item_colon'     => 'Parent noticia',
        'all_items'             => 'Todas las noticias',
        'add_new_item'          => 'Agregar nueva noticia',
        'add_new'               => 'Agregar nuevo',
        'new_item'              => 'Agregar nueva noticia',
        'edit_item'             => 'Editar noticia',
        'update_item'           => 'Actualizar noticia',
        'view_item'             => 'Ver noticia',
        'search_items'          => 'Buscar noticia',
        'not_found'             => 'No encontrado',
        'not_found_in_trash'    => 'No encontrado en la papelera',
        'featured_image'        => 'Imagen destacada',
        'set_featured_image'    => 'Poner imagen destacada',
        'remove_featured_image' => 'Quitar imagen destacada',
        'use_featured_image'    => 'Usar como imagen destacada',
        'insert_into_item'      => 'Insertar en la noticia',
        'uploaded_to_this_item' => 'Actualizar la noticia',
        'items_list'            => 'Lista de noticias',
        'items_list_navigation' => 'Lista de navegación',
        'filter_items_list'     => 'Filtrar noticias',
        );
    $args = array(
        'labels'                => $labels,
        'description'           => '',
        'hierarchical'          => false,
        "has_archive"           => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        "map_meta_cap"          => true,
        'exclude_from_search'   => false,
        "rewrite" => array( "slug" => "/noticia/%subdirecciones_name%", "with_front " => false ),
        'query_var' => true,
        "supports" => array( "title", "editor", "thumbnail","author", "custom-fields" ),
        );
    register_post_type( 'noticia', $args );

}
add_action( 'init', 'noticia_post_type', 0 );

add_action( "pre_get_posts", "custom_post_type_in_query" );
function custom_post_type_in_query( $query ){
    // Si no es el query principal salir
   if ( ! $query->is_main_query() ) {
       return;
   }

   if ( 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
       return;
   }

      // Incluir custom post type en el query
   if ( ! empty( $query->query['name'] ) ) {
      $post_types = array('post', 'mkarea', "mksubdireccion", 'page', 'noticia');
      $query->set('post_type', $post_types);
  }
}#end function custom_post_type_in_query

add_action('parse_query', 'cyb_parse_query');
/**
 * [cyb_parse_query funcion para solucionar posibles erros con paginas que se llamen igual a un post_type]
 * @param  [type] $wp_query [description]
 * @return [type]           [description]
 */
function cyb_parse_query( $wp_query ) {

    if( get_page_by_path($wp_query->query_vars['name']) ) {
        $wp_query->is_single = false;
        $wp_query->is_page = true;
    }

}#end function cyb_parse_query



add_action('add_meta_boxes', function() {
    add_meta_box('areas-parent', 'Sub Dirección', 'areas_attributes_meta_box', 'mkarea', 'side', 'default');
    add_meta_box('areas-parent', 'Sub Dirección', 'areas_attributes_meta_box', 'noticia', 'side', 'default');
});

function areas_attributes_meta_box($post) {
    $pages = wp_dropdown_pages(array('post_type' => 'mksubdireccion', 'selected' => $post->post_parent, 'name' => 'parent_id', 'sort_column'=> 'menu_order, post_title', 'echo' => 0));
    if ( ! empty($pages) ) {
        echo $pages;
        } // end empty pages check
    }

    add_action( 'init', function() {
        add_rewrite_rule( '^post/(.*)/([^/]+)/?$','index.php?mkarea=$matches[2]','top' );
        add_rewrite_rule('^noticias/?$', 'index.php?noticiap=y','top');
        add_rewrite_rule('^noticias/page/([0-9]+)/?$', 'index.php?noticiap=y&paged=$matches[1]','top');
        add_rewrite_rule( '^noticia/(.*)/([^/]+)/?$','index.php?noticia=$matches[2]','top' );
        add_rewrite_rule( '^noticias/([a-zA-Z_-]+)/?$','index.php?snoticia=$matches[1]','top' );
        add_rewrite_rule( '^noticias/([a-zA-Z_-]+)/page/([0-9]+)/?$','index.php?snoticia=$matches[1]&paged=$matches[2]','top' );
    });

    add_filter( 'post_type_link', function( $link, $post ) {
        if ( 'mkarea' == get_post_type( $post ) || 'noticia' == get_post_type( $post ) ) {
        //Lets go to get the parent subdireccion name
            if( $post->post_parent ) {
                $parent = get_post( $post->post_parent );
                if( !empty($parent->post_name) ) {
                    return str_replace( '%subdirecciones_name%', $parent->post_name, $link );
                }
            } else {
                return str_replace( '/%subdirecciones_name%', '', $link );
            }

        }
        return $link;
    }, 10, 2 );

    add_filter( 'post_type_link', function( $post_link, $post, $leavename ){
        if ($post->post_type != 'mksubdireccion' || $post->post_status != 'publish') {
            return $post_link;
        }

        $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);
        return $post_link;
    }, 10, 3 );

    /*Agregar metabox*/

    function metabox_color(){
        add_meta_box( "mkmetabox_color", "Color identificador", "agregar_metabox_color", "mksubdireccion", "side", "high" );
}#end function metabox_color
add_action( "add_meta_boxes", "metabox_color");

function agregar_metabox_color( $post ){
    wp_enqueue_script( "Pick color", get_template_directory_uri() . '/niveles/jscolor.js', array( 'jquery' ), '1.0', true );
    #recuperar la variable
    $color = get_post_meta($post->ID, "mkboxcolor", true );
    $imagen = get_post_meta( $post->ID, "mkimagenpost", true );
    $color = !empty( $color ) ? $color : "FFFFFF";
    $imagen = !empty( $imagen ) ? $imagen : "";

    include('partials/display_metabox_color.php');
    wp_nonce_field( basename( __FILE__ ), 'mkmetabox_color' );
}#end function metabox_color

function guardar_box_color( $post_id ){
    // verify taxonomies meta box nonce
    if ( !isset( $_POST['mkmetabox_color'] ) || !wp_verify_nonce( $_POST['mkmetabox_color'], basename( __FILE__ ) ) )
        return;
        // return if autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
        // Check the user's permissions.
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return;
    if( isset( $_REQUEST['mk_metabox_color'] ) )
        update_post_meta( $post_id, "mkboxcolor", sanitize_text_field( $_REQUEST['mk_metabox_color'] ) );

    if( isset( $_REQUEST['mk_imagen'] ) )
        update_post_meta( $post_id, "mkimagenpost", $_REQUEST['mk_imagen'] );

}#end function guardar_box_color
add_action( "save_post", "guardar_box_color" );

function display_subdirecciones_home(){
    #recuperar las subdirecciones
    $get_subdirecciones_posts = new WP_Query( array(
        'posts_per_page'        => "4",
        'post_type'             => 'mksubdireccion',
        'ignore_sticky_posts'   => true,
        'orderby'               => "date",
        'order'                 => "ASC"
        ) );
    include( 'partials/display_list_subdirecciones.php' );
}#end function display_subdirecciones_home
add_action( "mk_mostrar_subdirecciones_home", "display_subdirecciones_home" );

#crear menu de configuracion de sidebar left
add_action( "admin_menu", "admin_menu_sidebar" );
function admin_menu_sidebar(){
    add_menu_page( "Menu sidebar Sub Dirección", "Menu sidebar Sub Dirección", "manage_options", "mksidebar-options", "menu_side_bar_subdireccion", "dashicons-align-left", 98 );
}#end function admin_menu_sidebar

function encontrar_en_arreglo_sidebar( $slider, $elemento ){
    $encontrado = false;
    if( !empty( $slider ) && is_array( $slider ) )
        foreach ($slider as $key => $value) {
            if( $key == $elemento ){
                $encontrado = true;
                break;
            }
        }
        return $encontrado;
}#end function encontrar_en_arreglo_sidebar

function fgenerar_id_unico( $arreglo ){
    do {
        $id = fgenerateID(6);
    } while ( fis_in_table($id, $arreglo)  );

    return $id;
}#end function generar_id_unico

function fis_in_table( $iden, $arreglo ){
    $return = false;
    if( !empty( $arreglo ) && is_array($arreglo) )
        foreach ($arreglo as $key => $value) {
            if( $key == $iden ){
                $return = true;
                break;
            }
        }
        return $return;
}#end function is_in_table
function fgenerateID($lenght){
    $random = '';
    for ($i = 0; $i < $lenght; $i++) {
        $random .= chr(rand(ord('a'), ord('z')));
    }
    return $random;
}#end function fgenerateID

function menu_side_bar_subdireccion(){

    $options_slider             = "";
    $options                    = "";
    $url_nuevo                  = admin_url( "admin.php?page=mksidebar-options" );
    $action                     = "nuevo";
    $id_slider                  = 0;
    $errores                    = array();
    $mensaje                    = "";
    $data_slider                = array();
    $data_slider['titulo']      = "";
        #recuperar options sidebar
    $options_slider = get_option( "mksidebarsbd", false );
    if( !empty($options_slider) OR $options_slider != false )
        $options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );


        #ver si hay que editar un sidebar
    if( isset( $_GET['action'] ) && $_GET['action'] == 'editar' && !isset( $_POST['action'] ) ) {
            #recuperar el id dle elemento a editar
        $action = "editar";
        $id_slider = $_GET['iden'];
            #ver que exista ese item
        $encontrado = encontrar_en_arreglo_sidebar( $options_slider, $id_slider );
        if( !$encontrado )
            wp_redirect( $url_nuevo );
            #caso contrario recuperamos los datos
        $data_slider['titulo']      = isset( $options_slider[$id_slider]['nombre'] ) ? $options_slider[$id_slider]['nombre'] : "";
    }

        #ver si viene un post
    if( isset( $_POST['action'] ) && $_POST['action'] == 'nuevo' ){
        #recuperar los datos
        $data_slider['titulo'] = $_POST['txtTitulo'];
        #validar campo necesario
        if( $data_slider['titulo'] == '' ){
            $errores[] = "Titulo es necesario.";
        } else {
            #verificar que no exista ya un titulo parecido
            $encontrado = false;
            if( !empty( $options_slider ) && is_array( $options_slider ) )
                foreach ($options_slider as $key => $value) {
                    if( $value['nombre'] == $data_slider['titulo'] ){
                        $encontrado = true;
                        break;
                    }
                    }#end foreach options_slider
                    if( $encontrado ){
                        $errores[] = "Titulo ya existente.";
                    }
                }

                if( count( $errores ) == 0 ){
                    #echo "entro";
                    #no tiene errores guardar los datos
                    $iden = fgenerar_id_unico( $options_slider );
                    $options_slider[$iden] = array(
                        "nombre" => $data_slider['titulo'],
                        "slider" => array()
                        );
                    $data_json = base64_encode( serialize( $options_slider ) );
                    update_option( "mksidebarsbd", $data_json );
                }
        }#end action crear
        elseif( isset( $_POST['action'] ) && $_POST['action'] == 'editar' ){

            $id_slider                  = $_POST['txthid'];
            $data_slider['titulo']      = $_POST['txtTitulo'];
            $action                     = "editar";

            #ver que exista este item
            $encontrado = encontrar_en_arreglo_sidebar( $options_slider, $id_slider );
            if( !$encontrado ){
                $errores[] = 'Item no encontrado';
            } else {
                #existe el item del slider
                if( $data_slider['titulo'] == "" ){
                    $errores[] = "Titulo es necesario.";
                } else {
                    #verificar que no exista ya un titulo parecido
                    $encontrado = false;
                    if( !empty( $options_slider ) && is_array( $options_slider ) )
                        foreach ($options_slider as $key => $value) {
                            if( $value['nombre'] == $data_slider['titulo'] && $key != $id_slider ){
                                $encontrado = true;
                                break;
                            }
                    }#end foreach options_slider
                    if( $encontrado ){
                        $errores[] = "Titulo ya existente.";
                    }
                }

            }

            if( count( $errores ) == 0 ){
                #actualizar el item
                $options_slider[$id_slider]['nombre']      = $data_slider['titulo'];

                $data_json = base64_encode( serialize( $options_slider ) );
                update_option( "mksidebarsbd", $data_json );
                $action = "editar";
            }
        }#end action editar
        $options .= '<option value="0" ';
        if( $id_slider === 0 )
            $options .= ' selected="selected" ';
        $options .= ' >-- Seleccionar --</option>';
        if( is_array( $options_slider ) ){
            foreach ($options_slider as $key => $value) {
                #armar la url
                $url = admin_url('admin.php?page=mksidebar-options&action=editar&iden=' . $key);
                $options .= '<option value="'.$url.'" ';
                if( $key === $id_slider )
                    $options .= 'selected="selected"';
                $options .= ' >'.$value['nombre'].'</option>';
                }#end foreach options_slider
            }

            if( !empty( $errores ) ) {
                $mensaje .= '<ul>';
                foreach ($errores as $value) {
                    $mensaje .= '<li>'.$value.'</li>';
            }#end foreach errores
            $mensaje .= '</ul>';
        } elseif( isset( $_POST['action'] ) && $_POST['action'] == 'nuevo' ){
            $mensaje = '<p><strong>Elementro creado</strong></p>';
        } elseif( isset( $_POST['action'] ) && $_POST['action'] == 'editar' ){
            $mensaje = '<p><strong>Elementro actualizado</strong></p>';
        }
        include('partials/display_sidebar_config.php');
}#end function menu_side_bar_subdireccion

add_action( "wp_ajax_displaytemside", "mostrar_side_items" );

function mostrar_side_items(){
    $iden = "0";
    $html = "";
    $send_rpta = array( "recuperado" => 0, "listado" => '<p class="mensajeCentral">No hay elementos en el sidebar.</p>', "mensaje" => "Error inesperado" );

    if( isset( $_POST['iden'] ) )
        $iden = $_POST['iden'];

        #recuperar la cfg del slider
    $options_slider = get_option( "mksidebarsbd", false );
    if( !empty($options_slider) OR $options_slider != false )
        $options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
    $encontrado = false;
    if( !empty( $options_slider ) && is_array( $options_slider ) )
        foreach ($options_slider as $key => $value) {
            if( $iden == $key ){
                $encontrado = true;
                break;
            }
            }#end foreach options_slider
            if( $encontrado ){
                $items = $options_slider[$iden]['slider'];
                if( !empty($items) ){
                    foreach ($items as $key => $value) {
                        $html .= '<div class="itemslider itemslider_'.$key.'">';
                        $html .= '<div class="opts"><div class="mkeditarsidebar" data-iden="'.$key.'" data-idensl="'.$iden.'"><span class="dashicons dashicons-edit"></span></div><div class="mkeliminarsidebar" data-iden="'.$key.'" data-idensl="'.$iden.'"><span class="dashicons dashicons-trash"></span></div></div>';
                        $html .= '<img width="220" src="'.$value['imagen'].'" alt="imagen">';
                        if( $value['titulo'] != '' )
                            $html .= '<h4 class="titulo">'.$value['titulo'].'</h4>';
                        $html .= '</div>';
                }#end foreach items
                $send_rpta['listado'] = $html;
            }
            $send_rpta['recuperado'] = 1;

        }#end if encontrado true

        echo json_encode($send_rpta);
        exit;
}#end function mostrar_side_items

add_action( "wp_ajax_recuperaritemsidebar", "recuperar_item_sidebar" );
function recuperar_item_sidebar(){
    $iden = "0";
    $slider = "0";
    $send_rpta = array("recuperado"=>0, "item"=>"","url"=>admin_url( "admin.php?page=mksidebar-options" ));

    if( isset( $_POST['iden'] ) )
        $iden = $_POST['iden'];
    if( isset( $_POST['slider'] ) )
        $slider = $_POST['slider'];

        #recuperar la cfg del slider
    $options_slider = get_option( "mksidebarsbd", false );
    if( !empty($options_slider) OR $options_slider != false )
        $options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
    $encontrado = false;
    if( !empty( $options_slider ) && is_array( $options_slider ) )
        foreach ($options_slider as $key => $value) {
            if( $slider == $key ){
                $encontrado = true;
                break;
            }
            }#end foreach options_slider
            if($encontrado){
                $slider_array = $options_slider[$slider]['slider'];
                $encontrado = false;
                if( !empty( $slider_array ) && is_array( $slider_array ) )
                    foreach ($slider_array as $key => $value) {
                        if( $iden == $key ){
                            $encontrado = true;
                            break;
                        }
                }#end foreach slider
                if($encontrado){
                #se encontro tambien el slider
                    $send_rpta['item'] = $slider_array[$iden];
                    $send_rpta['recuperado'] = 1;
                }
        }#end if encontrado true

        echo json_encode($send_rpta);
        exit;
}#end function recuperar_item_sidebar

add_action( "wp_ajax_eliminaritemsidebar", "eliminar_item_sidebar" );
function eliminar_item_sidebar(){
    $iden = "0";
    $slider = "0";
    $send_rpta = array("eliminado"=>0);

    if( isset( $_POST['iden'] ) )
        $iden = $_POST['iden'];
    if( isset( $_POST['slider'] ) )
        $slider = $_POST['slider'];

        #recuperar la cfg del slider
    $options_slider = get_option( "mksidebarsbd", false );
    if( !empty($options_slider) OR $options_slider != false )
        $options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
    $encontrado = false;
    if( !empty( $options_slider ) && is_array( $options_slider ) )
        foreach ($options_slider as $key => $value) {
            if( $slider == $key ){
                $encontrado = true;
                break;
            }
            }#end foreach options_slider
            if($encontrado){
                $slider_array = $options_slider[$slider]['slider'];
                $encontrado = false;
                if( !empty( $slider_array ) && is_array( $slider_array ) )
                    foreach ($slider_array as $key => $value) {
                        if( $iden == $key ){
                            $encontrado = true;
                            break;
                        }
                }#end foreach slider
                if($encontrado){
                    unset($slider_array[$iden]);
                    $options_slider[$slider]['slider'] = $slider_array;
                    $data_json = base64_encode( serialize( $options_slider ) );
                    update_option( "mksidebarsbd", $data_json );
                    $send_rpta['eliminado'] = 1;
                }
            }
            echo json_encode($send_rpta);
            exit;
}#end function eliminar_item_sidebar

add_action( "wp_ajax_eliminarslsidebar", "eliminar_sidebar" );
function eliminar_sidebar(){
    $iden = "0";
    $send_rpta = array("eliminado" => 0, "url" => "", "mensaje" =>"Error inesperado!");

    if( isset( $_POST['iden'] ) )
        $iden = $_POST['iden'];

        #recuperar la cfg del slider
    $options_slider = get_option( "mksidebarsbd", false );
    if( !empty($options_slider) OR $options_slider != false )
        $options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
    $encontrado = false;
    if( !empty( $options_slider ) && is_array( $options_slider ) )
        foreach ($options_slider as $key => $value) {
            if( $iden == $key ){
                $encontrado = true;
                break;
            }
            }#end foreach options_slider
            if( $encontrado ){
                unset( $options_slider[$iden] );
                $send_rpta['eliminado'] = 1;
                #recuperar la url
                $send_rpta['url'] = admin_url( "admin.php?page=mksidebar-options" );
                $data_json = base64_encode( serialize( $options_slider ) );
                update_option( "mksidebarsbd", $data_json );
            }

            echo json_encode($send_rpta);
            exit;
}#end function eliminar_sidebar

add_action( "wp_ajax_editaritemsidebar", "editar_item_sidebar" );
function editar_item_sidebar(){
    $id_slider   = 0;
    $id_item     = 0;
    $titulo      = "";
    $enlace      = "";
    $imagen      = "";
    $action      = "";
    $html        = "";
    $send_rpta   = array("modificado"=>0, "listado" => '<p class="mensajeCentral">No hay elementos en el sidebar.</p>', "mensaje" => "Error inesperado");

        #recuperar valores
    if( isset($_POST['cambio']) )
        $action = $_POST['cambio'];
    if( isset($_POST['titulo']) )
        $titulo = $_POST['titulo'];
    if( isset($_POST['enlace']) )
        $enlace = $_POST['enlace'];
    if( isset($_POST['imagen']) )
        $imagen = $_POST['imagen'];
    if( isset($_POST['iditem']) )
        $id_item = $_POST['iditem'];
    if( isset($_POST['idslider']) )
        $id_slider = $_POST['idslider'];

        #recuperar la cfg del slider
    $options_slider = get_option( "mksidebarsbd", false );
    if( !empty($options_slider) OR $options_slider != false )
        $options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
    $encontrado = false;
    if( !empty( $options_slider ) && is_array( $options_slider ) )
        foreach ($options_slider as $key => $value) {
            if( $id_slider == $key ){
                $encontrado = true;
                break;
            }
            }#end foreach options_slider

            if( $encontrado ){
                $slider = $options_slider[$id_slider]['slider'];
            #ver cual es la accion
                if( $action == 'a' ){
                #accion agregar
                    if( empty( $imagen ) )
                        $send_rpta['mensaje'] = "Imagen es necesaria";
                    else {
                    #tiene imagen
                        $iden = fgenerar_id_unico( $slider );
                        $slider[$iden] = array(
                            "titulo" => $titulo,
                            "enlace" => $enlace,
                            "imagen" => $imagen
                            );
                        $options_slider[$id_slider]['slider'] = $slider;
                        $data_json = base64_encode( serialize( $options_slider ) );
                        update_option( "mksidebarsbd", $data_json );
                        $send_rpta['modificado'] = 1;
                        $send_rpta['mensaje'] = "Item insertado";
                } #el se tiene imagen
            } elseif($action == 'e'){
                #accion editar, verificar q el id del slider exista
                $encontrado = false;
                if( !empty( $slider ) && is_array( $slider ) )
                    foreach ($slider as $key => $value) {
                        if( $id_item == $key ){
                            $encontrado = true;
                            break;
                        }
                    }#end foreach slider
                    if($encontrado){
                    #se encontro
                        if( empty( $imagen ) )
                            $send_rpta['mensaje'] = "Imagen es necesaria";
                        else{
                            $slider[$id_item]["titulo"]      = $titulo;
                            $slider[$id_item]["enlace"]      = $enlace;
                            $slider[$id_item]["imagen"]      = $imagen;

                            $options_slider[$id_slider]['slider'] = $slider;
                            $data_json = base64_encode( serialize( $options_slider ) );
                            update_option( "mksidebarsbd", $data_json );
                            $send_rpta['modificado'] = 1;
                            $send_rpta['mensaje'] = "Item actualizado";
                    }#end imagen existe
                } else {
                    $send_rpta['mensaje'] = "Item no localizado!";
                }
            }
        }#end encontrado

        #modificar el listado siemproe y cuando modificado == 1
        if( $send_rpta['modificado'] == 1 ){
            $items = $options_slider[$id_slider]['slider'];
            if( !empty($items) ){
                foreach ($items as $key => $value) {
                    $html .= '<div class="itemslider itemslider_'.$key.'">';
                    $html .= '<div class="opts"><div class="mkeditarsidebar" data-iden="'.$key.'" data-idensl="'.$id_slider.'"><span class="dashicons dashicons-edit"></span></div><div class="mkeliminarsidebar" data-iden="'.$key.'" data-idensl="'.$id_slider.'"><span class="dashicons dashicons-trash"></span></div></div>';
                    $html .= '<img width="220" src="'.$value['imagen'].'" alt="imagen">';
                    if( $value['titulo'] != '' )
                        $html .= '<h4 class="titulo">'.$value['titulo'].'</h4>';
                    $html .= '</div>';
                }#end foreach items
                $send_rpta['listado'] = $html;
            }
        }#end modificado == 1

        echo json_encode($send_rpta);
        exit;

}#end function editar_item_sidebar

add_action( "add_meta_boxes", "agregar_metabox_sidebar" );

function agregar_metabox_sidebar(){
    add_meta_box( "mk_mbsidebar", '<strong>Sidebar</strong>', "mostrar_metabox_sidebar","mksubdireccion", "normal", "low" ) ;
}#end function agregar_metabox_sidebar

function mostrar_metabox_sidebar( $post ){
    $options = "";
        #recuperar metabox
    $idenslider = get_post_meta($post->ID, 'mkpost_sidebar_iden', true );
    if( !$idenslider )
        $idenslider = "0";

    $options .= '<option value="0"';
    if($idenslider == "0")
        $options .= ' selected="selected" ';
    $options .= '>No usar sidebar</option>';
        #recuperar la lista de sliders
    $options_slider = get_option( "mksidebarsbd", false );
    if( !empty($options_slider) OR $options_slider != false )
        $options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
    if( !empty( $options_slider ) && is_array( $options_slider ) )
        foreach ($options_slider as $key => $value) {
            $options .= '<option value="'.$key.'" ';
            if($key == $idenslider)
                $options .= ' selected="selected" ';
            $options .= '>'.$value['nombre'].'</option>';
            }#end foreach options_slider
            include_once('partials/mk-metabox-sidebar-form.php');
            wp_nonce_field( basename( __FILE__ ), 'mk_meta_box_sidebar_icon_nonce' );
}#end function mostrar_metabox_sidebar

add_action( "save_post", "save_metabox_sidebar" );
function save_metabox_sidebar( $post_id ){
    // verify taxonomies meta box nonce
    if ( !isset( $_POST['mk_meta_box_sidebar_icon_nonce'] ) || !wp_verify_nonce( $_POST['mk_meta_box_sidebar_icon_nonce'], basename( __FILE__ ) ) )
        return;
        // return if autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

        // Check the user's permissions.
    if ( ! current_user_can( 'edit_post', $post_id ) )
        return;
    if( isset( $_REQUEST['slt_sidebar_post'] ) ){
        $sld = $_REQUEST['slt_sidebar_post'];
        update_post_meta( $post_id, "mkpost_sidebar_iden", $sld );
        } #end request mk_imagen_listado
}#end function save_metabox_sidebar

#filter
add_filter("query_vars", "rewriteAddVar");
function rewriteAddVar($query_vars) {
    $query_vars[] = "snoticia";
    $query_vars[] = "paged";
    $query_vars[] = "noticiap";
    return $query_vars;
}#end function rewriteAddVar

add_action('template_redirect', 'redirectCatchPage');

function redirectCatchPage() {
    $per_page = '20';
    if(get_query_var("snoticia")) {
        $sbd = get_query_var("snoticia", '');
        #recuperar post type
        $objs = get_posts(array('name'=>$sbd, 'posts_per_page'=>1,'post_type'=>'mksubdireccion','post_status'=>'publish'));
        if($objs) {
            $obj = $objs[0];
            if(get_class($obj) == "WP_Post") {
                #recuperar las noticias de este post
                $paginado = get_query_var("paged", 1);
                if($paginado == 0) {
                    $paginado = 1;
                }
                #$offset = ($paginado - 1) * $per_page;
                $args = array(
                    'post_type' => 'noticia',
                    'post_parent' => $obj->ID,
                    'orderby' => 'date',
                    'order' => "ASC",
                    'posts_per_page' => $per_page,
                    'paged' => $paginado
                    );
                $query_noticias = new WP_Query($args);
                include('partials/display_noticias.php');
            }
        }
        exit;
    } elseif(get_query_var('noticiap')) {
        $paginado = get_query_var("paged", 1);
        if($paginado == 0) {
            $paginado = 1;
        }
        $args = array(
                "post_type" => 'noticia',
                'order_by' => 'date',
                'order' => "DESC",
                'posts_per_page' => $per_page,
                'paged' => $paginado
                );
        $query_noticias = new WP_Query($args);
        include('partials/display_noticias_general.php');
        exit;
    }#noticiap query_var
}#end function redirectCatchPage



function noticias_carrusel_shortcode() {
    // 🔹 Consulta la primera noticia más reciente
    $destacada = new WP_Query(array(
        'post_type'      => 'noticia',
        'posts_per_page' => 1,
    ));

    // 🔹 Consulta las siguientes noticias (excluyendo la destacada)
    $query = new WP_Query(array(
        'post_type'      => 'noticia',
        'posts_per_page' => 6,
        'offset'         => 1,
    ));

    ob_start(); ?>
    
    <div class="noticias-section">
        <h2 class="cm-widget-title"> Noticias</h2>

        <?php if ($destacada->have_posts()): ?>
            <div class="noticia-destacada">
                <?php while ($destacada->have_posts()): $destacada->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="noticia-destacada-link">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="noticia-destacada-img">
                                <?php the_post_thumbnail('large'); ?>
                            </div>
                        <?php endif; ?>
                        <div class="noticia-destacada-contenido">
                            <h3 class="noticia-destacada-titulo"><?php the_title(); ?></h3>
                            <p class="noticia-destacada-fecha">
                                <i class="fa fa-calendar"></i> <?php echo get_the_date(); ?>
                            </p>
                            <p class="noticia-destacada-extracto">
                                <?php echo wp_trim_words(get_the_content(), 45, '...'); ?>
                            </p>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>

        <?php if ($query->have_posts()): ?>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <?php while ($query->have_posts()): $query->the_post(); ?>
                        <div class="swiper-slide noticia-slide">
                            <a href="<?php the_permalink(); ?>" class="noticia-link">
                                <?php if (has_post_thumbnail()): ?>
                                    <div class="noticia-img">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </div>
                                <?php endif; ?>
                                <h3 class="noticia-titulo"><?php the_title(); ?></h3>
                                <p class="noticia-fecha"><i class="fa fa-calendar"></i> <?php echo get_the_date(); ?></p>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Botones de navegación -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <!-- Paginación -->
                <div class="swiper-pagination"></div>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('noticias_carrusel', 'noticias_carrusel_shortcode');



function cargar_swiper() {
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), null, true);

    wp_add_inline_script('swiper-js', "
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.mySwiper', {
                slidesPerView: 3,
                spaceBetween: 20,
                loop: true,
                speed: 1000, // transición más suave
                effect: 'silde', // prueba también 'fade', 'coverflow', 'cards'
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    1024: { slidesPerView: 3 },
                    768: { slidesPerView: 2 },
                    480: { slidesPerView: 1 }
                }
            });
        });
    ");
}
add_action('wp_enqueue_scripts', 'cargar_swiper');
