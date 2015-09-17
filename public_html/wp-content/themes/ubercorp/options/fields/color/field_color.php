<?php
class NHP_Options_color extends NHP_Options{	
	
	/**
	 * Field Constructor.
	 *
	 * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
	 *
	 * @since NHP_Options 1.0
	*/
	function __construct($field = array(), $value ='', $parent){
		
		parent::__construct($parent->sections, $parent->args, $parent->extra_tabs);
		$this->field = $field;
		$this->value = $value;
		//$this->render();

	}//function
	
	
	
	/**
	 * Field Render Function.
	 *
	 * Takes the vars and outputs the HTML for the field in the settings
	 *
	 * @since NHP_Options 1.0
	*/
	function render(){
		
		$class = (isset($this->field['class']))?$this->field['class']:'';
		$field_id = preg_replace('#[^\w()/.%\-&]#',"", $this->field['id']);
		if(!isset($this->field['std']) || empty($this->field['std'])){ $this->field['std'] = '#ffffff'; }
		if(!isset($this->value) || empty($this->value) ){ $this->value = $this->field['std']; }
		echo '<div class="farb-popup-wrapper">';
			if(isset($this->field['label'])){ echo '<label class="color-label">'. $this->field['label'].'</label>'; }
			echo '<div class="clearfix">';
			echo '<input type="text" id="'.$field_id.'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" value="'.$this->value.'" class="'.$class.' popup-colorpicker" style="width:70px;"/>';
			echo '<div class="farb-popup"><div class="farb-popup-inside"><div id="'.$field_id.'picker" class="color-picker"></div></div></div>';
			echo '<div class="color-display"></div>';	
			echo '</div>';
		echo '</div>';
		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.$this->field['desc'].'</span>':'';
		
	}//function
	
	
	/**
	 * Enqueue Function.
	 *
	 * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
	 *
	 * @since NHP_Options 1.0
	*/
	function enqueue(){
		
		wp_enqueue_script(
			'nhp-opts-field-color-js', 
			NHP_OPTIONS_URL.'fields/color/field_color.js', 
			array('jquery', 'farbtastic'),
			time(),
			true
		);
		
	}//function
	
}//class
?>