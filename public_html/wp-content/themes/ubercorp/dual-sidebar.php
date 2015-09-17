<?php
/*
 *
 * Template Name: Dual Sidebar
 *
*/
?>
<?php get_header(); 

global $be_themes_options; 

while( have_posts() ): the_post(); ?>
			<section id="content" class="dual-sidebar-page">
				<div id="content-wrap" class="be-wrap clearfix">

					<div id="dual-sidebar-wrap" class="left">
						<section id="page-content" class="content-dual-sidebar">
							<div class="clearfix">
								<?php the_content(); ?>
							</div> <!--  End Page Content -->

							<?php if( isset($be_themes_data['comments_on_page']) && $be_themes_data['comments_on_page'] == 1 ) : ?>
								<div class="be-themes-comments be-row be-wrap">
									<?php comments_template( '', true ); ?>
								</div> <!--  End Optional Page Comments -->
							<?php endif; ?>	
						</section>

						<section id="left-sidebar">
							<?php get_sidebar( 'left' ); ?>
						</section>
						<div class="clear"></div>
					</div>

					<section id="right-sidebar">
						<?php get_sidebar(); ?>
					</section>

				</div>
			</section>					 
<?php endwhile; ?>
<?php get_footer(); ?>