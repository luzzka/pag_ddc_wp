<?php

/**

 * Template to show the front page.

 *

 * @package ThemeGrill

 * @subpackage ColorMag

 * @since ColorMag 1.0

 */

?>



<?php get_header(); ?>


   <div class="front-page-top-section clearfix">

      <div class="widget_slider_area"><?php do_action("mkslider_action_display"); ?></div>

      <div class="widget_beside_slider">
         <?php do_action("mk_mostrar_subdirecciones_home"); ?>
      </div>

   </div>

   <div class="main-content-section clearfix">

      <div id="primary">

         <div id="content" class="clearfix">



         <?php

         if( is_active_sidebar( 'colormag_front_page_content_top_section' ) ) {

            if ( !dynamic_sidebar( 'colormag_front_page_content_top_section' ) ):

            endif;

         }



         if( is_active_sidebar( 'colormag_front_page_content_middle_left_section' ) || is_active_sidebar( 'colormag_front_page_content_middle_right_section' )) {

         ?>

            <div class="tg-one-half">

               <?php

               if ( !dynamic_sidebar( 'colormag_front_page_content_middle_left_section' ) ):

               endif;

               ?>

            </div>

            <div class="tg-one-half tg-one-half-last">

               <?php

               if ( !dynamic_sidebar( 'colormag_front_page_content_middle_right_section' ) ):

               endif;

               ?>

            </div>

         <div class="clearfix"></div>

         <?php

         }

         if( is_active_sidebar( 'colormag_front_page_content_bottom_section' ) ) {

            if ( !dynamic_sidebar( 'colormag_front_page_content_bottom_section' ) ):

            endif;

         }

         if (get_theme_mod('colormag_hide_blog_front', 0) == 0): ?>



            <div class="article-container">

               <?php if ( have_posts() ) : ?>

                  <?php while ( have_posts() ) : the_post(); ?>

                     <?php

                     if ( is_front_page() && is_home() ) {

                       get_template_part( 'content', '' );

                     } elseif ( is_front_page() ) {

                       get_template_part( 'content', 'page' );

                     }

                     ?>



                  <?php endwhile; ?>



                  <?php get_template_part( 'navigation', 'none' ); ?>



               <?php else : ?>



                  <?php get_template_part( 'no-results', 'none' ); ?>



               <?php endif; ?>

            </div>

         <?php endif; ?>

         </div>

      </div>

      <?php colormag_sidebar_select(); ?>

   </div>



<?php get_footer(); ?>


//<?php
/**
 * Template to show the front page.
 * Este archivo está modificado para el tema hijo.
 * Combina la estructura del tema ColorMag actualizado con las funciones personalizadas.
 *
 * @package ColorMag
 * @since   ColorMag 1.0.0
 */
/*
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<?php // ------ INICIO: Sección Superior (Slider y Subdirecciones) con la estructura del TEMA NUEVO ------ ?>
<div class="cm-front-page-top-section">
	<div class="cm-slider-area">
		<?php
			// En lugar de dynamic_sidebar, llamamos a nuestra acción personalizada del slider.
			do_action( "mkslider_action_display" );
		?>
	</div>

	<div class="cm-beside-slider-widget">
		<?php
			// En lugar de dynamic_sidebar, llamamos a nuestra acción para mostrar las subdirecciones.
			do_action( "mk_mostrar_subdirecciones_home" );
		?>
	</div>
</div>
<?php // ------ FIN: Sección Superior ------ ?>


<?php/* // ------ INICIO: Resto del Contenido con la estructura del TEMA NUEVO para que no se rompa el layout ------ ?>
<div class="cm-row">
	<?php

	//Hook: colormag_before_body_content.
	do_action( 'colormag_before_body_content' );
	?>

	<div id="cm-primary" class="cm-primary">

		<?php
		// Mantenemos las áreas de widgets del tema por si se usan en el futuro.
		// Esto es parte de la estructura original que arregla el problema de las columnas.
		if ( is_front_page() && ! is_page_template( 'page-templates/page-builder.php' ) ) :

			if ( is_active_sidebar( 'colormag_front_page_content_top_section' ) ) {
				dynamic_sidebar( 'colormag_front_page_content_top_section' );
			}

			if ( is_active_sidebar( 'colormag_front_page_content_middle_left_section' ) || is_active_sidebar( 'colormag_front_page_content_middle_right_section' ) ) {
				?>
			<div class="cm-column-half">
				<div class="cm-one-half">
					<?php
					dynamic_sidebar( 'colormag_front_page_content_middle_left_section' );
					?>
				</div>

				<div class="cm-one-half cm-one-half-last">
					<?php
					dynamic_sidebar( 'colormag_front_page_content_middle_right_section' );
					?>
				</div>
			</div>

				<?php
			}

			if ( is_active_sidebar( 'colormag_front_page_content_bottom_section' ) ) {
				dynamic_sidebar( 'colormag_front_page_content_bottom_section' );
			}

		endif;

		// Mantenemos la lógica para mostrar o no los posts del blog.
		$hide_blog_front = get_theme_mod( 'colormag_hide_blog_static_page_post', false );

		if ( ! $hide_blog_front ) :

			?>

			<div class="cm-posts cm-layout-2-style-1 col-2" >
				<?php
				if ( have_posts() ) :

					while ( have_posts() ) :
						the_post();

						if ( is_front_page() && is_home() ) {
							get_template_part( 'template-parts/content', '' );
						} elseif ( is_front_page() ) {
							get_template_part( 'template-parts/content', 'page' );
						}

					endwhile;

				else :
					get_template_part( 'template-parts/no-results', 'none' );
				endif;
				?>
			</div>

			<?php
				colormag_pagination();
			?>

		<?php endif; ?>
	</div>


	<?php
	// Esta función es crucial para llamar a la barra lateral derecha y mantener el layout de columnas.
	colormag_sidebar_select();

	//Hook: colormag_after_body_content.
	do_action( 'colormag_after_body_content' );
	?>

</div>
<?php // ------ FIN: Resto del Contenido ------ ?>


<?php
get_footer();*/