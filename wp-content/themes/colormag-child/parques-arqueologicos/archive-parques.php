<?php
/**
 * Plantilla de archivo para Parques Arqueológicos (CPT: parques)
 * Ubicación: colormag-child/archive-parques.php
 */

get_header(); ?>

<main id="primary" class="site-main archive-parques">

    <header class="page-header">
        <h1 class="page-title">Parques Arqueológicos</h1>
        <?php if ( term_description() ) : ?>
            <div class="archive-description"><?php echo term_description(); ?></div>
        <?php endif; ?>
    </header>
            
    <?php if ( have_posts() ) : ?>
        <div class="parques-grid">
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('parque-item'); ?>>

                    <div class="parque-card">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="parque-img">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="parque-info">
                            <h2 class="parque-titulo">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <p><?php echo get_the_excerpt(); ?></p>
                            <a class="parque-link" href="<?php the_permalink(); ?>">Ver más →</a>
                        </div>
                    </div>

                </article>
            <?php endwhile; ?>
        </div>

        <div class="parques-pagination">
            <?php the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => '← Anteriores',
                'next_text' => 'Siguientes →',
            ) ); ?>
        </div>

    <?php else : ?>
        <p>No se encontraron parques registrados.</p>
    <?php endif; ?>

</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
