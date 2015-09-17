<?php

/* ---------------------------------------------  */
// Function to find last word
/* ---------------------------------------------  */

function be_themes_last_word( $str  ) {
	$str_Pattern = '/[^ ]*$/';
	preg_match( $str_Pattern, $str, $results ); 
	return preg_replace( $str_Pattern,'',$str ).'<span class="alt-color">'.$results[0].'</span>';
}


/* ---------------------------------------------  */
// Function to print pagination 
/* ---------------------------------------------  */


if ( ! function_exists( 'be_themes_pagination' ) ) :
	function be_themes_pagination( $pages = '', $range = 3 ) {  
		$showitems = ( $range * 2 ) + 1;  

		global $paged;
		if( empty( $paged ) ) { 
			$paged = 1;
		}

		if( $pages == '' ) {
		    global $wp_query;
		    $pages = $wp_query->max_num_pages;
		    if( !$pages ) {
		        $pages = 1;
		    }
		}   

		if( 1 != $pages ) {
		    echo '<div class="pagination secondary_text"><span class="sec-bg sec-color">Page '.$paged.' of '.$pages.'</span>';
		    if( $paged > 2 && $paged > $range+1 && $showitems < $pages ) {
		    	echo "<a href='".get_pagenum_link(1)."' class='sec-bg sec-color'>&laquo; ".__('First','be-themes')."</a>";
		    }
		    if( $paged > 1 && $showitems < $pages ) { 
		    	echo "<a href='".get_pagenum_link($paged - 1)."' class='sec-bg sec-color'>&lsaquo; ".__('Prev','be-themes')."</a>";
		    }

		    for ( $i=1; $i <= $pages; $i++ ) {
		        if ( 1 != $pages && ( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ) ) {
		            echo ( $paged == $i) ? "<span class='current alt-bg alt-bg-text-color'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive sec-bg sec-color' >".$i."</a>";
		        }
		    }

		    if ( $paged < $pages && $showitems < $pages ) {
		    	echo "<a href='".get_pagenum_link($paged + 1)."' class='sec-bg sec-color'>".__('Next','be-themes')." &rsaquo;</a>";  
		    }
		    if ( $paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages ) { 
		    	echo "<a href='".get_pagenum_link($pages)."' class='sec-bg sec-color'>".__('Last','be-themes')." &raquo;</a>";
		    }
		    echo "</div>\n";
		}
	}
endif;

/* ---------------------------------------------  */
// Function to customize archives widget
/* ---------------------------------------------  */

add_filter( 'widget_archives_args', 'be_archives' );

if ( ! function_exists( 'be_archives' ) ) :
	function be_archives( $args ) {
		$args['format'] = "custom";
		$args['before'] = "<li class='swap_widget_archive'>";
		$args['after'] = "</li>";
		return $args;
	}
endif;


/* ---------------------------------------------  */
// Function to trim content to the required characters
/* ---------------------------------------------  */

if ( ! function_exists( 'be_themes_trim_content' ) ) :
	function be_themes_trim_content( $content, $count ) {
		if(strlen( $content ) > $count ) {
			return substr( $content, 0, $count ).'. . .';
		} else {
			return substr( $content, 0, $count );
		}
	}
endif;


/* ---------------------------------------------  */
// Function to return pagination markup  */
/* ---------------------------------------------  */


if ( ! function_exists( 'get_be_themes_pagination' ) ) :
	function get_be_themes_pagination( $pages = '', $range = 3 ) {  
	    $showitems = ( $range * 2 ) + 1;  

	    global $paged;
	    if( empty( $paged ) ) $paged = 1;

	    if( $pages == '' ) {
	        global $wp_query;
	        $pages = $wp_query->max_num_pages;
	        if( !$pages ) {
	            $pages = 1;
			}
	    }      

	    if( 1 != $pages ){
	        $returnvalue='<div class="pagination secondary_text"><span class="sec-bg sec-color">Page '.$paged.' of '.$pages.'</span>';
	        if( $paged > 2 && $paged > $range+1 && $showitems < $pages ) { 
	        	$returnvalue.="<a href='".get_pagenum_link(1)."' class='sec-bg sec-color'>&laquo; ".__('First','be-themes')."</a>";
	        }
	        if( $paged > 1 && $showitems < $pages ) { 
	        	$returnvalue.="<a href='".get_pagenum_link($paged - 1)."' class='sec-bg sec-color'>&lsaquo; ".__('Prev','be-themes')."</a>";
	        }
	        for ( $i=1; $i <= $pages; $i++ ) {
	            if (  1 != $pages && ( !( $i >= $paged+$range+1 || $i <= $paged-$range-1 ) || $pages <= $showitems ) ) {
	                $returnvalue.= ( $paged == $i ) ? "<span class='current alt-bg alt-bg-text-color'>".$i."</span>":"<a href='".get_pagenum_link( $i )."' class='inactive sec-bg sec-color' >".$i."</a>";
	            }
	        }
	        if ( $paged < $pages && $showitems < $pages ) { 
	        	$returnvalue.= "<a href='".get_pagenum_link( $paged + 1 )."' class='sec-bg sec-color'>".__( 'Next', 'be-themes' )." &rsaquo;</a>";
	        }  
	        if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) { 
	        	$returnvalue.= "<a href='".get_pagenum_link($pages)."' class='sec-bg sec-color'>".__( 'Last', 'be-themes' )." &raquo;</a>";
	        }
	        $returnvalue.= "</div>\n";
			return $returnvalue;
	    }
	}
endif;


/* ---------------------------------------------  */
// Function to find youtube and Vimeo videos
/* ---------------------------------------------  */

if ( ! function_exists( 'be_themes_video_type' ) ) :
	function be_themes_video_type( $url ) {
		if (strpos( $url, 'youtube' ) > 0) {
			return 'youtube';
		} 
		elseif ( strpos( $url, 'vimeo' ) > 0) {
			return 'vimeo';
		} 
		else {
			return '';
		}
	}
endif;

/* ---------------------------------------------  */
// Function to print categories
/* ---------------------------------------------  */

if ( ! function_exists( 'be_themes_category_list' ) ) :
	function be_themes_category_list( $id ) {
		$numItems = count( get_the_category( $id ) );
		$i = 0;
		foreach( ( get_the_category( $id ) ) as $category ) {
			if( ++$i === $numItems ) {
				echo '<a href="'.get_category_link( $category->cat_ID ).'" title="View all posts in '.$category->cat_name.'"> '.$category->cat_name.'</a>' ;
			} else {
				echo '<a href="'.get_category_link( $category->cat_ID ).'" title="View all posts in '.$category->cat_name.'"> '.$category->cat_name.'</a> , ' ;
			}
		}
	}
endif;


/* ---------------------------------------------  */
//  Function to retrieve categories
/* ---------------------------------------------  */

if ( ! function_exists( 'get_be_themes_category_list' ) ) :
	function get_be_themes_category_list( $id ) {
		$terms = wp_get_object_terms( $id, 'portfolio_categories' );
		$category = "";
		$taxonomies = get_the_term_list( $id, 'portfolio_categories', '', ' / ', '' );
		$taxonomies = strip_tags( $taxonomies );
		$term_count = count( $terms );
		$i = 0;
		foreach ( $terms as $term ) {
			if( ++$i === $term_count )
				$category .= $term->slug;
			else 
				$category .= $term->slug.", ";
		}
		return $category;
	}
endif;



/* ---------------------------------------------  */
// Function to retrieve post slug
/* ---------------------------------------------  */

if ( ! function_exists( 'be_themes_get_the_slug' ) ) :
	function be_themes_get_the_slug( $post_id ) {
	    $post_data = get_post( $post_id, ARRAY_A );
	    $slug = $post_data['post_name'];
	    return $slug; 
	}
endif;


/* ---------------------------------------------  */
// Function to retrieve post ID from slug
/* ---------------------------------------------  */

if ( ! function_exists( 'be_themes_get_id_by_slug' ) ) :
	function be_themes_get_id_by_slug( $post_slug ) {
		$args=array(
			'post_type' => 'portfolio',
			'name' => $post_slug,
			'post_status' => 'publish',
			'showposts' => 1,
			'ignore_sticky_posts'=> 1,
		);
		$my_posts = get_posts( $args );
		if( $my_posts )
			return $my_posts[0]->ID;
		else
			return null;
	}
endif;

/* ---------------------------------------------  */
// Functions for like, tweet and plusone buttons 
/* ---------------------------------------------  */

function be_themes_get_facebook_button( $url ){
	$out = "<iframe src='//www.facebook.com/plugins/like.php?href=".urlencode($url)."&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35&amp;appId=173868296037629' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:100px; height:20px;' allowTransparency='true'></iframe>";
	return $out;
}

function be_themes_get_twitter_button( $url ){
	$out = '<iframe allowtransparency="true" data-count="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.html?url='.$url.'&via=xtapit&text=test" style="width:90px; height:20px;"></iframe>';
	return $out;
}

function be_themes_get_googleplus_button( $url ){
	$out = "<iframe src='https://plusone.google.com/_/+1/fastbutton?url='".$url."'&amp;size=medium&amp;count=true&amp;lang='en' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:65px; height:24px;'></iframe>";
	return $out;
}


/* ---------------------------------------------  */
// Display Next and Previous posts links in blog
/* ---------------------------------------------  */

if ( ! function_exists( 'be_content_nav' ) ) :
	function be_themes_content_nav( $nav_id ) {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) : ?>
			<nav id="<?php echo $nav_id; ?>" class="blog-nav clearfix">
				<div class="nav-previous left"><?php next_posts_link( __( 'Older posts', 'paws' ) ); ?></div>
				<div class="nav-next right"><?php previous_posts_link( __( 'Newer posts', 'paws' ) ); ?></div>
			</nav><!-- #nav-above -->
		<?php endif;
	}
endif; 


/* ---------------------------------------------  */
// Function to Unregister default widgets
/* ---------------------------------------------  */ 

add_action( 'widgets_init', 'be_themes_unregister_widgets', 1 );

if ( ! function_exists( 'be_themes_unregister_widgets' ) ) :
	function be_themes_unregister_widgets() {
	    unregister_widget('WP_Widget_Recent_Posts');
	    unregister_widget('WP_Widget_Recent_Comments');
	}
endif;


/* ---------------------------------------------  */
//
/* ---------------------------------------------  */

add_filter( 'excerpt_length', 'be_themes_custom_excerpt_length', 999 );

if ( ! function_exists( 'be_themes_custom_excerpt_length' ) ) :
	function be_themes_custom_excerpt_length( $length ) {
		return 70;
	}
endif;


/* ---------------------------------------------  */
//
/* ---------------------------------------------  */

add_filter( 'comment_form_field_comment', 'be_themes_comment_field' );

if ( ! function_exists( 'be_themes_comment_field' ) ) :
	function be_themes_comment_field() {
		$commentArea = '<p class="no-margin"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required placeholder="Comment"></textarea></p>';
		return $commentArea;
	}
endif;


/* ---------------------------------------------  */
// HTML5 Search & Comment Forms
/* ---------------------------------------------  */

add_filter( 'get_search_form', 'be_themes_html5_search_form' );
add_filter( 'comment_form_default_fields', 'be_themes_comments_form' );

if ( ! function_exists( 'be_themes_html5_search_form' ) ) :
	function be_themes_html5_search_form( $form ) {
	    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	    <input type="text" placeholder="'.__( "Search..." ).'" value="' . get_search_query() . '" name="s" id="s" class="sec-bg sec-border sec-color" />
	    <i class="search-icon icon-search font-icon"></i>
	    <input type="submit" class="search-submit" value="" />
	    </form>';

	    return $form;
	}
endif;

//HTML5 comment form

if ( ! function_exists( 'be_themes_comments_form' ) ) :
	function be_themes_comments_form() {

		$req = get_option( 'require_name_email' );

		$fields =  array(
		'author' => '<p class="no-margin"><input id="author" name="author" type="text" value="" aria-required="true" placeholder = "Name"' . ( $req ? ' required' : '' ) . '/></p>',

		'email'  => '<p class="no-margin"><input id="email" name="email" type="text" value="" aria-required="true" placeholder="Email"' . ( $req ? ' required' : '' ) . ' /></p>',

		'url'    => '<p class="no-margin"><input id="url" name="url" type="text" value="" placeholder="Website" /></p>'

		);
		return $fields;
	}
endif;


/* ---------------------------------------------  */
// Function to handle blog comments
/* ---------------------------------------------  */

if ( ! function_exists( 'be_themes_comments' ) ) :
function be_themes_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback clearfix">
		<p><?php echo ucfirst( $comment->comment_type ).":  "; comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'be-themes' ) , '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment sec-border-bottom clearfix">
			<div class="comment-author vcard">
					<div class="comment-author-inner">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent ) {
							$avatar_size = 39;
						}
						echo get_avatar( $comment, $avatar_size ); ?>
						<span class="reply"> <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __('Reply','be-themes'), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
					</div>
			</div><!-- .comment-author .vcard -->
			
			<div class="comment-content">
			
				<footer class="comment-meta">
				<?php
						
						printf( __('%1$s %2$s','be-themes'),
							sprintf( '<h6 class="fn">%s</h6>', get_comment_author_link() ),
							sprintf( '<a href="%1$s" class="comment-date-time"><time datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( '%1$s', get_comment_date('d F Y') )
							)
						);
					?>

					
				

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.','be-themes' ); ?></em>
					<br />
				<?php endif; ?>

				</footer>
				<div class="comment_text">
					<?php comment_text(); ?>
			  	</div>
				<ul class="comment-edit-reply clearfix">
					<?php edit_comment_link( __( 'Edit', 'be-themes' ), '<li class="edit-link">', '</li>' ); ?>
				</ul>
			</div>


		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif;


/* ---------------------------------------------  */
// Filter to handle empty search query
/* ---------------------------------------------  */

add_filter( 'request', 'be_themes_request_filter' );

if ( ! function_exists( 'be_themes_request_filter' ) ) :
	function be_themes_request_filter( $query_vars ) {
	    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
	        $query_vars['s'] = " ";
	    }
	    return $query_vars;
	}
endif;


/* ---------------------------------------------  */
// Filter to remove empty widget title <h> tags
/* ---------------------------------------------  */

add_filter( 'widget_title', 'be_themes_empty_widget_title' ); 

if ( ! function_exists( 'be_themes_empty_widget_title' ) ) :
	function be_themes_empty_widget_title($title) {
	    return $title == '&nbsp;' ? '' : $title;
	}
endif;


/* ---------------------------------------------  */
// Filter to execute shortcodes in widgets
/* ---------------------------------------------  */

add_filter( 'widget_text', 'do_shortcode' );


/* ---------------------------------------------  */
// Filter to add custom Tiny MCE buttons
/* ---------------------------------------------  */

add_filter( 'mce_external_plugins', 'be_themes_tinyplugin_register' );
add_filter( 'mce_buttons', 'be_themes_tinyplugin_add_button', 0 );

if ( ! function_exists( 'be_themes_tinyplugin_add_button' ) ) :
	function be_themes_tinyplugin_add_button( $buttons ) {
	    array_push( $buttons, '|', 'tinyplugin','linebreak' );
		return $buttons;
	}
endif;

if ( ! function_exists( 'be_themes_tinyplugin_register' ) ) :
	function be_themes_tinyplugin_register( $plugin_array ) {
	    $url = trim( get_template_directory_uri(), "/" )."/tinymce/editor_plugin_src.js";
	    $plugin_array['tinyplugin'] = $url;
		$plugin_array['linebreak'] = $url;
	    return $plugin_array;
	}
endif;


/* ---------------------------------------------  */
// Filter to prevent empty <p> from shortcodes
/* ---------------------------------------------  */

add_filter( 'the_content', 'do_shortcode', 7 );


/* ---------------------------------------------  */
// Filter to adjust tag could font size
/* ---------------------------------------------  */

add_filter( 'widget_tag_cloud_args' , 'be_themes_tag_font' );

if ( ! function_exists( 'be_themes_tag_font' ) ) :
	function be_themes_tag_font( $args ) {
	  $args['smallest'] = 12;
	  $args['largest'] = 12;
	  $args['unit'] =  'px';	  
	  return $args;
	}
endif;


/* ---------------------------------------------  */
// Filter to generate slug for custom sidebars
/* ---------------------------------------------  */

if ( ! function_exists( 'generateSlug' ) ) :
	function generateSlug( $phrase, $maxLength ) {
		$result = strtolower($phrase);

		$result = preg_replace( "/[^a-z0-9\s-]/", "", $result );
		$result = trim( preg_replace( "/[\s-]+/", " ", $result ) );
		$result = trim( substr( $result, 0, $maxLength ) );
		$result = preg_replace( "/\s/", "-", $result );

		return $result;
	}
endif;

if ( ! function_exists( 'be_themes_get_excerpt' ) ) :
	function be_themes_get_excerpt( $post_id, $length=45 ) {
	    $the_post = get_post( $post_id ); //Gets post ID
	    $the_excerpt = $the_post->post_content; //Gets post_content to be used as a basis for the excerpt
	    $excerpt_length = $length; //Sets excerpt length by word count
	    $the_excerpt = strip_tags( strip_shortcodes( $the_excerpt ) ); //Strips tags and images
	    $words = explode( ' ', $the_excerpt, $excerpt_length + 1 );

	    if( count( $words ) > $excerpt_length ) :
	        array_pop( $words );
	        array_push( $words, '...' );
	        $the_excerpt = implode( ' ', $words );
	    endif;

	    return $the_excerpt;
	}
endif;

/* ---------------------------------------------  */
// Add Video URL field to media uploader
/* ---------------------------------------------  */


add_filter( 'attachment_fields_to_edit', 'be_themes_attachment_field_add', 10, 2 );

if ( ! function_exists( 'be_themes_attachment_field_add' ) ) :
	function be_themes_attachment_field_add( $form_fields, $post ) {
		$form_fields['be-themes-featured-video-url'] = array(
			'label' => 'Youtube/Vimeo URL',
			'input' => 'text',
			'value' => get_post_meta( $post->ID, 'be_themes_featured_video_url', true ),
			'helps' => 'Enter a Youtube/Vimeo URL to be linked to the featured image',
		);

		return $form_fields;
	}
endif;


add_filter( 'attachment_fields_to_save', 'be_themes_attachment_field_save', 10, 2 );

if ( ! function_exists( 'be_themes_attachment_field_save' ) ) :
	function be_themes_attachment_field_save( $post, $attachment ) {
		if( isset( $attachment['be-themes-featured-video-url'] ) ) {
			update_post_meta( $post['ID'], 'be_themes_featured_video_url', $attachment['be-themes-featured-video-url'] );
		}

		return $post;
	}
endif;


/* ---------------------------------------------  */
// Breadcrumbs
/* ---------------------------------------------  */

if ( ! function_exists( 'be_themes_breadcrumb' ) ) :
	function be_themes_breadcrumb() {
		global $post;
	    $sep = '  /  ';

	    if ( ! is_front_page() ) {

	        echo '<div class="breadcrumbs">';
	        echo '<a href="';
	        echo home_url();
	        echo '">';
	        echo '<i class="font-icon icon-home"></i>';
	        echo '</a>' . $sep;

	        if ( ( is_category() || is_single() ) && ! is_singular( 'portfolio' ) ){
	            the_category( ' / ' );
	        } elseif ( ( is_archive() || is_single() ) && ! is_singular( 'portfolio' ) ){
	            if ( is_day() ) {
	                printf( __( '%s', 'be-themes' ), get_the_date() );
	            } elseif ( is_month() ) {
	                printf( __( '%s', 'be-themes' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'be-themes' ) ) );
	            } elseif ( is_year() ) {
	                printf( __( '%s', 'be-themes' ), get_the_date( _x( 'Y', 'yearly archives date format', 'be-themes' ) ) );
	            } else {
	                _e( 'Blog Archives', 'be-themes' );
	            }
	        }

	        if( is_singular('portfolio') ) {
	            echo get_the_term_list( $post->ID, 'portfolio_categories','','  /  ' ); 
	        }

	        if ( is_single() ) {
	            echo $sep;
	            the_title();
	        }

	        if ( is_page() ) {
	        	$parents = get_ancestors( get_the_ID(),'page' );
	        	if( !empty( $parents ) ){
	        		foreach ( $parents as $parent ) {
	        			echo '<a href="'.get_permalink($parent).'">'.get_the_title( $parent ).'</a> / ';
	        		}
	        	}
	            echo the_title();
	        }

	        if ( is_home() ){
	            global $post;
	            $page_for_posts_id = get_option( 'page_for_posts' );
	            if ( $page_for_posts_id ) { 
	                $post = get_page( $page_for_posts_id );
	                setup_postdata( $post );
	                the_title();
	                rewind_posts();
	            }
	        }

	        echo '</div>';
	    }
	}
endif;


/* ---------------------------------------------  */
// Related Projects
/* ---------------------------------------------  */


if ( ! function_exists( 'be_themes_related_projects' ) ) :
	function be_themes_related_projects( $id  ) {
		global $be_themes_data;
		//$tags = get_terms('portfolio_tags',$id);
		$cats = get_the_terms( $id, 'portfolio_categories' );

		if ( $cats ) {
			$ids = array();
			foreach ( $cats as $cat ) {
				array_push( $ids, $cat->term_id );
			}
			
			$number_related = $be_themes_data['number_related_portfolio'];
			if( $number_related == 'three' ){
				$posts_per_page = 3;
				$column = 'third';
			} else {
				$posts_per_page = 4;
				$column = 'fourth';
			}

			$args = array(
				'post_type' => 'portfolio',
				'tax_query' => array (
					array (
						'taxonomy' => 'portfolio_categories',
						'field' => 'term_id',
						'terms' => $ids,
					)
				),
				'post__not_in' => array($id),
				'posts_per_page'=> $posts_per_page,
				'ignore_sticky_posts'=>1,
			);
			$my_query = new WP_Query( $args );
			if( $my_query->have_posts()) {
				echo '<h4 class="related-posts-title">'.__( $be_themes_data['related_portfolio_title'], 'be-themes' ).'</h4>';
				echo '<div class="be-row clearfix related-items">';
				

				while ( $my_query->have_posts() ) : $my_query->the_post(); 
					$attachment_id = get_post_thumbnail_id( get_the_ID() );
					$attachment_thumb=wp_get_attachment_image_src( $attachment_id, 'portfolio-'.$number_related );
					$attachment_full = wp_get_attachment_image_src( $attachment_id, 'full');
					$attachment_thumb_url = $attachment_thumb[0];
					$attachment_full_url = $attachment_full[0];
					$video_url = get_post_meta( $attachment_id, 'be_themes_featured_video_url', true );
					$mfp_class='mfp-image';
					if( !empty( $video_url ) ){
						$attachment_full_url = $video_url;
						$mfp_class = 'mfp-iframe';
					}
					echo '<div class="one-'.$column.' column-block be-hoverlay">';
					echo '<div class="element-inner">';
					echo '<div class="thumb-wrap"><img src="'.$attachment_thumb_url.'" alt />';
					echo '<div class="thumb-overlay"><div class="thumb-bg">';
					echo '<div class="thumb-icons"><a href="'.get_permalink().'"><i class="font-icon icon-link"></i></a><a href="'.$attachment_full_url.'" class="image-popup-vertical-fit '.$mfp_class.'"><i class="font-icon icon-search"></i></a></div>';
					echo '</div></div>';//end thumb overlay & bg
					echo '</div>';//end thumb wrap

					echo '<div class="sec-bg portfolio-title"><h5 class="sec-title-color"><a href="'.get_permalink().'">'.get_the_title().'</a></h5></div>';
					echo '</div>';
					echo '</div>';//end element inner
					
				endwhile;
				echo '</div>';
			}
			wp_reset_query();
		}
	}
endif;

/* ---------------------------------------------  */
// Top Header Widget
/* ---------------------------------------------  */

if ( ! function_exists( 'be_get_widget' ) ) :
	function be_get_widget( $widget_title ) {

		global $be_themes_data;

		switch ( $widget_title ) {
			case 'search':
				the_widget( 'WP_Widget_Search' );
				break;
			case 'social':
				the_widget( 'BE_social_media' );
				break;
			case 'contact':
				echo '<div class="header-contact">';
				if(!empty($be_themes_data['phone_number']))
					echo '<span class="phone-number"><i class="font-icon icon-mobile"></i>'.$be_themes_data['phone_number'][0].'</span>';
				if(!empty($be_themes_data['mail_id']))
					echo '<a href="mailto:'.$be_themes_data['mail_id'][0].'" class="mail-id"><i class="font-icon icon-mail"></i>'.$be_themes_data['mail_id'][0].'</a>';	
				echo '</div>';							
				break;			
			default:
				echo '';
				break;
		}

	}
endif;


/* ---------------------------------------------  */
// Function to get image id from src url
/* ---------------------------------------------  */

if ( ! function_exists( 'get_attachment_id_from_src' ) ) :
	function get_attachment_id_from_src( $image_src ) {
	     global $wpdb;
	     $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
	     $id = $wpdb->get_var( $query );
	     return $id;
	}
endif;


add_action( 'admin_footer', 'be_themes_toggle_post_formats' );
function be_themes_toggle_post_formats() {

    $script = '
    <script type="text/javascript">
        jQuery( document ).ready( function($)
            {
            	var selected_post_format = jQuery("input[name=post_format]:checked").attr("value");
            	toggle_post_format_options(selected_post_format);

            	jQuery("input[name=post_format]").change(function(){
            		toggle_post_format_options(jQuery(this).attr("value"));
            	});

            }
        );
		        function toggle_post_format_options(format){
		        	
            		switch (format){
            			case "0":
            			case "image":
            			case "aside":
            				jQuery("#post_format_options .rwmb-meta-box").removeClass("visible").addClass("hidden");
            				break;
            			case "video":
            				jQuery("#post_format_options .rwmb-meta-box").removeClass("hidden").addClass("visible");
            				jQuery("#be_themes_video_url").closest(".rwmb-field").removeClass("hidden").addClass("visible").siblings().addClass("hidden");
            				break;	
            			case "audio":
            				jQuery("#post_format_options .rwmb-meta-box").removeClass("hidden").addClass("visible");
            				jQuery("#be_themes_audio_url").closest(".rwmb-field").removeClass("hidden").addClass("visible").siblings().addClass("hidden");
            				break;	
            			case "gallery":
            				jQuery("#post_format_options .rwmb-meta-box").removeClass("hidden").addClass("visible");
            				jQuery("label[for=be_themes_gal_post_format]").closest(".rwmb-field").removeClass("hidden").addClass("visible").siblings().addClass("hidden");
            				break;
            			case "link":
            				jQuery("#post_format_options .rwmb-meta-box").removeClass("hidden").addClass("visible");
            				jQuery("#be_themes_link_url").closest(".rwmb-field").removeClass("hidden").addClass("visible").siblings().addClass("hidden");
            				break;
            			case "quote":
            				jQuery("#post_format_options .rwmb-meta-box").removeClass("hidden").addClass("visible");
            				jQuery("#post_format_options").find(".rwmb-field").removeClass("visible").addClass("hidden");
            				jQuery("#be_themes_quote_title").closest(".rwmb-field").removeClass("hidden").addClass("visible");
            				jQuery("#be_themes_quote_author").closest(".rwmb-field").removeClass("hidden").addClass("visible");
            				break;            				            					            				            				
            		}

            	}
    </script>
    ';

    return print $script;
}

function be_themes_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) ) {
		$args['show_home'] = true;
		$args['menu_class'] = 'menu';
	}
	return $args;
}
add_filter( 'wp_page_menu_args', 'be_themes_page_menu_args' );

?>