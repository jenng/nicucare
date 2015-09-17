<?php
global $be_themes_data;
	global $blog_style;	
	$post_classes = get_post_class();
	$post_classes = implode( ' ', $post_classes );	
?>	
<article id="post-<?php the_ID(); ?>" class="blog-post clearfix <?php echo $post_classes; ?>">
	<header class="post-header clearfix">
		<div class="post-date alt-bg alt-bg-text-color">
			<?php echo get_the_date( 'M' ); ?><br />
			<span><?php echo get_the_date( 'd' ); ?></span> 
		</div>
		<?php 
		$post_format = get_post_format();
		if( $post_format == 'quote' ) : 
			$quote = get_post_meta(get_the_ID(),'be_themes_quote_title',true);
			$quote_author = get_post_meta(get_the_ID(),'be_themes_quote_author',true);

			$output = '[blockquote style= "style-2" author= "'.$quote_author.'" company= "" ]<a href="'.get_permalink(get_the_ID()).'">'.$quote.'</a><br /><span class="quote-author">- '.$quote_author.'</span>[/blockquote]';
			echo do_shortcode( $output );
		else:
		?>
	    <h3 class="post-title">
			<a href="<?php echo get_permalink(get_the_ID()); ?>"> 
				<?php echo get_the_title(get_the_ID()); ?>
			</a>
		</h3>
		<?php endif; ?>
	</header>
	<?php
	if( is_single() && $post_format != 'quote' ) {
		get_template_part( 'post-details' ); 
	}

	if( $post_format != 'quote' ) {
		get_template_part( 'content', $post_format ); 
	}
	?>
	<div class="post-details">
		<div class="post-content">
			<?php

				if( ! is_single() && $be_themes_data['blog_snippet'] == 'excerpt' ){
					the_excerpt();
				} else {
					the_content( __( 'Continue Reading ->', 'be-themes' ) );
				}
				if( is_single() ): 
				$args = array(
				'before'           => '<div class="pages_list margin-40">',
				'after'            => '</div>',
				'link_before'      => '',
				'link_after'       => '',
				'next_or_number'   => 'next',
				'nextpagelink'     => __('Next >','be-themes'),
				'previouspagelink' => __('< Prev','be-themes'),
				'pagelink'         => '%',
				'echo'             => 1 );
				wp_link_pages( $args );
			?>
			<div class="post-tags">
				<?php the_tags( 'Tags:', '' ); ?>
			</div>
			<nav class="project_navigation clearfix">
			<?php	
				previous_post_link( '%link', __('Previous', 'be-themes' ) ); 
				next_post_link( '%link', __( 'Next', 'be-themes' ) );
			?>
			</nav>
		<?php endif; ?>
		</div>
	</div>
	<div class="clearfix"></div>

	<?php if( !is_single() ): ?>
	<footer class="post-footer">
		<?php get_template_part( 'post-details' ); ?>
	</footer>
	<?php endif; ?>
</article>