<?php

function cargar_mapa_despues_del_tema () {
    // Verificar que exista la clase ColorMag_Widget
    if ( ! class_exists( 'ColorMag_Widget' ) ) {
        return; 
    }

    // Widget DRC: Mapa con ubicaciones ---------------------
    class featured_display_map extends ColorMag_Widget {

        public function __construct() {
            $this->widget_cssclass    = 'cm-mapa-widget'; 
            $this->widget_description = esc_html__( 'Widget con mapa y ubicaciones marcadas.', 'colormag' );
            $this->widget_name        = esc_html__( 'DRC: Mapa con Ubicaciones', 'colormag' );

            $this->settings = array(
                'titulo_seccion' => array(
                    'type'    => 'text',
                    'default' => '',
                    'label'   => esc_html__( 'Título de la Sección:', 'colormag' ),
                ),
            );

            for ( $i = 1; $i <= 4; $i++ ) {
                $this->settings[ "ubicacion_titulo_{$i}" ] = array(
                    'type'    => 'text',
                    'default' => '',
                    'label'   => sprintf( esc_html__( 'Ubicación %d: Título', 'colormag' ), $i ),
                );
                $this->settings[ "ubicacion_lat_{$i}" ] = array(
                    'type'    => 'text',
                    'default' => '',
                    'label'   => sprintf( esc_html__( 'Ubicación %d: Latitud', 'colormag' ), $i ),
                );
                $this->settings[ "ubicacion_lng_{$i}" ] = array(
                    'type'    => 'text',
                    'default' => '',
                    'label'   => sprintf( esc_html__( 'Ubicación %d: Longitud', 'colormag' ), $i ),
                );
            }

            parent::__construct();
        }

        public function widget( $args, $instance ) {
            $titulo_seccion = isset( $instance['titulo_seccion'] ) ? $instance['titulo_seccion'] : '';

            $this->widget_start( $args );

            if ( ! empty( $titulo_seccion ) ) {
                $this->widget_title( $titulo_seccion, 'latest', 0 );
            }

            // Recolectar ubicaciones
            $ubicaciones = [];
            for ( $i = 1; $i <= 4; $i++ ) {
                $titulo = ! empty( $instance[ "ubicacion_titulo_{$i}" ] ) ? esc_html( $instance[ "ubicacion_titulo_{$i}" ] ) : '';
                $lat    = ! empty( $instance[ "ubicacion_lat_{$i}" ] ) ? esc_html( $instance[ "ubicacion_lat_{$i}" ] ) : '';
                $lng    = ! empty( $instance[ "ubicacion_lng_{$i}" ] ) ? esc_html( $instance[ "ubicacion_lng_{$i}" ] ) : '';

                if ( $titulo && $lat && $lng ) {
                    $ubicaciones[] = [
                        'titulo' => $titulo,
                        'lat'    => $lat,
                        'lng'    => $lng,
                    ];
                }
            }
            ?>

            <div class="mapa-contenedor" style="display:flex; gap:20px;">
                <div id="mapa-widget" style="height:400px; width:70%;"></div>
                <div class="mapa-lista" style="width:30%;">
                    <?php foreach ( $ubicaciones as $ubi ) : ?>
                        <div class="mapa-card" style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
                            <strong><?php echo $ubi['titulo']; ?></strong><br>
                            <small>(<?php echo $ubi['lat']; ?>, <?php echo $ubi['lng']; ?>)</small>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <script>
            document.addEventListener("DOMContentLoaded", function() {
                var map = L.map('mapa-widget').setView([<?php echo $ubicaciones[0]['lat'] ?? '0'; ?>, <?php echo $ubicaciones[0]['lng'] ?? '0'; ?>], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                <?php foreach ( $ubicaciones as $ubi ) : ?>
                    L.marker([<?php echo $ubi['lat']; ?>, <?php echo $ubi['lng']; ?>])
                        .addTo(map)
                        .bindPopup("<?php echo $ubi['titulo']; ?>");
                <?php endforeach; ?>
            });
            </script>

            <?php
            $this->widget_end( $args );
        }
    }

    // Enqueue de Leaflet
    function colormag_dj_enqueue_leaflet() {
        wp_enqueue_style( 'leaflet-css', 'https://unpkg.com/leaflet/dist/leaflet.css' );
        wp_enqueue_script( 'leaflet-js', 'https://unpkg.com/leaflet/dist/leaflet.js', [], null, true );
    }
    add_action( 'wp_enqueue_scripts', 'colormag_dj_enqueue_leaflet' );

    // Registrar el widget
    add_action( 'widgets_init', function() {
        register_widget( 'featured_display_map' );
    });

} 

// cargar la función luego del padre
add_action( 'after_setup_theme', 'cargar_mapa_despues_del_tema' );