<?php get_header(); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Contenedor principal en Flex -->
<div id="content" class="site-content container" style="display:flex; gap:30px; width:100%; max-width:none;">

    <!-- Contenido principal -->
    <div id="cm-primary" class="content-area" style="flex:3;">
        <main id="main" class="site-main parque-single" role="main">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                <h1><?php the_title(); ?></h1>
                <!-- Contenedor completo imagen + galería -->
                <div class="galeria-wrapper">

                    <!-- Imagen destacada -->
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="imagen-destacada">
                            <?php the_post_thumbnail('large', ['class' => 'imagen-destacada-img']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Línea separadora -->
                    <div class="separador-tema"></div>

                    <!-- Galería -->
                    <div class="galeria">
                        <?php for ($i = 1; $i <= 3; $i++):
                            $img = get_post_meta(get_the_ID(), "_galeria$i", true);
                            if ($img): ?>
                                <div class="galeria-img-container">
                                    <img src="<?php echo esc_url($img); ?>" alt="Imagen <?php echo $i; ?>" class="galeria-img">
                                </div>
                        <?php endif; endfor; ?>
                    </div>

                </div>
               <h2>Información del Parque</h2>
                <div class="info-parque">
                    <div class="contenido">
                        <?php the_content(); ?>
                    </div>

                    <?php
                    $ubicacion = get_post_meta(get_the_ID(), '_ubicacion', true);
                    $extension = get_post_meta(get_the_ID(), '_extension', true);
                    $acceso    = get_post_meta(get_the_ID(), '_acceso', true);
                    ?>

                    <div class="info-item">
                        <?php if ( $ubicacion ) : ?>
                            <p class="info-label"><i class="fas fa-map-marker-alt"></i> Ubicación:</p>
                            <p class="info-text"><?php echo esc_html($ubicacion); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="info-item">
                        <?php if ( $extension ) : ?>
                            <p class="info-label"><i class="fas fa-expand-arrows-alt"></i> Extensión:</p>
                            <p class="info-text"><?php echo esc_html($extension); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="info-item">
                        <?php if ( $acceso ) : ?>
                            <p class="info-label"><i class="fas fa-walking"></i> Acceso:</p>
                            <p class="info-text"><?php echo nl2br(esc_html($acceso)); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endwhile; endif; ?>
        </main>
    </div>

    <!-- Sidebar -->
    <aside id="cm-secondary-p" class="widget-area" style="flex:1;">
        <?php get_sidebar(); ?>
    </aside>

</div><!-- #content -->

<?php get_footer(); ?>
