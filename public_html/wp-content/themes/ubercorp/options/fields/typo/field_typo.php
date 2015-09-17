<?php
	require_once(NHP_OPTIONS_DIR.'fields/color/field_color.php');
	require_once(NHP_OPTIONS_DIR.'fields/select/field_select.php');	// Include Select
	require_once(NHP_OPTIONS_DIR.'fields/hidden/field_hidden.php');

class NHP_Options_typo extends NHP_Options{	
	
	
	function __construct($field = array(), $value ='', $parent){
		
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
		$this->parent = $parent;
		$this->google_fonts = $parent->google_font;

	}// Constructor function
	
	
	function render(){
		
		$values = $this->typo_values('value'); //Get The Value of Element's Value from function typo_values
		$label = $this->typo_values('fontoptions'); //Get The Value of Element's Value from function typo_values
		$class = (isset($this->field['class']))?$this->field['class']:'regular-text';
		
		echo '<div class="typo" >';
			
			$hidden_array = array(  'class' => "hidden-id" , 'id' => 'hidden-id' );
			$hidden_field1 = new NHP_Options_hidden( $hidden_array , $this->field['id'] , $this->parent);	  // Field ID
			$hidden_field1->render();

			$hidden_array1 = array(  'class' => "hidden-url" , 'id' => 'hidden-url' );
			$hidden_field2 = new NHP_Options_hidden( $hidden_array1 , NHP_OPTIONS_URL.'fields/typo/preview.php' , $this->parent);	// Url
			$hidden_field2->render();

			if(isset($this->field['group'])){
				
				$hidden_array2 = array(  'class' => "heading-group" , 'id' => 'heading-group' );
				$hidden_field3 = new NHP_Options_hidden( $hidden_array2 , $this->field['group'] , $this->parent);	// Show Apply All Heading Button
				$hidden_field3->render();
			}


			// Set Initial values
			if(!isset($this->value['color']))
				$this->value['color'] = '#000000'; 

			if(!empty($this->value['family'])){ // Update the options the font family of typography
				$fonts = get_option('be_themes_selected_fonts');
				if(empty($fonts)){
					$fonts[0] = $this->value['family'] ;
				}
				elseif (!in_array($this->value['family'], $fonts)) {
				    array_push($fonts,$this->value['family'] );
				}
				update_option('be_themes_selected_fonts',$fonts); 
			}

			//Show Font Family 
			$select_array = array( 'options' => $this->google_fonts , 'id' => $this->field['id'].'][family' , 'label' => 'Font Family' );
			$select_field = new NHP_Options_select( $select_array , $this->value['family'] , $this->parent);	 // Call Chk Box
			$select_field->render();
			
		

			$keys = array_slice(array_keys($values) , 1 , 7);
			// Show Select boxes
			$i=0;
			foreach($keys as $key){
				$this->field['options'][$key] = $values[$key];
				$select_array = array( 'options' => $this->field['options'][$key] , 'id' => $this->field['id'].']['.$key , 'label' => $label[$i] );
				$select_field = new NHP_Options_select( $select_array , $this->value[$key] , $this->parent);	 // Call Chk Box
				$select_field->render();
				$i++;
			}
			// Show Color Picker
			$color_picker = new NHP_Options_color(array('id'=> $this->field['id'].'][color' , 'label' => 'Font Color'),$this->value['color'], $this->parent);	 // Call Color Box
			$color_picker->enqueue();
			$color_picker->render();
			// Show Group apply button if required
			if( isset( $this->field['group_head'] ) && $this->field['group_head'] == $this->field['group'] ){
				echo '<input type="button" name="" class="preset-heading button-primary" value="Apply to all Headings" id="'.$this->field['group'].'" />';
			}
		
			echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.$this->field['desc'].'</span>':'';	

		echo '</div>'; // Field Type Wrapper
		
	}//function

	
	function typo_values($options){
		$values = array(); $bgoptions = array();
		$values['family'] = array('Arial' => 'Arial' , 'Arial Black' => 'Arial Black' , 'Times New Roman' => 'Times New Roman' , 'Comic Sans MS' => 'Comic Sans MS' , 'Courier New' => 'Courier New' , 'Georgia' => 'Georgia' , 'Impact' => 'Impact' , 'Lucida Console' => 'Lucida Console' , 'Lucida Sans Unicode' => 'Lucida Sans Unicode' , 'Palatino Linotype' => 'Palatino Linotype' , 'Tahoma' => 'Tahoma' , 'Trebuchet MS' => 'Trebuchet MS' , 'Verdana' => 'Verdana' , 'MS Sans Serif' => 'MS Sans Serif' , 'MS Serif' => 'MS Serif', 'NovecentowideBookBold' => 'NovecentowideBookBold' , 'NovecentowideUltraLightBold' => 'NovecentowideUltraLightBold');
		for($i=6;$i<=100;$i++){
			$values['size'][$i.'px'] = $i;
			$values['line_height'][$i.'px'] = $i;
		}
		$values['style'] = array('normal' => 'Normal' , 'italic' => 'Italic' , 'oblique' => 'Oblique');
		$values['weight'] = array('normal' => 'Normal' , 'bold' => 'Bold' , 'bolder' => 'Bolder' , 'lighter' => 'Lighter' , '100' => '100' , '200' => '200' , '500' => '500' , '600' => '600' , '900' => '900');
		$values['transform'] = array('none' => 'None' , 'capitalize' => 'Capitalize' , 'uppercase' => 'Uppercase' , 'lowercase' => 'Lowercase');
		$fontoptions = array('Font Size' , 'Line Height' , 'Font Style' ,'Font Weight','Text Transform');
		switch ($options) {
			case 'value':
				return $values;
				break;
			
			default:
				return $fontoptions;
				break;
		}
	}

	
	function enqueue(){
		
		wp_register_script( 'nhp-opts-field-typo-js',
			NHP_OPTIONS_URL.'fields/typo/field_typo.js', 
			array('jquery','jquery-ui-slider','jquery-ui-core','farbtastic'), time(),
			true );
		wp_enqueue_script('nhp-opts-field-typo-js');
		wp_register_style( 'typo-style', NHP_OPTIONS_URL.'fields/typo/field_typo.css', array(), time(), 'all' );  
		wp_enqueue_style('typo-style');
	}//function

}//class
?>