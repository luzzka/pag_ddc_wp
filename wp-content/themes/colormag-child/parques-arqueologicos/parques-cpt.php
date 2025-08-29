<?php
/* *********************************************************************************** */
// CPT Parques Arqueológicos + Metaboxes personalizados

// 🔹 Registro del CPT
function drc_register_cpt_parques() {
    $labels = array(
        'name'               => 'Parques',
        'singular_name'      => 'Parque',
        'menu_name'          => 'Parques Arqueológicos',
        'name_admin_bar'     => 'Parque',
        'add_new'            => 'Añadir Nuevo',
        'add_new_item'       => 'Añadir Nuevo Parque',
        'edit_item'          => 'Editar Parque',
        'new_item'           => 'Nuevo Parque',
        'view_item'          => 'Ver Parque',
        'search_items'       => 'Buscar Parques',
        'not_found'          => 'No se encontraron parques',
        'not_found_in_trash' => 'No hay parques en la papelera',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-location',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'parques' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'parques', $args );
}
add_action( 'init', 'drc_register_cpt_parques' );


/* *********************************************************************************** */
// 🔹 Metaboxes personalizados
function drc_add_parques_metaboxes() {
    add_meta_box( 
        'parque_info', 
        'Información del Parque', 
        'drc_render_parque_info', 
        'parques', 
        'normal', 
        'high' 
    );
}
add_action( 'add_meta_boxes', 'drc_add_parques_metaboxes' );


// 🔹 Render de los campos
function drc_render_parque_info($post) {
    // Obtener valores guardados
    $ubicacion = get_post_meta($post->ID, '_ubicacion', true);
    $extension = get_post_meta($post->ID, '_extension', true);
    $acceso    = get_post_meta($post->ID, '_acceso', true);

    // Nonce para seguridad
    wp_nonce_field('drc_save_parque_info', 'drc_parque_nonce');

    ?>
    <p>
        <label><strong>Ubicación:</strong></label><br>
        <input type="text" name="ubicacion" value="<?php echo esc_attr($ubicacion); ?>" style="width:100%">
    </p>
    <p>
        <label><strong>Extensión:</strong></label><br>
        <input type="text" name="extension" value="<?php echo esc_attr($extension); ?>" style="width:100%">
    </p>
    <p>
        <label><strong>Acceso:</strong></label><br>
        <textarea name="acceso" rows="4" style="width:100%"><?php echo esc_textarea($acceso); ?></textarea>
    </p>
    <hr>
    <p><strong>Galería de imágenes (3):</strong></p>
    <?php for ($i=1; $i<=3; $i++): 
        $img = get_post_meta($post->ID, "_galeria$i", true); ?>
        <div style="margin-bottom:10px;">
            <input type="text" name="galeria<?php echo $i; ?>" id="galeria<?php echo $i; ?>" value="<?php echo esc_attr($img); ?>" style="width:70%">
            <button class="button drc-upload" data-target="galeria<?php echo $i; ?>">Subir</button>
            <?php if ($img): ?>
                <img src="<?php echo esc_url($img); ?>" style="max-width:100px; display:inline-block; margin-left:10px;">
            <?php endif; ?>
        </div>
    <?php endfor; ?>

    <script>
    jQuery(document).ready(function($){
        $('.drc-upload').click(function(e){
            e.preventDefault();
            var button = $(this);
            var target = button.data('target');

            var uploader = wp.media({
                title: 'Seleccionar imagen',
                button: { text: 'Usar imagen' },
                multiple: false
            }).on('select', function(){
                var attachment = uploader.state().get('selection').first().toJSON();
                $('#'+target).val(attachment.url);
            }).open();
        });
    });
    </script>
    <?php
}


// 🔹 Guardar metadatos
function drc_save_parque_info($post_id) {
    if(!isset($_POST['drc_parque_nonce']) || !wp_verify_nonce($_POST['drc_parque_nonce'], 'drc_save_parque_info')) return;
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if(!current_user_can('edit_post', $post_id)) return;

    // Guardar campos simples
    $campos = ['ubicacion','extension','acceso'];
    foreach($campos as $campo){
        if(isset($_POST[$campo])){
            update_post_meta($post_id, "_$campo", sanitize_text_field($_POST[$campo]));
        }
    }

    // Guardar galerías
    for ($i=1; $i<=3; $i++) {
        if(isset($_POST["galeria$i"])){
            update_post_meta($post_id, "_galeria$i", esc_url_raw($_POST["galeria$i"]));
        }
    }
}
add_action('save_post', 'drc_save_parque_info');

function drc_single_parques_styles() {
    if ( is_singular('parques') ) {
        wp_enqueue_style(
            'drc-single-parques-style',
            get_stylesheet_directory_uri() . '/parques-arqueologicos/single-parques.css', // ruta al CSS
            array(),
            '1.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'drc_single_parques_styles');
