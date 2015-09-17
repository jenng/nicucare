<?php
/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign
$prefix = 'be_themes_';

global $meta_boxes;

$meta_boxes = array();



$meta_boxes[] = array(
	// Meta box id, UNIQUE per meta box
	'id' => 'portfolio',

	// Meta box title - Will appear at the drag and drop handle bar
	'title' => 'Portfolio Post Type',

	// Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
	'pages' => array( 'portfolio' ),

	// Where the meta box appear: normal (default), advanced, side; optional
	'context' => 'normal',

	// Order of meta box: high (default), low; optional
	'priority' => 'high',

	// List of meta fields
	'fields' => array(
		array(
			// Field name - Will be used as label
			'name'		=> __('Client Name','be-themes'),
			// Field ID, i.e. the meta key
			'id'	=> "{$prefix}portfolio_client_name",
			// Field description (optional)
			'desc'		=> '',
			// Field description (optional)
			'type'		=> 'text',
			// Default value (optional)
			'std'		=> ''
		),		
		array(
			// Field name - Will be used as label
			'name'		=> __('Project Date','be-themes'),
			// Field ID, i.e. the meta key
			'id'	=> "{$prefix}portfolio_project_date",
			// Field description (optional)
			'desc'		=> 'Project Date',
			// Field description (optional)
			'type'		=> 'text',
			// Default value (optional)
			'std'		=> ''
		),
		array(
			// Field name - Will be used as label
			'name'		=> __('Visit Site url','be-themes'),
			// Field ID, i.e. the meta key
			'id'	=> "{$prefix}portfolio_visitsite_url",
			// Field description (optional)
			'desc'		=> 'Visit Site url',
			// Field description (optional)
			'type'		=> 'text'
		),
		array(
			// Field name - Will be used as label
			'name'		=> __('Visit Site Link Text','be-themes'),
			// Field ID, i.e. the meta key
			'id'	=> "{$prefix}portfolio_visitsite_link_text",
			// Field description (optional)
			'desc'		=> 'Visit Site Link Text',
			// Field description (optional)
			'type'		=> 'text',
			'std'		=> 'Visit Site'
		), 
		array(
			// Field name - Will be used as label
			'name'		=> __('Link Thumbnail To','be-themes'),
			// Field ID, i.e. the meta key
			'id'	=> "{$prefix}portfolio_link_to",
			// Field description (optional)
			'desc'		=> 'Portfolio thumbnail & Title will be linked to ?',
			// Field description (optional)
			'type' => 'radio',
			'options'	=> array(
				'no_link'=> 'No Link',
				'single_portfolio' => 'Single Portfolio Page',
				'external_url' => 'External Url',
			),
			'std'  => 'single_portfolio'
		),
		array(
			'name' => __('Thumbnail Expands to ','be-themes'),
			'id'   => "{$prefix}thumbnail_lightbox",
			'type' => 'select',
			'options'=>array('featured_image'=>'Lightbox with Full sized Featured  Image','gallery'=>'Lightbox With Gallery of Attachments'),
			'std'  => 'featured_image',
			'desc' => '',
		),		
	)
);





$meta_boxes[] = array(
	// Meta box id, UNIQUE per meta box
	'id' => 'page_portfolio',

	// Meta box title - Will appear at the drag and drop handle bar
	'title' => 'Sidebar and Blog Options',

	// Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
	'pages' => array( 'page' ),

	// Where the meta box appear: normal (default), advanced, side; optional
	'context' => 'advanced',

	// Order of meta box: high (default), low; optional
	'priority' => 'high',

	// List of meta fields
	'fields' => array(
		array(
			'name' => __('Page Sidebar Layout','be-themes'),
			'id'   => "{$prefix}page_layout",
			'type' => 'select',
			'options'=>array('right'=>'right','left'=>'left'),
			'std'  => 'right',
			'desc' => '',
		),									
		array(
			'name' => __('Left Sidebar','be-themes'),
			'id'   => "{$prefix}left_sidebar",
			'type' => 'sidebar_select',
			'std'  => 'left-sidebar',
			'desc' => '',
		),
		array(
			'name' => __('Right Sidebar','be-themes'),
			'id'   => "{$prefix}right_sidebar",
			'type' => 'sidebar_select',
			'std'  => 'right-sidebar',
			'desc' => '',
		),
		array(
			'name' => __('Blog Style','be-themes'),
			'id'   => "{$prefix}blog_style",
			'type' => 'select',
			'options'=>array('1'=>'Style 1','2'=>'Style 2'),
			'std'  => 'style-1',
			'desc' => '',
		)		
	)
);


$meta_boxes[] = array(
	// Meta box id, UNIQUE per meta box
	'id' => 'page_layout_options',

	// Meta box title - Will appear at the drag and drop handle bar
	'title' => 'Page Options',

	// Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
	'pages' => array( 'page','portfolio' ),

	// Where the meta box appear: normal (default), advanced, side; optional
	'context' => 'normal',

	// Order of meta box: high (default), low; optional
	'priority' => 'high',

	// List of meta fields
	'fields' => array(
		array(
			'name' => __('Show Page Title Bar ?','be-themes'),
			'id'   => "{$prefix}show_page_titlebar",
			'type' => 'select',
			'options'=>array('yes'=>'Yes','no'=>'No'),
			'std'  => 'yes',
			'desc' => '',
		),
		array(
			'name' => __('Show Breadcrumbs ?','be-themes'),
			'id'   => "{$prefix}show_breadcrumbs",
			'type' => 'select',
			'options'=>array('yes'=>'Yes','no'=>'No'),
			'std'  => 'yes',
			'desc' => '',
		),	
		array(
			'name' => __('Show Bottom Widgets','be-themes'),
			'id'   => "{$prefix}show_bottom_widgets",
			'type' => 'select',
			'options'=>array('yes'=>'Yes','no'=>'No'),
			'std'  => 'yes',
			'desc' => '',
		),
		array(
			'name' => __('Show Top Header Bar','be-themes'),
			'id'   => "{$prefix}show_header_top",
			'type' => 'select',
			'options'=>array('yes'=>'Yes','no'=>'No'),
			'std'  => 'yes',
			'desc' => '',
		),			
		array(
			'name' => __('Show Footer','be-themes'),
			'id'   => "{$prefix}show_footer",
			'type' => 'select',
			'options'=>array('yes'=>'Yes','no'=>'No'),
			'std'  => 'yes',
			'desc' => '',
		),
					
	)
);

$meta_boxes[] = array(
	// Meta box id, UNIQUE per meta box
	'id' => 'post_format_options',

	// Meta box title - Will appear at the drag and drop handle bar
	'title' => 'Post Format Options',

	// Post types, accept custom post types as well - DEFAULT is array('post'); (optional)
	'pages' => array( 'post' ),

	// Where the meta box appear: normal (default), advanced, side; optional
	'context' => 'normal',

	// Order of meta box: high (default), low; optional
	'priority' => 'high',

	// List of meta fields
	'fields' => array(
		array (
			// Field name - Will be used as label
			'name'		=> __('Youtube / Vimeo Video Url','be-themes'),
			// Field ID, i.e. the meta key
			'id'	=> "{$prefix}video_url",
			// Field description (optional)
			'desc'		=> '',
			
			'type'		=> 'text',
			// Default value (optional)
			'std'		=> ''
		),
		array (
			// Field name - Will be used as label
			'name'		=> __('Audio Embed Code Or Link to an Audio File','be-themes'),
			// Field ID, i.e. the meta key
			'id'	=> "{$prefix}audio_url",
			// Field description (optional)
			'desc'		=> '',
			
			'type'		=> 'text',
			// Default value (optional)
			'std'		=> ''
		),
		array (
			// Field name - Will be used as label
			'name'		=> __('Quote Title','be-themes'),
			// Field ID, i.e. the meta key
			'id'	=> "{$prefix}quote_title",
			// Field description (optional)
			'desc'		=> '',
			
			'type'		=> 'text',
			// Default value (optional)
			'std'		=> ''
		),
		array (
			// Field name - Will be used as label
			'name'		=> __('Quote Author','be-themes'),
			// Field ID, i.e. the meta key
			'id'	=> "{$prefix}quote_author",
			// Field description (optional)
			'desc'		=> '',
			
			'type'		=> 'text',
			// Default value (optional)
			'std'		=> ''
		),				
		array (
			// Field name - Will be used as label
			'name'		=> __('Gallery Post Format Images','be-themes'),
			// Field ID, i.e. the meta key
			'id'	=> "{$prefix}gal_post_format",
			// Field description (optional)
			'desc'		=> '',
			
			'type'		=> 'thickbox_image',
			// Default value (optional)
			'max_file_uploads' => 10,
		)					


	)
);


/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function be_themes_register_meta_boxes()
{
	global $meta_boxes;
	if ( class_exists( 'RW_Meta_Box' ) )
	{
		foreach ( $meta_boxes as $meta_box )
		{
			new RW_Meta_Box( $meta_box );
		}
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'be_themes_register_meta_boxes' );