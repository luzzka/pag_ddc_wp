jQuery(document).ready(function($) {
    let frame;

    // Añadir nueva imagen
    $('.drc-add-image').on('click', function(e) {
        e.preventDefault();

        let container = $('#drc-galeria-wrapper');
        let newItem = $('<div class="drc-galeria-item" style="margin-bottom:10px;">' +
            '<img src="" style="max-width:150px; margin-bottom:5px; display:none;" />' +
            '<input type="hidden" name="drc_galeria[]" value="" />' +
            '<button class="button drc-upload">Subir</button> ' +
            '<button class="button drc-remove">Eliminar</button>' +
        '</div>');
        container.append(newItem);
    });

    // Subir o cambiar imagen
    $(document).on('click', '.drc-upload', function(e) {
        e.preventDefault();
        let button = $(this);
        let container = button.closest('.drc-galeria-item');

        // Crear frame de medios
        frame = wp.media({
            title: 'Seleccionar imagen',
            button: { text: 'Usar esta imagen' },
            multiple: false
        });

        frame.on('select', function() {
            let attachment = frame.state().get('selection').first().toJSON();
            container.find('img').attr('src', attachment.url).show();
            container.find('input[type=hidden]').val(attachment.url);
        });

        frame.open();
    });

    // Eliminar imagen
    $(document).on('click', '.drc-remove', function(e) {
        e.preventDefault();
        $(this).closest('.drc-galeria-item').remove();
    });
});
