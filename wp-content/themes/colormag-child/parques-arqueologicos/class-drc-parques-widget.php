<?php
class DRC_Parques_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'drc_parques_widget',
            __('Parques Arqueológicos', 'colormag'),
            array('description' => __('Muestra parques arqueológicos desde el CPT.', 'colormag'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];

        $titulo = !empty($instance['titulo']) ? $instance['titulo'] : 'Parques Arqueológicos';
        echo $args['before_title'] . esc_html($titulo) . $args['after_title'];

        $query = new WP_Query(array(
            'post_type' => 'parques',
            'posts_per_page' => -1
        ));

        if($query->have_posts()) {
            echo '<div class="parques-arq-grid">';
            $count = 0;
            while($query->have_posts()) {
                $query->the_post();
                $hidden_class = $count >= 4 ? ' hidden-parque' : '';

                echo '<div class="parque-item'.$hidden_class.'">';
                echo '<div class="parque-card">';

                // Imagen
                if(has_post_thumbnail()) {
                    echo '<div class="parque-img">';
                    the_post_thumbnail('medium');
                    echo '</div>';
                }

                // Contenido
                echo '<div class="parque-info">';
                echo '<h3 class="titulo-parque"><span><a href="'.get_permalink().'">'.get_the_title().'</a></span></h3>';
                echo '<p>'.wp_trim_words(get_the_excerpt(), 25, '...').'</p>';
                echo '</div>';

                echo '</div></div>';
                $count++;
            }
            echo '</div>';

            // Botones mostrar más/menos
            if($query->post_count > 4) {
                echo '<div class="parques-btn">
                        <button id="ver-mas-parques">'.esc_html__('Mostrar más', 'colormag').'</button>
                        <button id="ver-menos-parques" style="display:none;">'.esc_html__('Mostrar menos', 'colormag').'</button>
                      </div>';
            }
        } else {
            echo '<p>No hay parques registrados.</p>';
        }

        wp_reset_postdata();
        echo $args['after_widget'];
    }

    public function form($instance) {
        $titulo = !empty($instance['titulo']) ? $instance['titulo'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('titulo')); ?>">Título:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('titulo')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('titulo')); ?>" type="text"
                   value="<?php echo esc_attr($titulo); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['titulo'] = (!empty($new_instance['titulo'])) ? strip_tags($new_instance['titulo']) : '';
        return $instance;
    }
}

function drc_parques_widget_scripts() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnVerMas = document.getElementById('ver-mas-parques');
        const btnVerMenos = document.getElementById('ver-menos-parques');

        if(btnVerMas && btnVerMenos){
            btnVerMas.addEventListener('click', function(){
                const hiddenItems = document.querySelectorAll('.parque-item.hidden-parque');
                hiddenItems.forEach(item => item.style.display = 'flex');
                btnVerMas.style.display = 'none';
                btnVerMenos.style.display = 'inline-block';
            });

            btnVerMenos.addEventListener('click', function(){
                const hiddenItems = document.querySelectorAll('.parque-item.hidden-parque');
                hiddenItems.forEach(item => item.style.display = 'none');
                btnVerMas.style.display = 'inline-block';
                btnVerMenos.style.display = 'none';
            });
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'drc_parques_widget_scripts');

