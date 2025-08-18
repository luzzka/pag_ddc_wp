<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.facebook.com/orlandoox
 * @since      1.0.0
 *
 * @package    Mkslider_Doox
 * @subpackage Mkslider_Doox/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="mkcontainer">
	<h1 class="prin">Configuración</h1>
	<?php if( !empty( $mensaje ) ) : ?>
		<div class="<?php echo ( empty( $errores ) ) ? "notice-success" : "notice-error" ?> notice inline is-dismissible" id="setting-error-settings_updated">
			<?php echo $mensaje; ?>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text">Descartar este aviso.</span></button>
		</div>
	<?php endif; ?>
	<div class="mkbody">
		<div class="mkprincipal mkclean">
			<div class="mkleft">
				<div class="mkctn mkclean">
					<div class="butNuevo">
						<form action="<?php echo $url_nuevo; ?>" method="post">
							<input type="hidden" name="action" value="crear">
							<button type="submit" class="button-primary mkbutton mkbutton_nuevo_slid">Nuevo</button>
						</form>
					</div>
					<div class="divListSld">
						<span class="mkmore">ó editar</span>
						<select name="slt_sld" id="slt_sld">
							<?php echo $options; ?>
						</select>
					</div>
				</div>
			</div>
			<div class="mkright">
				<div class="mkctn">
					<div class="frmEditNew">
						<form action="" method="post">
							<input type="hidden" name="action" value="<?php echo $action; ?>">
							<input type="hidden" name="txthid" id="txthid" value="<?php echo $id_slider ?>">
							<table class="widefat">
								<thead>
									<tr>
										<th colspan="2">
											<div class="tableTitle tableEditNew"><?php echo ucfirst($action) ?> slider</div>
											<div class="mnserror mnserror_ajax_slider "></div>
										</th>
									</tr>
								</thead>
								<tr>
									<th><span class="lft">Título</span></th>
									<td>
										<input type="text" name="txtTitulo" id="txtTitulo" class="regular-text" value="<?php echo $data_slider['titulo'] ?>">
									</td>
								</tr>
								<tr class="<?php if( $action == 'nuevo' ) echo 'mkhidden'; ?> mkslidertable">
									<th><span class="lft">Slider</span></th>
									<td>
										<button class="button-primary bu_editar_slider mkbutton">Editar</button>
									</td>
								</tr>
								<tr>
									<th><span class="lft">Mostrar en portada</span></th>
									<td>
										<input type="checkbox" name="chb_home" id="chb_home" <?php if( $data_slider['on_home'] == 1 ) echo 'checked' ?>>
									</td>
								</tr>
								<tr>
									<th><span class="lft">Descripción</span></th>
									<td>
										<input type="checkbox" name="chb_descripcion" id="chb_descripcion" <?php if( $data_slider['con_des'] == 1 ) echo 'checked' ?>>
									</td>
								</tr>
								<tr class="<?php if( $data_slider['con_des'] == 0 ) echo 'mkhidden'; ?> mksdescripcion">
									<th>&nbsp;</th>
									<td>
										<div id="descriptioneditor">
											<?php
											$settings = array(
												'_content_editor_dfw' => true,
												'drag_drop_upload' => true,
												'media_buttons' => false,
												'editor_height' => 150,
												);
											wp_editor($data_slider['descripcion'], 'txadescripcion', $settings);
											?>
										</div>
									</td>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<td>
										<button type="submit" class="button-primary mkbutton mkguardarslider">Guardar</button>
										<?php if( $action == 'editar' ): ?>
											<button type="button" class="button buEliminarSlider" data-iden="<?php echo $id_slider ?>">Eliminar</button>
										<?php endif; ?>
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="mksecundario mkclean mkhidden">
			<div class="mkleft">
				<div class="mkctn">
					<div class="formSlider">
						<table class="widefat">
							<thead>
								<tr>
									<th colspan="2">
									<div class="tableTitle tableEditNewSlider">Agregar item</div>
									<input type="hidden" id="actionItem" value="a">
									<input type="hidden" id="idItem" value="0">
										<div class="mnserror mnserror_ajax_item"></div>
									</th>
								</tr>
							</thead>
							<tr>
								<th>Titulo</th>
								<td><input type="text" id="txtTituloSlider" class="regular-text" value=""></td>
							</tr>
							<tr>
								<th>Descripción</th>
								<td><textarea id="txaDescription" class="large-text" rows="5"></textarea></td>
							</tr>
							<tr>
								<th>Enlace</th>
								<td><input type="text" id="txtEnlace" class="regular-text" value=""></td>
							</tr>
							<tr>
								<th>Imagen</th>
								<td>
									<input type="hidden" id="imagenSlider" value="">
									<div class="mkaddimage">
										<a href="javascript:void(0);" id="agregar_imagen">Agregar imagen</a>
										<p class="howto">Recomendado 940 x 335</p>
									</div>
									<div class="delimage mkhidden">
										<img src="" width="236" class="mkimage_hover" alt="imagen" id="mk_imagen_muestra">
										<p class="howto">Click en la imagen para editarla o actualizarla</p>
										<p><a href="javascript:void(0)" id="rmv_imagen">Quitar la imagen</a></p>
									</div>
								</td>
							</tr>
							<tr>
								<th>&nbsp;</th>
								<td>
									<button type="button" class="button butActionSlider">Crear</button>
									<button type="button" class="button butCancelEditar mkhidden">Agregar m&aacute;s</button>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="mkright">
				<div class="mkctn">
					<div class="listadoItems">
						<p class="mensajeCentral">No hay elementos en el slider.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
  jQuery(document).ready(function($){

    $('#agregar_imagen, #mk_imagen_muestra').click(function(e) {
      e.preventDefault();
      var image = wp.media({
        title: 'Seleccionar imagen slider 940 x 335',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
          }).open()
      .on('select', function(e){
            // This will return the selected image from the Media Uploader, the result is an object
            var uploaded_image = image.state().get('selection').first();
            // We convert uploaded_image to a JSON object to make accessing it easier
            var image_url = uploaded_image.toJSON().url;
            // Let's assign the url value to the input field
            $('#imagenSlider').val(image_url);
            $("#mk_imagen_muestra").attr("src",image_url);
            $(".delimage").show();
            $(".mkaddimage ").hide();
          });
    });
    
    $("#rmv_imagen").click(function(event) {
      event.preventDefault();
      $('#imagenSlider').val("");
      $(".delimage").hide();
      $(".mkaddimage ").show();
    });

    

  });
</script>