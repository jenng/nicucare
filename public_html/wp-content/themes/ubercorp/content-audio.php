<?php		
	global $blog_style;
?>		
<div class="post-thumb <?php echo 'style-'.$blog_style; ?>">
	<?php
		$audio_embed = get_post_meta( get_the_ID(), 'be_themes_audio_url', true );
		if( !empty( $audio_embed ) ) {
			echo apply_filters( 'the_content', $audio_embed );		
		}	
	?>
</div>