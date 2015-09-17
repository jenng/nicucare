<?php
/**************************************************************************
							SHORTCODES 
**************************************************************************/


function be_themes_formatter( $content ) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	foreach ( $pieces as $piece ) {
		if ( preg_match( $pattern_contents, $piece, $matches ) ) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}

/**************************************
			SECTION
**************************************/

add_shortcode( 'section', 'be_section' );
	function be_section( $atts, $content ) { 

		extract( shortcode_atts( array(
	        'bg_color'=>'',
	        'bg_image' => '',
	        'bg_repeat' => 'repeat',
	        'bg_attachment' => 'scroll',
	        'bg_position' => 'left top',
	        'bg_stretch'=>0,
	        'border_size' => '1',
	        'border_color' =>'',
	        'padding_top'=>'',
	        'padding_bottom'=>'',
	    ),$atts));

	    $background = '';
	    $border = '';

	    if(empty( $bg_image  ) ){
	    	if( ! empty( $bg_color ) )
	    		$background = 'background-color: '.$bg_color.';';	
	    } else{
			$attachment_info=wp_get_attachment_image_src($bg_image,'full');
			$attachment_url = $attachment_info[0];
			if( ! empty( $attachment_url ) ) {
	    		$background = 'background:'.$bg_color.' url('.$attachment_url.') '.$bg_repeat.' '.$bg_attachment.' '.$bg_position.';';
	    	}
	    }

	    if( ! empty( $border_color ) ) {
	    	$border = 'border-top:'.$border_size.'px solid '.$border_color.';border-bottom:'.$border_size.'px solid '.$border_color.';';
	    }

	    if( isset( $padding_top ) && $padding_top != '' ) {
	    	$padding_top = 'padding-top:'.$padding_top.'px;';
	    }

	    if( isset( $padding_bottom ) && $padding_bottom != '' ) {
	    	$padding_bottom = 'padding-bottom:'.$padding_bottom.'px;';
	    }
	    if( isset( $bg_stretch ) && 1 == $bg_stretch ) {
	    	$bg_stretch = 'be-bg-cover';
	    } else {
	    	$bg_stretch = '';
	    }

		return '<div class="be-section '.$bg_stretch.' clearfix" style="'.$padding_top.$padding_bottom.$background.$border.'">'.do_shortcode( $content ).'</div>';
	}


/**************************************
			ROW
**************************************/

add_shortcode( 'row','be_row' );
	function be_row( $atts, $content ) {

		extract( shortcode_atts( array(
	        'no_wrapper'=>0,
	        'no_margin_bottom'=>0,
	    ),$atts ) );

		$class = 'be-wrap clearfix';
	    if( isset( $no_wrapper ) &&  1 == $no_wrapper ) {
	    	$class = '';
	    }
	    if( isset( $no_margin_bottom ) &&  1 == $no_margin_bottom ) {
	    	$class .= ' zero-bottom';
	    }	    

		return '<div class="be-row '.$class.'">'.do_shortcode( $content ).'</div>';
	}

/**************************************
			TEXT BLOCK
**************************************/

add_shortcode( 'text', 'be_text' );
	function be_text( $atts, $content ) {
		return be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) );
	}

/**************************************
			PREMIUM SLIDERS
**************************************/

add_shortcode( 'premium_sliders', 'be_premium_sliders' );
	function be_premium_sliders( $atts, $content ) {
		return do_shortcode( $content );
	}



/**************************************
			SEPARATOR
**************************************/

add_shortcode( 'separator', 'be_separator' );
	function be_separator( $atts ) {
		extract( shortcode_atts( array(
	        'style' => 'style-1',
	        'color' =>'',
	    ),$atts ) );
		$output ='';
		if( ! empty( $color ) ) {
			$color = 'style="border-color:'.$color.';color:'.$color.';"';
		}
		$output .='<hr class="be-shortcode separator '.$style.'" '.$color.' />';
		return $output;
	}

/**************************************
			Special Heading
**************************************/

add_shortcode( 'special_heading', 'be_special_heading' );
	function be_special_heading( $atts, $content ) {
		extract( shortcode_atts( array(
	        'divider_style' => 'style-1',
	        'divider_position' => 'bottom',
	        'h_tag' => 'h3',
	        'color'=>'',
	    ),$atts ) );

		$output ='';
		if( ! empty( $color ) ) {
			$color = 'style="border-color:'.$color.';color:'.$color.';"';
		}
		$output .='<div class="special-heading divider-'.$divider_position.' '.$divider_style.'"><'.$h_tag.' class="special-h-tag">'.$content.'</'.$h_tag.'><hr '.$color.' /></div>';
		return $output;
	} 

/**************************************
			Services
**************************************/

add_shortcode( 'services', 'be_services' );
	function be_services( $atts, $content ) {

		global $be_themes_data;
		extract( shortcode_atts( array(
	        'style'=>'style-1',
	        'icon' => 'none',
	        'circled'=>0,
	        'icon_bg'=> $be_themes_data['color_scheme'],
	        'icon_color'=>$be_themes_data['alt_bg_text_color'],        
	        'image'=>'',     
	        'button_text'=>'',
	        'button_link'=>'',
	        'button_type'=>'link',
	        'background'=>'',
	        'border_size'=>'1',
	        'border_color'=>'',         
	    ),$atts ) );
		$output ='';
		$icon_or_img = '';
		$border = '';
		if( ! empty( $image ) ) {
			$url = wp_get_attachment_image_src( $image, 'portfolio-one' );
			$icon_or_img = '<img src="'.$url[0].'" alt="" />';
		} else {
			if( $icon != 'none' ) { 
			 	if( 1 == $circled ) {
			 		$circled = 'circled';
			 		$background_color = 'background-color:'.$icon_bg.';';
			 	} else {
			 		$circled = '';
			 		$background_color = ''; 		
			 	}
			 	$icon_or_img = '<i class="font-icon icon-'.$icon.' title-icon '.$circled.'" style="'.$background_color.'color:'.$icon_color.';"></i>';
			}
		} 
		if( !empty( $border_color ) ) {
	    	$border = 'border:'.$border_size.'px solid '.$border_color.';';
	    }
	    if( !empty( $background ) ){
	    	$background = 'background:'.$background.';';
	    }
	    switch ( $style ) {
	    	case 'style-1':
	    		$output .= '<div class="services-wrap sec-bg" style="'.$background.$border.'">';
	    		if( ! empty( $icon_or_img ) ) {
	    			$output .= '<div class="services-img '.$style.'">'.$icon_or_img.'</div>';
	    		}
	    		$output .= '<div class="services-description sec-color">'.be_themes_formatter(do_shortcode(shortcode_unautop($content))).'</div>';
	    		if( ! empty( $button_text ) ){
	    			$output .= do_shortcode( '[button type="'.$button_type.'" link="'.$button_link.'" button_text="'.$button_text.'"]' );
	    		}
	    		$output .='</div>';
	    		break;
	    	case 'style-2':
	    		//$url = wp_get_attachment_image_src( $image, 'full' );
	    		$output .= '<div class="services-img '.$style.'">'.$icon_or_img.'</div>';
	    		$output .= '<div class="services-wrap sec-bg" style="'.$background.$border.'">';
	    		$output .= '<div class="services-description sec-color">'.be_themes_formatter(do_shortcode(shortcode_unautop($content))).'</div>';
	    		if( ! empty( $button_text ) ){
	    			$output .= do_shortcode( '[button type="'.$button_type.'" link="'.$button_link.'" button_text="'.$button_text.'"]' );
	    		} 
	    		$output .='</div>';  		
	    		break;
	    }
		
		return $output;

	}

/**************************************
			MEET OUR TEAM
**************************************/

add_shortcode( 'team', 'be_team' );
	function be_team( $atts, $content ) {
		extract( shortcode_atts( array( 
			'title'=>'',
			'h_tag'=>'h5',
			'image'=>'',
			'designation'=>'',
			'description'=>'',
			'facebook'=>'',
			'twitter'=>'',
			'dribbble'=>'',
			'google_plus'=>'',
			'linkedin'=>'',
			'youtube'=>'',
			'vimeo'=>'',
		),$atts ) );
		$output = '';
		$url = wp_get_attachment_image_src( $image, 'portfolio-one' );
		$output .= '<div class="team-img"><img src="'.$url[0].'" alt="'.$title.'" /></div>
					<div class="team-wrap sec-bg">
					<'.$h_tag.' class="team-title sec-title-color">'.$title.'</'.$h_tag.'><p class="designation alt-color">'.$designation.'</p>
					<p class="team-description sec-color">'.$description.'</p>';
		if( ! empty( $facebook ) || ! empty( $twitter ) || ! empty( $dribbble ) || ! empty( $google_plus ) || ! empty( $linkedin ) || ! empty( $youtube ) || ! empty( $vimeo ) ){
			$output .='<ul class="team-social clearfix">';
			if( ! empty( $facebook ) ){
				$output .='<li><a href="'.$facebook.'" class="team_icons" target="_blank"><i class="icon-facebook"></i></a></li>';
			}
			if( ! empty( $twitter ) ){
				$output .='<li><a href="'.$twitter.'" class="team_icons" target="_blank"><i class="icon-twitter"></i></a></li>';
			}
			if( ! empty( $google_plus ) ){
				$output .='<li><a href="'.$google_plus.'" class="team_icons" target="_blank"><i class="icon-gplus"></i></a></li>';
			}
			if( ! empty( $linkedin ) ){
				$output .='<li><a href="'.$linkedin.'" class="team_icons" target="_blank"><i class="icon-linkedin"></i></a></li>';
			}
			if( !empty( $youtube ) ){
				$output .='<li><a href="'.$youtube.'" class="team_icons" target="_blank"><i class="icon-youtube"></i></a></li>';
			}
			if( !empty( $vimeo ) ){
				$output .='<li><a href="'.$vimeo.'" class="team_icons" target="_blank"><i class="icon-vimeo"></i></a></li>';
			}								
			if( !empty( $dribbble ) ){
				$output .='<li><a href="'.$dribbble.'" class="team_icons" target="_blank"><i class="icon-dribbble"></i></a></li>';
			}
			$output .='</ul>';
		}			
		$output .='</div>';			
		return $output;		
	}


/**************************************
			SKILlS
**************************************/

add_shortcode( 'skills', 'be_skills' );
add_shortcode( 'skill', 'be_skill' );

	function be_skills( $atts, $content ) {
		return '<div class="skill_container be-shortcode"><div class="col"><ul id="skill">'.do_shortcode( $content ).'</ul></div></div>';
	}


	function be_skill( $atts, $content ) {
		global $be_themes_data;
		extract( shortcode_atts( array( 
			'title'=>'',
			'value'=>'',
			'fill_color'=>$be_themes_data['color_scheme'],
			'bg_color'=> $be_themes_data['sec_bg'],
		),$atts ) );
		return '<li class="sec-bg" style="background:'.$bg_color.';"><span class="expand alt-bg alt-bg-text-color" style="width: '.$value.'%;background:'.$fill_color.';"><span class="skill_name">'.$title.'</span></span></li>';
	}


/**************************************
			LINEBREAK
**************************************/
add_shortcode( 'linebreak', 'be_linebreak' );
	function be_linebreak( $atts ) {
		extract(shortcode_atts( array(
	        'height'=>'50',
	    ),$atts ) );	
		$output = '';
		$output .='<div class="linebreak" style="height:'.$height.'px;"></div>';
		return $output;
	}

/**************************************
			BLOCKQUOTE
**************************************/
add_shortcode( 'blockquote', 'be_bq' );
	function be_bq( $atts,$content) {
		extract(shortcode_atts( array(
	        'style'=>'style-1',
	        'author'=>'',
	        'company'=>'',
	        'author_image'=>'',
	    ),$atts ) );
	    if( ! empty( $author_image ) ) {
	    	$attachment = wp_get_attachment_image_src( $author_image, 'bq-author' );
	    	$author_image = '<img src="'.$attachment[0].'" alt="'.$author.'" class="left" />';    	
	    }

	    switch ( $style ) {
	    	case 'style-1':
	    		return '<blockquote class="'.$style.'"><i class="icon-quote-left blockquote-icon alt-color"></i>'.do_shortcode( $content ).'</blockquote>';
	    		break;
	    	case 'style-3':
	    		return '<blockquote class="'.$style.'"><div><i class="icon-quote blockquote-icon alt-color"></i></div><p class="bq-quote">'.do_shortcode( $content ).'</p><div class="bq-author-wrap clearfix">'.$author_image.'<div class="bq-author-details left"><p class="bq-author alt-color">'.$author.'</p><p class="bq-company">'.$company.'</p></div></div></blockquote>';
	    	break;
	    	case 'style-2':
	    		return '<blockquote class="'.$style.' sec-bg sec-border"><i class="icon-quote blockquote-icon alt-color"></i>'.do_shortcode( $content ).'</blockquote>';
	    	break;	
	    	default:
	    		return '<blockquote class="'.$style.'">'.do_shortcode( $content ).'</blockquote>';
	    		break;
	    }
		
	}

/**************************************
			YOUTUBE
**************************************/

add_shortcode( 'video', 'be_video' );
	function be_video( $atts, $content ) {
		extract(shortcode_atts( array(
			'source'=>'youtube',
	        'url'=>'',
	    ),$atts ) );

	    switch ( $source ) {
	    	case 'youtube':
	    		return be_youtube( $url );
	    		break;
	    	
	    	default:
	    		return be_vimeo( $url );
	    		break;
	    }
	}


	function be_youtube( $url ) {
		$video_id = '';
		if( ! empty( $url ) ) {
			if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match ) ) {
				
				$video_id = $match[1];
			}
			return '<iframe class="youtube" src="http://www.youtube.com/embed/'.$video_id.'" style="border: none;"></iframe>';		
		} else {
			return '';
		}

	}
	/**************************************
				VIMEO
	**************************************/

	function be_vimeo( $url ) {
		$video_id = '';
		if( ! empty( $url ) ) {
			sscanf(parse_url($url, PHP_URL_PATH), '/%d', $video_id);
			return '<iframe src="http://player.vimeo.com/video/'.$video_id.'" width="500" height="281" style="border: none;"></iframe>';
		} else {
			return '';
		}
	}


/**************************************
			TITLE WITH ICON
**************************************/
add_shortcode( 'title_icon', 'be_title_icon' );
function be_title_icon( $atts, $content ) {
	global $be_themes_data;

	extract( shortcode_atts( array(
		'style'=>'small',
        'icon'=>'none',
        'circled'=>0,
        'icon_bg'=> $be_themes_data['color_scheme'],
        'icon_color'=>$be_themes_data['alt_bg_text_color'],
        'image'=>'',
        'title' =>'',
        'h_tag'=>'h4',
    ),$atts ) );


    $output = '';
 
 	if( 1 == $circled ) {
 		$circled = 'circled';
 		$background_color = 'background-color:'.$icon_bg.';';
 	} else {
 		$circled = '';
 		$background_color = ''; 		
 	}

    if( empty( $image ) && $icon == 'none' ) {
    	$output .= '<div class="title-with-icon">';
    	$output .='<'.$h_tag.'>'.$title.'</'.$h_tag.'>';
    	$output .= do_shortcode($content);
    	$output .='</div>';    	
    } elseif( ! empty( $image ) ) {
		$img = wp_get_attachment_image_src( $image, 'full' );

	    if( $style == 'small' ) {
    		$output .= '<div class="title-with-icon image '.$style.'">';
	    	$output .='<'.$h_tag.' class="title-icon-heading"><img class="title-image-icon" src='.$img[0].' alt="'.$title.'" />'.$title.'</'.$h_tag.'>';
	    	$output .= be_themes_formatter(do_shortcode(shortcode_unautop($content)));
			$output .='</div>';	    	
	    } else {
    		$output .= '<div class="title-with-icon image '.$style.'">';	    	
	    	$output .='<img class="title-image-icon" src='.$img[0].' alt="'.$title.'" />';
	    	$output .= '<'.$h_tag.' class="title-icon-heading">'.$title.'</'.$h_tag.'>';
	    	$output .= be_themes_formatter(do_shortcode(shortcode_unautop($content)));
    		$output .='</div>';  
	    }
	} elseif($icon !='none') {
	    if($style == 'small'){
    		$output .= '<div class="title-with-icon '.$style.'">';
	    	$output .='<'.$h_tag.' class="title-icon-heading"><i class="font-icon icon-'.$icon.' title-icon '.$circled.'" style="'.$background_color.'color:'.$icon_color.';"></i>'.$title.'</'.$h_tag.'>';
	    	$output .= be_themes_formatter(do_shortcode(shortcode_unautop($content)));
			$output .='</div>';	    	
	    } else {
    		$output .= '<div class="title-with-icon '.$style.'">';	    	
	    	$output .='<i class="font-icon icon-'.$icon.' title-icon '.$circled.'" style="'.$background_color.'color:'.$icon_color.';"></i>';
	    	$output .= '<'.$h_tag.' class="title-icon-heading">'.$title.'</'.$h_tag.'>';
	    	$output .= be_themes_formatter(do_shortcode(shortcode_unautop($content)));
    		$output .='</div>';  
	    }		
	}
    return $output; 
}

/**************************************
			TABS
**************************************/

add_shortcode( 'tabs', 'be_tabs' );
	function be_tabs( $atts, $content ) {
		$GLOBALS['tabs_cnt'] = 0;
		$tabs_cnt = 0;
		$GLOBALS['tabs'] = array();
		$content = do_shortcode( $content );
		$rand = rand();	
		if( is_array( $GLOBALS['tabs'] ) ){
			foreach( $GLOBALS['tabs'] as $tab ){
				$tabs_cnt++;
				if( ! empty($tab['icon']) && $tab['icon'] != 'none' ) {
					$class="tab-icon icon-".$tab['icon'];
				} else {
					$class="";
				}
				$tabs[] = '<li class="sec-bg sec-border"><h6 class="sec-title-color"><a  class="swap_tab_controller '.$class.'" href="#fragment-'.$rand.'-'.$tabs_cnt.'" >'.$tab['title'].'</a></h6></li>';
				$panes[] = '<div class="pane sec-border clearfix" id="fragment-'.$rand.'-'.$tabs_cnt.'">'.be_themes_formatter(do_shortcode(shortcode_unautop($tab['content']))).'</div>';
			}
			$return = '<div class="tabs_wrap be-shortcode" style="visibility:hidden;"><ul class="tabs sec-border-bottom">'.implode( "\n", $tabs ).'</ul>'.implode( $panes ).'</div>';
		}
		return $return;
	}


add_shortcode( 'tab', 'be_tab' );
	function be_tab( $atts, $content ) {
		$content= do_shortcode( $content );

		extract(shortcode_atts( array(
	        'icon'=>'',
	        'title'=>'',
	    ),$atts ) );
		$x = $GLOBALS['tabs_cnt'];
		$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tabs_cnt'] ), 'content' =>  $content, 'icon'=> $icon );
		$GLOBALS['tabs_cnt']++;
	}	


/**************************************
			ACCORDIAN
**************************************/

add_shortcode( 'accordion', 'be_accordian' );
	function be_accordian( $atts, $content ) {
		extract(shortcode_atts( array(
	        'style'=>'accordion',
	    ),$atts ) );

	    if( $style == 'collapsed' ){
	    	return '<div class="accordion_all_collapsed be-shortcode clearfix" style="visibility:hidden;">'.do_shortcode( $content ).'</div>';
	    } else {
			return '<div class="accordion be-shortcode clearfix" style="visibility:hidden;">'.do_shortcode( $content ).'</div>';
	    }
	}

add_shortcode( 'collapsed', 'be_collapsed' );
	function be_collapsed( $atts, $content ) {
		return '<div class="accordion_all_collapsed be-shortcode">'.do_shortcode( $content ).'</div>';
	}

add_shortcode( 'toggle', 'be_toggle' );
	function be_toggle( $atts, $content ) {
		extract(shortcode_atts( array( 'title'=>'' ),$atts ) );
		return '<h6 class="sec-border sec-bg sec-title-color"><a href="#" class="font-icon">'.$title.'</a></h6><div class="accordion_content sec-border">'.do_shortcode( $content ).'<div class="clear"></div></div>';
	}

/**************************************
			TESTIMONIALS
**************************************/

add_shortcode( 'testimonials', 'be_testimonials' );
	function be_testimonials( $atts, $content ){
		extract( shortcode_atts( array(
	        'animation'=> 'fade',
			'slide_interval'=> '3000'
	    ), $atts ) );
		return '<div class="be-flex-slider flexslider flexslider_testimonials" data-animation="'.$animation.'" data-auto-slide="1" data-slide-interval="'.$slide_interval.'"><ul class="slides">'.do_shortcode($content).'</ul></div>';
	}
add_shortcode( 'testimonial', 'be_testimonial' );
	function be_testimonial( $atts, $content ){
		extract(shortcode_atts(array('image'=>'', 'author'=>'', 'company'=>''),$atts));
		if ( !empty( $image ) ) {
			$attachment_info = wp_get_attachment_image_src( $image, 'thumbnail' );
			$attachment_url = $attachment_info[0];
			$author_image =  '<img src="'.$attachment_url.'" alt="" />';
		}
		return '<li><ul class="clearfix testimonial_container"><li class="testimonials_content_container"><div style="margin-bottom: 0px;"><div class="testimonial clearfix">'.$author_image.'<p class="no-margin testimonial-content"><i class="icon-quote blockquote-icon alt-color"></i> '.do_shortcode($content).'</p><div class="clearfix testimonial-detail"><div class="testimonial-company right">'.$company.'</div><div class="testimonial-author right alt-color">'.$author.'</div></div></div></div></li></ul></li>';
	}

/**************************************
			LISTS
**************************************/

add_shortcode( 'lists', 'be_lists' );
	function be_lists( $atts, $content ) {
		return '<ul class="custom-list">'.do_shortcode( $content ).'</ul>';
	}


add_shortcode( 'list', 'be_list' );
	function be_list( $atts, $content ) {
		global $be_themes_data;
		extract(shortcode_atts( array( 
			'icon'=>'',
			'circled'=>'',
			'icon_bg'=> $be_themes_data['color_scheme'], 
			'icon_color' => $be_themes_data['alt_bg_text_color'], 
		), $atts ) );
		//$content = str_replace('<ul>', '<ul class="'.$style.' custom-list">', do_shortcode($content));
		if( $icon != 'none' ) { 
		 	if( 1 == $circled ){
		 		$circled = 'circled';
		 		$background_color = 'background-color:'.$icon_bg.';';
		 	} else {
		 		$circled = '';
		 		$background_color = ''; 		
		 	}
		} 
		return '<li class="clearfix"><i class="font-icon icon-'.$icon.' '.$circled.'" style="'.$background_color.'color:'.$icon_color.';"></i><p class="custom-list-content">'.$content.'</p></li>';
	}

/**************************************
			DROP CAPS
**************************************/
add_shortcode( 'dropcap', 'be_dropcap' );
	function be_dropcap( $atts, $content ) {
		extract( shortcode_atts( array(
	        'type'=>'circle',
	        'color'=>'',
	        'size' =>'small',
	        'letter'=>'',
	        'icon'=>'none',
	    ), $atts ) );
		$output="";
		if( $icon != 'none' ){
			$letter = '<i class="font-icon icon-'.$icon.'"></i>';
		}
		$background_color="";
		if( $type == 'square' ) {
			if( $color ){
	    		$background_color = '" style="background-color:'.$color.';"';
	   		} else {
	   			$background_color = ' alt-bg alt-bg-text-color"';
	   		}
			return '<span class="dropcap dropcap-square '.$size.$background_color.'>'.$letter.'</span>'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) );
		}
		if( $type == 'circle' ) {
			if( $color ){
	    		$background_color = '" style="background-color:'.$color.';"';
	   		} else {
	   			$background_color = ' alt-bg alt-bg-text-color"';
	   		}
			return '<span class="dropcap dropcap-circle '.$size.$background_color.'>'.$letter.'</span>'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) );
		} else {
		    if( $color ){
	    		$background_color = ' style="color:'.$color.';"';
	   		}
			return '<span class="dropcap dropcap-letter '.$size.'"'.$background_color.'>'.$letter.'</span>'.be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) );
		}
	}


/**************************************
			NOTIFICATIONS
**************************************/

add_shortcode( 'notifications', 'be_notifications' );

	function be_notifications( $atts, $content ) {
		extract(shortcode_atts( array(
	        'type'=>'success',
	    ), $atts ) );

	    switch ( $type ) {
	    	case 'success':
	    		return '<div class="success be-notification">'.do_shortcode( $content ).'</div>';
	    		break;
	    	case 'error':
	    		return '<div class="error be-notification">'.do_shortcode( $content ).'</div>';
	    		break;
	    	case 'information':
	    		return '<div class="information be-notification">'.do_shortcode( $content ).'</div>';
	    		break;    	
	    	case 'warning':
	    		return '<div class="warning be-notification">'.do_shortcode( $content ).'</div>';
	    		break; 
	    }
	}



/**************************************
			CONTENT FORMATING
**************************************/

add_shortcode( 'one_col', 'be_one_col' );
	function be_one_col( $atts, $content ) {
		$output = '';
		$output .= '<div class="one-col column-block clearfix">'.do_shortcode( $content ).'</div>';
		return $output;
	}

/***********ONE THIRD**************/

add_shortcode( 'one_third', 'be_one_third' );
	function be_one_third( $atts, $content ) {
		$output = '';
		$output .= '<div class="one-third column-block">'.do_shortcode( $content ).'</div>';
		return $output;
	}

add_shortcode( 'one_third_last', 'be_one_third_last' );
	function be_one_third_last( $atts, $content ) {
		$output = '';
		$output .= '<div class="one-third column-block last">'.do_shortcode( $content ).'</div>';
		$output .= '<div class="clear"></div>';
		return $output;
	}


/***********ONE FOURTH**************/
	
add_shortcode( 'one_fourth', 'be_one_fourth' );
	function be_one_fourth( $atts, $content ) {
		$output = '';
		$output = '<div class="one-fourth column-block">'.do_shortcode( $content ).'</div>';
		return $output;
	}
	
add_shortcode( 'one_fourth_last', 'be_one_fourth_last' );
	function be_one_fourth_last( $atts, $content ) {
		$output = '';
		$output .= '<div class="one-fourth column-block last">'.do_shortcode( $content ).'</div>';
		$output .= '<div class="clear"></div>';
		return $output;
	}


/***********ONE HALF**************/

add_shortcode( 'one_half', 'be_one_half' );
	function be_one_half( $atts, $content )  {
		$output = '';
		$output = '<div class="one-half column-block">'.do_shortcode( $content ).'</div>';
		return $output;
	}
add_shortcode('one_half_last','be_one_half_last');
	function be_one_half_last( $atts, $content ) {
		$output = '';
		$output .= '<div class="one-half column-block last">'.do_shortcode( $content ).'</div>';
		$output .= '<div class="clear"></div>';
		return $output;
	}

/***********TWO THIRD**************/
		
add_shortcode( 'two_third', 'be_two_third' );
	function be_two_third( $atts, $content ) {
		$output = '';
		$output = '<div class="two-third column-block">'.do_shortcode( $content ).'</div>';
		return $output;
	}
add_shortcode('two_third_last','be_two_third_last');
	function be_two_third_last( $atts, $content ) {
		$output = '';
		$output = '<div class="two-third column-block last">'.do_shortcode( $content ).'</div>';
		$output .= '<div class="clear"></div>';
		return $output;
	}
/***********THREE FOURTH**************/	

	
add_shortcode( 'three_fourth', 'be_three_fourth' );
	function be_three_fourth( $atts, $content ) {
		$output = '';
		$output = '<div class="three-fourth column-block">'.do_shortcode( $content ).'</div>';
		return $output;
	}	
add_shortcode('three_fourth_last','be_three_fourth_last');
	function be_three_fourth_last( $atts, $content ) {
		$output = '';
		$output = '<div class="three-fourth column-block last">'.do_shortcode( $content ).'</div>';
		$output .= '<div class="clear"></div>';
		return $output;
	}


/**************************************
			BUTTON
**************************************/


add_shortcode( 'button', 'be_button' );	
function be_button( $atts, $content ) {
	extract( shortcode_atts( array( 
		'color'=>'#000000',
		'url'=>'',
		'hover'=>'',
		'type'=>'small',
		'icon'=>'',
		'gradient'=>'', 
		'rounded'=>'',
		'button_text'=>'',
	), $atts ) );

	!empty( $color ) ? ( $background_color = "background-color:".$color ) : ( $background_color="" );
    
	if( empty( $hover ) ) {
		$hover = $color;
	}
    
    ( !empty( $icon ) && $icon != 'none' )  ? ( $icon = "icon-".$icon." icon-button" ) : ( $icon = '' );
    $gradient == "1" ? ( $gradient = "gradient" ): ( $gradient = '' );
    $rounded == "1" ? ( $rounded = "rounded" ): ( $rounded = '' );

    if( $type == 'link' ) {
    	return '<a href="'.$url.'">'.$button_text.'</a>';
    } else {
		return '<a class="be-shortcode '.$type.'btn be-button '.$gradient.' '.$rounded.' '.$icon.'" data-hover-color="'.$hover.'" data-default-color="'.$color.'" href="'.$url.'" style="'.$background_color.'" >'.$button_text.'</a>';
	}
}

/**************************************
			Font Icons
**************************************/

add_shortcode( 'icon', 'be_icons' );
function be_icons( $atts, $content ) {
	extract(shortcode_atts(array(
		'name' => '',
        'size'=> 'small',
		'color'=> '#fff',
		'bg_color'=> '#000',
		'style'=> 'square',
		'href'=> '#',
		'hover_color'=> '#fff',
		'hover_bg_color'=> '#000',
    ),$atts));

	$output ="";
	if( $style == 'plain' ) {
		$output .='<a href="'.$href.'" class="icon-shortcode"><i class="font-icon icon-'.$name.' '.$size.' '.$style.'" style="color:'.$color.'; data-color="'.$color.'" data-hover-color="'.$hover_color.'"></i></a>';
	} else {
		$output .='<a href="'.$href.'" class="icon-shortcode"><i class="font-icon icon-'.$name.' '.$size.' '.$style.'" style="color:'.$color.';background-color:'.$bg_color.';" data-color="'.$color.'" data-bg-color="'.$bg_color.'" data-hover-color="'.$hover_color.'" data-bg-hover-color="'.$hover_bg_color.'"></i></a>';
	}
	return $output;
}	

/**************************************
			PORTFOLIO
**************************************/
add_shortcode( 'portfolio' , 'be_portfolio' );
	function be_portfolio( $atts ) {
		extract( shortcode_atts( array(
	        'col'=>'three',
	        'show_filters'=>'yes',
	        'filter'=>'categories',        
	        'category'=>'',
	        'style'=>'show_title',
	        'overlay_color'=>'#000000',
	        'pagination'=>'yes',
	        'items_per_page'=>'12',
	    ) , $atts ) );

		$output = '';

		$output .= '<div class="portfolio '.$col.'-col">';

		$filter_to_use = 'portfolio_'.$filter;
		$category = explode(',', $category);
		if($filter_to_use == 'tag' || empty( $category ) ) {
			$terms = get_terms( $filter_to_use );
		} else{
	    	$args_cat = array( 'taxonomy' => array( $filter_to_use ) );
			$stack = array();
			foreach(get_categories( $args_cat ) as $single_category ){
				if ( in_array( $single_category->slug, $category ) ) {
					array_push( $stack, $single_category->cat_ID );
				}
			}
			$terms = get_terms($filter_to_use, array('include' => $stack) );
		}
	    if( ! empty( $terms ) && $show_filters == 'yes') {	
		    $output .='<div class="filters clearfix">';
		    
	    	$output .='<span class="sort current_choice" data-id="element">All</span>';
	    	foreach ($terms as $term) {
	    		$output .='<span class="sort" data-id="'.$term->slug.'">'.$term->name.'</span>';
	    	}
		    
	    	$output .='</div>'; //end filters	
		}
		$output .='<div class="portfolio-container clickable clearfix">';


	    global $paged;
		if( $paged == 0 ) {
			$offset=0;
		} else {
			$offset = ( ( $items_per_page * $paged ) - $items_per_page );
		}	
		if( empty( $items_per_page ) ) {
			$items_per_page = -1;
		}	


		if( empty( $category[0] ) ) {
			
			$args = array(
				'post_type' => 'portfolio',
				'posts_per_page' => $items_per_page,
				'offset'=> $offset,
				'orderby'=>'menu_order',
				'order'=>'ASC',				
			);
		} else {
			$args = array(
				'post_type' => 'portfolio',
				'posts_per_page' => $items_per_page,
				'tax_query' => array(
					array(
						'taxonomy' => 'portfolio_categories',
						'field' => 'slug',
						'terms' => $category,
						'operator' => 'IN',
					)
				),
				'offset'=> $offset,
				'orderby'=>'menu_order',
				'order'=>'ASC',	
			);	
		}


		$the_query = new WP_Query( $args );
		while ( $the_query->have_posts() ) : $the_query->the_post();
		$filter_classes = '';
		$post_terms = get_the_terms( get_the_ID(), $filter_to_use );

		if( $show_filters == 'yes' && is_array( $post_terms ) ) {
			foreach ( $post_terms as  $term ) {
				$filter_classes .=$term->slug." ";
			}
		} else{
			$filter_classes='';
		}
		
		$attachment_id = get_post_thumbnail_id(get_the_ID());
		if($col == 'fullscreen') {
			$attachment_thumb=wp_get_attachment_image_src( $attachment_id, 'portfolio-two');
		} else {
			$attachment_thumb=wp_get_attachment_image_src( $attachment_id, 'portfolio-'.$col);
		}
		$attachment_full = wp_get_attachment_image_src( $attachment_id, 'full');
		$attachment_thumb_url = $attachment_thumb[0];
		$attachment_full_url = $attachment_full[0];
		$video_url = get_post_meta( $attachment_id, 'be_themes_featured_video_url', true );
		$visit_site_url = get_post_meta( get_the_ID(), 'be_themes_portfolio_visitsite_url', true );
		$link_to = get_post_meta( get_the_ID(), 'be_themes_portfolio_link_to', true );
		$thumb_options = get_post_meta( get_the_ID(), 'be_themes_thumbnail_lightbox', true );
		$permalink = '';
		
		if( isset( $link_to ) && $link_to != 'no_link' ) {
			if( $link_to == 'external_url' ) {
				$permalink = $visit_site_url;
			} else {
				$permalink = get_permalink();
			}
		}
		$mfp_class='mfp-image';
		if( ! empty( $video_url ) ) {
			$attachment_full_url = $video_url;
			$mfp_class = 'mfp-iframe';
		}

		if( isset( $thumb_options ) && $thumb_options == 'gallery' ) {
			$thumb_class = 'be-lightbox';
		} else {
			$thumb_class =  'image-popup-vertical-fit';
		}
		
		if( $col == 'one' ) {
			$output .= '<div class="element clearfix '.$filter_classes.'">';
			$output .= '<div class="be-row clearfix">';
			$output .= '<div class="one-half column-block be-hoverlay"><div class="element-inner"><div class="thumb-wrap"><img src="'.$attachment_thumb_url.'" alt />';
			$output .= '<div class="thumb-overlay"><div class="thumb-bg">';
			$output .= '<div class="thumb-icons">';
			if( ! empty( $permalink ) ) {
				$output .='<a href="'.$permalink.'"><i class="font-icon icon-link"></i></a>';
			}
			$output .= '<a href="'.$attachment_full_url.'" class="'.$thumb_class.' '.$mfp_class.'"><i class="font-icon icon-search"></i></a>';
			if( isset($thumb_options) && $thumb_options == 'gallery' ):
				$output .='<div class="popup-gallery">';
				$attachment_args = array( 'post_type' => 'attachment', 'posts_per_page' => -1, 'post_status' => 'any', 'post_parent'=> get_the_ID(), 'orderby' => 'menu_order' , 'order'=>'ASC' );
				$attachments = get_posts( $attachment_args );
				
				foreach ( $attachments as $att ) { 
					$video_url = get_post_meta( $att->ID, 'be_themes_featured_video_url', true );
					$mfp_class='mfp-image';
					if( ! empty( $video_url ) ) {
						$url = $video_url;
						$mfp_class = 'mfp-iframe';
					} else {
						$url = wp_get_attachment_image_src($att->ID,'full');
						$url = $url[0];
					}
					$output .='<a href="'.$url.'" class="'.$mfp_class.'"></a>';
				}
				$output .= '</div>';
			endif;

			$output .= '</div>'; // end thumb icons
			$output .= '</div></div>';//end thumb overlay & bg
			$output .= '</div>';//end thumb wrap
			$output .= '</div>'; // end element-inner
			$output .= '</div>';// one-half		
			$output .= '<div class="one-half column-block">';
				$output .= '<div class="portfolio-content-wrap">';
				$output .= '<h3 class="portfolio-title"><a href="'.$permalink.'">'.get_the_title().'</a></h3>';
				$output .= '<ul class="secondary_text portfolio-categories clearfix">';
				if( is_array( $post_terms ) ) {
					foreach ( $post_terms as  $term ) {
						$output .= '<li>'.$term->name.'</li>';
					}
				}
				$output .='</ul>';

			$output .= '<div class="portfolio-content">'.get_the_excerpt().'</div>';
			$output .= do_shortcode('[button button_text= "Learn More" type= "small" gradient= "1" rounded= "1" icon= "" color= "#00bfd7" hover= "#00bfd7" url="'.get_permalink(get_the_ID()).'" ]');
			if(!empty($visit_site_url)){
				$output .=do_shortcode('[button button_text= "Visit Site" type= "small" gradient= "1" rounded= "1" icon= "" color= "#00bfd7" hover= "#00bfd7" url="'.get_permalink(get_the_ID()).'" ]');
			}
			$output .= '</div>';	
			$output .= '</div>'; // end one half
			$output .= '</div>';//end row
			$output .= do_shortcode( '[separator style= "style-1" ]' );
			$output .= '</div>';//end element
			
		} else {
			$output .='<div class="element be-hoverlay '.$filter_classes.'">';
			$output .= '<div class="element-inner">';
			switch ( $style ) {
				case 'no_title':
					$output .='<div class="thumb-wrap"><img src="'.$attachment_thumb_url.'" alt />';
					$output .='<div class="thumb-overlay"><div class="thumb-bg">';
					$output .='<div class="thumb-icons">';
					if( ! empty( $permalink ) ){
						$output .='<a href="'.$permalink.'"><i class="font-icon icon-link"></i></a>';
					}
					$output .='<a href="'.$attachment_full_url.'" class="'.$thumb_class.' '.$mfp_class.'"><i class="font-icon icon-search"></i></a>';
					if( isset($thumb_options) && $thumb_options == 'gallery' ):
						$output .='<div class="popup-gallery">';
						$attachment_args = array( 'post_type' => 'attachment', 'posts_per_page' => -1, 'post_status' => 'any', 'post_parent'=> get_the_ID(), 'orderby' => 'menu_order' , 'order'=>'ASC' );
						$attachments = get_posts( $attachment_args );
						
						foreach ( $attachments as $att ) { 
							$video_url = get_post_meta( $att->ID, 'be_themes_featured_video_url', true );
							$mfp_class='mfp-image';
							if( ! empty( $video_url ) ) {
								$url = $video_url;
								$mfp_class = 'mfp-iframe';
							} else {
								$url = wp_get_attachment_image_src($att->ID,'full');
								$url = $url[0];
							}
							$output .='<a href="'.$url.'" class="'.$mfp_class.'"></a>';
						}
						$output .= '</div>';
					endif;

					$output .= '</div>'; // end thumb icons								
					$output .='</div></div>';//end thumb overlay & bg
					$output .='</div>';//end thumb wrap
					break;
				case 'show_title':
					$output .= '<div class="thumb-wrap"><img src="'.$attachment_thumb_url.'" alt />';
					$output .= '<div class="thumb-overlay"><div class="thumb-bg">';
					$output .= '<div class="thumb-icons">';
					if( ! empty( $permalink ) ){
						$output .= '<a href="'.$permalink.'"><i class="font-icon icon-link"></i></a>';
					}
					$output .= '<a href="'.$attachment_full_url.'" class="'.$thumb_class.' '.$mfp_class.'"><i class="font-icon icon-search"></i></a>';
					if( isset($thumb_options) && $thumb_options == 'gallery' ):
						$output .='<div class="popup-gallery">';
						$attachment_args = array( 'post_type' => 'attachment', 'posts_per_page' => -1, 'post_status' => 'any', 'post_parent'=> get_the_ID(), 'orderby' => 'menu_order' , 'order'=>'ASC' );
						$attachments = get_posts( $attachment_args );
						
						foreach ( $attachments as $att ) { 
							$video_url = get_post_meta( $att->ID, 'be_themes_featured_video_url', true );
							$mfp_class='mfp-image';
							if( ! empty( $video_url ) ) {
								$url = $video_url;
								$mfp_class = 'mfp-iframe';
							} else {
								$url = wp_get_attachment_image_src($att->ID,'full');
								$url = $url[0];
							}
							$output .='<a href="'.$url.'" class="'.$mfp_class.'"></a>';
						}
						$output .= '</div>';
					endif;

					$output .= '</div>'; // end thumb icons			
					$output .= '</div></div>';//end thumb overlay & bg
					$output .= '</div>';//end thumb wrap

					$output .= '<div class="sec-bg portfolio-title"><h5 class="sec-title-color">';
					if( empty( $permalink ) ) {
						$permalink = '#';
					}
					$output .= '<a href="'.$permalink.'">'.get_the_title().'</a>';
					$output .= '</h5></div>';
					break;
				case 'overlay_title':
					$rgb_color = be_themes_hexa_to_rgb( $overlay_color );
					$output .= '<div class="thumb-wrap"><img src="'.$attachment_thumb_url.'" alt />';
					$output .= '<div class="thumb-overlay" style="background:'.$overlay_color.';background-color:rgba('.$rgb_color[0].','.$rgb_color[1].','.$rgb_color[2].',0.8);"><div class="thumb-bg act-table">';
					$output .= '<div class="overlay-thumb-title-wrap"><div class="overlay-thumb-title"><h5>';
					if( empty( $permalink ) ) {
						$permalink = '#';
					}
					$output .= '<a href="'.$permalink.'">'.get_the_title().'</a>';
					$output .= '</h5><hr />';
					$output .= '<span class="overlay-cats">';
					$cat = array(); 
					if( is_array( $post_terms ) ) {
						foreach ( $post_terms as  $term ) {
							array_push( $cat, $term->name );
						}
					}

					$output .= implode( ', ', $cat ).'</span></div></div>';
					$output .= '<div class="overlay-thumb-icons">';
					if( ! empty( $permalink ) && $link_to != 'no_link' ){
						$output .= '<a href="'.$permalink.'"><i class="font-icon icon-link"></i></a>';
					}
					$output .= '<a href="'.$attachment_full_url.'" class="'.$thumb_class.' '.$mfp_class.'"><i class="font-icon icon-search"></i></a>';
					if( isset($thumb_options) && $thumb_options == 'gallery' ):
						$output .='<div class="popup-gallery">';
						$attachment_args = array( 'post_type' => 'attachment', 'posts_per_page' => -1, 'post_status' => 'any', 'post_parent'=> get_the_ID(), 'orderby' => 'menu_order' , 'order'=>'ASC' );
						$attachments = get_posts( $attachment_args );
						
						foreach ( $attachments as $att ) { 
							$video_url = get_post_meta( $att->ID, 'be_themes_featured_video_url', true );
							$mfp_class='mfp-image';
							if( ! empty( $video_url ) ) {
								$url = $video_url;
								$mfp_class = 'mfp-iframe';
							} else {
								$url = wp_get_attachment_image_src($att->ID,'full');
								$url = $url[0];
							}
							$output .='<a href="'.$url.'" class="'.$mfp_class.'"></a>';
						}
						$output .= '</div>';
					endif;

					$output .= '</div>'; // end thumb icons		
					$output .= '</div></div>';//end thumb overlay & bg
					$output .= '</div>';//end thumb wrap
				default:
					# code...
					break;
			}

			
			$output .= '</div>'; //end element inner
			$output .= '</div>';//end element
			
		}
		
		endwhile;
		wp_reset_postdata();

		$output .='</div>'; //end portfolio-container
		if( $pagination == 'yes' ) {
			$output	.='<div class="pagination_parent">'.get_be_themes_pagination($the_query->max_num_pages).'</div>'; //End  Pagination 
		}
		$output .='</div>'; //end portfolio

		return $output;
	}


/**************************************
			SLIDER
**************************************/

add_shortcode( 'flex_slider', 'be_flex_slider' );

	function be_flex_slider( $atts, $content ) {
		extract( shortcode_atts( array(
	        'animation'=> 'fade',
	        'auto_slide'=> 'no',                //Boolean: Animate slider automatically
			'slide_interval'=> '1000',           //Integer: Set the speed of the slideshow cycling, in milliseconds
	    ), $atts ) );
	    $output = "";
	    $output .= '<div class="be-flex-slider flexslider content-flexslider" data-animation="'.$animation.'" data-auto-slide='.$auto_slide.' data-slide-interval="'.$slide_interval.'"><ul class="slides">';
		$output .= do_shortcode( $content );
	    $output .= '</ul></div>';
	    return $output;
	}

add_shortcode( 'flex_slide', 'be_flex_slide' );
	function be_flex_slide( $atts, $content ){
			extract( shortcode_atts( array(
				'image'=>'',
				'video'=>'',
				'title'=>'',
				'caption' => '',
				'show_title'=>'no',
	        	'show_caption'=>'no',
	        	'size'=>'full',
	    	), $atts ) );

			$output = '';
	    	$output .= '<li>';
			if( ! empty( $video ) ) {	
				$videoType = be_themes_video_type( $video );
				if( $videoType == "youtube" ) {
					if ( preg_match( '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video, $match ) ) {
						$video_id = $match[1];
					}
					$output.='<iframe width="940" height="450" src="http://www.youtube.com/embed/'.$video_id.'" allowfullscreen></iframe>';
				}
				elseif( $videoType == "vimeo" ) {
					sscanf( parse_url( $video, PHP_URL_PATH ), '/%d', $video_id );
					$output.='<iframe src="http://player.vimeo.com/video/'.$video_id.'" width="500" height="281" allowFullScreen></iframe>';
				}
			} else {
				if ( !empty( $image ) ) { // check if the post has a Post Thumbnail assigned to it.
					
					$attachment_info = wp_get_attachment_image_src( $image, $size );
					$attachment_url = $attachment_info[0];
					$output .=  '<img src="'.$attachment_url.'" alt="" />';
				}
			}
			if($show_title == 'yes') {
				$title = '<h4 class="flex-slide-title alt_bg_color">'.$title.'</h4>';
			}
			if($show_caption == 'yes') {
				$caption = '<p>'.$caption.'</p>';
			}
			if($show_title == 'yes' || $show_caption == 'yes') {
				$output .=  '<div class="flex-caption">'.$title.$caption.'</div>';
			}
			
	        $output .='</li>';

	        return $output;
	}

/**************************************
			CALL TO ACTION
**************************************/	

add_shortcode( 'call_to_action', 'be_call_to_action' );

	function be_call_to_action( $atts, $content ){
			extract( shortcode_atts( array(
	        'title'=>'',
	        'h_tag'=> 'h4',
			'new_tab'=> 'no',
			'button_text'=>'Click Here',
			'button_color'=>'#00bfd7',
			'button_link'=>'',
			'background_color'=>'',
			'title_color'=>'',
			'pattern'=>0,
	    ), $atts ) );

		$output = '';
		$style = '';
		if( isset( $pattern ) &&  1 == $pattern ) {
			$pattern = 'url('.get_template_directory_uri().'/img/stripe.png)';
		} else {
			$pattern = '';
		}
		if( ! empty( $pattern ) || ! empty( $background_color ) ) {
			$style = 'style="background:'.$background_color.' '.$pattern.';"';
		}
		if( ! empty( $title_color ) ){
			$title_color = 'style="color:'.$title_color.';"';
		}	
		$output .= '<div class="call-to-action be-shortcode sec-bg sec-border clearfix" '.$style.'>';
		//$button_shortcode = '[button button_text= "'.$button_text.'" type= "large" gradient= "1" rounded= "1" icon= "" color= "'.$button_color.'" hover= "#00bfd7" url="'.$button_link.'"]';
		//$output .=do_shortcode($button_shortcode);
		$output .= '<div class="action-content">';
		$output .= '<'.$h_tag.' '.$title_color.'>'.$title.'</'.$h_tag.'>';
		$output .= be_themes_formatter( do_shortcode( shortcode_unautop( $content ) ) );
		$output .= '</div>';
		if( ! empty( $button_link ) ){
			$output .= '<div class="action-button"><a class="mediumbtn be-button gradient rounded" data-hover-color="#000" data-default-color="'.$button_color.'" href="'.$button_link.'" style="background-color:'.$button_color.';border:1px solid'.$button_color.';" >'.$button_text.'</a></div>';
		}
		$output .= '</div>';
		return $output;	
	}


/**************************************
			PROJECT DETAILS
**************************************/

add_shortcode( 'project_details', 'be_project_details' );

	function be_project_details( $atts, $content ) {
		global $post;
		$output = '';
		$post_type = get_post_type();
		if( $post_type != 'portfolio' ) {
			return '';
		} else {
			$client_name = get_post_meta( $post->ID, 'be_themes_portfolio_client_name', true );
			$project_date = get_post_meta( $post->ID, 'be_themes_portfolio_project_date', true );

			$cats = get_the_terms( $post->ID, 'portfolio_categories' );
			$portfolio_cats = array();
			foreach ( $cats as $value ) {
				array_push( $portfolio_cats, $value->name );
			}
			$portfolio_cats = implode( ', ', $portfolio_cats );

			$tags = get_the_terms( $post->ID, 'portfolio_tags' );
			$portfolio_tags = array();
			foreach ( $tags as $value ) {
				array_push( $portfolio_tags, $value->name );
			}
			$portfolio_tags = implode( ', ', $portfolio_tags );

			$visit_site_url = get_post_meta( $post->ID, 'be_themes_portfolio_visitsite_url', true );
			$button_text = get_post_meta( $post->ID, 'be_themes_portfolio_visitsite_link_text', true );

			if( empty( $button_text ) ) {
				$button_text = 'Visit Site';
			}

			$output .= '<ul class="project_details">';
			if( ! empty( $client_name ) ) {
				$output .= '<li class="client_name"><i class="font-icon icon-user"></i>'.$client_name.'</li>';
			}
			if( ! empty( $project_date ) ) {
				$output .= '<li class="project_date"><i class="font-icon icon-calendar"></i>'.$project_date.'</li>';
			}
			if( ! empty( $portfolio_cats ) ) {
				$output .= '<li class="project_cats"><i class="font-icon icon-folder"></i>'.$portfolio_cats.'</li>';
			}
			if( ! empty( $portfolio_tags ) ) {
				$output .= '<li class="project_cats"><i class="font-icon icon-tag"></i>'.$portfolio_tags.'</li>';
			}						
			$output .='</ul>';
			if(  ! empty( $visit_site_url ) ) {
				$output .= do_shortcode('[button button_text= "'.$button_text.'" type= "small" gradient= "1" rounded= "1" icon= "link" color= "#00bfd7" hover= "#00bfd7" url="'.$visit_site_url.'" ]');	
			}	
			return $output;
		}

	}


/**************************************
			CLIENTS
**************************************/

add_shortcode('clients','be_clients');

function be_clients($atts,$content){

	$output = '<div class="carousel-wrap clearfix">';
	$output .='<ul class="be-carousel client-carousel">';
	$output .=do_shortcode($content);
	$output .='</ul>';
	$output .='<a id="prev2" class="prev be-carousel-nav icon-left-open-big" href="#"></a><a id="next2" class="next be-carousel-nav icon-right-open-big" href="#"></a>';
	$output .='</div>';
	return $output;
}


add_shortcode( 'client', 'be_client' );
	function be_client( $atts, $content ) {
		extract( shortcode_atts( array(
			'image'=>'',
			'link' =>'',
			'new_tab'=> 'yes',
	    ), $atts ) );

	    $output =  '';
	    $attachment = wp_get_attachment_image_src( $image, 'full' );
	    $url = $attachment[0];
	    if( $url ) {
	    	$output .='<li><a href="'.$link.'"><img src="'.$url.'" alt="" /></a></li>';
	    }
	    return $output;
	}


/**************************************
			RECENT PROJECTS
**************************************/

add_shortcode( 'recent_projects', 'be_recent_projects' );
	function be_recent_projects( $atts, $content ) {

		extract( shortcode_atts( array(
			'number'=>'three',
	    ), $atts ) );
			
		if($number == 'three') {
			$posts_per_page = 3;
			$column = 'third';
		} else {
			$posts_per_page = 4;
			$column = 'fourth';
		}

		$args = array(
			'post_type' => 'portfolio',
			'posts_per_page'=> $posts_per_page,
			'orderby'=>'date',
			'ignore_sticky_posts'=>1,
		);
		$output = '';
		$my_query = new WP_Query( $args );
		if( $my_query->have_posts() ) {
			
			$output .= '<div class="clearfix related-items">';
			while ($my_query->have_posts()) : $my_query->the_post(); 
				$attachment_id = get_post_thumbnail_id( get_the_ID() );
				$attachment_thumb = wp_get_attachment_image_src( $attachment_id, 'portfolio-two' );
				$attachment_full = wp_get_attachment_image_src( $attachment_id, 'full' );
				$attachment_thumb_url = $attachment_thumb[0];
				$attachment_full_url = $attachment_full[0];
				$video_url = get_post_meta( $attachment_id, 'be_themes_featured_video_url', true );
				$mfp_class='mfp-image';
				if( ! empty( $video_url ) ){
					$attachment_full_url = $video_url;
					$mfp_class = 'mfp-iframe';
				}
				$output .= '<div class="one-'.$column.' column-block be-hoverlay">';
				$output .= '<div class="element-inner">';
				$output .= '<div class="thumb-wrap"><img src="'.$attachment_thumb_url.'" alt />';
				$output .= '<div class="thumb-overlay"><div class="thumb-bg">';
				$output .= '<div class="thumb-icons"><a href="'.get_permalink().'"><i class="font-icon icon-link"></i></a><a href="'.$attachment_full_url.'" class="image-popup-vertical-fit '.$mfp_class.'"><i class="font-icon icon-search"></i></a></div>';
				$output .= '</div></div>';//end thumb overlay & bg
				$output .= '</div>';//end thumb wrap

				$output .= '<div class="sec-bg portfolio-title"><h5 class="sec-title-color"><a href="'.get_permalink().'">'.get_the_title().'</a></h5></div>';
				$output .= '</div>';
				$output .= '</div>'; // end element inner
			endwhile;
			$output .= '</div>'; // end column block
		}
		wp_reset_query();
		return $output;
	}


/**************************************
			RECENT POSTS
**************************************/

add_shortcode( 'recent_posts', 'be_recent_posts' );
	function be_recent_posts( $atts, $content ) {

		extract( shortcode_atts( array(
			'number'=>'three',
	    ), $atts ) );
			
		if( $number == 'three' ) {
			$posts_per_page = 3;
			$column = 'third';
		} else {
			$posts_per_page = 4;
			$column = 'fourth';
		}

		$args=array(
			'post_type' => 'post',
			'posts_per_page'=> $posts_per_page,
			'orderby'=>'date',
			'ignore_sticky_posts'=>1,
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => array( 'post-format-quote' ),
					'operator' => 'NOT IN',
				)
			),
		);
		$output = '';
		$my_query = new WP_Query( $args  );
		if( $my_query->have_posts() ) {
			
			$output .= '<div class="clearfix related-items">';
			while ( $my_query->have_posts() ) : $my_query->the_post(); 
				 $output .= '<div class="one-'.$column.' column-block be-hoverlay">';
				 $output .= '<div class="element-inner">';
				global $blog_style; 
				$blog_style = '2'; 
				ob_start();
				get_template_part( 'content', get_post_format() );
				$post_format_content = ob_get_clean();
				$output .= $post_format_content;
				$output .= '</div>'; // end element inner
				$output .= '<header class="recent-post-header"><h5 class="recent-post-title">'.get_the_title().'</h5><nav class="recent-post-nav"><span class="secondary_text alt-color"><i class="icon-clock"></i>'.get_the_date( "F j, Y" ).' / </span><span class="secondary_text alt-color">'.get_comments_number('0','1','%').__(' comments','be-themes').'</span></nav></header>';
				$output .= '<article class="recent-posts-content">'.be_themes_get_excerpt( get_the_ID(), 20 ).'</article>';
				
				$output .= '</div>'; // end column block
			endwhile;
			$output .= '</div>';
		}
		wp_reset_query();
		return $output;
	}


/**************************************
			PRICING TABLE
**************************************/

add_shortcode( 'pricing_column', 'be_pricing_column' );
	function be_pricing_column( $atts, $content ) {
		global $be_themes_data;
		extract( shortcode_atts( array(
			'title'=>'',
			'h_tag'=>'h3',
			'price'=>'',
			'duration'=>'',
			'currency'=>'$',
			'button_text'=>'',
			'button_color'=>$be_themes_data['color_scheme'],
			'button_link'=>'',
			'highlight'=>'no',
			'style'=>'style-1',
	    ), $atts ) );

	    $output = '';

	    $output .= '<ul class="pricing-table highlight-'.$highlight.'">';
	    if( ! empty( $title ) ) {
	    	if( $style == 'style-1' ) {
	    		$output .='<li class="pricing-title"><'.$h_tag.'>'.$title.'</'.$h_tag.'></li>';
	    	} else {
	    		$output .='<li class="pricing-title alt-bg"><'.$h_tag.' class="alt-bg-text-color">'.$title.'</'.$h_tag.'></li>';
	    	}
	    }
	    if( ! empty( $duration ) ) {
	    	$duration = '/ '.$duration;
	    }
	    if( ! empty( $price ) ) {
	    	$output .='<li class="pricing-price sec-bg sec-color"><span class="currency">'.$currency.'</span><span class="price">'.$price.'</span><span class="pricing-duration">'.$duration.'</span></li>';
	    }	
	    $output .= do_shortcode( $content );

	    if( !empty( $button_text ) && !empty( $button_link ) ) {
	    	$output .= '<li class="pricing-button sec-bg sec-color">'.do_shortcode('[button button_text= "'.$button_text.'" type= "medium" gradient= "1" rounded= "1" icon= "" color= "'.$button_color.'" hover= "#00bfd7" url="'.$button_link.'" ]').'</li>';
	    }
	    $output .= '</ul>';

	    return $output;

	}

add_shortcode( 'pricing_feature', 'be_pricing_feature' );
function be_pricing_feature( $atts, $column ) {

	extract( shortcode_atts( array(
		'feature'=>'',
    ), $atts ) );

	$output = '';
	if( ! empty( $feature ) ) {
		$output .='<li class="pricing-feature">'.$feature.'</li>';
	}
	return $output;
}

add_shortcode( 'gmaps', 'be_gmaps' );
function be_gmaps( $atts, $content ) {

	extract( shortcode_atts( array(
		'address'=>'',
		'height'=>'300',
		'zoom'=>'20',
		'style'=>'MAP'
    ), $atts ) );

	$output = '';
	if( ! empty( $address ) ) {
		$output .= '<div class="gmap-wrapper" style="height:'.$height.'px;"><div class="gmap map_960" data-address="'.$address.'" data-zoom="'.$zoom.'"></div></div>';
	}

	return $output;
}

add_shortcode('lightbox_image','be_lightbox_image');
function be_lightbox_image( $atts, $content ){

	extract( shortcode_atts( array(
		'image'=>'',
		'link'=>'',
    ), $atts ) );

	$output = '';
	$full = wp_get_attachment_image_src( $image, 'full' );
	$attachment_thumb_url = $full[0];
	$attachment_full_url = $full[0];
	$video_url = get_post_meta( $image, 'be_themes_featured_video_url', true );
	$mfp_class='mfp-image';
	if( ! empty( $video_url ) ) {
		$attachment_full_url = $video_url;
		$mfp_class = 'mfp-iframe';
	}	
	$output .= '<div class="element-inner">';
	$output .='<div class="thumb-wrap"><img src="'.$attachment_thumb_url.'" alt />';
					$output .='<div class="thumb-overlay"><div class="thumb-bg">';
					$output .='<div class="thumb-icons">';
					if( ! empty( $link ) ){
						$output .='<a href="'.$link.'"><i class="font-icon icon-link"></i></a>';
					}
					$output .='<a href="'.$attachment_full_url.'" class="image-popup-vertical-fit '.$mfp_class.'"><i class="font-icon icon-search"></i></a>';
					$output .= '</div>'; // end thumb icons								
					$output .='</div></div>';//end thumb overlay & bg
					$output .='</div>';//end thumb wrap
					$output .='</div>';

	return $output;				
}

?>