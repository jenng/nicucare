<?php
	class BE_contact extends WP_Widget {
		function BE_contact() {
			$widget_ops = array('classname' => 'contact', 'description' => __('Display Address Information - Kindly enter the details in the contact tab of the theme options panel','be_themes') );
			$this->WP_Widget('contact', __('BE Themes - Contact','be-themes'), $widget_ops);
		}
		function widget($args, $instance) {
			extract($args, EXTR_SKIP);
			echo $before_widget; 
 			$be_themes_options = get_option(PREMIUM_THEME_NAME);
			$title = empty($instance['title']) ? ' ' : apply_filters('title', $instance['title']); 			
 			$output='';
			if ( !empty( $title ) )  
				echo $before_title . $title . $after_title;
			if(isset($be_themes_options['address']) || isset($be_themes_options['mail_id']) || isset($be_themes_options['phone_number'])) { 
				$output .=	'<div class="contact-address">';
				$output .=  '<ul class="contact-information custom-list clearfix">';
								if(isset($be_themes_options['address'])) {
									$output.='<li class="clearfix">
										<h6>'.__( 'Address', 'be-themes' ).'<i class="font-icon icon-location circled"></i></h6><p>'.$be_themes_options['address'].'
									</p></li>';
								}
								if(isset($be_themes_options['phone_number'])) {
									$output.='<li class="clearfix"><h6>'.__( 'Phone', 'be-themes' ).'<i class="font-icon icon-mobile circled"></i></h6><p>';
										foreach($be_themes_options['phone_number'] as $phone){
											$output.=$phone.'<br/>';;
										}
									$output.='</p></li>';
								}
								if(isset($be_themes_options['mail_id'])) {
									$output.='<li class="clearfix"><h6>'.__( 'Email', 'be-themes' ).'<i class="font-icon icon-mail circled"></i></h6><p>';
										foreach($be_themes_options['mail_id'] as $mailid){
											$output.='<a href="mailto:'.$mailid.'">'.$mailid.'</a><br/>';
										}
									$output.='</p></li>';
								}
				$output .='</ul>';
				$output .='</div>';
			} 
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
	register_widget('BE_contact');
?>