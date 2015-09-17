<?php
/**
 * The Sidebar containing the main (right) widget area.
 *
 * @package WordPress
 * 
 * 
 */  ?>
<div class="sidebar-widgets">
	<?php
		global $wp_registered_sidebars; 
		$sidebar_array = array();
		foreach ( $wp_registered_sidebars as $key => $value ) {
			$sidebar_array[] = $key;
		}
		$right_sidebar = get_post_meta(get_the_ID(),'be_themes_right_sidebar',true);
		if( empty( $right_sidebar ) || !in_array( $right_sidebar, $sidebar_array ) ) {
			$right_sidebar = 'right-sidebar';
		}
		if (is_active_sidebar( $right_sidebar ) ) {
			dynamic_sidebar( $right_sidebar );
		}
	?>
</div>