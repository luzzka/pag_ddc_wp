<div class="mkcontainer_slider">
	<div class="mkslider mkslider-principal">
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
            <?php if( isset( $value['enlace'] ) && !empty( $value['enlace'] ) ): ?>
                <a href="<?php echo $value['enlace'];?>">
            <?php endif; ?>
			<img src="<?php echo $value['imagen']; ?>" />
            <?php if( isset( $value['enlace'] ) && !empty( $value['enlace'] ) ): ?>
                </a>
            <?php endif; ?>
			<div class="mkcontent">
				<p class="mktitle">
					<?php echo $value['titulo'];?>	
				</p>
				<p class="mkdescrip">
					<?php echo $value['descripcion'];?>
				</p>

			</div>
		</div>
		<?php
		endforeach;
		?>
	</div>
</div>