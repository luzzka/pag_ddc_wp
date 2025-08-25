<?php

/**

 * The template used for displaying page content notice in page.php

 *

 * @package ThemeGrill

 * @subpackage ColorMag

 * @since ColorMag 1.0

 */

?>



<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>

   <?php do_action( 'colormag_before_post_content' ); ?>

   <?php if ( has_post_thumbnail() ) { ?>
      <div class="featured-image">
         <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail( 'colormag-featured-image' ); ?></a>
      </div>
   <?php } ?>

   <div class="article-content clearfix">

      <?php if( get_post_format() ) { get_template_part( 'inc/post-formats' ); } ?>

      <?php
        #recuperar el padre de la subdireccion.
        $id_parent = wp_get_post_parent_id(get_the_ID());
        if($id_parent) {
          echo '<div class="above-entry-meta"><span class="cat-links">';
          echo '<a href="'.get_post_permalink( $id_parent ).'"  rel="category tag">'.get_the_title($id_parent ).'</a>';
          echo '</span></div>';
        }
      ?>

      <header class="entry-header">
         <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a>
         </h2>
      </header>
      <?php colormag_entry_meta(); ?>
      <div class="entry-content clearfix">
         <?php
             $contenido = get_the_content();
              $contenido = html_entity_decode( $contenido, ENT_QUOTES, get_bloginfo( 'charset' ) );
              $contenido = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $contenido);
              $contenido = strip_tags($contenido);
              $contenido = strip_shortcodes($contenido);
              $excerpt  = implode(' ', array_slice(explode(' ', $contenido), 0, 40));
              echo $excerpt;
         ?>
         <a class="more-link" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><span><?php _e( 'Leer más', 'colormag' ); ?></span></a>
      </div>
   </div>
   <?php do_action( 'colormag_after_post_content' ); ?>
</article>
