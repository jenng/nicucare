<?php
	class BE_Newsletter extends WP_Widget {
		function BE_Newsletter() {
			$widget_ops = array('classname' => 'widget_newsletter', 'description' => __('Newsletter - Integrate with Mail Chimp or have new subscriber information emailed to you','be-themes') );
			$this->WP_Widget('newsletter', __('Newsletter','be-themes'), $widget_ops);
		}
		function widget($args, $instance) {
			extract($args, EXTR_SKIP);
			echo $before_widget;
			$title = empty($instance['title']) ? ' ' : apply_filters('title', $instance['title']);
			$description = empty($instance['description']) ? ' ' : apply_filters('description', $instance['description']);
			$api_key = empty($instance['api_key']) ? ' ' : apply_filters('api_key', $instance['api_key']);
			$list_id = empty($instance['list_id']) ? ' ' : apply_filters('list_id', $instance['list_id']);
			$api_prefix = empty($instance['api_prefix']) ? ' ' : apply_filters('api_prefix', $instance['api_prefix']);
			if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
			$output ='';
			$output .='	<div class="newsletter_form">
							
								<form method="post" action="test.php" class="newsletter" >';
								if(!empty($description)) {
									$output .='<p>'.$description.'</p>';
								}
						$output .='<div class="newsletter_wrapper" style="position: relative;">
									<input type="text" name="newsletter_email"  class="newsletter_email autoclear" value="'.__('Enter Email Address','be-themes').'" />
									<input type="hidden" name="newsletter_api_key"  value="'.str_replace(' ', '', $api_key).'" />
									<input type="hidden" name="newsletter_list_id"  value="'.str_replace(' ', '', $list_id).'" />
									<input type="hidden" name="newsletter_api_prefix"  value="'.str_replace(' ', '', $api_prefix).'" />
									<input type="submit" name="submit" value="'.__('Send','paws').'" class="newsletter_submit"/>
									</div>
									<div class="newsletter_status"></div>
								</form>
							
							<div class="newsletter_loader"></div>
						</div>';
			echo $output;
			echo $after_widget;
		}
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['description'] = strip_tags($new_instance['description']);
			$instance['api_key'] = strip_tags($new_instance['api_key']);
			$instance['list_id'] = strip_tags($new_instance['list_id']);
			$instance['api_prefix'] = strip_tags($new_instance['api_prefix']);
			return $instance;
		}
		function form($instance) {
			$instance = wp_parse_args( (array) $instance, array( 'title' => '','description' =>'','api_key' => '','list_id' => '','api_prefix' => '') );
			$title = strip_tags($instance['title']);
			$description = strip_tags($instance['description']);
			$api_key = strip_tags($instance['api_key']);
			$list_id = strip_tags($instance['list_id']);
			$api_prefix = strip_tags($instance['api_prefix']);
			?>
				<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','be-themes'); ?><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
				<p><label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description','be-themes'); ?><input class="widefat" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>" type="text" value="<?php echo esc_attr($description); ?>" /></label></p>
				<p><label for="<?php echo $this->get_field_id('api_key'); ?>">API KEY: <input class="widefat" id="<?php echo $this->get_field_id('api_key'); ?>" name="<?php echo $this->get_field_name('api_key'); ?>" type="text" value="<?php echo esc_attr($api_key); ?>" /></label></p>
				<p><label for="<?php echo $this->get_field_id('list_id'); ?>">List ID: <input class="widefat" id="<?php echo $this->get_field_id('list_id'); ?>" name="<?php echo $this->get_field_name('list_id'); ?>" type="text" value="<?php echo esc_attr($list_id); ?>" /></label></p>
				<p><label for="<?php echo $this->get_field_id('api_prefix'); ?>">API Prefix: <input class="widefat" id="<?php echo $this->get_field_id('api_prefix'); ?>" name="<?php echo $this->get_field_name('api_prefix'); ?>" type="text" value="<?php echo esc_attr($api_prefix); ?>" /></label></p>
			<?php
		}
	}
	register_widget('BE_Newsletter');
?>