<?php
 
//CARGA EL STYLE.CSS DEL TEMA PADRE EN EL TEMA HIJO
require_once get_stylesheet_directory() . '/niveles/functions.php';
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

function colormag_child_override_widgets() {
    // 1. Eliminar el widget original del padre
    unregister_widget( 'colormag_featured_posts_widget' );

    // 2. Incluir el archivo del hijo con tu clase modificada
    require_once get_stylesheet_directory() . '/inc/widgets/class-colormag-featured-posts-widget.php';

    // 3. Registrar tu nueva clase (la tuya, no la del padre)
    register_widget( 'colormag_featured_noticias_widget' );
}
add_action( 'widgets_init', 'colormag_child_override_widgets', 20 );

/* ****************************************************************************** */
// cargar carpeta niveles
/* ******************************************************************************** */
require_once get_stylesheet_directory() . '/niveles/functions.php';


/* ****************************************************************************** */
/* ****************************************************************************** */
/**
 * colormag_dj_drc_publicaciones
 */
/*class colormag_dj_drc_publicaciones extends WP_Widget{

    function __construct() {
        $widget_ops = array( 'classname' => 'widget_featured_posts widget_featured_drc_publicaciones widget_featured_meta', 'description' => __( 'Agregar una Publicacion', 'colormag') );
        $control_ops = array( 'width' => 200, 'height' => 250 );
        parent::__construct( false,$name= __( 'DRC: Publicaciones', 'colormag' ),$widget_ops);
    }

    function form($instance){
        $tg_defaults['titulo_seccion'] = '';

        $tg_defaults['publi_enlace_1'] = '';
        $tg_defaults['publi_img_url_1'] = '';
        $tg_defaults['publi_enlace_2'] = '';
        $tg_defaults['publi_img_url_2'] = '';
        $tg_defaults['publi_enlace_3'] = '';
        $tg_defaults['publi_img_url_3'] = '';
        $tg_defaults['publi_enlace_4'] = '';
        $tg_defaults['publi_img_url_4'] = '';


        $instance = wp_parse_args((array)$instance, $tg_defaults);

        $titulo_seccion = esc_attr($instance['titulo_seccion']);

        for ($i=1; $i < 5; $i++) {
            $publi_enlace = 'publi_enlace_'.$i;
            $publi_imgurl = 'publi_img_url_'.$i;
            $instance[$publi_enlace] = esc_url($instance[$publi_enlace]);
            $instance[$publi_imgurl] = esc_url($instance[$publi_imgurl]);
        }
        ?>

        <label><?php _e( 'Agregar Publicacion', 'colormag' ); ?></label>
        <!-- titulo de la seccion -->
        <p>
            <label for="<?php echo $this->get_field_id('titulo_seccion'); ?>"><?php echo 'Titulo de la Seccion' ?></label>
            <input id="<?php echo $this->get_field_id('titulo_seccion'); ?>" name="<?php echo $this->get_field_name('titulo_seccion'); ?>" type="text" class="widefat" value="<?php echo $titulo_seccion; ?>" />
        </p>
        <!-- publicacion 1,2,3,4 -->
        <?php
        for ($i=1; $i < 5; $i++) {
            $publi_enlace = 'publi_enlace_'.$i;
            $publi_imgurl = 'publi_img_url_'.$i;
            //}
            ?>
            <hr>
            <h4>Publicación: <?php echo ' '.$i; ?></h4>

            <p><!-- enlace de la publicacion -->
                <label for="<?php echo $this->get_field_id($publi_enlace); ?>"> <?php echo 'Enlace: ' ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id($publi_enlace); ?>" name="<?php echo $this->get_field_name($publi_enlace); ?>" value="<?php echo $instance[$publi_enlace]; ?>"/>
            </p>
            <p><!-- imagen de la publicacion -->
                <label for="<?php echo $this->get_field_id($publi_imgurl); ?>"> <?php echo 'Imagen del Parque: '; ?></label>
            <div class="media-uploader" id="<?php echo $this->get_field_id($publi_imgurl); ?>">
                <div class="custom_media_preview">
                    <?php if($instance[$publi_imgurl] != '') : ?>
                        <img class="custom_media_preview_default" src="<?php echo esc_url($instance[$publi_imgurl]); ?>" style="max-width: 100%;">
                    <?php endif; ?>
                </div>
                <input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id($publi_imgurl); ?>" name="<?php echo $this->get_field_name($publi_imgurl); ?>" value="<?php echo esc_url($instance[$publi_imgurl]); ?>" style="margin-top: 5px;"/>
                <button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id($publi_imgurl); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'colormag' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'colormag' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'colormag' ); ?></button>
            </div>
            </p>
            <hr>
        <?php }//end for ?>
        <?php
    }#end function form

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance[ 'titulo_seccion' ] = strip_tags( $new_instance[ 'titulo_seccion' ] );

        #publicaciones 1,2,3,4
        for ($i=1; $i < 5; $i++) {
            $publi_enlace = 'publi_enlace_'.$i;
            $publi_imgurl = 'publi_img_url_'.$i;
            $instance[$publi_enlace] = esc_url_raw($new_instance[$publi_enlace]);
            $instance[$publi_imgurl] = esc_url_raw($new_instance[$publi_imgurl]);
        }

        return $instance;
    }

    function widget( $args, $instance ) {
        extract( $args );
        extract( $instance );

        //$titulo_seccion = isset( $instance[ 'titulo_seccion' ] ) ? $instance[ 'titulo_seccion' ] : '';
        $titulo_seccion    = apply_filters( 'widget_title', isset( $instance['titulo_seccion'] ) ? $instance['titulo_seccion'] : '' );

        $publi_enlace_array = array();
        $publi_imgurl_array = array();

        #publicacion 1,2,3,4
        for ($i=1; $i < 5; $i++) {
            $publi_enlace = 'publi_enlace_'.$i;
            $publi_imgurl = 'publi_img_url_'.$i;

            $publi_enlace = isset($instance[$publi_enlace]) ? $instance[$publi_enlace] : '';
            $publi_imgurl = isset($instance[$publi_imgurl]) ? $instance[$publi_imgurl] : '';

            if(!empty($publi_enlace))
                array_push($publi_enlace_array, $publi_enlace);
            if(!empty($publi_imgurl))
                array_push($publi_imgurl_array, $publi_imgurl);
        }

        echo $before_widget;
        ?>

        <?php
        //titulo de la seccion
        if ( !empty( $titulo_seccion ) )
            echo '<h3 class="widget-title"><span>'. esc_html( $titulo_seccion ) .'</span>
                    <a class="view-all-link" href="/publicaciones" title="" target="_blank" style="width: auto">Ver Publicaciones &gt;&gt;</a>
                </h3>';
        //mostrar publicacion 1,2,3,4
        $output = '';
        for ($i=1; $i < 5; $i++) {
            $j = $i - 1;
            $output .= '<div class="first-post publi2">';
            $output .= '<div class="single-article clearfix">';
            $output .= '<figure>';
            $output .= '<a href="'.$publi_enlace_array[$j].'" title="" target="_blank">';
            $output .= '<img width="211" height="205" src="'.$publi_imgurl_array[$j].'" class="attachment-colormag-featured-post-medium size-colormag-featured-post-medium wp-post-image" alt="" title="">';
            $output .= '</a>';
            $output .= '</figure>';
            $output .= '</div></div>';
        }
        echo $output;
        ?>
        <?php

        echo $after_widget;
    }

}*/

/**
 * Widget DRC: Publicaciones (Modernizado para ser compatible con el nuevo ColorMag)
 * Hereda de ColorMag_Widget para usar la nueva estructura y estilos.
 */
/*class colormag_dj_drc_publicaciones extends ColorMag_Widget {

    public function __construct() {
        // 1. Usamos la nueva forma de definir el widget
        $this->widget_cssclass    = 'cm-widget-custom-publications'; // Clase CSS principal propia y única
        $this->widget_description = esc_html__( 'Agregar hasta 4 publicaciones manualmente.', 'colormag' );
        $this->widget_name        = esc_html__( 'DRC: Publicaciones', 'colormag' );

        // 2. Definimos los campos del formulario de forma estructurada
        $this->settings = array(
            'titulo_seccion' => array(
                'type'    => 'text',
                'default' => '',
                'label'   => esc_html__( 'Título de la Sección:', 'colormag' ),
            ),
        );

        // Creamos los campos para las 4 publicaciones dinámicamente
        for ( $i = 1; $i <= 4; $i++ ) {
            $this->settings[ "publi_enlace_{$i}" ] = array(
                'type'    => 'url',
                'default' => '',
                'label'   => sprintf( esc_html__( 'Publicación %d: Enlace', 'colormag' ), $i ),
            );
            $this->settings[ "publi_img_url_{$i}" ] = array(
                'type'    => 'image',
                'default' => '',
                'label'   => sprintf( esc_html__( 'Publicación %d: Imagen', 'colormag' ), $i ),
            );
        }

        // Llamamos al constructor de la clase padre (ColorMag_Widget)
        parent::__construct();
    }

    /**
     * El método form() ya no es necesario.
     * La clase ColorMag_Widget lo genera automáticamente a partir del array $this->settings.
     */

    /**
     * El método update() tampoco es necesario.
     * La clase ColorMag_Widget lo maneja automáticamente.
     */

    /*Salida del widget en el frontend.*/ /*
     
    public function widget( $args, $instance ) {

        // Obtenemos el título de forma segura
        $titulo_seccion = apply_filters( 'widget_title', isset( $instance['titulo_seccion'] ) ? $instance['titulo_seccion'] : '' );

        // 3. Usamos las funciones de la nueva clase base para la envoltura
        $this->widget_start( $args );

        // 4. Usamos la función del tema para mostrar el título (si existe)
        if ( ! empty( $titulo_seccion ) ) {
            // El tema ahora maneja la etiqueta <a> por separado en el título. Lo replicamos.
            echo $args['before_title'] . esc_html( $titulo_seccion );
            echo '<a class="view-all-link" href="/publicaciones" title="Ver todas las publicaciones" target="_blank">Ver Publicaciones &gt;&gt;</a>';
            echo $args['after_title'];
        }

        echo '<div class="cm-posts">'; // Envoltura para los posts

        // Iteramos para mostrar las publicaciones
        for ( $i = 1; $i <= 4; $i++ ) {
            $enlace = isset( $instance[ "publi_enlace_{$i}" ] ) ? esc_url( $instance[ "publi_enlace_{$i}" ] ) : '';
            $imagen = isset( $instance[ "publi_img_url_{$i}" ] ) ? esc_url( $instance[ "publi_img_url_{$i}" ] ) : '';

            // Solo mostramos el post si tiene enlace e imagen
            if ( ! empty( $enlace ) && ! empty( $imagen ) ) {
                ?>
                <!-- 5. Usamos la nueva estructura y clases CSS del tema -->
                <div class="cm-post">
                    <figure class="cm-featured-image">
                        <a href="<?php echo $enlace; ?>" title="" target="_blank">
                            <img width="211" height="205" src="<?php echo $imagen; ?>" alt="">
                        </a>
                    </figure>
                    <!-- El nuevo diseño es más simple, solo muestra la imagen con su enlace -->
                </div>
                <?php
            }
        }
        
        echo '</div>'; // Cierre de la envoltura .cm-posts

        // 6. Usamos la función de la nueva clase base para cerrar la envoltura
        $this->widget_end( $args );
    }
}

// Registrar el widget
add_action( 'widgets_init', function() {
    register_widget( 'colormag_dj_drc_publicaciones' );
});*/

/* ****************************************************************************** */
/* WIDGET DE PUBLICACIONES EN PAGINA PRINCIPAL
/* ****************************************************************************** */

// Cargar el widget luego del padre
function mi_tema_hijo_cargar_codigo_personalizado() {

    // verificar que exista la clase ColorMag_Widget
    if ( ! class_exists( 'ColorMag_Widget' ) ) {
        return; // Si no existe, no hacemos nada.
    }

    // Widget DRC: Publicaciones ---------------------
    class colormag_dj_drc_publicaciones extends ColorMag_Widget {

        // construir la funcion, para escoger publicaciones manualmente, con url e imagen
        public function __construct() {
            $this->widget_cssclass    = 'cm-featured-posts '; 
            $this->widget_description = esc_html__( 'Agregar hasta 4 publicaciones manualmente.', 'colormag' );
            $this->widget_name        = esc_html__( 'DRC: Publicaciones', 'colormag' );

            $this->settings = array(
                'titulo_seccion' => array(
                    'type'    => 'text',
                    'default' => '',
                    'label'   => esc_html__( 'Título de la Sección:', 'colormag' ),
                ),
            );

            for ( $i = 1; $i <= 4; $i++ ) {
                $this->settings[ "publi_enlace_{$i}" ] = array(
                    'type'    => 'url',
                    'default' => '',
                    'label'   => sprintf( esc_html__( 'Publicación %d: Enlace', 'colormag' ), $i ),
                );
                $this->settings[ "publi_img_url_{$i}" ] = array(
                    'type'    => 'image',
                    'default' => '',
                    'label'   => sprintf( esc_html__( 'Publicación %d: Imagen', 'colormag' ), $i ),
                );
            }

            parent::__construct();
        }

        public function widget( $args, $instance ) {

            $titulo_seccion = isset( $instance['titulo_seccion'] ) ? $instance['titulo_seccion'] : '';

            $this->widget_start( $args );

            if ( ! empty( $titulo_seccion ) ) {
                $this->widget_title( 
                    $titulo_seccion, // título
                    'latest',        // tipo (si tu helper lo pide)
                    0                // categoría (si aplica)
                );
            }


            for ( $i = 1; $i <= 4; $i++ ) {
                $enlace = isset( $instance[ "publi_enlace_{$i}" ] ) ? esc_url( $instance[ "publi_enlace_{$i}" ] ) : '';
                $imagen = isset( $instance[ "publi_img_url_{$i}" ] ) ? esc_url( $instance[ "publi_img_url_{$i}" ] ) : '';

                if ( ! empty( $enlace ) && ! empty( $imagen ) ) {
                    ?>
                    <div class="first-post publi2">
                        <div class="single-article clearfix">
                            <figure>
                                <a href="<?php echo $enlace; ?>" title="" target="_blank">
                                    <img width="211" height="205"
                                        src="<?php echo $imagen; ?>"
                                        class="attachment-colormag-featured-post-medium size-colormag-featured-post-medium wp-post-image"
                                        alt=""
                                        title="">
                                </a>
                            </figure>
                        </div>
                    </div>
                    <?php
                }
            }
            
            $this->widget_end( $args );
        }
    } 

    // Registrar el widget
    add_action( 'widgets_init', function() {
        register_widget( 'colormag_dj_drc_publicaciones' );
    });

} 

// cargar la función luego del padre
add_action( 'after_setup_theme', 'mi_tema_hijo_cargar_codigo_personalizado' );



/* ****************************************************************************** */
/* ****************************************************************************** */
/**
 * colormag_dj_drc_parques
 */
class colormag_dj_drc_parques extends WP_Widget {

    function __construct() {
        $widget_ops = array( 'classname' => 'widget_featured_posts widget_featured_drc_parques widget_featured_meta', 'description' => __( 'Mostrar los Parques Arqueologicos.', 'colormag') );
        $control_ops = array( 'width' => 200, 'height' =>250 );
        parent::__construct( false,$name= __( 'DRC: Parques Arqueologicos', 'colormag' ),$widget_ops);
    }

    function form( $instance ) {
        $tg_defaults['titulo_seccion'] = '';

        $tg_defaults['nombre_parque_1'] = '';
        $tg_defaults['descripcion_parque_1'] = '';
        $tg_defaults['enlace_parque_1'] = '';
        $tg_defaults['img_url_parque_1'] = '';

        $tg_defaults['nombre_parque_2'] = '';
        $tg_defaults['descripcion_parque_2'] = '';
        $tg_defaults['enlace_parque_2'] = '';
        $tg_defaults['img_url_parque_2'] = '';

        $tg_defaults['nombre_parque_3'] = '';
        $tg_defaults['descripcion_parque_3'] = '';
        $tg_defaults['enlace_parque_3'] = '';
        $tg_defaults['img_url_parque_3'] = '';

        $tg_defaults['nombre_parque_4'] = '';
        $tg_defaults['descripcion_parque_4'] = '';
        $tg_defaults['enlace_parque_4'] = '';
        $tg_defaults['img_url_parque_4'] = '';

        $instance = wp_parse_args( (array) $instance, $tg_defaults );

        $titulo_seccion = esc_attr( $instance[ 'titulo_seccion' ] );

        for ($i=1; $i < 5; $i++) {
            $parque_nombre = 'nombre_parque_'.$i;
            $parque_descripcion = 'descripcion_parque_'.$i;
            $parque_enlace = 'enlace_parque_'.$i;
            $parque_url = 'img_url_parque_'.$i;

            $instance[$parque_nombre] = esc_attr($instance[$parque_nombre]);
            $instance[$parque_descripcion] = esc_textarea($instance[$parque_descripcion]);
            $instance[$parque_enlace] = esc_url($instance[$parque_enlace]);
            $instance[$parque_url] = esc_url($instance[$parque_url]);
        }
        ?>

        <p><?php _e( 'Layout will be as below:', 'colormag' ) ?></p>
        <div style="text-align: center;"><img src="<?php echo get_template_directory_uri() . '/img/style-3.jpg'?>"></div>
        <!-- titulo de la seccion -->
        <p>
            <label for="<?php echo $this->get_field_id('titulo_seccion'); ?>"><?php echo 'Titulo de la Seccion' ?></label>
            <input id="<?php echo $this->get_field_id('titulo_seccion'); ?>" name="<?php echo $this->get_field_name('titulo_seccion'); ?>" type="text" class="widefat" value="<?php echo $titulo_seccion; ?>" />
        </p>

        <!-- parque 1,2,3,4 -->
        <?php
        for ($i=1; $i < 5; $i++) {
            $parque_nombre = 'nombre_parque_'.$i;
            $parque_descripcion = 'descripcion_parque_'.$i;
            $parque_enlace = 'enlace_parque_'.$i;
            $parque_url = 'img_url_parque_'.$i;
            ?>
            <hr>
            <h4>Parque<?php echo ' '.$i.': '.$instance[$parque_nombre]; ?></h4>
            <p><!-- nombre del parque -->
                <label for="<?php echo $this->get_field_id($parque_nombre); ?>"><?php echo 'Nombre del Parque: '; ?></label>
                <input id="<?php echo $this->get_field_id($parque_nombre); ?>" name="<?php echo $this->get_field_name($parque_nombre); ?>" type="text" value="<?php echo $instance[$parque_nombre]; ?>" />
            </p>
            <p><!-- descripcion del parque -->
                <label for="<?php echo $this->get_field_id($parque_descripcion); ?>"><?php echo 'Descripción: ' ?></label>
                <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id($parque_descripcion); ?>" name="<?php echo $this->get_field_name($parque_descripcion); ?>"><?php echo $instance[$parque_descripcion]; ?></textarea>
            </p>
            <p><!-- enlace a la pagina del parque -->
                <label for="<?php echo $this->get_field_id($parque_enlace); ?>"> <?php echo 'Enlace: ' ?></label>
                <input type="text" class="widefat" id="<?php echo $this->get_field_id($parque_enlace); ?>" name="<?php echo $this->get_field_name($parque_enlace); ?>" value="<?php echo $instance[$parque_enlace]; ?>"/>
            </p>
            <p><!-- imagen del parque -->
                <label for="<?php echo $this->get_field_id($parque_url); ?>"> <?php echo 'Imagen del Parque: '; ?></label>
            <div class="media-uploader" id="<?php echo $this->get_field_id($parque_url); ?>">
                <div class="custom_media_preview">
                    <?php if($instance[$parque_url] != '') : ?>
                        <img class="custom_media_preview_default" src="<?php echo esc_url($instance[$parque_url]); ?>" style="max-width: 100%;">
                    <?php endif; ?>
                </div>
                <input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id($parque_url); ?>" name="<?php echo $this->get_field_name($parque_url); ?>" value="<?php echo esc_url($instance[$parque_url]); ?>" style="margin-top: 5px;"/>
                <button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id($parque_url); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'colormag' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'colormag' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'colormag' ); ?></button>
            </div>
            </p>
            <hr>
        <?php }//end for ?>
        <?php
    }#end function form

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['titulo_seccion'] = strip_tags($new_instance['titulo_seccion']);

        #parque 1,2,3,4
        for ($i=1; $i < 5; $i++) {
            $parque_nombre = 'nombre_parque_'.$i;
            $parque_descripcion = 'descripcion_parque_'.$i;
            $parque_enlace = 'enlace_parque_'.$i;
            $parque_url = 'img_url_parque_'.$i;
            $instance[$parque_nombre] = strip_tags($new_instance[$parque_nombre]);
            if(current_user_can('unfiltered_html'))
                $instance[$parque_descripcion] = $new_instance[$parque_descripcion];
            else
                $instance[$parque_descripcion] = stripslashes( wp_filter_post_kses( addslashes($new_instance[$parque_descripcion]) ) );
            $instance[$parque_enlace] = esc_url_raw($new_instance[$parque_enlace]);
            $instance[$parque_url] = esc_url_raw($new_instance[$parque_url]);
        }
        return $instance;
    }

    function widget( $args, $instance ) {
        extract( $args );
        extract( $instance );

        $titulo_seccion = isset( $instance[ 'titulo_seccion' ] ) ? $instance[ 'titulo_seccion' ] : '';
        $parque_nombre_array = array();
        $parque_descripcion_array = array();
        $parque_enlace_array = array();
        $parque_url_array = array();

        #parque 1,2,3,4
        for ($i=1; $i < 5; $i++) {
            $parque_nombre = 'nombre_parque_'.$i;
            $parque_descripcion = 'descripcion_parque_'.$i;
            $parque_enlace = 'enlace_parque_'.$i;
            $parque_url = 'img_url_parque_'.$i;

            $parque_nombre = isset($instance[$parque_nombre]) ? $instance[$parque_nombre] : '';
            $parque_descripcion = isset($instance[$parque_descripcion]) ? $instance[$parque_descripcion] : '';
            $parque_enlace = isset($instance[$parque_enlace]) ? $instance[$parque_enlace] : '';
            $parque_url = isset($instance[$parque_url]) ? $instance[$parque_url] : '';

            if(!empty($parque_nombre))
                array_push($parque_nombre_array, $parque_nombre);
            if(!empty($parque_descripcion))
                array_push($parque_descripcion_array, $parque_descripcion);
            if(!empty($parque_enlace))
                array_push($parque_enlace_array, $parque_enlace);
            if(!empty($parque_url))
                array_push($parque_url_array, $parque_url);
        }
        echo $before_widget;
        ?>

        <?php
        //titulo de la seccion
        if (!empty($titulo_seccion))
            // echo '<h3 class="widget-title">
            //          <span>'. esc_html( $titulo_seccion ) .'</span>
            //          <a class="view-all-link" href="'.get_site_url().'/parques-arqueologicos" title="parques arqueologicos" target="_blank">Ver parques >></a>
            //       </h3>';
            echo '<h3 class="widget-title">
                     <span>'. esc_html( $titulo_seccion ) .'</span>
                  </h3>';

        //parque 1,2,3,4
        $output = '';
        if(!empty($parque_nombre_array)) {
            $output .= '<div class="parques-arq">';
            for ($i=1; $i < 5; $i++) {
                $j = $i - 1;
                if(!empty($parque_url_array)) {
                    if (!empty($parque_enlace_array)) {
                        $output .= '<div class="single-article clearfix">';
                        $output .= '<figure>';
                        $output .= '<a href="'.$parque_enlace_array[$j].'" title="" >';
//                        $output .= '<img width="195" height="102" src="'.$parque_url_array[$j].'" class="attachment-colormag-featured-post-medium size-colormag-featured-post-medium wp-post-image" alt="" title="">';
                        $output .= '<img width="195" height="102" src="'.str_replace('172.16.2.74','www.culturacusco.gob.pe',$parque_url_array[$j]).'" class="attachment-colormag-featured-post-medium size-colormag-featured-post-medium wp-post-image" alt="" title="">';
                        $output .= '</a>';
                        $output .= '</figure>';
                    } else {
                        $output .= '<div class="single-article clearfix">';
                        $output .= '<figure>';
//                        $output .= '<img width="195" height="102" src="'.$parque_url_array[$j].'" class="attachment-colormag-featured-post-medium size-colormag-featured-post-medium wp-post-image" alt="" title="">';
                        $output .= '<img width="195" height="102" src="'.str_replace('172.16.2.74','www.culturacusco.gob.pe',$parque_url_array[$j]).'" class="attachment-colormag-featured-post-medium size-colormag-featured-post-medium wp-post-image" alt="" title="">';
                        $output .= '</figure>';
                    }
                }
                $output .= '<div class="article-content">';
                $output .= '<h3 class="entry-title">
                              <a href="'.$parque_enlace_array[$j].'" title="">'.$parque_nombre_array[$j].'</a>
                           </h3>';
                $output .= '<div class="entry-content">
                              <p>'.$parque_descripcion_array[$j].'</p>
                           </div>';
                $output .= '</div>';
                $output .= '</div>';
            }
        }
//        $output33 = '<div class="single-article drc-more-parques clearfix">
//                        <a href="http://www.culturacusco.gob.pe/index.php/patrimonio-cultural/patrimonio-arqueologico/parques-arqueologicos" title="" target="_blank">Ver parques</a>
//                     </div>';

        // -- Extra
        $output .= '<div class="item">
                        <div style="text-align: center"><a href="#" class="read_mmore">-- MOSTRAR MÁS --</a></div>
                        
    
                        <span class="mmore_text" style="display: none">
                            <div class="single-article clearfix">
        <figure><a href="/parques-arqueologicos/chinchero" title=""><img width="195" height="102" src="/wp-content/uploads/2017/07/Banner_Parks01.png" class="attachment-colormag-featured-post-medium size-colormag-featured-post-medium wp-post-image" alt="" title=""></a></figure><div class="article-content"><h3 class="entry-title">
        <a href="/parques-arqueologicos/chinchero" title="">Chinchero</a>
        </h3><div class="entry-content">
        <p>Se ubica en la localidad de Chinchero,en el distrito del mismo nombre, Provincia de Urubamba. Fue declarado como Parque Arqueológico a través de la Resolución Directoral Nacional Nº 515 del año 2005.</p>
        </div></div></div>
                            <div class="single-article clearfix">
                            <figure><a href="/parques-arqueologicos/pikillaqta/" title=""><img width="195" height="102" src="/wp-content/uploads/2017/07/Banner_Parks03.png" class="attachment-colormag-featured-post-medium size-colormag-featured-post-medium wp-post-image" alt="" title=""></a></figure><div class="article-content"><h3 class="entry-title">
                            <a href="/parques-arqueologicos/pikillaqta/" title="">Pikillaqta</a>
                            </h3><div class="entry-content">
                            <p>El Parque Arqueológico de Pikillaqta está ubicado a 32 km de la ciudad del Cusco, en la provincia de Quispicanchi. Ha sido declarado como tal mediante Resolución Directoral Nacional Na 396 del año 2002.</p>
                            </div></div></div>
                            <div class="single-article clearfix">
                            <figure><a href="/parques-arqueologicos/tipon/" title=""><img width="195" height="102" src="/wp-content/uploads/2017/07/Banner_Parks04.png" class="attachment-colormag-featured-post-medium size-colormag-featured-post-medium wp-post-image" alt="" title=""></a></figure><div class="article-content"><h3 class="entry-title">
                            <a href="/parques-arqueologicos/tipon/" title="">Tipon</a>
                            </h3><div class="entry-content">
                            <p>El Parque Arqueológico de Tipón se ubica en la comunidad de Choquepata,en el distrito de Oropesa, provincia de Quispicanchí, departamento del Cusco. Fue declarado como Parque Arqueológico mediante Resolución Directoral Nac[...].</p>
                            </div></div>
                            </div>
                            <div class="single-article clearfix">
                            <figure><a href="/parques-arqueologicos/choquequirao/" title=""><img width="195" height="102" src="/wp-content/uploads/2017/07/Banner_Parks09.png" class="attachment-colormag-featured-post-medium size-colormag-featured-post-medium wp-post-image" alt="" title=""></a></figure><div class="article-content"><h3 class="entry-title">
                            <a href="/parques-arqueologicos/choquequirao/" title="">Choquequirao</a>
                            </h3><div class="entry-content">
                            <p>[...]</p>
                            </div></div></div>
                            <div class="single-article clearfix">
                            <figure><a href="/parques-arqueologicos/raqchi" title=""><img width="195" height="102" src="/wp-content/uploads/2017/07/Banner_Parks05.png" class="attachment-colormag-featured-post-medium size-colormag-featured-post-medium wp-post-image" alt="" title=""></a></figure><div class="article-content"><h3 class="entry-title">
                            <a href="/parques-arqueologicos/raqchi" title="">Raqchi</a>
                            </h3><div class="entry-content">
                            <p>El Parque Arqueológico de Raqchi está ubicado en la comunidad de Raqchi, distrito de San Pedro, provincia de Carchis en el departamento del Cusco. Fue reconocido como tal mediante Resolución Directoral Nacional Nº 392-2009.</p>
                            </div></div></div>
                            <div class="single-article clearfix">
                                <figure>
                                    <a href="" title="">
                                        <img width="195" height="102" src="/wp-content/uploads/2017/07/Banner_Parks07.png" class="attachment-colormag-featured-post-medium size-colormag-featured-post-medium wp-post-image" alt="" title="">
                                    </a>
                                </figure>
                                <div class="article-content">
                                    <h3 class="entry-title">
                                        <a href="" title="">Moray</a>
                                    </h3>
                                    <div class="entry-content">
                                        <p>El acceso a la zona arqueológica se realiza por dos vías: la primera, la carretera Cusco-Urubamba, que une Maras-Moray a una distancia de 9 kilómetros (desvío al poblado de Maras) y ta otra desde el pueblo de Cruzpata mediante una tr[...]</p>
                                    </div>
                                </div>
                            </div>
                        </span>
                    <div style="text-align: center"><a href="#" class="read_mminus" style="display: none">-- MOSTRAR MENOS --</a></div>
                    </div>
                    <script>
                    
                    $("a.read_mmore").click(function(event){
                
                        event.preventDefault();
                        $(this).parents(".item").find(".mmore_text").show();
                        $(this).parents(".item").find(".read_mmore").hide();
                        $(this).parents(".item").find(".read_mminus").show();
                
                    });
                    $("a.read_mminus").click(function(event){
                
                        event.preventDefault();
                        $(this).parents(".item").find(".mmore_text").hide();
                        $(this).parents(".item").find(".read_mmore").show();
                        $(this).parents(".item").find(".read_mminus").hide();
                
                    });
                </script>';
        // -- Extra
        $output .= '</div>';
        echo $output;
        ?>
        <?php

        ?>
        <?php echo $after_widget;
    }

}

// Registrar el widget
add_action( 'widgets_init', function() {
    register_widget( 'colormag_dj_drc_parques' );
});

/* ****************************************************************************** */
/* ****************************************************************************** */

/* *********************************************************************************** */
// función para mostrar publicaciones 

function shortcode_publicaciones()
{

    global $wpdb;

    $retrieve_data = $wpdb->get_results("select imagen, nombre, enlace from `ddc_publicaciones` ORDER BY `fecha` DESC limit 4;");

    $uno = '';
    $dos = '';
    $tres = '';

    if (count($retrieve_data) > 0) {

        $ruta_base = "../../../../dmdocuments/ddc-publicaciones/";

        $uno .= '<section id="colormag_dj_drc_publicaciones-2" class="widget-impar widget-primero widget-1 widget widget_featured_posts widget_featured_drc_publicaciones widget_featured_meta clearfix">
                   <h3 class="widget-title"><span>PUBLICACIONESS</span></h3>';

        foreach ($retrieve_data as $row) {

            $dos .= '<div class="first-post publi2">
                        <div class="single-article clearfix">';

            $dos .= '<figure><a href="' . $row->enlace . '" title="'.$row->nombre.'" target="_blank"><img width="211" height="205" src="/dmdocuments/ddc-publicaciones/img/'.$row->imagen.'" class="attachment-colormag-featured-post-medium size-colormag-featured-post-medium wp-post-image" alt="'.$row->nombre.'"></a></figure>';

            $dos .= '</div>
                   </div>';
        }
    } else {
        return '-- PUBLICACIONES DDC --';
    }

    $tres .= '</section>';

    return $uno . $dos . $tres;
}

add_shortcode('publicaciones_ddc', 'shortcode_publicaciones');


/* *********************************************************************************** */
// mostrar historico de publicaciones en acordeon

function shortcode_histo_publicaciones()
{
    global $wpdb;

    $retrieve_data = $wpdb->get_results("select `imagen`, `nombre`, `enlace`, `pdf`, DATE_FORMAT(`fecha`, \"%d/%m/%y\") as fec, YEAR(`fecha`) as anio from `ddc_publicaciones` ORDER BY `fecha` DESC;");
    $data_anios = $wpdb->get_results("select distinct YEAR(`fecha`) as `anio` from `ddc_publicaciones` order by YEAR(`fecha`) DESC;");

    $html = '';

    // Verificar si existe al menos 1 publicacion en la DB
    if (count($retrieve_data) > 0) {

        $ruta_base = "../../../../dmdocuments/ddc-publicaciones/";

        // Iteración para la sección de Años
        foreach ($data_anios as $anio) {

            $i = 0;
            $final = true;

            if ($i == 0) {
                $html .= '<section id="colormag_dj_drc_publicaciones-2" class="accordion_publi widget-impar widget-primero widget-1 widget widget_featured_posts widget_featured_drc_publicaciones widget_featured_meta clearfix">';
            }
            else {
                $html .= '<section id="colormag_dj_drc_publicaciones-2" class="accordion_publi widget-impar widget-primero widget-1 widget widget_featured_posts widget_featured_drc_publicaciones widget_featured_meta clearfix">';
            }

            $html.= '<h3 class="widget-title">
                        <span>Publicaciones ' . $anio->anio . '</span>
                        <a id="ico_'.$anio->anio.'" class="view-all-link" >Ver mas +</a>
                    </h3>';

            $html.= '</section>';
            $html.= '<div class="panel_publi">';
            // Iterar en la lista de publicaciones
            foreach ($retrieve_data as $data) {

                // Si el año de la publicacion pertenece al del año corriente en la iteración
                if ($data->anio == $anio->anio)
                {
                    if ($i == 0) {
                        $final = false;
                        $html .= '<section id="colormag_dj_drc_publicaciones-2" class="publi_bottom widget-impar widget-primero widget-1 widget widget_featured_posts widget_featured_drc_publicaciones widget_featured_meta clearfix">';
                    }

                    $html .= '<div class="first-post publi2">
                              <div class="single-article clearfix container_publi">
                                 <figure class="image_publi">
                                    <img width="211" height="205" src="/dmdocuments/ddc-publicaciones/img/'.$data->imagen.'" class="attachment-colormag-featured-post-medium size-colormag-featured-post-medium wp-post-image" alt="q1w2">
                                 </figure>
                        <div class="middle_publi">';

                    if ( !is_null($data->enlace) && $data->enlace != '') {
                        $html .= '<a target="_blank" href="'.$data->enlace . '">
                                <div class="text_publi">
                                    VER ENLACE
                                </div>
                            </a>';
                    }
                    else {
                        $html .= '<div class="text_publi">
                                    VER ENLACE
                                </div>';
                    }

                    $html .= '<br>';

                    if ( !is_null($data->pdf) && $data->pdf != '') {
                        $html .= '<a href="'. $ruta_base .$data->pdf.'">
                                <div class="text_publi">
                                    DESCARGAR
                                </div>
                            </a>';
                    }

                    $html .= '</div>
                          </div>
                      <a target="_blank" href="'.$data->enlace . '" tabindex="-1">'.$data->nombre.'</a><br>
                      Publicado el '.$data->fec.'
                          </div>';

                    if ($i == 3) {
                        $html .= '</section>';
                        $final = true;
                        $i = 0;
                    }
                    else $i++;
                }
            }
            if (!$final) $html .= '</section>';

            $html.= '</div>';

        }
    } else return '-- PUBLICACIONES DDC --';

    $script = '<script>
                var acc = document.getElementsByClassName("accordion_publi");
                var i;
                
                for (i = 0; i < acc.length; i++) {
                  acc[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var panel = this.nextElementSibling;
                    var icon = this.children[0].children[1];
                    //var icon = icon.getId();
                    var icon = icon.getAttribute("id");
                    
                    if (panel.style.maxHeight){
                      panel.style.maxHeight = null;
                      document.getElementById(icon).textContent="Ver mas +";
                    } else {
                      panel.style.maxHeight = panel.scrollHeight + "px";
                      document.getElementById(icon).textContent="Ver menos -";
                    }
                    
                  });
                }
                
                document.getElementsByClassName("accordion_publi")[0].click();
                
                </script>';

    return $html . $script;
}

add_shortcode('histo_publicaciones_ddc', 'shortcode_histo_publicaciones');

/* *********************************************************************************** */
