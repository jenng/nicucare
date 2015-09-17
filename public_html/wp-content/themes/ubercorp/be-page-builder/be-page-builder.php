<?php

// windows-proof constants: replace backward by forward slashes - thanks to: https://github.com/peterbouwmeester
$fslashed_dir = trailingslashit(str_replace('\\','/',dirname(__FILE__)));
$fslashed_abs = trailingslashit(str_replace('\\','/',ABSPATH));

if(!defined('BE_PAGE_BUILDER_DIR')){
	define('BE_PAGE_BUILDER_DIR', $fslashed_dir);
}

if(!defined('BE_PAGE_BUILDER_URL')){
	define('BE_PAGE_BUILDER_URL', site_url(str_replace( $fslashed_abs, '', $fslashed_dir )));
} 

require_once(BE_PAGE_BUILDER_DIR.'be-pb-options.php');
require_once(BE_PAGE_BUILDER_DIR.'be-pb-backend-output.php');

global $row_controls;
global $section_controls;
global $blank_row;
global $blank_section;

				
$row_controls = '<div class="be-pb-row-controls clearfix">
					<div class="left">
					      <a class="med-btn mini-btn-light" title="Minus" role="button" data-col-name="one_col" data-col-count="1">
						      <span class="btn-icon-one-col">Full</span>
  						  </a>
  						  <a class="med-btn mini-btn-light" title="Minus" role="button" data-col-name="one_half" data-col-count="2">
					      	<span class="btn-icon-one-half">One Half</span>
					      </a>
  						  <a class="med-btn mini-btn-light" title="Minus" role="button" data-col-name="one_third" data-col-count="3">
					      	<span class="btn-icon-one-third">One Third</span>
					      </a>
  						  <a class="med-btn mini-btn-light" title="Minus" role="button" data-col-name="one_fourth" data-col-count="4">
					      	<span class="btn-icon-one-fourth">One Fourth</span>
					      </a>
  						  <a class="med-btn mini-btn-light" title="Minus" role="button" data-col-name="two_third" data-col-count="2">
					      	<span class="btn-icon-two-third">Two third</span>
					      </a>
  						  <a class="med-btn mini-btn-light" title="Minus" role="button" data-col-name="three_fourth" data-col-count="2">
					      	<span class="btn-icon-three-fourth">Three Fourth</span>
					      </a>
					 </div>
					 <div class="right">
					      <a class="med-btn mini-btn-light" title="Minus" data-action="duplicate">
						      <span class="btn-icon-row-duplicate">Duplicate Row</span>
  						  </a>
  						  <a class="med-btn mini-btn-light edit-shortcode" title="Minus" data-action="edit"  data-shortcode="row">
					      	<span class="btn-icon-row-edit">Edit Row</span>
					      </a>   						  
  						  <a class="med-btn mini-btn-light" title="Minus" data-action="delete">
					      	<span class="btn-icon-row-delete">Delete Row</span>
					      </a>						 		
					 </div>   
				</div>';

$section_controls = '<div class="be-pb-section-controls clearfix">
						<a href="#" class="bluefoose-button-dark be-pb-add-row">Add Row</a>
						<div class="right">
					      <a class="med-btn mini-btn-light" title="Minus" data-action="duplicate">
						      <span class="btn-icon-section-duplicate">Duplicate Row</span>
  						  </a>
  						  <a class="med-btn mini-btn-light edit-shortcode" data-action="edit"  data-shortcode="section">
					      	<span class="btn-icon-section-edit">Edit Section</span>
					      </a>      						  
  						  <a class="med-btn mini-btn-light" title="Minus" data-action="delete">
					      	<span class="btn-icon-section-delete">Delete Row</span>
					      </a>
					 	</div>						 								 	
					</div>';

$blank_row = '<div class="be-pb-row-wrap be-pb-element clearfix">
	    				'.$row_controls.'
						<div class="be-pb-row be-pb-sortable clearfix">
							<div class="be-pb-col-wrap one_col" data-col-name="one_col">
								<div class="be-pb-column be-pb-shortcode-col"></div>
								<div class="be-pb-controls"><a class="mini-btn mini-btn-dark choose-shortcode" title="Add" role="button"><span class="btn-icon-plus">Add</span></a></div>
							</div>	
						</div>
						<pre class="shortcode">[row]</pre>						
				</div>';

$blank_section = '<div class="be-pb-section-wrap be-pb-element clearfix">
								'.$section_controls.'
								<div class="be-pb-section">
									'.$blank_row.'
								</div>
							 	<pre class="shortcode">[section padding_top="50" padding_bottom="50"]</pre>	
						</div>';													

function get_shortcode_form() {

	global $be_shortcode;
	extract($_POST);

	if(!array_key_exists('options', $be_shortcode[$shortcode]) && empty($be_shortcode[$shortcode]['options']))
		get_shortcode_block($shortcode, $be_shortcode[$shortcode]['type']);
	else 
		be_pb_print_form($shortcode);

	die();
}

function get_multi_shortcode_block($shortcode_name, $output = '', $inner_shortcode =''){
	global $be_shortcode;
	$hide = '';
	if(!array_key_exists('options', $be_shortcode[$shortcode_name]) && empty($be_shortcode[$shortcode_name]['options'])) {
		$hide = 'hidden';
	}
	$html = '';
	$html .= '<div class="be-pb-multi-wrap be-pb-element" data-shortcode="'.$shortcode_name.'">';
	$html .= '<pre class="shortcode">'.$output.'</pre>';
	$html .= '<h4>'.$be_shortcode[$shortcode_name]['name'].'<span class="be-pb-control-icon icon-cancel-circled icon-delete" title="Delete"></span><span class="be-pb-control-icon icon-pencil edit-shortcode '.$hide.'" title="Edit" data-shortcode="'.$shortcode_name.'" data-action="edit"></span><span class="be-pb-control-icon icon-book icon-duplicate" title="Duplicate"></span></h4>';
	$html .= '<div class="be-pb-multi-fields be-pb-shortcode-col be-pb-sortable">';
	if(!empty($inner_shortcode)){
		$html .= $inner_shortcode;
	}
	$html .= '</div>';
	$html .= '<div class="be-pb-controls"><a class="mini-btn mini-btn-dark add-multi-field" title="Add" role="button" data-single-field='.$be_shortcode[$shortcode_name]['single_field'].'><span class="btn-icon-plus">Add</span></a>';
	$html .= '</div>';
	return $html;
}

function get_single_shortcode_block($shortcode_name, $output = ''){
	global $be_shortcode;
	$hide = '';
	if(!array_key_exists('options', $be_shortcode[$shortcode_name]) && empty($be_shortcode[$shortcode_name]['options'])) {
		$hide = 'hidden';	
	}
	$html ='';
	$html .='<div class="portlet be-pb-element">';
	$html .= '<div class="portlet-header"><span class="be-pb-control-icon icon-cancel-circled icon-delete" title="Delete"></span><span class="be-pb-control-icon icon-pencil edit-shortcode '.$hide.'" title="Edit" data-shortcode="'.$shortcode_name.'" data-action="edit"></span><span class="be-pb-control-icon icon-book icon-duplicate" title="Duplicate"></span>'.$be_shortcode[$shortcode_name]['name'].'</div>';
	if(isset($be_shortcode[$shortcode_name]['backend_output']) && $be_shortcode[$shortcode_name]['backend_output'] === true) {
		$html .='<div class="portlet-content clearfix">'.be_pb_output($output, $shortcode_name).'</div>';
	}
	$html .= '<pre class="shortcode">'.$output.'</pre>';
	$html .= '</div>';
	return $html;
}

function get_shortcode_block($shortcode = '',$shortcode_type = '') {
	global $be_shortcode;
	$shortcode_action = '';
	extract($_POST);
	$output = '';
	$has_content = false;
	if(!empty($shortcode_name)) 
		$shortcode = $shortcode_name;

	if(array_key_exists('options', $be_shortcode[$shortcode])){
		foreach ($be_shortcode[$shortcode]['options'] as $att => $value) {
			if(array_key_exists('content', $value)){
				if($value['content'] == true){
					$has_content = true;
					$content_att = $att;
					break;
				}
			}
			else{
				$has_content = false;
			}
		 }
	}
	

	if(!empty($be_shortcode_atts)){
		 $output .='['.$shortcode;
		 if($has_content == true){
		 	foreach ($be_shortcode_atts as $att => $value) {
		 		if($att != $content_att){
		 			if(is_array($value)){
		 				$value = implode(',', $value);
		 			}
		 			$output .=' '.$att.'= "'.$value.'"';
		 		}
		 	}
		 	$output .=' ]'.shortcode_unautop(stripslashes_deep($be_shortcode_atts[$content_att])).'[/'.$shortcode.']';	
		}
		 else{
		 	foreach ($be_shortcode_atts as $att => $value) {
	 			if(is_array($value)){
	 				$value = implode(',', $value);
	 			}
	 			$output .=' '.$att.'= "'.$value.'"';
		 	}
		 	$output .=']';
		}
	}
	else
		$output .='['.$shortcode.']';

	

	 if($shortcode == 'section' || $shortcode == 'row' || ( $shortcode_action == 'edit' && $be_shortcode[$shortcode]['type']=='multi' )){
	 	echo $output;
	 }
	 else {
	 	if($shortcode_type == 'multi'){
			echo get_multi_shortcode_block($shortcode, $output);
	 	}
	 	else{
			echo get_single_shortcode_block($shortcode, $output);
		} 
	}
	
	die();
}

function edit_shortcode_form(){
	
	global $be_shortcode;


	$post = stripslashes_deep($_POST);

	$shortcode = $post['shortcode'];

	$pattern = get_shortcode_regex();
	
	preg_match("/$pattern/s", $shortcode, $parsed_value );

	

	if (preg_last_error() == PREG_BACKTRACK_LIMIT_ERROR) {
    	print 'Backtrack limit was exhausted!';
	}


	$shortcode_name = $post['shortcode_name'];

		//if(isset($parsed_value[3]))
			$atts = shortcode_parse_atts($parsed_value[3]);

		if(!empty($parsed_value[5])){
			$content = $parsed_value[5];	
		}
		else{
			$content='';
		}

		be_pb_print_form($shortcode_name, 'edit', $atts, $content);	

	die();	

}

function be_pb_add_field(){
	extract($_POST);

	be_pb_print_form($single_field);

	die();	
}


function be_pb_print_form($shortcode_name,$action='generate', $atts = array(), $content='') {
	global $be_shortcode;

	$chosen_shortcode = $be_shortcode[$shortcode_name];
	echo '<h2>'.$chosen_shortcode['name'].'</h2>';
	echo '<form data-shortcode-name="'.$shortcode_name.'" data-shortcode-type="'.$chosen_shortcode['type'].'">';

	foreach ($chosen_shortcode['options'] as $option_key => $option) {
		$default = isset( $option['default'] ) ? $option['default'] : '';
		if($action == 'edit'){
			if(is_array($atts) && array_key_exists($option_key, $atts)){
				$att_value = $atts[$option_key];
			}
			else{
				$att_value='';
			}
		}
		else {
			$att_value = $default;
			$content = $default;
		}
		
		echo '<fieldset class="clearfix">';
				if ($option['type'] == 'text' || $option['type'] == 'select')
			$label_class = "padding-top-5";
		else
			$label_class = "padding-top-0";
			echo '<div class="left-section '.$label_class.'"><label for="be_shortcode_atts['.$option_key.']" class="be-pb-label">'.$option['title'].'</label></div>';
		switch ($option['type']) {
				case 'text':
					echo '<div class="right-section"><input type="text" name="be_shortcode_atts['.$option_key.']" id="#'.$option_key.'" value="'.$att_value.'" class="be-shortcode-atts be-pb-text" /></div>';
					break;
				case 'select':		
					echo
					'<div class="right-section"><select name="be_shortcode_atts['.$option_key.']" id="#'.$option_key. '" class="be-shortcode-atts be-pb-select">';
					if(empty($att_value) || $att_value == 'none'){
						echo '<option value="none" disabled="disabled">'.esc_html__('Select', 'be-themes').'</option>';
					}
					
					foreach ($option['options'] as $value) {
						echo '<option value="'.$value.'" '.selected( $value, $att_value, false ).'>'.esc_html($value).'</option>';
					}
					echo '</select></div>';
					break;
				case 'tinymce':
					$content = wpautop($content);
					wp_editor($content, $option_key, array('textarea_name'=> 'be_shortcode_atts['.$option_key.']','editor_class'=>'be-shortcode-atts be-pb-editor', 'quicktags'=>false, 'wpautop'=>false ,'textarea_rows'=>20));
					
					break;
				case 'checkbox':
					echo '<input type="checkbox" name="be_shortcode_atts['.$option_key.']" value="1" class="be-shortcode-atts be-pb-checkbox" '.checked($att_value,'1',false).' />';
					break;	
				case 'multi_check':
					if(empty($att_value)){
						$att_value = array();
					}
					else {
						if(!is_array($att_value)){
							$att_value = explode(',', $att_value);
						}
					}
					echo '<div class="right-section">';
					foreach ($option['options'] as $value) {
						
						$checkbox_option = '<div class="margin-bottom-5"><input type="checkbox" name="be_shortcode_atts['.$option_key.'][]" value="'.$value.'" class="be-shortcode-atts be-pb-checkbox" ';
						if(in_array($value, $att_value)){
							$checkbox_option .= 'checked="checked" />';	
						}
						else{
							$checkbox_option .='/>';
						}
						echo $checkbox_option;
						echo '<label for="'.$value.'">'.$value.'</label></div>';
					}
					echo '</div>';
					break;
				case 'radio':
					echo '<div class="right-section">';
					foreach ($option['options'] as $value) {
						echo '<div class="margin-bottom-5"><input type="radio" name="be_shortcode_atts['.$option_key.'][]" value="'.$value.'" class="be-shortcode-atts be-pb-radio" '.checked($value,$att_value,false).' />';
						echo '<label for="'.$value.'">'.$value.'</label></div>';
					}
					break;
				case 'media':
					if(empty($att_value)){
						$att_value = array();
					}
					else {
						if(!is_array($att_value)){
							$att_value = explode(',', $att_value);
						}
					}									
					echo '<div class="right-section"><a href="#" class="button-secondary btn_browse_files '.$option['select'].'">Browse Files</a>
						<div class="browsed-images-container clearfix be-pb-sortable" data-name="be_shortcode_atts['.$option_key.']">';
						foreach ($att_value as $attachment_id) {
							echo '<div class="seleced-images-wrap">
								<input type="hidden" name="be_shortcode_atts['.$option_key.'][]" value="'.$attachment_id.'">
								<img src="'.wp_get_attachment_url( $attachment_id ).'">
								<span class="remove"></span>
								</div>';
						}
					echo '</div></div>';
					break;
				case 'color':
					echo '<div class="right-section"><input type="text" name="be_shortcode_atts['.$option_key.']" id="#'.$option_key.'" value="'.$att_value.'" class="be-pb-color-field be-shortcode-atts" /></div>';
					break;
				case 'taxo':
					if(empty($att_value)){
						$att_value = array();
					}
					else {
						if(!is_array($att_value)){
							$att_value = explode(',', $att_value);
						}
					}
					echo '<div class="right-section">';
					$taxonomy = get_terms($option['taxonomy']);
					foreach ($taxonomy as $term) {
						
						$checkbox_option = '<div class="margin-bottom-5"><input type="checkbox" name="be_shortcode_atts['.$option_key.'][]" value="'.$term->slug.'" class="be-shortcode-atts be-pb-checkbox" ';
						if(in_array($term->slug, $att_value)){
							$checkbox_option .= 'checked="checked" />';	
						}
						else{
							$checkbox_option .='/>';
						}
						echo $checkbox_option;
						echo '<label for="'.$term->name.'">'.$term->name.'</label></div>';
					}
					echo '</div>';
					break;
				case 'page':
					$pages = get_pages(array('post_type'=>'page'));	
					echo '<div class="right-section"><select name="be_shortcode_atts['.$option_key.']" id="#'.$option_key. '" class="be-shortcode-atts be-pb-select">';
					

					if(empty($att_value) || $att_value == 'none'){
						echo '<option value="none" disabled="disabled">'.esc_html__('Select', 'be-themes').'</option>';
					}
					
					foreach ($pages as $page) {
						echo '<option value="'.$page->ID.'" '.selected( $page->ID, $att_value, false ).'>'.esc_html($page->post_title).'</option>';
					}
						
					echo '</select></div>';
					break;																
			}
		echo "</fieldset>";		
	}
	echo '<input type="submit" class="bluefoose-button-light add-shortcode" data-action="'.$action.'" />
	</form>';
}

/**************************************
			Add Section
**************************************/

function be_pb_add_section(){
	global $blank_section;
	echo $blank_section;
}


/**************************************
			Add Row
**************************************/

function be_pb_add_row(){
	global $blank_row;
	echo $blank_row;
}


/**************************************
			Save Page Builder
**************************************/

add_action( 'wp_ajax_save_be_pb_builder', 'save_be_pb_builder' );
add_action( 'wp_ajax_save_be_pb_builder', 'save_be_pb_builder' );

function save_be_pb_builder(){
	extract($_POST);

	if (!wp_verify_nonce($nonce, 'be_pb_save_nonce')) {
    	exit();	
    }	

  //   if(get_post_meta($post_id,'_be_pb_html',true)) {
  //   	$return['html'] = update_post_meta($post_id,'_be_pb_html',$html);
  //   } else {
  //   	$return['html'] = add_post_meta($post_id,'_be_pb_html',$html,true);
 	// }

    if(get_post_meta($post_id,'_be_pb_content',true)) { 
		$return['output'] = update_post_meta($post_id,'_be_pb_content',$content);
	} else {
		$return['output'] = add_post_meta($post_id,'_be_pb_content',$content,true);
	}

    if(get_post_meta($post_id,'_be_pb_disable',true)) { 
		$return['disabled'] = update_post_meta($post_id,'_be_pb_disable',$disable_pb);
	} else {
		$return['disabled'] = add_post_meta($post_id,'_be_pb_disable',$disable_pb,true);
	}		

	if($return['output'] > 0 || $return['disabled'] > 0 ) {
		echo "success";
	} else { 
		echo "no_changes";
	}
	
	die();
}



add_action( 'wp_ajax_nopriv_edit_shortcode_form', 'edit_shortcode_form' );
add_action( 'wp_ajax_edit_shortcode_form', 'edit_shortcode_form' );

add_action( 'wp_ajax_nopriv_get_shortcode_form', 'get_shortcode_form' );
add_action( 'wp_ajax_get_shortcode_form', 'get_shortcode_form' );

add_action( 'wp_ajax_nopriv_get_shortcode_block', 'get_shortcode_block' );
add_action( 'wp_ajax_get_shortcode_block', 'get_shortcode_block' );

add_action( 'wp_ajax_nopriv_be_pb_add_field', 'be_pb_add_field' );
add_action( 'wp_ajax_be_pb_add_field', 'be_pb_add_field' );

add_action( 'wp_ajax_nopriv_be_pb_add_section', 'be_pb_add_section' );
add_action( 'wp_ajax_be_pb_add_section', 'be_pb_add_section' );

add_action( 'wp_ajax_nopriv_be_pb_add_row', 'be_pb_add_row' );
add_action( 'wp_ajax_be_pb_add_row', 'be_pb_add_row' );


function be_pb_output($output, $shortcode_name){

	global $be_shortcode;

	global $shortcode_tags;

	if (empty($shortcode_tags) || !is_array($shortcode_tags)) {
		return $output;
	}

	$pattern = get_shortcode_regex();

	if(isset($be_shortcode[$shortcode_name]['backend_output']) && $be_shortcode[$shortcode_name]['backend_output'] === true) {
		return preg_replace_callback( "/$pattern/s", 'be_pb_'.$shortcode_name.'_output', $output );
	}

}



/**************************************
		Setup Page Builder 
**************************************/

add_action( 'init', 'be_page_builder_init' );

function be_page_builder_init() {

	add_action( 'admin_enqueue_scripts', 'be_page_builder_enqueue');
	function be_page_builder_enqueue() {

		wp_enqueue_media();
		wp_enqueue_script( 'custom-header' );

		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_script( 'wp-color-picker' );

		wp_enqueue_script('jquery-uniform-js', BE_PAGE_BUILDER_URL.'/js/jquery.uniform.min.js');

		wp_enqueue_script('be-page-builder-js', BE_PAGE_BUILDER_URL.'/js/script.js', array('jquery','jquery-ui-core','jquery-ui-sortable','jquery-ui-draggable','jquery-ui-droppable','jquery-ui-dialog','wp-color-picker','jquery-uniform-js'));

		wp_register_style('be-page-builder', BE_PAGE_BUILDER_URL.'/css/style.css');
		wp_enqueue_style('be-page-builder',array( 'jquery-ui-core', 'jquery-ui-theme' ), '1.8.17');

		//wp_enqueue_style('be-pb-backend-output',BE_PAGE_BUILDER_URL.'/css/be-pb-backend-output.css' );

		wp_enqueue_style('be-pb-backend-output',get_template_directory_uri().'/css/shortcodes.css' );

		wp_enqueue_style('be-fontello',get_template_directory_uri().'/fonts/fontello/fontello.css' );
		//wp_enqueue_style('be-fontello');
	} 

	add_action( 'add_meta_boxes', 'be_page_builder_add_custom_box' ); 
	function be_page_builder_add_custom_box(){

	    $screens = array( 'page', 'portfolio', 'post' );
	    foreach ($screens as $screen) {
	        add_meta_box(
	            'be-page-builder',
	            __( 'Page Builder', 'be-themes' ),
	            'be_page_builder_custom_box',
	            $screen,
	            'normal',
	            'high'
	        );
	    }

	}

	function be_page_builder_custom_box() {
			global $be_shortcode;
			global $blank_section;
			wp_nonce_field('be_pb_save_nonce', 'be_pb_save_nonce');

		?>
		<input type="hidden" id="ajax_url" value="<?php echo home_url(); ?>/wp-admin/admin-ajax.php" />
		<div id="be-pb-disable">
			<?php $be_pb_disabled = get_post_meta(get_the_ID(),'_be_pb_disable',true); ?>
			<input type="checkbox" id="be-pb-disable-check"  name="be_pb_disable" value="yes" class="be-pb-checkbox" <?php echo checked($be_pb_disabled,'yes',false); ?> /><label for="be-pb-disable-check" class="be-pb-label">Disable Page Builder </label>
		</div>
		<div id="be-page-builder-controls"> <a href="#" class="bluefoose-button-dark" id="be-pb-add-section">Add Section</a></div>
		<h2><?php _e('Add Rows, organize content into column blocks and style the page using a myraid collection of shortcodes','be-themes') ?></h2>
		<div id="shortcodes" title="Choose a Shortcode Module" style="display:none;">
  			<?php
  				foreach ($be_shortcode as $shortcode_key => $shortcode) {
  					if(array_key_exists('options', $shortcode) && !empty($shortcode['options'])) {
  						$shortcode_options = 'yes';
  					} else {
  						$shortcode_options = 'no';
  					}
  					if($shortcode['type'] != 'multi_single' && $shortcode_key != 'section' && $shortcode_key != 'row') {
	  					echo '<div class="bluefoose-ui-button-light be-pb-choose-shortcode">
						          <button class="be-icon-'.$shortcode['name'].' insert-shortcode bluefoose-button-light" data-shortcode="'.$shortcode_key.'" data-action="insert" data-shortcode-type="'.$shortcode['type'].'" data-shortcode-options="'.$shortcode_options.'" />
						          	'.$shortcode['name'].'
						          </button>
						        </div>';
				    }
  				}
  			?>
  			<div class="separator"></div>
			<div id="shortcode-form"></div>
		</div>

		<div id="edit-shortcode" title="Edit Shortcode Module"></div>	
		
		<!--   Confirm Dialog  -->
		<div id="dialog-confirm" title="Empty the recycle bin?">
			<p>
				<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
				These items will be permanently deleted and cannot be recovered. Are you sure?
			</p>
		</div>

		<div id="be-pb-main" class="be-pb-sortable">
			<?php 
				global $post_id;

				$content = get_post_meta($post_id,'_be_pb_content',true);
				
				if(!empty($content)){

				 	echo be_pb_do_shortcode($content);
				}
				else{
					echo $blank_section;
				}
			?>

		</div>


		
		<div id="be-pb-save-wrap"><a href="#" class="bluefoose-button-dark" id="be-pb-save">Save</a><span id="be-pb-loader"></div>

		<?php	
		
	} 

}

function be_pb_do_shortcode($content){
	global $shortcode_tags;

	if (empty($shortcode_tags) || !is_array($shortcode_tags))
		return $content;

	$pattern = get_shortcode_regex();

	return preg_replace_callback( "/$pattern/s", 'be_pb_do_shortcode_tag', $content );
}

function be_pb_do_shortcode_tag($m){

	global $be_shortcode;
	global $row_controls;
	global $section_controls; 

	// allow [[foo]] syntax for escaping a tag
	if ( $m[1] == '[' && $m[6] == ']' ) {
		return substr($m[0], 1, -1);
	}

	if($m[2] == 'section'){
		return '<div class="be-pb-section-wrap be-pb-element clearfix">
					'.$section_controls.'
					<div class="be-pb-section">'.be_pb_do_shortcode($m[5]).'</div>
				    <pre class="shortcode">['.$m[2].$m[3].']</pre>						
				</div>';
	}

	elseif($m[2] == 'row'){
    return '<div class="be-pb-row-wrap be-pb-element clearfix">
    				'.$row_controls.'
					<div class="be-pb-row be-pb-sortable clearfix">'.be_pb_do_shortcode($m[5]).'
					</div>
				 	<pre class="shortcode">['.$m[2].$m[3].']</pre>	
			</div>';		
	}

	elseif($m[2] == 'one_col' || $m[2] == 'one_half' || $m[2] == 'one_third' || $m[2] == 'one_fourth' || $m[2] == 'two_third' || $m[2] == 'three_fourth'){
		return	'<div class="be-pb-col-wrap '.$m[2].'" data-col-name="'.$m[2].'">
			<div class="be-pb-column be-pb-shortcode-col">'.be_pb_do_shortcode($m[5]).'</div>
			<div class="be-pb-controls"><a class="mini-btn mini-btn-dark choose-shortcode" title="Add" role="button"><span class="btn-icon-plus">Add</span></a></div>
		</div>';
	}

	elseif(array_key_exists($m[2], $be_shortcode) && $be_shortcode[$m[2]]['type']== 'multi') {

		$hide = '';
		if(!array_key_exists('options', $be_shortcode[$m[2]]) && empty($be_shortcode[$m[2]]['options'])) {
			$hide = 'hidden';	
		}

		return 	 '<div class="be-pb-multi-wrap be-pb-element" data-shortcode="'.$m[2].'">
				<pre class="shortcode">['.$m[2].$m[3].']</pre>
				<h4>'.$be_shortcode[$m[2]]['name'].'<span class="be-pb-control-icon icon-cancel-circled icon-delete" title="Delete"></span><span class="be-pb-control-icon icon-pencil edit-shortcode '.$hide.'" title="Edit" data-shortcode="'.$m[2].'" data-action="edit"></span><span class="be-pb-control-icon icon-book icon-duplicate" title="Duplicate"></span></h4>
		 <div class="be-pb-multi-fields be-pb-shortcode-col be-pb-sortable">'.be_pb_do_shortcode($m[5]).'
		 </div>
		 <div class="be-pb-controls"><a class="mini-btn mini-btn-dark add-multi-field" title="Add" role="button" data-single-field='.$be_shortcode[$m[2]]['single_field'].'><span class="btn-icon-plus">Add</span></a>
		 </div></div>';
	}	

	else  {
		return get_single_shortcode_block($m[2],$m[0]);
	}

}

add_filter( 'the_content', 'be_pb_content_filter' );

function be_pb_content_filter($content){
	global $post;
	$be_pb_disabled = get_post_meta( $post->ID, '_be_pb_disable', true );
    if( !isset($be_pb_disabled) || false == $be_pb_disabled || $be_pb_disabled == 'no' ) {
		$be_pb_content = get_post_meta($post->ID,'_be_pb_content',true);
		$content = $be_pb_content;
	}
	return $content;
}


?>