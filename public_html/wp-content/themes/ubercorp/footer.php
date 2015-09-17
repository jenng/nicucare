<?php
	global $wp_query;
	$page_id = $wp_query->get_queried_object_id();
	global $be_themes_data; 
?>

			<?php 
			$show_bottom_widgets = get_post_meta($page_id,'be_themes_show_bottom_widgets',true);
			if(empty($show_bottom_widgets)) {
				$show_bottom_widgets = 'yes';
			}

			if($show_bottom_widgets == 'yes'):	
			?>
			<footer id="bottom-widgets">
				<div id="bottom-widgets-wrap" class="be-wrap be-row clearfix">
					<div class="one-fourth column-block clearfix">
						<?php 
						if ( is_active_sidebar( 'footer-widget-1' ) ) {
							dynamic_sidebar( 'footer-widget-1' );
						}
						?>
					</div>
					<div class="one-fourth column-block clearfix">
						<?php 
						if ( is_active_sidebar( 'footer-widget-2' ) ) {
							dynamic_sidebar( 'footer-widget-2' );
						}
						?>
					</div>
					<div class="one-fourth column-block clearfix">
						<?php 
						if ( is_active_sidebar( 'footer-widget-3' ) ) {
							dynamic_sidebar( 'footer-widget-3' );
						}
						?>
					</div>
					<div class="one-fourth column-block clearfix">
						<?php 
						if ( is_active_sidebar( 'footer-widget-4' ) ) {
							dynamic_sidebar( 'footer-widget-4' );
						}
						?>
					</div>														
				</div>
			</footer>
			<?php endif; ?>	
			<?php 
			$show_footer = get_post_meta($page_id,'be_themes_show_footer',true);
			if(empty($show_footer)) {
				$show_footer = 'yes';
			}

			if($show_footer == 'yes'):	
			?>
			<footer id="footer">
				<div id="footer-wrap" class="be-wrap clearfix">
					<div id="copyright" class="left">
						<p><?php echo $be_themes_data['copyright_text']; ?></p>
					</div>
					<div class="footer-icons right">
						<?php the_widget('BE_social_media') ?>
					</div>
				</div>
			</footer>
			<?php endif; ?>			
		</div>
        <script>
            var _gaq=[['_setAccount','<?php echo $be_themes_data['google_analytics_code'];  ?>'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
		<!-- Option Panel Custom JavaScript -->
		<script>
			jQuery(document).ready(function(){
				<?php echo stripslashes_deep(htmlspecialchars_decode($be_themes_data['custom_js'],ENT_QUOTES));  ?>
			});
		</script>
		<input type="hidden" id="ajax_url" value="<?php echo admin_url( 'admin-ajax.php' ); ?>" />
		<input type="hidden" id="nav_colors" value="" data-color = "<?php echo $be_themes_data['color_scheme']; ?>" data-border-color = "<?php echo $be_themes_data['nav_border_color']; ?>" />
		<?php wp_footer(); ?>
	</body>
</html>