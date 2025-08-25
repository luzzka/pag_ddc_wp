<div class="inside">
	<label for="mk_metabox_color">Asignar:</label>
	<input type="text" id="mk_metabox_color" class="jscolor" name="mk_metabox_color" value="<?php echo $color; ?>">
</div>
<div class="inside">
	<input type="hidden" name="mk_imagen" id="mk_imagen" value="<?php echo $imagen; ?>">
	<div class="mkctn_addimage <?php if( !empty($imagen) ) echo 'mkhidden'; ?>">
		<a href="javascript:void(0);" id="mkadd_image_search"><?php _e( "Agregar imagen" ); ?></a>
		<p class="howto"><?php _e( "Recomendado" ); ?> 180 x 80</p>
	</div>
	<div class="mkctn_delimage <?php if( empty( $imagen ) ) echo 'mkhidden'; ?>">
		<img width="180" src="<?php echo $imagen; ?>" alt="Imagen" id="mkimage_search" />
		<p class="howto"><?php _e("Click en la imagen para editarla o actualizarla"); ?></p>
		<p> <a href="javascript:void" id="mkrmv_image"><?php _e( "Quitar la imagen"); ?></a></p>
	</div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function($){

   $('#mkadd_image_search, #mkimage_search').click(function(e) {
    e.preventDefault();
    var image = wp.media({
     title: '<?php _e("Subir imagen" ); ?> 180 x 80',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
    .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#mk_imagen').val(image_url);
            $("#mkimage_search").attr("src",image_url);
            $(".mkctn_delimage").removeClass('mkhidden');
            $(".mkctn_addimage ").addClass('mkhidden');
        });
});

   $("#mkrmv_image").click(function(event) {
    event.preventDefault();
    $('#mk_imagen').val("");
    $(".mkctn_delimage").addClass('mkhidden');
    $(".mkctn_addimage ").removeClass('mkhidden');
});


});
</script>