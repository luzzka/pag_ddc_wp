<?php get_header(); ?>

<?php do_action( 'colormag_before_body_content' ); ?>

<div class="ctnsubtp centersubdireccion">

    <div id="content" class="clearfix">

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>

                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="featured-image">
                        <?php the_post_thumbnail( 'colormag-featured-image' ); ?>
                    </div>
                <?php endif; ?>

                <div class="article-content clearfix">

                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>

                    <?php colormag_entry_meta(); ?>

                    <div class="entry-content clearfix">
                        <?php
                            // Mostrar contenido completo
                            the_content();
                        ?>
                    </div>

                </div>

            </article>

        <?php endwhile; endif; ?>

        <?php if ( get_the_author_meta( 'description' ) ) : ?>
            <div class="author-box">
                <div class="author-img"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 100 ); ?></div>
                <h4 class="author-name"><?php the_author_meta( 'display_name' ); ?></h4>
                <p class="author-description"><?php the_author_meta( 'description' ); ?></p>
            </div>
        <?php endif; ?>

    </div><!-- #content -->

</div><!-- .ctnsubtp -->

<div class="ctnsubtp rightsub">

    <?php
    // Subdirecciones
    $args = array(
        'numberposts' => 4,
        'orderby'     => 'date',
        'order'       => 'ASC',
        'post_type'   => 'mksubdireccion'
    );
    $subdirecciones = get_posts( $args );
    if( !empty( $subdirecciones ) ) :
    ?>
        <div class="block-subdir">
            <div class="block-inner clearfix">
                <div class="listsubdir_s">
                    <?php foreach ( $subdirecciones as $value ) : 
                        $color  = get_post_meta( $value->ID, 'mkboxcolor', true ) ?: 'FFFFFF';
                        $imagen = get_post_meta( $value->ID, 'mkimagenpost', true ) ?: '';
                        $css    = ' style="background-color:#'.$color.';" ';
                    ?>
                        <a href="<?php echo get_permalink( $value->ID ); ?>">
                            <div class="itemsubdir_s" <?php echo $css; ?>>
                                <?php if( $imagen ) : ?>
                                    <img src="<?php echo esc_url($imagen); ?>" alt="<?php echo esc_attr( get_the_title($value->ID) ); ?>">
                                <?php else : ?>
                                    <?php echo esc_html( get_the_title($value->ID) ); ?>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php
    // Noticias relacionadas
    $args = array(
        'post_type'      => 'noticia',
        'post_parent'    => $post->post_parent,
        'orderby'        => 'date',
        'posts_per_page' => 2,
        'post__not_in'   => array( $post->ID )
    );
    $postDireccion = get_post( $post->post_parent );
    $query_n = new WP_Query( $args );

    if( $query_n->have_posts() ) :
    ?>
        <div class="notiS">
            <div class="block-contentS">
                <h2 class="titleS">Noticias</h2>
                <div class="content-fix clearfix">
                    <?php while( $query_n->have_posts() ) : $query_n->the_post(); ?>
                        <div class="attachS">
                            <div class="viewNP">
                                <?php if( has_post_thumbnail() ) : ?>
                                    <div class="fieldI">
                                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                            <?php the_post_thumbnail('medium'); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="fieldT">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                                </div>
                                <div class="fieldD">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <div class="more-linkS">
                        <a href="<?php echo get_site_url(); ?>/noticias/<?php echo $postDireccion->post_name; ?>">Leer más noticias</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; wp_reset_postdata(); ?>

</div>

<?php do_action( 'colormag_after_body_content' ); ?>

<?php get_footer(); ?>
