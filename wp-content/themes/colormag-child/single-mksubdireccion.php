<?php
/**
 * Plantilla para mostrar un post individual del Custom Post Type 'mksubdireccion'.
 *
 * Este archivo controla la vista de una "Subdirección" individual, mostrando su contenido
 * principal y una barra lateral con widgets personalizados y noticias relacionadas.
 *
 * @package ThemeGrill
 * @subpackage ColorMag
 * @since ColorMag 1.0
 */

// Carga el archivo header.php del tema.
get_header(); ?>

<?php
// Llama a acciones personalizadas del tema, probablemente para sliders o contenido global.
do_action( "mkslider_action_display" );
do_action( 'colormag_before_body_content' );
?>

<!-- Contenedor principal para la maquetación Flexbox de 2 columnas -->
<div class="main-layout-container">

    <!-- =================================================================
         COLUMNA CENTRAL (CENTERSUBDIRECCION) - CONTENIDO PRINCIPAL
         ================================================================= -->
    <div class="ctnsubtp centersubdireccion">
        <div id="content" class="clearfix">
            <?php
            // El Bucle Principal (The Main Loop) de WordPress.
            while ( have_posts() ) : the_post();

                /**
                 * MEJORA: Eliminamos la lógica del "Número Mágico" (ID 413) de la plantilla.
                 * En lugar de `if( get_the_ID() != 413 )`, es mucho mejor usar un filtro
                 * si necesitas ocultar el título de una página específica.
                 *
                 * ¿Cómo hacerlo correctamente? Añade este código a tu archivo functions.php:
                 *
                 * add_filter( 'the_title', 'ocultar_titulo_especifico', 10, 2 );
                 * function ocultar_titulo_especifico( $title, $id = null ) {
                 *     // ID de la página cuyo título quieres ocultar.
                 *     $id_a_ocultar = 413; 
                 *     if ( is_singular('mksubdireccion') && $id == $id_a_ocultar ) {
                 *         return ''; // Devuelve un string vacío para ocultar el título.
                 *     }
                 *     return $title; // Devuelve el título original para todas las demás páginas.
                 * }
                 *
                 * Esto es más limpio, mantenible y sigue las buenas prácticas de WordPress.
                 */

                /**
                 * MEJORA: Reutilizamos el código de `content-single.php`.
                 * En lugar de duplicar todo el código del <article>, simplemente llamamos
                 * a la plantilla parcial. Esto hace que el código sea limpio y fácil de mantener.
                 */
                get_template_part( 'content', 'single' );


                // --- Bloque de Autor, Relacionados y Comentarios (heredado de ColorMag) ---

                // Si el autor del post tiene una biografía, muestra la caja de autor.
                if ( get_the_author_meta( 'description' ) ) {
                    get_template_part('inc/author-bio'); // El tema puede tener una plantilla para esto.
                }

                // Si la opción de "posts relacionados" está activa, la muestra.
                if ( get_theme_mod( 'colormag_related_posts_activate', 0 ) == 1 ) {
                   get_template_part( 'inc/related-posts' );
                }
                
                // Muestra la sección de comentarios si están habilitados.
                if ( comments_open() || get_comments_number() != '0' ) {
                   comments_template();
                }

            endwhile; // Fin del bucle principal.
            ?>
        </div><!-- #content -->
    </div><!-- .centersubdireccion -->


    <!-- =================================================================
         COLUMNA DERECHA (RIGHTSUB) - WIDGETS Y NOTICIAS
         ================================================================= -->
    <div class="ctnsubtp rightsub">
        <?php
        // --- WIDGET 1: LISTA DE OTRAS SUBDIRECCIONES ---
        // (Este bloque es idéntico al de single-mkarea.php, podría convertirse en un template part también)
        $args_subdirs = array(
            "post_type"      => "mksubdireccion",
            "posts_per_page" => 4,
            "orderby"        => "date",
            "order"          => "ASC"
        );
        $subdirecciones = get_posts( $args_subdirs );
        if ( ! empty( $subdirecciones ) ) : ?>
            <div class="block-subdir">
                <div class="block-inner clearfix">
                    <div class="listsubdir_s">
                        <?php foreach ( $subdirecciones as $subdireccion_item ) :
                            $color  = get_post_meta( $subdireccion_item->ID, "mkboxcolor", true ) ?: 'FFFFFF';
                            $imagen = get_post_meta( $subdireccion_item->ID, "mkimagenpost", true );
                        ?>
                            <a href="<?php echo esc_url( get_permalink( $subdireccion_item->ID ) ); ?>">
                                <div class="itemsubdir_s" style="background-color: #<?php echo esc_attr( $color ); ?>;">
                                    <?php if ( ! empty( $imagen ) ) : ?>
                                        <img src="<?php echo esc_url( $imagen ); ?>" alt="<?php echo esc_attr( get_the_title( $subdireccion_item->ID ) ); ?>">
                                    <?php else : ?>
                                        <?php echo esc_html( get_the_title( $subdireccion_item->ID ) ); ?>
                                    <?php endif; ?>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php
        // --- WIDGET 2: SLIDER PERSONALIZADO ---
        // (Este bloque también es reutilizado)
        $idenslider = get_post_meta( get_the_ID(), 'mkpost_sidebar_iden', true );
        if ( ! empty( $idenslider ) && $idenslider != "0" ) {
            $options_slider_raw = get_option( "mksidebarsbd", false );
            if ( ! empty( $options_slider_raw ) ) {
                $options_slider = unserialize( base64_decode( $options_slider_raw ) );
                if ( is_array( $options_slider ) && isset( $options_slider[$idenslider]['slider'] ) ) {
                    $slider = $options_slider[$idenslider]['slider'];
                    if ( ! empty( $slider ) && is_array( $slider ) ) : ?>
                        <div class="block-sidebar">
                            <div class="block-inner clearfix">
                                <div class="view-content">
                                    <?php foreach ( $slider as $slide ) : ?>
                                        <div class="view-item">
                                            <a href="<?php echo esc_url( $slide['enlace'] ); ?>">
                                                <div class="item-image">
                                                    <img src="<?php echo esc_url( $slide['imagen'] ); ?>" alt="<?php echo esc_attr( $slide['titulo'] ); ?>" class="adaptive-image">
                                                </div>
                                                <div class="field-enlace-menu">
                                                    <span class="title"><?php echo esc_html( $slide['titulo'] ); ?></span>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif;
                }
            }
        }
        ?>

        <?php
        // --- WIDGET 3: NOTICIAS RELACIONADAS ---
        $args_noticias = array(
            'post_type'      => 'noticia',
            'post_parent'    => get_the_ID(),
            'orderby'        => 'date',
            'posts_per_page' => 2,
        );
        $query_noticias = new WP_Query( $args_noticias );

        if ( $query_noticias->have_posts() ) : ?>
            <div class="widget-news-related">
                <h3 class="widget-title"><span>Noticias</span></h3>
                <div class="widget-content">
                    <?php while( $query_noticias->have_posts() ) : $query_noticias->the_post(); ?>
                        <div class="news-item">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="news-item-image">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="news-item-content">
                                <h4 class="news-item-title">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h4>
                                <div class="news-item-excerpt">
                                    <?php
                                        // MEJORA: Usamos la función nativa de WordPress para crear un extracto.
                                        // Es más segura y eficiente que el método manual.
                                        echo wp_trim_words( get_the_content(), 20, '...' );
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <div class="news-more-link">
                        <?php $post_slug = get_post_field( 'post_name', get_the_ID() ); ?>
                        <a href="<?php echo esc_url( get_site_url( null, 'noticias/' . $post_slug ) ); ?>">Leer más noticias</a>
                    </div>
                </div>
            </div>
        <?php endif;
        // ¡Importante! Restaurar los datos del post original.
        wp_reset_postdata();
        ?>
    </div><!-- .rightsub -->

</div><!-- .main-layout-container -->

<?php
// Acciones finales y carga del footer.
do_action( 'colormag_after_body_content' );
get_footer();
?>