<?php
	class BE_social_media extends WP_Widget {
		function BE_social_media() {
			$widget_ops = array('classname' => 'social_media', 'description' => __('Display Social Media Icons with links to your social profiles - Choose icons from theme options panel','be_themes') );
			$this->WP_Widget('social_media', __('Social Media Icons','be_themes'), $widget_ops);
		}
		function widget($args, $instance) {
			extract($args, EXTR_SKIP);
			echo $before_widget;
 			$be_themes_options = get_option(PREMIUM_THEME_NAME);
 			$icons_array = array( 'facebook' , 'twitter' , 'linkedin' , 'gplus' , 'rss' , 'dribbble' , 'pinterest' , 'vimeo' , 'flickr', 'skype' );
			$output="";
			$title = empty($instance['title']) ? '' : apply_filters('title', $instance['title']);
			if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
			$output.='<ul class="social_media_icons clearfix">';
							foreach($icons_array as $icon){
								if(isset($be_themes_options[$icon.'_icon'])){
									$output.='<li class="icons">';
										$output.='<a href="'.$be_themes_options[$icon.'_icon_url'].'" target="_blank"><i class="icon-'.$icon.' font-icon"></i></a>';
									$output.='</li>';
								}
							}
					$output.='</ul>';
			echo $output;
			echo $after_widget;
		}
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			return $instance;
		}
		function form($instance) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
			$title = strip_tags($instance['title']);
			?>
				<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','be_themes'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
			<?php
		}
	}
	register_widget('BE_social_media');
?>