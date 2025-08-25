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
<div class="ctnsubtp leftsub">
   <?php
      #recupear el objeto
      $mkarea = get_queried_object();
      $subdireccion = array();
      if( !empty( $mkarea ) ){
         #ver si tiene un parent subdireccion
         $idsubdireccion = $mkarea->post_parent;
         $subdireccion = get_post( $idsubdireccion );
      }#end not empty mkarea
      if( !empty( $subdireccion ) ):
         $args = array(
               "post_type" => "mkarea",
               "post_per_page" => -1,
               "post_parent" => $subdireccion->ID,
               "order" => "ASC",
               "orderby" => "menu_order");
         $list_areas = new WP_Query( $args );
      ?>
      <div class="listareas clearfix">
         <div class="menu-block-wrapper">
            <ul class="mkmenu">
               <li class="menu-mlid">
                  <a href="<?php echo get_post_permalink( $subdireccion->ID );  ?>"><?php echo get_the_title($subdireccion->ID); ?></a>
                  <?php if( $list_areas->have_posts() ) :  ?>
                     <ul class="menumk">
                     <?php while( $list_areas->have_posts() ) : $list_areas->the_post(); ?>
                        <li class="menu-mlid <?php if( get_the_ID() == $mkarea->ID ) echo "active"; ?>">
                           <a href="<?php the_permalink(); ?>"><?php echo get_the_title( get_the_ID() ); ?></a>
                        </li>
                     <?php endwhile;?>
                     </ul>
                  <?php endif; wp_reset_query(); ?>
               </li>
            </ul>
         </div>
      </div>
   <?php endif; ?>
</div>
<div class="ctnsubtp centersub">
  <div id="content" class="clearfix">
   <?php
   while ( have_posts() ) : the_post();
      get_template_part( 'content', 'single' );
   endwhile;
   ?>
   <br><br><br>
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
   $idenslider = get_post_meta($post->post_parent, 'mkpost_sidebar_iden', true );
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
   </div>
   <?php do_action( 'colormag_after_body_content' ); ?>
   <?php get_footer(); ?>
