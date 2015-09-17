<?php 
	
require_once( get_template_directory() .'/functions/custom-post-types/PostType.php' );

/***********************************************
					PORTFOLIO
***********************************************/	

//Create Post Type
$portfolio = Create_Custom_Post_Type( 'portfolio' );

//Add Categories Style Taxonomy
$portfolio->Add_Categories_Style_Taxonomy( 'portfolio_categories' );

//Add Tags Style Taxonomy
$portfolio->Add_Tags_Style_Taxonomy( 'portfolio_tags' );




function be_themes_portfolio_sort_menu() {
   // $be_themes_sort_menu = add_submenu_page('edit.php?post_type=portfolio', 'Sort Portfolios', __('Sort Portfolios', 'be-themes'), 'edit_posts', basename(__FILE__), 'be_themes_portfolio_sort');
    $be_themes_sort_menu = add_theme_page('Sort Portfolio Items', 'Sort Portfolios','edit_posts','be_themes_portfolio_sort','be_themes_portfolio_sort');
    add_action( 'admin_enqueue_scripts', 'be_themes_sort_order_scripts' );
}
add_action('admin_menu', 'be_themes_portfolio_sort_menu');


function be_themes_portfolio_sort() {
	$args = array(
		'posts_per_page'  => -1,
		'orderby'         => 'menu_order',
		'order'           => 'ASC',
		'post_type'       => 'portfolio',
		'post_status'     => 'publish'
	);
	$posts = get_posts( $args );
	echo '<h3>'.__('Sort Portfolio Order','be-themes').'</h3>';
	echo '<p>'.__('Drag and Drop to rearrange the order in which the portfolio items need to be shown','be-themes').'</p>';
	echo '<input type="hidden" id="ajax_url" value="'.get_bloginfo('url').'/wp-admin/admin-ajax.php" />';
	echo '<div id="sort-items">';
	echo '<ul class="be-themes-sort-order">';
	foreach( $posts as $post ) : 
	echo '<li class="portlet be-pb-element" data-post-id="'.$post->ID.'">
			<div class="portlet-header">'.$post->post_title.'</div>
		</li>';

	endforeach;
	echo '</ul>';
	echo '</div>';
	echo '<div id="be-themes-save-wrap"><a href="#" class="bluefoose-button-dark" id="be-themes-sort-save">Save</a></div>';
}

function be_themes_sort_order_scripts($hook){
	
	if('appearance_page_be_themes_portfolio_sort' != $hook) {
		return;
	}
	wp_enqueue_script('be-themes-portfolio-sort-js', get_template_directory_uri().'/js/sort_order.js', array('jquery','jquery-ui-sortable'));
	wp_register_style('be-themes-portfolio-sort-css', get_template_directory_uri().'/css/sort_order.css');
	wp_enqueue_style('be-themes-portfolio-sort-css');	
}

function be_themes_sort_order_css($hook){
	if('appearance_page_be_themes_portfolio_sort' != $hook) {
		return;
	}
}

function be_themes_save_sort_order() {
    global $wpdb;
    
    $ids = $_POST['post_id'];
    $count = 0;

    foreach($ids as $id) {
        $wpdb->update($wpdb->posts, array('menu_order' => $count), array('ID' => $id));
        $count++;
    }
    die(1);
}
add_action( 'wp_ajax_be_themes_save_sort_order', 'be_themes_save_sort_order' );
add_action( 'wp_ajax_be_themes_save_sort_order', 'be_themes_save_sort_order' );


?>