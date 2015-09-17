<?php
/********************************************
			REGISTER WIDGET AREA
*********************************************/


add_action( 'widgets_init', 'be_themes_widgets_init' );
function be_themes_widgets_init() {
	global $be_themes_data;

	register_sidebar(
		array(
           'name' => __( 'Default Right Sidebar', 'paws' ),
           'id'   => 'right-sidebar',
           'description'   => __( 'Widget area of Right Sidebar template pages', 'be-themes' ),
           'before_widget' => '<div class="%2$s widget">', 
           'after_widget'  => '</div>',
           'before_title'  => '<h5>',
           'after_title'   => '</h5>',
		)
	);
	register_sidebar(
		array(
           'name' => __( 'Default Left Sidebar', 'be-themes' ),
           'id'   => 'left-sidebar',
           'description'   => __( 'Header Widget Area', 'be-themes' ),
           'before_widget' => '<div class="%2$s widget">', 
           'after_widget'  => '</div>',
           'before_title'  => '<h5>',
           'after_title'   => '</h5>',
		)
	);
	register_sidebar(
		array(
           'name' => __( 'Footer Column 1', 'be-themes' ),
           'id'   => 'footer-widget-1',
           'description'   => __( 'Footer widget area', 'be-themes' ),
           'before_widget' => '<div class="%2$s widget">', 
           'after_widget'  => '</div>',
           'before_title'  => '<h5>',
           'after_title'   => '</h5>',
		)
	);
	register_sidebar(
		array(
           'name' => __( 'Footer Column 2', 'be-themes' ),
           'id'   => 'footer-widget-2',
           'description'   => __( 'Footer widget area', 'be-themes' ),
           'before_widget' => '<div class="%2$s widget">', 
           'after_widget'  => '</div>',
           'before_title'  => '<h5>',
           'after_title'   => '</h5>',
		)
	);
	register_sidebar(
		array(
           'name' => __( 'Footer Column 3', 'be-themes' ),
           'id'   => 'footer-widget-3',
           'description'   => __( 'Footer widget area', 'be-themes' ),
           'before_widget' => '<div class="%2$s widget">', 
           'after_widget'  => '</div>',
           'before_title'  => '<h5>',
           'after_title'   => '</h5>',
		)
	);
	register_sidebar(
		array(
           'name' => __( 'Footer Column 4', 'be-themes' ),
           'id'   => 'footer-widget-4',
           'description'   => __( 'Footer widget area', 'be-themes' ),
           'before_widget' => '<div class="%2$s widget">', 
           'after_widget'  => '</div>',
           'before_title'  => '<h5>',
           'after_title'   => '</h5>',
		)
	);						
	
	if( !empty( $be_themes_data['custom_sidebars'] ) && sizeof( $be_themes_data['custom_sidebars'] ) > 0 ) {
		foreach( $be_themes_data['custom_sidebars'] as $sidebar ) {
			register_sidebar( 
				array(
				'name' => __( $sidebar, 'be-themes' ),
				'id' => generateSlug( $sidebar, 45 ),
	            'description'   => '',
	            'before_widget' => '<div class="%2$s widget">', 
	            'after_widget'  => '</div>',
	            'before_title'  => '<h5>',
	            'after_title'   => '</h5>',
				) 
			);
		}
	}
}

/********************************************
			INCLUDE WIDGET FUNCTIONS
*********************************************/
	require_once( get_template_directory() .'/functions/widgets/recent_post_widget.php' );
	require_once( get_template_directory() .'/functions/widgets/recent_comment_widget.php' );
	require_once( get_template_directory() .'/functions/widgets/social_media_widget.php' );
	// require_once( get_template_directory() .'/functions/widgets/newsletter_widget.php' );
	require_once( get_template_directory() .'/functions/widgets/contact_widget.php' );
	require_once( get_template_directory() .'/functions/widgets/brankic-photostream-widget/bra_photostream_widget.php' );	
?>