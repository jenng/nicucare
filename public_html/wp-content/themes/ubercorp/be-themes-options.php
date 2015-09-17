<?php
/*
 * 
 * Require the framework class before doing anything else, so we can use the defined urls and dirs
 * Also if running on windows you may have url problems, which can be fixed by defining the framework url first
 *
 */
//define('NHP_OPTIONS_URL', site_url('path the options folder'));
if(!class_exists('NHP_Options')){
	require_once( dirname( __FILE__ ) . '/options/options.php' );
}

/*
 * 
 * Custom function for filtering the sections array given by theme, good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for urls, and dir will NOT be available at this point in a child theme, so you must use
 * get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections){
	
	//$sections = array();
	$sections[] = array(
				'title' => __('A Section added by hook', 'be-themes'),
				'desc' => __('<p class="description">This is a section created by adding a filter to the sections array, great to allow child themes, to add/remove sections from the options.</p>', 'be-themes'),
				//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
				//You dont have to though, leave it blank for default.
				'icon' => trailingslashit(get_template_directory_uri()).'options/img/glyphicons/glyphicons_062_attach.png',
				//Lets leave this as a blank section, no options just some intro text set above.
				'fields' => array()
				);
	
	return $sections;
	
}
//function
//add_filter('nhp-opts-sections-twenty_eleven', 'add_another_section');


/*
 * 
 * Custom function for filtering the args array given by theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args){
	
	//$args['dev_mode'] = false;
	
	return $args;
	
}


/*
 * This is the meat of creating the optons page
 *
 * Override some of the default values, uncomment the args and change the values
 * - no $args are required, but there there to be over ridden if needed.
 *
 *
 */

function setup_framework_options(){
$args = array();

//Set it to dev mode to view the class settings/info in the form - default is false
$args['dev_mode'] = true;


$args['intro_text'] = __('<p>Welcome to Ubercorp Options Panel. You will find out that its very simple to do what you want to and yet powerful enough to do whatever you want to with our wide variety of options. </p>', 'be-themes');


//Choose to disable the import/export feature
//$args['show_import_export'] = false;

//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
$args['opt_name'] = PREMIUM_THEME_NAME;


$args['menu_title'] = __('Ubercorp Options', 'be-themes');

//Custom Page Title for options page - default is "Options"
$args['page_title'] = __('Ubercorp Theme Options', 'be-themes');

//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "nhp_theme_options"
$args['page_slug'] = PREMIUM_THEME_NAME.'_theme_options';



//custom page location - default 100 - must be unique or will override other items
$args['page_position'] = 29;

//Custom page icon class (used to override the page icon next to heading)
$args['page_icon'] = PREMIUM_THEME_NAME.'-logo';

	
$args['help_tabs'][] = array(
							'id' => 'nhp-opts-1',
							'title' => __('Theme Information 1', 'be-themes'),
							'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'be-themes')
							);
$args['help_tabs'][] = array(
							'id' => 'nhp-opts-2',
							'title' => __('Theme Information 2', 'be-themes'),
							'content' => __('<p>This is the tab content, HTML is allowed.</p>', 'be-themes')
							);

//Set the Help Sidebar for the options page - no sidebar by default										
$args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'be-themes');

global $sections;

$sections = array();
global $pattern_array;
$pattern_array = array(
				'None' => array('title' => 'None', 'img' => NHP_OPTIONS_URL.'images/pattern/None.png'),
				'Style-1' => array('title' => 'Style-1', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-1.png'),
				'Style-2' => array('title' => 'Style-2', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-2.png'),
				'Style-3' => array('title' => 'Style-3', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-3.png'),
				'Style-4' => array('title' => 'Style-4', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-4.png'),
				'Style-5' => array('title' => 'Style-5', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-5.png'),
				'Style-6' => array('title' => 'Style-6', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-6.png'),
				'Style-7' => array('title' => 'Style-7', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-7.png'),
				'Style-8' => array('title' => 'Style-8', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-8.png'),
				'Style-9' => array('title' => 'Style-9', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-9.png'),
				'Style-10' => array('title' => 'Style-10', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-10.png'),
				'Style-11' => array('title' => 'Style-11', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-11.png'),
				'Style-12' => array('title' => 'Style-12', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-12.png'),
				'Style-13' => array('title' => 'Style-13', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-13.png'),
				'Style-14' => array('title' => 'Style-14', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-14.png'),
				'Style-15' => array('title' => 'Style-15', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-15.png'),
				'Style-16' => array('title' => 'Style-16', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-16.png'),
				'Style-17' => array('title' => 'Style-17', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-17.png'),
				'Style-18' => array('title' => 'Style-18', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-18.png'),
				'Style-19' => array('title' => 'Style-19', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-19.png'),
				'Style-20' => array('title' => 'Style-20', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-20.png'),
				'Style-21' => array('title' => 'Style-21', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-21.png'),
			);
global $background_array;
$background_array = array (
				'None' => array('title' => 'None', 'img' => NHP_OPTIONS_URL.'images/pattern/None.png'),
				'Style-1' => array('title' => 'Style-1', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-1.png'),
				'Style-2' => array('title' => 'Style-2', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-2.png'),
				'Style-3' => array('title' => 'Style-3', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-3.png'),
				'Style-4' => array('title' => 'Style-4', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-4.png'),
				'Style-5' => array('title' => 'Style-5', 'img' => NHP_OPTIONS_URL.'images/pattern/Style-5.png')
			);

$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'images/icon/general.png',
				'title' => __('General', 'be-themes'),
				'desc' => __('<p class="description"></p>', 'be-themes'),
				'fields' =>	array(
					array(
						'id' => 'dev_or_deploy',
						'type' => 'button_set',
						'title' => __('Status of the Website', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('It is important to set this to "deploy" after you have finished playing with options panel and ready to launch the website. It will help us cache the css and optimize performance of the website', 'be-themes'),
						'options' => array('dev' => 'Develop','deploy' => 'Deploy'),//Must provide key => value pairs for radio options
						'std' => 'dev'
						),
					
					array(
						'id' => 'logo',
						'type' => 'upload',
						'title' => __('Your Logo', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please upload your logo here.', 'be-themes')
						),				
					array(
						'id' => 'favicon',
						'type' => 'upload',
						'title' => __('Your Favicon', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please upload a favicon here.', 'be-themes')
						),
					array(
						'id' => 'copyright_text',
						'type' => 'textarea',
						'title' => __('Copyrights Text', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please Enter the text along with any links that need to go in the footer copyright area', 'be-themes'),
						'validate' => 'html', 
						'std' => 'Copyrights 2012. All Rights Reserved'
						),

					array(
						'id' => 'google_analytics_code',
						'type' => 'text',
						'title' => __('Google Analytics Code', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please enter your Google analytics tracking ID here.', 'be-themes'),
						'validate' => 'js', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
						'std' => ''
						),
					array(
						'id' => 'custom_css',
						'type' => 'textarea',
						'title' => __('Custom CSS', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please add your custom css here.', 'be-themes'),
						'validate' => 'html_custom', 
						'std' => ''
						),
					array(
						'id' => 'custom_js',
						'type' => 'textarea',
						'title' => __('Custom Javascript', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please add your custom js code here', 'be-themes'),
						'validate' => 'html_custom', 
						'std' => ''
						)											
				)
			);

$sections[] = array(
				'title' => __('Background', 'be-themes'),
				'desc' => __('<p class="description">Control the Appearance of the site from this tab by uploading your own patterns and images or by choosing from one of the plethora of presets available</p>', 'be-themes'),
				'icon' => NHP_OPTIONS_URL.'images/icon/bg.png',
				'fields' => array(
					array(
						'id' => 'body',
						'type' => 'background',
						'title' => __('Body', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'defaults' => $pattern_array,
						'patterns' => array('dark' => 'Dark','light' => 'Light'),
						'std' =>    array(            
								'background' =>'', 
			                    'scale' => 0,
			                    'bgdefault' => '',
			                    'bgpattern' => '',
			                    'color' => '#e8ecef ', 
			                    'opacity' => '1'
			                )
						
						),
					array(
						'id' => 'header_top',
						'type' => 'background',
						'title' => __('Header Top', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Bar at the top of the webpage', 'be-themes'),
						'defaults' => $pattern_array,
						'patterns' => array('dark' => 'Dark','light' => 'Light'),
						'std' =>    array(            
								'background' =>'', 
			                    'scale' => 0,
			                    'bgdefault' => '',
			                    'bgpattern' => '',
			                    'color' => '#2a2a2a', 
			                    'opacity' => '1'
			                )
						
						),					

					array(
						'id' => 'header',
						'type' => 'background',
						'title' => __('Header', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'defaults' => $pattern_array,
						'patterns' => array('dark' => 'Dark','light' => 'Light'),
						'std' =>    array(            
								'background' =>'', 
			                    'scale' => 0,
			                    'bgdefault' => '',
			                    'bgpattern' => '',
			                    'color' => '#2a2a2a', 
			                    'opacity' => '1'
			                )
						
						),
					array(
						'id' => 'page_title_background',
						'type' => 'background',
						'title' => __('Page Title', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'defaults' => $pattern_array,
						'patterns' => array('dark' => 'Dark','light' => 'Light'),
						'std' =>    array(            
								'background' =>'', 
			                    'scale' => 0,
			                    'bgdefault' => '',
			                    'bgpattern' => '',
			                    'color' => '#00bfd7', 
			                    'opacity' => '1'
			                )
						
						),
					array(
						'id' => 'content',
						'type' => 'background',
						'title' => __('Content Area', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'defaults' => $pattern_array,
						'patterns' => array('dark' => 'Dark','light' => 'Light'),
						'std' =>    array(            
								'background' =>'', 
			                    'scale' => 0,
			                    'bgdefault' => '',
			                    'bgpattern' => '',
			                    'color' => '#ffffff', 
			                    'opacity' => '1'
			                )
						
						),
					array(
						'id' => 'bottom_widgets',
						'type' => 'background',
						'title' => __('Bottom Widget Area', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'defaults' => $pattern_array,
						'patterns' => array('dark' => 'Dark','light' => 'Light'),
						'std' =>    array(            
								'background' =>'', 
			                    'scale' => 0,
			                    'bgdefault' => '',
			                    'bgpattern' => '',
			                    'color' => '#ececef', 
			                    'opacity' => '1'
			                )
						
						),
					array(
						'id' => 'footer',
						'type' => 'background',
						'title' => __('Footer', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'defaults' => $pattern_array,
						'patterns' => array('dark' => 'Dark','light' => 'Light'),
						'std' =>    array(            
								'background' =>'', 
			                    'scale' => 0,
			                    'bgdefault' => '',
			                    'bgpattern' => '',
			                    'color' => '#2a2a2a', 
			                    'opacity' => '1'
			                )
						
						)												
					)
				);


$sections[] = array(
				'title' => __('Typography', 'be-themes'),
				'desc' => __('<p class="description"></p>', 'be-themes'),
				'icon' => NHP_OPTIONS_URL.'images/icon/typo.png',
				'fields' => array(

					array(
						'id' => 'preview',
						'type' => 'typo_preview',
						'title' => __('Font Preview', 'be-themes'), 
						'sub_desc' => __('Typography Font Preview Section', 'be-themes'),
						'desc' => __('', 'be-themes')
						),

					array(
						'id' => 'h1',
						'type' => 'typo',
						'title' => __('H1', 'be-themes'), 
						'sub_desc' => __('Heading Tag 1', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'group' => 'typo',
						'group_head' => 'typo',
						'std' => array
					                (
					                    'family' => 'google/Ubuntu:regular',
					                    'size' => '32px',
					                    'line_height' => '48px',
					                    'style' => 'normal',
					                    'weight' => '400',
					                    'transform' => 'none',
					                    'color' => '#1e1e1e'
					                )
						),

					array(
						'id' => 'h2',
						'type' => 'typo',
						'title' => __('H2', 'be-themes'), 
						'sub_desc' => __('Heading Tag 2', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'group' => 'typo',
						'std' => array
					                (
					                    'family' => 'google/Ubuntu:regular',
					                    'size' => '28px',
					                    'line_height' => '42px',
					                    'style' => 'normal',
					                    'weight' => '400',
					                    'transform' => 'none',
					                    'color' => '#1e1e1e'
					                )
						),

					array(
						'id' => 'h3',
						'type' => 'typo',
						'title' => __('H3', 'be-themes'), 
						'sub_desc' => __('Heading Tag 3', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'group' => 'typo',
						'std' => array
					                (
					                    'family' => 'google/Ubuntu:regular',
					                    'size' => '24px',
					                    'line_height' => '36px',
					                    'style' => 'normal',
					                    'weight' => '400',
					                    'transform' => 'none',
					                    'color' => '#1e1e1e'
					                )
						),

					array(
						'id' => 'h4',
						'type' => 'typo',
						'title' => __('H4', 'be-themes'), 
						'sub_desc' => __('Heading Tag 4', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'group' => 'typo',
						'std' => array
					                (
					                    'family' => 'google/Ubuntu:regular',
					                    'size' => '18px',
					                    'line_height' => '27px',
					                    'style' => 'normal',
					                    'weight' => '400',
					                    'transform' => 'none',
					                    'color' => '#1e1e1e'
					                )
						),

					array(
						'id' => 'h5',
						'type' => 'typo',
						'title' => __('H5', 'be-themes'), 
						'sub_desc' => __('Heading Tag 5', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'group' => 'typo',
						'std' => array
					                (
					                    'family' => 'google/Ubuntu:regular',
					                    'size' => '16px',
					                    'line_height' => '24px',
					                    'style' => 'normal',
					                    'weight' => '400',
					                    'transform' => 'none',
					                    'color' => '#1e1e1e'
					                )
						),

					array(
						'id' => 'h6',
						'type' => 'typo',
						'title' => __('H6', 'be-themes'), 
						'sub_desc' => __('Heading Tag 6', 'be-themes'), 
						'desc' => __('', 'be-themes'),
						'group' => 'typo',
						'std' => array
					                (
					                    'family' => 'google/Ubuntu:regular',
					                    'size' => '14px',
					                    'line_height' => '21px',
					                    'style' => 'normal',
					                    'weight' => '400',
					                    'transform' => 'none',
					                    'color' => '#1e1e1e'
					                )
						),

					array(
						'id' => 'page_title',
						'type' => 'typo',
						'title' => __('Page Title', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'), 
						'desc' => __('', 'be-themes'),
						'group' => 'typo',
						'std' => array
					                (
					                    'family' => 'google/Ubuntu:300',
					                    'size' => '26px',
					                    'line_height' => '40px',
					                    'style' => 'normal',
					                    'weight' => '300',
					                    'transform' => 'none',
					                    'color' => '#ffffff'
					                )
						), 

					array(
						'id' => 'body_text',
						'type' => 'typo',
						'title' => __('Body Text', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => array
					                (
					                    'family' => 'google/Ubuntu:regular',
					                    'size' => '13px',
					                    'line_height' => '23px',
					                    'style' => 'normal',
					                    'weight' => '400',
					                    'transform' => 'none',
					                    'color' => '#707070'
					                )
						),

					array(
						'id' => 'sidebar_widget_text',
						'type' => 'typo',
						'title' => __('Sidebar Widget Text', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'), 
						'desc' => __('', 'be-themes'),
						'std' => array
					                (
					                    'family' => 'google/Ubuntu:regular',
					                    'size' => '12px',
					                    'line_height' => '20px',
					                    'style' => 'normal',
					                    'weight' => '400',
					                    'transform' => 'none',
					                    'color' => '#707070'
					                )
						),

					array(
						'id' => 'bottom_widget_text',
						'type' => 'typo',
						'title' => __('Bottom Widget Text', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'), 
						'desc' => __('', 'be-themes'),
						'std' => array
					                (
					                    'family' => 'google/Ubuntu:regular',
					                    'size' => '12px',
					                    'line_height' => '20px',
					                    'style' => 'normal',
					                    'weight' => '400',
					                    'transform' => 'none',
					                    'color' => '#707070'
					                )
						),

					array(
						'id' => 'footer_text', 
						'type' => 'typo',
						'title' => __('Footer Text', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => array
					                (
					                    'family' => 'google/Ubuntu:regular',
					                    'size' => '13px',
					                    'line_height' => '13px',
					                    'style' => 'normal',
					                    'weight' => '400',
					                    'transform' => 'none',
					                    'color' => '#e2e2e2'
					                )
						),

					array(
						'id' => 'navigation_text',
						'type' => 'typo',
						'title' => __('Navigation Menu', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'), 
						'desc' => __('', 'be-themes'),
						'std' => array
					                (
					                    'family' => 'google/Ubuntu:regular',
					                    'size' => '13px',
					                    'line_height' => '76px',
					                    'style' => 'normal',
					                    'weight' => '400',
					                    'transform' => 'uppercase',
					                    'color' => '#e2e2e2'
					                )
						),
					array(
						'id' => 'post-title-color',
						'type' => 'color',
						'title' => __('Color of Blog Post Title', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '#1e1e1e'
						),
					array(
						'id' => 'header_top_color',
						'type' => 'color',
						'title' => __('Color of Text in Top Bar', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '#bbbbbb'
						),	
					array(
						'id' => 'bottom_widgets_title_color',
						'type' => 'color',
						'title' => __('Color of Widget Title in Bottom Widget area', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '#1e1e1e',
						),											

					) // Fields Array
				);

$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'images/icon/layout-new.png',
				'title' => __('Layout', 'be-themes'),
				'desc' => __('<p class="description">', 'be-themes'),
				'fields' =>	array(

					array (
						'id' => 'layout',
						'type' => 'radio_img',
						'title' => __('Layout', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'options' => array(
										'layout-box' => array('title' => 'Boxed Layout', 'img' => NHP_OPTIONS_URL.'images/boxed.png'),
										'layout-wide' => array('title' => 'Wide Layout', 'img' => NHP_OPTIONS_URL.'images/wide.png')
									),//Must provide key => value(array:title|img) pairs for radio options
						'std' => 'layout-box'
					),	
						
					array (
						'id' => 'sticky_header',
						'type' => 'radio_img',
						'title' => __('Enable Sticky Header', 'be-themes'),
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'options' => array(
										'header-sticky' => array('title' => 'Sticky Header', 'img' => NHP_OPTIONS_URL.'images/sticky.png'),
										'header-nosticky' => array('title' => 'Fixed Header', 'img' => NHP_OPTIONS_URL.'images/fixed.png')
									),
						'std' => 'header-sticky'
					),
					
					array (
						'id' => 'menu_styling',
						'type' => 'select',
						'title' => __('Menu Style', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('' , 'be-themes'),
						'options'=> array('style1'=> 'Style1','style2'=> 'Style2'),
						'std' => 'style1'
					),

					array(
						'id' => 'header_top_left',
						'type' => 'select',
						'title' => __('Top Bar Left Widget', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('' , 'be-themes'),
						'options'=> array('search'=>'Search','social'=>'Social Media Icons','contact'=>'Phone and Email'),
						'std' => 'contact'
						),

					array(
						'id' => 'header_top_right',
						'type' => 'select',
						'title' => __('Top Bar Right Widget', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('' , 'be-themes'),
						'options'=> array('search'=>'Search','social'=>'Social Media Icons','contact'=>'Phone and Email'),
						'std' => 'social'
						),
					array(
						'id' => 'enable_header_top_in_mobile',
						'type' => 'checkbox',
						'title' => __('Enable Header Top in Mobile Dimensions ?', 'be-themes'),
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => 1
						),																		
					array(
						'id' => 'enable_search_in_title',
						'type' => 'checkbox',
						'title' => __('Show Search Widget in Page Title Area ?', 'be-themes'),
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => 0
						),	
					array(
						'id' => 'top_header_bottom_margin',
						'type' => 'text',
						'title' => __('Bottom Margin of Top Bar', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '25'
					),					

					array(
						'id' => 'logo_top_margin',
						'type' => 'text',
						'title' => __('Logo Top Margin', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '25'
					),
					array(
						'id' => 'logo_bottom_margin',
						'type' => 'text',
						'title' => __('Logo Bottom Margin', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '25'
					),
					array(
						'id' => 'page_title_top_margin',
						'type' => 'text',
						'title' => __('Page Title Top Margin', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '20'
					),
					array(
						'id' => 'page_title_bottom_margin',
						'type' => 'text',
						'title' => __('Page Title Bottom Margin', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '20'
					),
					array(
						'id' => 'content_top_margin',
						'type' => 'text',
						'title' => __('Content Area Top Margin', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '50'
					),
					array(
						'id' => 'comments_on_page',
						'type' => 'checkbox',
						'title' => __('Show Comments Section in Pages ?', 'be-themes'),
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => 0
						),						
					array(
						'id' => 'custom_sidebars',
						'type' => 'multi_text',
						'title' => __('Custom Sidebars', 'be-themes'),
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => ''
						)																
				)
			);


$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'images/icon/brush.png',
				'title' => __('Colors', 'be-themes'),
				'desc' => __('<p class="description">', 'be-themes'),
				'fields' =>	array(

					array(
						'id' => 'color_scheme',
						'type' => 'color',
						'title' => __('Color Scheme', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '#00bfd7'
						),

					array(
						'id' => 'alt_bg_text_color',
						'type' => 'color',
						'title' => __('Text Color on a background which has the above Color Scheme', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '#ffffff'
						),
					array(
						'id' => 'separator_color',
						'type' => 'color',
						'title' => __('Color of Separator', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '#bbbbbb'
						),
					array(
						'id' => 'nav_border_color',
						'type' => 'color',
						'title' => __('Color of Main Menu Border', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '#333333',
						),											
					array(
						'id' => 'sec_bg',
						'type' => 'color',
						'title' => __('Secondary Background Color', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Background Color of certain shortcode and widget elements such as Blockquotes, Call To Action Box, Tabs, Accordion, Text boxes etc', 'be-themes'),
						'std' => '#f9f9f9'
						),
					array(
						'id' => 'sec_color',
						'type' => 'color',
						'title' => __('Secondary Text Color', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Text Color of certain shortcode and widget elements which have the secondary background above', 'be-themes'),
						'std' => '#707070'
						),
					array(
						'id' => 'sec_title_color',
						'type' => 'color',
						'title' => __('Secondary Title Color', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Color of Heading tags on certain shortcode and widget elements which have the secondary background above', 'be-themes'),
						'std' => '#333333'
						),
					array(
						'id' => 'sec_border_color',
						'type' => 'color',
						'title' => __('Secondary Border Color', 'be-themes'), 
						'sub_desc' => __('Set to the same color as the secondary background if you do not want a border', 'be-themes'),
						'desc' => __('Border Color of certain shortcode and widget elements which have the secondary background above', 'be-themes'),
						'std' => '#eeeeee'
						),
					array(
						'id' => 'bottom_widget_sec_bg',
						'type' => 'color',
						'title' => __('Secondary Background Color in Bottom Widget area', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '#f9f9f9'
						),
					array(
						'id' => 'bottom_widget_sec_color',
						'type' => 'color',
						'title' => __('Secondary Text Color in Bottom Widget area', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '#707070'
						),
					array(
						'id' => 'bottom_widget_sec_title_color',
						'type' => 'color',
						'title' => __('Secondary Title Color in Bottom Widget area', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '#333333'
						),
					array(
						'id' => 'bottom_widget_sec_border_color',
						'type' => 'color',
						'title' => __('Secondary Border Color in Bottom Widget area', 'be-themes'), 
						'sub_desc' => __('Set to the same color as the secondary background if you do not want a border', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'std' => '#eeeeee'
						),												
				)
			);



$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'images/icon/social.png',
				'title' => __('Social Media Settings', 'be-themes'),
				'desc' => __('<p class="description">Please choose the icons that need to be displayed using the Social Media Widget. Use this widget to direct your visitors to follow your social media profiles.</p>', 'be-themes'),
				'fields' => array(

					array(
						'id' => 'facebook_icon',
						'type' => 'checkbox_hide_below',
						'title' => __('Facebook', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Add Facebook Icon', 'be-themes'),
						'std'=> 1,
						),

					array(
						'id' => 'facebook_icon_url',
						'type' => 'text',
						'title' => __('Facebook Icon Url', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please enter your Facebook page/profile url', 'be-themes'),
						'validate' => 'url',
						'std' => 'http://www.facebook.com'
						),

					array(
						'id' => 'twitter_icon',
						'type' => 'checkbox_hide_below',
						'title' => __('Twitter', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Add Twitter Icon', 'be-themes'),
						'std'=> 1,

						),

					array(
						'id' => 'twitter_icon_url',
						'type' => 'text',
						'title' => __('Twitter Icon Url', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please enter your Twitter page/profile url', 'be-themes'),
						'validate' => 'url',
						'std' => 'http://www.twitter.com'

						),

					array(
						'id' => 'gplus_icon',
						'type' => 'checkbox_hide_below',
						'title' => __('Google Plus', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Add Google Plus Icon', 'be-themes'),
						'std'=> 1,
						),

					array(
						'id' => 'gplus_icon_url',
						'type' => 'text',
						'title' => __('Google Plus Icon Url', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please enter your Google plus page/profile url', 'be-themes'),
						'validate' => 'url',
						'std' => 'http://google.com'
						),
					
					array(
						'id' => 'rss_icon',
						'type' => 'checkbox_hide_below',
						'title' => __('RSS', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Add RSS Icon', 'be-themes')
						),

					array(
						'id' => 'rss_icon_url',
						'type' => 'text',
						'title' => __('RSS Icon Url', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('', 'be-themes'),
						'validate' => 'url',
						'std' => 'http://rss.com'
						),
					
					array(
						'id' => 'dribbble_icon',
						'type' => 'checkbox_hide_below',
						'title' => __('Dribbble', 'be-themes'), 
						'sub_desc' => __('Please enter your RSS feed url', 'be-themes'),
						'desc' => __('Add Dribbble Icon', 'be-themes')
					),

					array(
						'id' => 'dribbble_icon_url',
						'type' => 'text',
						'title' => __('Dribbble Icon Url', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please enter your Dribbble profile url', 'be-themes'),
						'validate' => 'url',
						'std' => 'http://dribbble.com'
					),
					array(
						'id' => 'pinterest_icon',
						'type' => 'checkbox_hide_below',
						'title' => __('Pinterest', 'be-themes'), 
						'sub_desc' => __('Please enter your Pinterest url', 'be-themes'),
						'desc' => __('Add Pinterest Icon', 'be-themes'),
						'std'=> 1,
					),

					array(
						'id' => 'pinterest_icon_url',
						'type' => 'text',
						'title' => __('Pinterest Icon Url', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please enter your Pinterest profile url', 'be-themes'),
						'validate' => 'url',
						'std' => 'http://pinterest.com/'
					),
					array(
						'id' => 'vimeo_icon',
						'type' => 'checkbox_hide_below',
						'title' => __('Vimeo', 'be-themes'), 
						'sub_desc' => __('Please enter your Vimeo url', 'be-themes'),
						'desc' => __('Add Vimeo Icon', 'be-themes')
					),

					array(
						'id' => 'vimeo_icon_url',
						'type' => 'text',
						'title' => __('Vimeo Icon Url', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please enter your Vimeo url', 'be-themes'),
						'validate' => 'url',
						'std' => 'http://vimeo.com/'
					),
					array(
						'id' => 'flickr_icon',
						'type' => 'checkbox_hide_below',
						'title' => __('Flickr', 'be-themes'), 
						'sub_desc' => __('Please enter your Flickr url', 'be-themes'),
						'desc' => __('Add Flickr Icon', 'be-themes')
					),

					array(
						'id' => 'flickr_icon_url',
						'type' => 'text',
						'title' => __('Flickr Icon Url', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please enter your Flickr profile url', 'be-themes'),
						'validate' => 'url',
						'std' => 'http://www.flickr.com/'
					),
					array(
						'id' => 'skype_icon',
						'type' => 'checkbox_hide_below',
						'title' => __('Skype', 'be-themes'), 
						'sub_desc' => __('Please enter your Skype url', 'be-themes'),
						'desc' => __('Add Skype Icon', 'be-themes')
					),

					array(
						'id' => 'skype_icon_url',
						'type' => 'text',
						'title' => __('Skype Icon Url', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please enter your Skype profile url', 'be-themes'),
						'validate' => 'url',
						'std' => 'http://www.skype.com/'
					)					
				)
			
			);		

$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'images/icon/contact.png',
				'title' => __('Contact Settings', 'be-themes'),
				'desc' => __('<p class="description"></p>', 'be-themes'),
				'fields' => array(

					array(
						'id' => 'address',
						'type' => 'textarea',
						'title' => __('Contact Address', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please Enter your address to be used in the contact page as well as the contact widget', 'be-themes'),
						'validate' => 'no_html',
						'std' => 'CIT Nagar Chennai, India 600035'
						),

					array(
						'id' => 'phone_number',
						'type' => 'multi_text',
						'title' => __('Contact Phone Numbers', 'be-themes'),
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please enter your phone number', 'be-themes'),
						'std' => array('001-123-456-7890')
						),

					array(
						'id' => 'mail_id',
						'type' => 'multi_text',
						'title' => __('Contact Email Id', 'be-themes'),
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please enter your email address', 'be-themes'),
						'std' => array('name@yourdomain.com')
						)

					)
			);	

$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'images/icon/portfolio.png',
				'title' => __('Portfolio Settings', 'be-themes'),
				'desc' => __('<p class="description"></p>', 'be-themes'),
				'fields' => array(

					array(
						'id' => 'one_col_height',
						'type' => 'text',
						'title' => __('Height of thumbnails of a One Column Portfolio', 'be-themes'), 
						'sub_desc' => __('Only numbers, no text', 'be-themes'),
						'desc' => __('Please enter height in pixels considering max width in any of the screen resolution is 460px  Defaults to 260px' , 'be-themes'),
						'validate'=>'numeric',
						'std' => '260'
						),

					array(
						'id' => 'two_col_height',
						'type' => 'text',
						'title' => __('Height of thumbnails of a Two Column Portfolio', 'be-themes'), 
						'sub_desc' => __('Only numbers, no text', 'be-themes'),
						'desc' => __('Please enter height in pixels considering max width in any of the screen resolution is 460px  Defaults to 260px' , 'be-themes'),
						'validate'=>'numeric',
						'std' => '260'
						),

					array(
						'id' => 'three_col_height',
						'type' => 'text',
						'title' => __('Height of thumbnails of a Three Column Portfolio', 'be-themes'), 
						'sub_desc' => __('Only numbers, no text', 'be-themes'),
						'desc' => __('Please enter height in pixels considering max width in any of the screen resolution is 300px  Defaults to 220px' , 'be-themes'),
						'validate'=>'numeric',
						'std' => '220'
						),

					array(
						'id' => 'four_col_height',
						'type' => 'text',
						'title' => __('Height of thumbnails of a Four Column Portfolio', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('Please enter height in pixels considering max width in any of the screen resolution is 300px  Defaults to 272px' , 'be-themes'),
						'validate'=>'numeric',
						'std' => '272'
						),

					
					array(
						'id' => 'show_related_portfolio',
						'type' => 'checkbox',
						'title' => __('Show Related Items ?', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('' , 'be-themes'),
						'std' => 1
						),
					array(
						'id' => 'number_related_portfolio',
						'type' => 'select',
						'title' => __('Number of Related Items', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('' , 'be-themes'),
						'options'=> array('three'=>'3','four'=>'4'),
						'std' => 'four'
						),
					array(
						'id' => 'related_portfolio_title',
						'type' => 'text',
						'title' => __('Related Items Title', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('' , 'be-themes'),
						'std' => 'Related Projects'
						)
					)
			);	

$sections[] = array(
				'icon' => NHP_OPTIONS_URL.'images/icon/blog.png',
				'title' => __('Blog Settings', 'be-themes'),
				'desc' => __('<p class="description"></p>', 'be-themes'),
				'fields' => array(
					array(
						'id' => 'blog_style',
						'type' => 'select',
						'title' => __('Blog Style', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('' , 'be-themes'),
						'options'=> array('1'=>'Style 1 - Full Width Thumb ','2'=>'Style 2 - Half Thumb'),
						'std' => '1'
						),
					array(
						'id' => 'blog_sidebar',
						'type' => 'select',
						'title' => __('Blog Sidebar Position', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('' , 'be-themes'),
						'options'=> array('left'=>'Left Sidebar','right'=>'Right Sidebar'),
						'std' => 'right'
					),
					array(
						'id' => 'blog_snippet',
						'type' => 'select',
						'title' => __('Get Blog Snippet from ?', 'be-themes'), 
						'sub_desc' => __('', 'be-themes'),
						'desc' => __('' , 'be-themes'),
						'options'=> array('content'=>'Content','excerpt'=>'Excerpt'),
						'std' => 'content',
					),					
				)					
			);	




				
				
	$tabs = array();
			
	if (function_exists('wp_get_theme')){
		$theme_data = wp_get_theme();
		$theme_uri = $theme_data->get('ThemeURI');
		$description = $theme_data->get('Description');
		$author = $theme_data->get('Author');
		$version = $theme_data->get('Version');
		$tags = $theme_data->get('Tags');
	}else{
		$theme_data = wp_get_theme(trailingslashit(get_stylesheet_directory()).'style.css');
		$theme_uri = $theme_data['URI'];
		$description = $theme_data['Description'];
		$author = $theme_data['Author'];
		$version = $theme_data['Version'];
		$tags = $theme_data['Tags'];
	}	

	$theme_info = '<div class="nhp-opts-section-desc">';
	$theme_info .= '<p class="nhp-opts-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'be-themes').'<a href="'.$theme_uri.'" target="_blank">'.$theme_uri.'</a></p>';
	$theme_info .= '<p class="nhp-opts-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'be-themes').$author.'</p>';
	$theme_info .= '<p class="nhp-opts-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'be-themes').$version.'</p>';
	$theme_info .= '<p class="nhp-opts-theme-data description theme-description">'.$description.'</p>';
	$theme_info .= '<p class="nhp-opts-theme-data description theme-tags">'.__('<strong>Tags:</strong> ', 'be-themes').implode(', ', $tags).'</p>';
	$theme_info .= '</div>';



	$tabs['theme_info'] = array(
					'icon' => NHP_OPTIONS_URL.'img/glyphicons/glyphicons_195_circle_info.png',
					'title' => __('Theme Information', 'be-themes'),
					'content' => $theme_info
					);

	global $NHP_Options;
	$NHP_Options = new NHP_Options($sections, $args, $tabs);

}//function
add_action('init', 'setup_framework_options', 0);

/*
 * 
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value){
	print_r($field);
	print_r($value);

}//function

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value){
	
	$error = false;
	$value =  'just testing';
	/*
	do your validation
	
	if(something){
		$value = $value;
	}elseif(somthing else){
		$error = true;
		$value = $existing_value;
		$field['msg'] = 'your custom error message';
	}
	*/
	
	$return['value'] = $value;
	if($error == true){
		$return['error'] = $field;
	}
	return $return;
	
}//function
?>