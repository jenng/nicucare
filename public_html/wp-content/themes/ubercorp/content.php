<?php
	global $blog_style;
	if( empty( $blog_style ) ) {
		$blog_style ='1';
	}		
?>	
<?php 
if( has_post_thumbnail() ) : 
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'blog-image-'.$blog_style );
    $thumb_full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );    
	$url = $thumb['0'];
	$attachment_full_url = $thumb_full[0];
endif;	
if( !empty( $url ) ) : ?>
<div class="post-thumb <?php echo 'style-'.$blog_style; ?> be-hoverlay">	
	<div class="element-inner">        	
		<div class="thumb-wrap">
			<img src="<?php echo $url; ?>" alt="<?php echo get_the_title( get_the_ID() ); ?>" />
			<div class="thumb-overlay"><div class="thumb-bg">
				<div class="thumb-icons">
					<a href="<?php echo get_permalink( get_the_ID() ); ?>"><i class="font-icon icon-link"></i></a><a href="<?php echo $attachment_full_url; ?>" class="image-popup-vertical-fit mfp-image"><i class="font-icon icon-search"></i></a></div>
				</div>
			</div>
		</div>
	</div>			
</div>
<?php endif; ?>