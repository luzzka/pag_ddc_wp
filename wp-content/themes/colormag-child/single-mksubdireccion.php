<?php

/**

 * Theme Single Post Section for our theme.

 *

 * @package ThemeGrill

 * @subpackage ColorMag

 * @since ColorMag 1.0

 */

?>



<?php get_header(); ?>
<?php do_action( "mkslider_action_display" ); ?>
<?php do_action( 'colormag_before_body_content' ); ?>
<div class="ctnsubtp centersubdireccion">
 <div id="content" class="clearfix">
   <?php
   while ( have_posts() ) : the_post(); ?>
   <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
   <?php do_action( 'colormag_before_post_content' ); ?>

   <?php
      $image_popup_id = get_post_thumbnail_id();
      $image_popup_url = wp_get_attachment_url( $image_popup_id );
   ?>

   <?php if ( has_post_thumbnail() ) { ?>
      <div class="featured-image">
      <?php if (get_theme_mod('colormag_featured_image_popup', 0) == 1) { ?>
         <a href="<?php echo $image_popup_url; ?>" class="image-popup"><?php the_post_thumbnail( 'colormag-featured-image' ); ?></a>
      <?php } else { ?>
         <?php the_post_thumbnail( 'colormag-featured-image' ); ?>
      <?php } ?>
      </div>
   <?php } ?>

   <div class="article-content clearfix">

   <?php if( get_post_format() ) { get_template_part( 'inc/post-formats' ); } ?>

   <?php colormag_colored_category(); ?>

      <?php if( get_the_ID() != 413 ) { ?> 
      
         <header class="entry-header">
            <h1 class="entry-title">
               <?php the_title(); ?>
            </h1>
         </header>
      
      <?php } ?>

      <?php colormag_entry_meta(); ?>

      <div class="entry-content clearfix">
         <?php
            the_content();

            wp_link_pages( array(
               'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.__( 'Pages:', 'colormag' ),
               'after'             => '</div>',
               'link_before'       => '<span>',
               'link_after'        => '</span>'
            ) );
         ?>
      </div>

   </div>

   <?php do_action( 'colormag_after_post_content' ); ?>
</article>
   <?php
   endwhile;
   ?>
</div><!-- #content -->
<?php #get_template_part( 'navigation', 'single' ); ?>

<?php if ( get_the_author_meta( 'description' ) ) : ?>

   <div class="author-box">

      <div class="author-img"><?php echo get_avatar( get_the_author_meta( 'user_email' ), '100' ); ?></div>

      <h4 class="author-name"><?php the_author_meta( 'display_name' ); ?></h4>

      <p class="author-description"><?php the_author_meta( 'description' ); ?></p>

   </div>

<?php endif; ?>

<?php if ( get_theme_mod( 'colormag_related_posts_activate', 0 ) == 1 )

get_template_part( 'inc/related-posts' );

?>
<?php
do_action( 'colormag_before_comments_template' );
// If comments are open or we have at least one comment, load up the comment template
if ( comments_open() || '0' != get_comments_number() )

   comments_template();

do_action ( 'colormag_after_comments_template' );

?>

</div><!-- #centersub -->

<div class="ctnsubtp rightsub">
   <?php
      #recuperar todos las subdirecciones
   $args = array("numberposts" => 4, "orderby" => "date", "order" => "ASC", "post_type" => "mksubdireccion");
   $subdirecciones = get_posts( $args );
   if( !empty( $subdirecciones ) ):
      ?>
   <div class="block-subdir">
      <div class="block-inner clearfix">
         <div class="listsubdir_s">
            <?php
            foreach ($subdirecciones as $key => $value) {
                  #recuperar el color del post
               $color =  get_post_meta($value->ID, "mkboxcolor", true );
               $imagen = get_post_meta($value->ID, "mkimagenpost", true );
               $color = !empty( $color ) ? $color : "FFFFFF";
               $imagen = !empty( $imagen ) ? $imagen : "";
               #armar el css
               $css = ' style="background-color:#'.$color.';';
               $css .= '" ';
               ?>
               <a href="<?php the_permalink($value->ID); ?>">
                  <div class="itemsubdir_s" <?php echo $css; ?>>
                     <?php
                     if( empty( $imagen ) ) {
                        echo get_the_title($value->ID);
                     } else {
                        echo "<img src='".$imagen."' alt='".get_the_title($value->ID)."'>";
                     }
                     ?>
                  </div>
               </a>
               <?php
               }#end foreach subdirecciones
               ?>
            </div>
         </div>
      </div>
   <?php endif; ?>

   <?php
      #recuperar el side bar de este patrimonio
   $idenslider = get_post_meta($post->ID, 'mkpost_sidebar_iden', true );
   if( !$idenslider )
      $idenslider = "0";
   $slider = array();
   if( $idenslider != "0" ){
         #recuperar el slider
      $options_slider = get_option( "mksidebarsbd", false );
      if( !empty($options_slider) OR $options_slider != false )
         $options_slider = stripslashes_deep( unserialize( base64_decode( $options_slider ) ) );
      $encontrado = false;
      if( !empty( $options_slider ) && is_array( $options_slider ) )
         foreach ($options_slider as $key => $value) {
            if( $idenslider == $key ){
               $encontrado = true;
               break;
            }
         }#end foreach options_slider
         if( $encontrado )
            $slider = $options_slider[$idenslider]['slider'];
      }
      if( !empty( $slider ) ):
         ?>
      <div class="block-sidebar">
         <div class="block-inner clearfix">
            <div class="view-content">
               <?php foreach ($slider as $key => $slide) {
                  ?>
                  <div class="view-item">
                     <a href="<?php echo $slide['enlace']; ?>">
                        <div class="item-image">
                           <img src="<?php echo $slide['imagen'] ?>" alt="<?php echo $slide['titulo'] ?>" class="adaptive-image">
                        </div>
                        <div class="field-enlace-menu">
                           <span class="title"><?php echo $slide['titulo']; ?></span>
                        </div>
                     </a>
                  </div>
                  <?php
               } ?>
            </div>
         </div>
      </div>
   <?php endif; ?>

   <?php
   $args = array(
      'post_type' => 'noticia',
      'post_parent' => $post->ID,
      'orderby' => 'date',
      'posts_per_page' => '2');
   $post_slug = $post->post_name;
   $query_n = new WP_Query($args);
   if($query_n->have_posts()):
      ?>
   <div class="notiS">
      <div class="block-contentS">
         <h2 class="titleS">Noticias</h2>
         <div class="content-fix clearfix">
            <?php
            $count = 0;
            while($query_n->have_posts()) : $query_n->the_post(); $count++;
            $contenido = get_the_content();
            $contenido = html_entity_decode( $contenido, ENT_QUOTES, get_bloginfo( 'charset' ) );
            $contenido = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $contenido);
            $contenido = strip_tags($contenido);
            $contenido = strip_shortcodes($contenido);
            $excerpt  = implode(' ', array_slice(explode(' ', $contenido), 0, 20)); ?>
            <div class="attachS">
               <div class="viewNP">
                  <?php if($count == 1 && has_post_thumbnail()): ?>
                     <div class="fieldI">
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                           <?php the_post_thumbnail('medium'); ?>
                        </a>
                     </div>
                  <?php endif; ?>
                  <div class="fieldT">
                     <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php the_title(); ?>
                     </a>
                  </div>
                  <div class="fieldD">
                     <p><?php echo $excerpt; ?></p>
                  </div>
               </div>
            </div>
         <?php endwhile; ?>
         <div class="more-linkS">
            <a href="<?php echo get_site_url(); ?>/noticias/<?php echo $post_slug; ?>">Leer m&aacute;s noticias</a>
         </div>
      </div>
   </div>
</div>
<?php endif; wp_reset_postdata();?>
</div>

<?php do_action( 'colormag_after_body_content' ); ?>

<?php get_footer(); ?>
