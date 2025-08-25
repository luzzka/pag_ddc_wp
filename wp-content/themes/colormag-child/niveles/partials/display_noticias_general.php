<?php get_header(); ?>

<?php do_action( 'colormag_before_body_content' ); ?>

<div id="primary">

  <div id="content" class="clearfix list_noticias">

    <?php if($query_noticias->have_posts()): while ($query_noticias->have_posts()) : $query_noticias->the_post(); ?>

      <?php get_template_part( 'content', 'notice' ); ?>
  <?php endwhile; endif; ?>
  <?php
  #paginacion
  $total_pages = $query_noticias->max_num_pages;
  echo '<div id="paginacion" style="float: right;">';
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
  echo '</div>';
  wp_reset_postdata();
  ?>
</div><!-- #content -->

</div><!-- #primary -->

<?php colormag_sidebar_select(); ?>
<?php do_action( 'colormag_after_body_content' ); ?>

<?php get_footer(); ?>
