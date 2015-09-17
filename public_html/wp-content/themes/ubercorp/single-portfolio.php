<?php
/*
 *  The template for displaying a Portfolio Item.
 * 
 *
*/
?>
<?php get_header(); 
while (have_posts() ) : the_post();
?>
<section id="content" class="no-sidebar-page">
	<div id="content-wrap">

		<section id="page-content">
			<div class="clearfix">	
				<?php the_content(); ?>
				

				<div class="be-wrap">
					<nav class="project_navigation clearfix">
					<?php	
						previous_post_link('%link',__('Previous','be-themes')); 
						next_post_link('%link',__('Next','be-themes'));
					?>
					</nav>	
					<?php be_themes_related_projects(get_the_ID()); ?>
				</div>
			</div> <!--  End Page Content -->

		</section>

	</div>
</section>					 
<?php endwhile; ?>
<?php get_footer(); ?>