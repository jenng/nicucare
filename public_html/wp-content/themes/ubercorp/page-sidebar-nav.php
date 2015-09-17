<?php
/*
 *
 * Template Name: Page With Sidebar Navigation
 *
*/
?>
<?php get_header(); 

global $be_themes_options; 

while(have_posts()): the_post(); 
?>

			<section id="content" class="left-sidebar-page">
				<div id="content-wrap" class="be-wrap clearfix">

					<section id="page-content" class="content-single-sidebar">
						<div class="clearfix">
							<?php the_content(); ?>
						</div> <!--  End Page Content -->

						<div class="be-themes-comments be-row be-wrap">
							<?php comments_template( '', true ); ?>
						</div> <!--  End Optional Page Comments -->
					</section>

					<section id="left-sidebar" class="sidebar-widgets">
						<ul class="sidebar-navigation sec-bg sec-color be-shadow">
							<?php 
								$ancestors = get_post_ancestors( $post->ID );
								$post_parent = end( $ancestors );

							if( $post_parent ) { 
								$parent_title = get_the_title( $post_parent ); 
								$permalink = get_permalink( $post_parent );

							?>
								
							<li <?php if( is_page( $post_parent ) ): ?> class="current_page_item"<?php endif; ?>><a href="<?php echo $permalink; ?>" title="<?php echo $parent_title; ?>"><?php echo $parent_title; ?></a></li>
							
							<?php } else { ?>
							<li <?php if( is_page( $post_parent ) ): ?> class="current_page_item"<?php endif; ?>><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>

							<?php } 

							if( $post_parent ) {
								$children = wp_list_pages( "title_li=&child_of=".$post_parent."&echo=0" ); 
							} else {
								$children = wp_list_pages( "title_li=&child_of=".$post->ID."&echo=0" ); 
							}

							if ( $children ) {
								echo $children;
							}
							?>
						</ul>
						
					</section>

				</div>
			</section>					 
<?php endwhile; ?>
<?php get_footer(); ?>