	<?php
	/**
	 * TG: Featured Noticias (Style 1) widget.
	 *
	 * @package    ThemeGrill
	 * @subpackage ColorMag
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	class colormag_featured_noticias_widget extends ColorMag_Widget {

		/**
		 * Constructor.
		 */
		public function __construct() {

			$this->widget_cssclass    = 'cm-featured-posts cm-featured-posts--style-1';
			$this->widget_description = esc_html__( 'Display latest noticias or noticias from a specific category.', 'colormag' );
			$this->widget_name        = esc_html__( 'TG: ULTIMAS NOTICIAS (Style 1)' );
			$this->settings           = array(
				'title'    => array(
					'type'    => 'text',
					'default' => '',
					'label'   => esc_html__( 'Title:', 'colormag' ),
				),
				'text'     => array(
					'type'    => 'textarea',
					'default' => '',
					'label'   => esc_html__( 'Description', 'colormag' ),
				),
				'number'   => array(
					'type'    => 'number',
					'default' => 4,
					'label'   => esc_html__( 'Number of noticias to display:', 'colormag' ),
				),
				'type'     => array(
					'type'    => 'radio',
					'default' => 'latest',
					'label'   => '',
					'choices' => array(
						'latest'   => esc_html__( 'Show latest Noticias', 'colormag' ),
						'category' => esc_html__( 'Show noticias from a category', 'colormag' ),
					),
				),
				'category' => array(
					'type'    => 'dropdown_categories',
					'default' => '',
					'label'   => esc_html__( 'Select category (from Noticias)', 'colormag' ),
				),
			);

			parent::__construct();
		}

		/**
		 * Sobrescribimos la query para usar CPT = noticia
		 */
		public function query_posts( $number, $type, $category = '', $tag = '', $author = '' ) {
			$args = array(
				'posts_per_page'      => $number,
				'post_type'           => 'noticia', // 👈 usamos tu CPT
				'ignore_sticky_posts' => true,
			);

			if ( 'category' === $type && $category ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $category,
					),
				);
			}

			return new WP_Query( $args );
		}


		/**
		 * Output widget.
		 */
		public function widget( $args, $instance ) {
			global $post;

			$title    = apply_filters( 'widget_title', isset( $instance['title'] ) ? $instance['title'] : '' );
			$text     = isset( $instance['text'] ) ? $instance['text'] : '';
			$number   = empty( $instance['number'] ) ? 4 : $instance['number'];
			$type     = isset( $instance['type'] ) ? $instance['type'] : 'latest';
			$category = isset( $instance['category'] ) ? $instance['category'] : '';

			$get_featured_posts = $this->query_posts( $number, $type, $category );

			$this->widget_start( $args );

			// Título y descripción
			$this->widget_title( $title, $type, $category );
			$this->widget_description( $text );

			$i = 1;
			while ( $get_featured_posts->have_posts() ) :
				$get_featured_posts->the_post();

				$featured = ( 1 === $i ) ? 'colormag-featured-post-medium' : 'colormag-featured-post-small';

				if ( 1 === $i ) {
					echo '<div class="cm-first-post">';
				} elseif ( 2 === $i ) {
					echo '<div class="cm-posts">';
				}
				?>
				<div class="cm-post">
					<?php
					if ( has_post_thumbnail() ) {
						$this->the_post_thumbnail( $post->ID, $featured );
					}
					?>
					<div class="cm-post-content">
						<?php
						colormag_colored_category();
						$this->the_title();
						$this->entry_meta();
						?>
						<?php if ( 1 === $i ) : ?>
							<div class="cm-entry-summary">
								<?php the_excerpt(); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<?php
				if ( 1 === $i ) {
					echo '</div>';
				}
				++$i;
			endwhile;
			if ( $i > 2 ) {
				echo '</div>';
			}

			wp_reset_postdata();
			$this->widget_end( $args );
		}
	}

	/**
	 * Registro del widget personalizado.
	 */
	function register_colormag_featured_noticias_widget() {
		register_widget( 'colormag_featured_noticias_widget' );
	}
	add_action( 'widgets_init', 'register_colormag_featured_noticias_widget' );
