<?php
/*
 *
 * Template Name: Page 940
 *
*/
?>
<?php get_header(); 

global $be_themes_data; 

while(have_posts()): the_post(); ?>

			<section id="content" class="no-sidebar-page">
				<div id="content-wrap" class="">

					<section id="page-content" class="be-wrap">
						<div class="clearfix">	
							<?php the_content(); ?>
						</div> <!--  End Page Content -->

						<?php if( isset($be_themes_data['comments_on_page']) && $be_themes_data['comments_on_page'] == 1 ) : ?>

						<div class="be-themes-comments be-row be-wrap">
							<?php comments_template( '', true ); ?>
						</div> <!--  End Optional Page Comments -->

						<?php endif; ?>

					</section>

				</div>
			</section>					 
<?php endwhile; ?>
<?php get_footer(); ?>