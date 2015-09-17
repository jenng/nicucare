<?php
/*
 *
 * Template Name: Blog Template
 *
*/
?>
<?php get_header(); 
	$sidebar = get_post_meta(get_the_ID(),'be_themes_page_layout',true);
	if(empty($sidebar)) {
		$sidebar = 'right';
	}
	global $be_themes_data;
?>
	<section id="content" class="<?php echo $sidebar; ?>-sidebar-page">
		<div id="content-wrap" class="be-wrap clearfix">

			<section id="page-content" class="content-single-sidebar">
				<div class="clearfix">
					<?php 
					
					$blog_style = get_post_meta(get_the_ID(),'be_themes_blog_style',true);
					if(empty($blog_style))
						$blog_style = $be_themes_data['blog_style'];
					query_posts('post_type=post&paged='.$paged);
					//$blog_posts = new WP_Query(array('post_type'=>'post','paged'=>$paged));	
					if( have_posts() ) : 
						while (have_posts()) : the_post();
							get_template_part('loop'); 
						endwhile;
						echo '<div class="pagination_parent">'.get_be_themes_pagination().'</div>';
					else:
						echo '<p class="inner-content">'.__('Apologies, but no results were found. Perhaps searching will help find a related post.','be-themes').'</p>';
					endif;
					wp_reset_query();
					?>
				</div> <!--  End Page Content -->
			</section>

			<section id="<?php echo $sidebar; ?>-sidebar" class="sidebar-widgets">
				<?php get_sidebar($sidebar); ?>
			</section>

		</div>
	</section>					
<?php get_footer(); ?>