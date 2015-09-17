	<?php
/*
 *
 * Template Name: Contact
 *
*/
?>
<?php get_header(); 

global $be_themes_data; 

while(have_posts()): the_post(); 
	$sidebar = get_post_meta(get_the_ID(),'be_themes_page_layout',true);
	if(empty($sidebar))
		$sidebar = 'right';
?>
			<section id="content" class="<?php echo $sidebar; ?>-sidebar-page">
				<div id="content-wrap" class="be-wrap clearfix">

					<section id="page-content" class="content-single-sidebar">
						<div class="clearfix">
							<?php the_content(); ?>
							<!--<div class="gmap map_960" id="contact-page-map" data-address="<?php echo $be_themes_data['address']; ?>" data-zoom="20"></div>-->

							<div class="contact_form">
								<form method="post" class="contact">
									<div class="be-row clearfix">
										<fieldset class="one-third column-block contact_fieldset">
											<input type="text" name="contact_name" class="txt autoclear" placeholder="<?php _e('Name','be-themes'); ?>" />
										</fieldset>
										<fieldset class="one-third column-block contact_fieldset">
											<input type="text" name="contact_email" class="txt autoclear" placeholder="<?php _e('Email','be-themes'); ?>" />
										</fieldset>
										<fieldset class="one-third column-block contact_fieldset">
											<input type="text" name="contact_subject" class="txt autoclear" placeholder="<?php _e('Subject','be-themes'); ?>" />
										</fieldset>
									</div>
									<fieldset class="contact_fieldset">
										<textarea name="contact_comment" class="txt_area autoclear" placeholder="<?php _e('Message','be-themes'); ?>" ></textarea>
									</fieldset>
									<fieldset class="contact_fieldset submit-fieldset">
										<input type="submit" name="contact_submit" value="<?php _e('Submit','be-themes'); ?>" class="contact_submit title_headings"/>
										<div class="contact_loader"></div>
									</fieldset>
									<div class="contact_status"></div>
								</form>
							</div>  <!-- End Contact Form -->

						</div> <!--  End Page Content -->

					</section>

					<section id="<?php echo $sidebar; ?>-sidebar" class="sidebar-widgets">
						<?php get_sidebar($sidebar); ?>
					</section>

				</div>
			</section>					 
<?php endwhile; ?>
<?php get_footer(); ?>