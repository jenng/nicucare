<?php
define('PREMIUM_THEME_NAME','ubercorp');

if ( ! isset( $content_width ) ) { 
	$content_width = 940;
}
$be_themes_data = get_option(PREMIUM_THEME_NAME);


/* ---------------------------------------------  */
// Theme Setup
/* ---------------------------------------------  */

add_action( 'after_setup_theme', 'be_themes_setup' );

if ( ! function_exists( 'be_themes_setup' ) ):
	function be_themes_setup() {
		load_theme_textdomain( 'be-themes', get_template_directory() . '/languages' );
		$locale = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) ) {
			require_once( $locale_file );
		}
		register_nav_menu( 'main_nav', 'Main Menu' );		
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'gallery', 'image', 'quote', 'video', 'audio' ) );
	}
endif;


require_once( get_template_directory().'/functions/helpers.php' );
require_once( get_template_directory().'/functions/widget-functions.php' );
require_once( get_template_directory().'/functions/custom-post-types.php' );
require_once( get_template_directory().'/ajax-handler.php' );
require_once( get_template_directory().'/functions/shortcodes.php' );
require_once( get_template_directory().'/be-themes-options.php' ); 
require_once( get_template_directory().'/functions/be-styles-functions.php' );
//define( 'RWMB_URL', trailingslashit( get_stylesheet_directory_uri() . '/meta-box' ) );
//define( 'RWMB_DIR', trailingslashit( get_stylesheet_directory() . '/meta-box' ) );
require_once  ( get_template_directory().'/meta-box/meta-box.php' );
require_once( get_template_directory().'/be-themes-metabox.php' );


function be_themes_image_sizes( $sizes ) {

    global $_wp_additional_image_sizes;
    if ( empty( $_wp_additional_image_sizes ) )
        return $sizes;

    foreach ( $_wp_additional_image_sizes as $id => $data ) {
        if ( !isset($sizes[$id]) )
            $sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
    }

    return $sizes;
}



/* ---------------------------------------------  */
// Specifying the various image sizes for theme
/* ---------------------------------------------  */

empty( $be_themes_data['one_col_height'] ) ? ( $one_col_height = 260 ) : ( $one_col_height = $be_themes_data['one_col_height'] );
empty( $be_themes_data['two_col_height'] ) ? ( $two_col_height = 260 ) : ( $two_col_height = $be_themes_data['two_col_height'] );
empty( $be_themes_data['three_col_height'] ) ? ( $three_col_height = 220 ) : ( $three_col_height = $be_themes_data['three_col_height'] );
empty( $be_themes_data['four_col_height'] ) ? ( $four_col_height = 272 ) : ( $four_col_height = $be_themes_data['four_col_height'] );

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'blog-image-1', 700, 270, true );
	add_image_size( 'blog-image-2', 300, 175, true );
	add_image_size( 'portfolio-one', 460, $one_col_height, true );
	add_image_size( 'portfolio-two', 460, $two_col_height, true );
	add_image_size( 'portfolio-three', 300, $three_col_height, true );
	add_image_size( 'portfolio-four', 300, $four_col_height, true );
	add_image_size( 'blog-widget', 40, 40,true );
	add_image_size( 'bq-author', 60, 60,true );
	add_image_size( 'one-half', 460 );
	add_image_size( 'client_carousel', 160, 120, true );
	add_filter( 'image_size_names_choose', 'be_themes_image_sizes' );
}


/* ---------------------------------------------  */
// Remove Admin bar & add support for post formats
/* ---------------------------------------------  */

add_filter('show_admin_bar', '__return_false');

add_post_type_support( 'page', 'post-formats' );





/* ---------------------------------------------  */
// Function for including the required google fonts
/* ---------------------------------------------  */

add_action( 'wp_head', 'be_themes_google_fonts',0 );

function be_themes_google_fonts() {
	global $be_themes_data;
	$be_themes_fonts[] = $be_themes_data['h1']['family'];
	$google_fonts = array();
	array_push(
		$be_themes_fonts,
		$be_themes_data['h2']['family'],
		$be_themes_data['h3']['family'],
		$be_themes_data['h4']['family'],
		$be_themes_data['h5']['family'],
		$be_themes_data['h6']['family'],
		$be_themes_data['page_title']['family'],
		$be_themes_data['body_text']['family'],
		$be_themes_data['bottom_widget_text']['family'],
		$be_themes_data['sidebar_widget_text']['family'],
		$be_themes_data['footer_text']['family'],
		$be_themes_data['navigation_text']['family']
	);
	
	$be_themes_fonts = array_unique($be_themes_fonts);
	
	foreach( $be_themes_fonts as $font ) {
	    $font_family = explode( '/', $font );
		if( $font_family[0] == 'google' ) {
			$google_fonts[] .= "'".$font_family[1]."'";
		}
	}
	
	if( isset( $google_fonts ) ) {
		$fonts_include = implode( ',', $google_fonts );
	}
		
	if( isset( $fonts_include ) ){
		echo 
		     '<script type="text/javascript">
		  		WebFontConfig = {
		    		google: { families: ['.$fonts_include.']}
		  		};
		  		(function() {
			        var wf = document.createElement("script");
			        wf.src = ("https:" == document.location.protocol ? "https" : "http") +
			            "://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js";
			        wf.type = "text/javascript";
			        wf.async = "true";
			        var s = document.getElementsByTagName("script")[0];
			        s.parentNode.insertBefore(wf, s);
			    })();
		    </script>';
	}	    
	
}


/* ---------------------------------------------  */
// Function for setting the background image of a page
/* ---------------------------------------------  */

add_action( 'wp_head', 'be_themes_body_background' );

function be_themes_body_background() {
	global $wp_query;
	global $be_themes_data;
	$page_id = $wp_query->get_queried_object_id();
	$output ='';	 
		 $bg_image = get_post_meta( $page_id, 'be-themes_page_bg_image', true );
		 if( $bg_image ) {
		 	$src = wp_get_attachment_image_src( $bg_image, 'full' );
		 	$src = $src[0];
        } else {
	    	if( isset( $be_themes_data['body']['scale'] ) ){
	    		if( isset($be_themes_data['body']['custom']) ){
		    		$src = $be_themes_data['body']['bgpattern'];
		    	}
		    	elseif( !empty( $be_themes_data['body']['background'] ) ){
			    	$src = get_template_directory_uri().'/css/patterns/'.$be_themes_data['body']['background'].'.png';
		    	}
		    			
		  	}
	    }
	    if( isset($src) ) { 
	    $output .='
	    <script>
	    	jQuery(document).ready(function(){
		    	jQuery.backstretch("'.$src.'");
	    	});
	    </script>';
	    
     }
     echo $output;
}


/* ---------------------------------------------  */
// Function for generating dynamic css
/* ---------------------------------------------  */

add_action( 'wp_ajax_be_themes_options_css', 'be_themes_options_css' );
add_action( 'wp_ajax_nopriv_be_themes_options_css', 'be_themes_options_css' ); 

function be_themes_options_css() {
	global $be_themes_data;
    header( 'Content-Type: text/css' );
    if( $be_themes_data['dev_or_deploy']=="dev" ) {
	    header( 'Expires: Thu, 31 Dec 2050 23:59:59 GMT' );
	    header( 'Pragma: cache' );
	    delete_transient( 'be_themes_css' );
	}
   if ( false === ( $css = get_transient( 'be_themes_css' ) ) ) {
        $be_themes_path = get_template_directory_uri();
        $css_dir = get_stylesheet_directory() . '/css/'; 
        ob_start(); // Capture all output (output buffering)

		require(get_template_directory() .'/css/be-themes-styles.php'); // Generate CSS

		$css = ob_get_clean(); // Get generated CSS (output buffering)
		
        set_transient( 'be_themes_css', $css );
    }

    echo $css;
    die();
}


/* ---------------------------------------------  */
// Enqueue Stylesheets
/* ---------------------------------------------  */

add_action( 'wp_enqueue_scripts', 'be_themes_add_styles' );

function be_themes_add_styles() {

	wp_register_style( 'be-themes-shortcodes', get_template_directory_uri().'/css/shortcodes.css' );
	wp_enqueue_style( 'be-themes-shortcodes' );

	wp_register_style( 'be-themes-css', admin_url('admin-ajax.php?action=be_themes_options_css') );
	wp_enqueue_style( 'be-themes-css' );

	wp_register_style( 'fontello', get_template_directory_uri().'/fonts/fontello/fontello.css' );
	wp_enqueue_style( 'fontello' );

	wp_register_style( 'be-lightbox-css', get_template_directory_uri().'/css/magnific-popup.css' );
	wp_enqueue_style( 'be-lightbox-css' );

	wp_register_style( 'be-flexslider', get_template_directory_uri().'/css/flexslider.css' );
	wp_enqueue_style( 'be-flexslider' );
	
}




/* ---------------------------------------------  */
// Enqueue scripts
/* ---------------------------------------------  */

add_action( 'wp_enqueue_scripts', 'be_themes_add_scripts' ); 

function be_themes_add_scripts() {

	global $be_themes_data;

	wp_deregister_script( 'modernizr' );
	wp_register_script( 'modernizr', get_template_directory_uri() . '/js/vendor/modernizr-2.6.2.min.js' );
	wp_enqueue_script( 'modernizr' );
	
	wp_deregister_script( 'be-themes-plugins-js' );
	wp_register_script( 'be-themes-plugins-js', get_template_directory_uri() . '/js/plugins.js', array( 'jquery' ), FALSE, TRUE );
	wp_enqueue_script( 'be-themes-plugins-js' );

	wp_deregister_script( 'map-api' );
	wp_register_script( 'map-api', 'http://maps.google.com/maps/api/js?sensor=false', array(), FALSE, TRUE );
	wp_enqueue_script( 'map-api' );
	
	wp_deregister_script( 'be-map' );
	wp_register_script( 'be-map', get_template_directory_uri() . '/js/gmap3.min.js', array( 'jquery','map-api' ), FALSE, TRUE );
	wp_enqueue_script( 'be-map' );

	wp_deregister_script( 'jquery_ui_custom' );
	wp_register_script( 'jquery_ui_custom', get_template_directory_uri() . '/js/jquery-ui-1.8.22.custom.min.js', array( 'be-themes-plugins-js' ), FALSE, TRUE );
	wp_enqueue_script( 'jquery_ui_custom' );

	wp_deregister_script( 'be-themes-script-js' );
	wp_register_script( 'be-themes-script-js', get_template_directory_uri() . '/js/script.js', array( 'jquery','be-themes-plugins-js'), FALSE, TRUE );
	wp_enqueue_script( 'be-themes-script-js' );
	
}

require_once( get_template_directory() .'/be-page-builder/be-page-builder.php' );
require_once( get_template_directory() .'/functions/be-tgm-plugins.php' );
?>