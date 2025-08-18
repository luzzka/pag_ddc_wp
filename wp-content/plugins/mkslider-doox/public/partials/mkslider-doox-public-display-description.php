<?php
	#recuperar el titulo y sus metas del post
if( isset( $mkobjeto ) ){
	#si tiene elemento
	$titulo = get_the_title( $mkobjeto->ID );
	#recuperar el color de la fuente
	$color = get_post_meta( $mkobjeto->ID, "mkboxcolor", true );
	$color = !empty( $color ) ? $color : "FFFFFF";

} else {
		#es home
	$titulo = get_bloginfo();
}
?>
<div class="mkslider2-content clearfix" style="background-color: #<?php echo $color; ?>">
	<div class="mkslider2-slider mkslider">
		<!-- img.ratio: use padding to define ratio of the slider -->
		<img class="ratio" style="padding:0 33%" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAEALAAAAAABAAEAAAIBTAA7" />
		<?php
		$count = 0;
		$limite = count($slider_item['slider']);
		foreach ($slider_item['slider'] as $key => $value):
			$count++;
		$checked = 0;
		if($count == $limite)
			$checked = 1;
		?>
		<input class="mkslide" type="radio" name="mkslider-principal" id="s-1-<?php echo $count;?>" <?php if( $checked ) echo 'checked';  ?> />
		<label for="s-1-<?php echo $count; ?>"></label>
		<div>
			<img src="<?php echo $value['imagen']; ?>" />
			<div class="mkcontent">
				<p class="mktitle"><?php echo $value['titulo'];?></p>
				<p class="mkdescrip"><?php echo $value['descripcion'];?></p>
				<?php if( isset( $value['enlace'] ) && !empty( $value['enlace'] ) ): ?>
					<p class="mkenlace"><a class="mkseemore" href="<?php echo $value['enlace'];?>" title="">Ver</a></p>
				<?php endif; ?>
			</div>
		</div>
		<?php endforeach;?>
	</div>
	<div class="mkslider2-links">
		<h2><?php echo $titulo; ?></h2>
		<?php echo apply_filters('the_content', $slider_item['descripcion']); ?>
	</div>
</div>
