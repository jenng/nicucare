<?php
/**
 *  Left Sidebar Widget Area
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
		$left_sidebar = get_post_meta( get_the_ID(), 'be_themes_left_sidebar', true );
		if( empty($left_sidebar) || !in_array( $left_sidebar, $sidebar_array ) ) {
			$left_sidebar = 'left-sidebar';
		}
		if (is_active_sidebar( $left_sidebar ) ) {
			dynamic_sidebar( $left_sidebar );
		}
	?>
</div>