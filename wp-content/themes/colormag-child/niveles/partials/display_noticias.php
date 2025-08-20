<?php get_header(); ?>

<?php do_action( 'colormag_before_body_content' ); ?>

<div class="ctnsubtp centersubdireccion">

  <div id="content" class="clearfix list_noticias">
    <div class="title_main_noticia">
      <h1>Noticias - <small><?php echo $obj->post_title; ?></small></h1>
    </div>

    <?php if($query_noticias->have_posts()): while ($query_noticias->have_posts()) : $query_noticias->the_post();
              #recuperar extra infor de la noticia
    $contenido = get_the_content();
    $contenido = html_entity_decode( $contenido, ENT_QUOTES, get_bloginfo( 'charset' ) );
    $contenido = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $contenido);
    $contenido = strip_tags($contenido);
    $contenido = strip_shortcodes($contenido);
    $excerpt  = implode(' ', array_slice(explode(' ', $contenido), 0, 50)); ?>
    <?php get_template_part( 'content', 'archive' ); ?>

    <!--<div class="item_notice">
      <div class="tit_notice">
        <a href="< ?php the_permalink(); ?>">< ?php the_title(); ?></a><br/>
        <small>< ?php echo get_the_date('F j, Y'); ?></small>
      </div>
      <div class="cont_notice">< ?php echo $excerpt.'...'; ?> <a href="< ?php the_permalink(); ?>" class="ver-noticia">Ver noticia</a></div>
    </div> -->

  <?php endwhile; endif; ?>
  <?php
    #paginacion
  $total_pages = $query_noticias->max_num_pages;
  //echo '<div id="paginacion">';
  if ($total_pages > 1) {
    $current_page = max(1, get_query_var('paged'));
	
    echo paginate_links(array(
      'base' => get_pagenum_link(1) . '%_%',
      'format' => 'page/%#%',
      'current' => $current_page,
      'total' => $total_pages,
      'prev_text'    => __('« prev'),
      'next_text'    => __('sig »'),
      ));
  
  }
  //echo '</div>';
  wp_reset_postdata();
  ?>
</div><!-- #content -->

</div><!-- #primary -->

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
       $idenslider = get_post_meta($obj->ID, 'mkpost_sidebar_iden', true );
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
         <?php foreach ($slider as $key => $slide) { ?>
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
       <?php } ?>
     </div>
   </div>
 </div>
<?php endif; ?>


</div>

<?php do_action( 'colormag_after_body_content' ); ?>

<?php get_footer(); ?>
