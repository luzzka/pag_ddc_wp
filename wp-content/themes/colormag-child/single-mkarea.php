<?php
/**
 * Plantilla para mostrar un post individual del Custom Post Type 'mkarea'.
 * Este archivo controla la vista de una "Área Funcional" individual.
 *
 * @package ThemeGrill
 * @subpackage ColorMag
 * @since ColorMag 1.0
 */

// Carga el archivo header.php del tema.
get_header(); ?>

<?php
do_action( "mkslider_action_display" );
do_action( 'colormag_before_body_content' );
?>

<div class="main-layout-container">
   <!-- =================================================================
      MENÚ DE ÁREAS RELACIONADAS
      ================================================================= -->
   <div class="ctnsubtp leftsub">
      <?php
      // Obtener el objeto del post actual que se está mostrando en la página (mkarea)
      $mkarea = get_queried_object();
      $subdireccion = null; 

      // Verificar que el area haya cargado correctamente
      if ( ! empty( $mkarea ) ) {
         // el padre del area es la subdirección
         $idsubdireccion = $mkarea->post_parent;
         // Si tiene un ID de padre, obtenemos el objeto completo de ese post padre
         if ( $idsubdireccion > 0 ) {
         $subdireccion = get_post( $idsubdireccion );
         }
      }

      // Si encontramos al padre (una subdirección) se construye el manu de toda la subdir
      if ( ! empty( $subdireccion ) ) :

         // Definimos los argumentos para una nueva consulta a la base de datos (WP_Query).
         $args = array(
            "post_type"      => "mkarea",       // Queremos posts del tipo 'mkarea'.
            "posts_per_page" => -1,            // traer todos los posts
            "post_parent"    => $subdireccion->ID, // Solo los que son hijos de la misma subdirección.
            //"order"          => "ASC",          // Orden ascendente.	
            "orderby"        => "menu_order"    // Ordenar por el "Orden" definido en el editor de WordPress.
         );

         // crear un query
         $list_areas = new WP_Query( $args );
      ?>

      <div class="listareas clearfix">
         <div class="menu-block-wrapper">
            <ul class="mkmenu">
               <li class="menu-mlid">
                  <!-- Enlace al post padre (la subdirección) -->
                  <a href="<?php echo esc_url( get_permalink( $subdireccion->ID ) ); ?>"><?php echo esc_html( get_the_title( $subdireccion->ID ) ); ?></a>

                  <?php
                  // mostrar en una lista las areas encontradas
                  if ( $list_areas->have_posts() ) :
                  ?>
                     <ul class="menumk">
                     <?php
                     while ( $list_areas->have_posts() ) : $list_areas->the_post();
                     // aplicar una clase 'active' si es el area actual
                     $active_class = ( get_the_ID() == $mkarea->ID ) ? 'active' : '';
                     ?>
                     <li class="menu-mlid <?php echo esc_attr( $active_class ); ?>">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                     </li>
                     <?php endwhile; ?>
                     </ul>
                  <?php
                  endif;
                  //  Restaura los datos del post original de la página.
                  wp_reset_postdata();
                  ?>
               </li>
            </ul>
         </div>
      </div>
      <?php endif; ?>
   </div>

   <!-- =================================================================
      COLUMNA CENTRAL (CENTER SUB) - CONTENIDO PRINCIPAL
      ================================================================= -->
   <div class="ctnsubtp centersub">
      <div id="content" class="clearfix">
      <?php
      // muestra el contenido del mkarea actual
      while ( have_posts() ) : the_post();
         get_template_part('content', 'single');
         //the_title( '<h2 class="entry-title">', '</h2>' );
         //the_content();

      endwhile; 
      ?>
      <br><br><br>
   </div><!-- #content -->

   <?php // Si el autor del post tiene una biografía, muestra la caja de autor. ?>
   <?php if ( get_the_author_meta( 'description' ) ) : ?>
      <div class="author-box">
         <div class="author-img"><?php echo get_avatar( get_the_author_meta( 'user_email' ), '100' ); ?></div>
         <h4 class="author-name"><?php the_author_meta( 'display_name' ); ?></h4>
         <p class="author-description"><?php the_author_meta( 'description' ); ?></p>
      </div>
   <?php endif; ?>

   <?php 
   // Si la opción de "posts relacionados" está activa , carga la plantilla correspondiente. 
   if ( get_theme_mod( 'colormag_related_posts_activate', 0 ) == 1 ) {
      get_template_part( 'inc/related-posts' );
   }
   ?>

   <?php
   // Acción del tema antes de la plantilla de comentarios.
   do_action( 'colormag_before_comments_template' );

   // Si los comentarios están abiertos o si ya hay al menos un comentario, carga la plantilla de comentarios (comments.php).
   if ( comments_open() || get_comments_number() != '0' ) {
      comments_template();
   }

   // Acción del tema después de la plantilla de comentarios.
   do_action ( 'colormag_after_comments_template' );
   ?>

   </div><!-- #centersub -->

   <!-- =================================================================
      COLUMNA DERECHA (RIGHT SUB) - WIDGETS PERSONALIZADOS
      ================================================================= -->
   <div class="ctnsubtp rightsub">
      <?php
         // PRIMER BLOQUE: Muestra las subdirecciones
         $args_subdirs = array(
            "post_type"      => "mksubdireccion",
            "posts_per_page" => 4,
            "orderby"        => "date",
            "order"          => "ASC"
         );
         $subdirecciones = get_posts( $args_subdirs );

         if ( ! empty( $subdirecciones ) ) :
      ?>
      <div class="block-subdir">
         <div class="block-inner clearfix">
            <div class="listsubdir_s">
               <?php
               foreach ( $subdirecciones as $subdireccion_item ) {
                  // Obtenemos los metadatos (campos personalizados) para cada subdirección.
                  $color = get_post_meta( $subdireccion_item->ID, "mkboxcolor", true );
                  $imagen = get_post_meta( $subdireccion_item->ID, "mkimagenpost", true );

                  // Asignamos valores por defecto si los campos están vacíos.
                  $color = ! empty( $color ) ? $color : "FFFFFF";
                  $imagen = ! empty( $imagen ) ? $imagen : "";

                  // Construimos el CSS en línea de forma segura.
                  $estilo_css = 'background-color: #' . esc_attr( $color ) . ';';
               ?>
                  <a href="<?php echo esc_url( get_permalink( $subdireccion_item->ID ) ); ?>">
                     <div class="itemsubdir_s" style="<?php echo esc_attr( $estilo_css ); ?>">
                        <?php
                        if ( empty( $imagen ) ) {
                           // Si no hay imagen, muestra el título. Idealmente, siempre muestra la imagen
                           echo esc_html( get_the_title( $subdireccion_item->ID ) );
                        } else {
                           // Si hay imagen, la muestra.
                           echo '<img src="' . esc_url( $imagen ) . '" alt="' . esc_attr( get_the_title( $subdireccion_item->ID ) ) . '">';
                        }
                        ?>
                     </div>
                  </a>
               <?php }  ?>
            </div>
         </div>
      </div>
      <?php endif; ?>

      <?php
      // SEGUNDO BLOQUE: Muestra un sidebar personalizado 
      $idenslider = get_post_meta( $post->post_parent, 'mkpost_sidebar_iden', true );
      $slider = array(); // Inicializamos el array.

      if ( ! empty( $idenslider ) && $idenslider != "0" ) {
         // Obtener la opción guardada en la tabla wp_options.
         $options_slider_raw = get_option( "mksidebarsbd", false );

         if ( ! empty( $options_slider_raw ) ) {
            // Decodifica y deserializa los datos. 
            $options_slider = unserialize( base64_decode( $options_slider_raw ) );

            // Verificamos que los datos sean un array y que la clave que buscamos exista.
            if ( is_array( $options_slider ) && isset( $options_slider[$idenslider]['slider'] ) ) {
               $slider = $options_slider[$idenslider]['slider'];
            }
         }
      }

      // Si logramos obtener los datos del slider, lo mostramos.
      if ( ! empty( $slider ) && is_array( $slider ) ) :
      ?>
         <div class="block-sidebar">
            <div class="block-inner clearfix">
               <div class="view-content">
                  <?php foreach ($slider as $slide) : ?>
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
      <?php endif; ?>
   </div>
</div> <!-- .main-layout-container -->

<?php
// Acción del tema después del contenido principal.
do_action( 'colormag_after_body_content' );
get_footer();
?>