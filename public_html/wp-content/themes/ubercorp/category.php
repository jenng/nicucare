<?php
/**
* The template for displaying Category Archive pages.
* 
*/
?>
<?php get_header(); 
	global $be_themes_data;
	$sidebar = $be_themes_data['blog_sidebar'];
	if( empty( $sidebar ) ) {
		$sidebar = 'right';
	}
?>
	<section id="content" class="<?php echo $sidebar; ?>-sidebar-page">
		<div id="content-wrap" class="be-wrap clearfix">

			<section id="page-content" class="content-single-sidebar">
				<div class="clearfix">
					<?php 
					$blog_style = $be_themes_data['blog_style'];
					if( empty( $blog_style ) ) {
						$blog_style = '1';
					}					
					if( have_posts() ) : 
						while ( have_posts() ) : the_post();
							get_template_part( 'loop' ); 
						endwhile;
						echo '<div class="pagination_parent">'.get_be_themes_pagination().'</div>';
					else:
						echo '<p class="inner-content">'.__( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'be-themes' ).'</p>';
					endif;
					?>
				</div> <!--  End Page Content -->
			</section>

			<section id="<?php echo $sidebar; ?>-sidebar">
				<?php get_sidebar( $sidebar ); ?>
			</section>

		</div>
	</section>					
<?php get_footer(); ?>