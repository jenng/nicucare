<?php
class NHP_Options_select extends NHP_Options{	
	
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
		
		echo '<div class="select-wrapper">';
		$class = (isset($this->field['class']))?'class="'.$this->field['class'].'" ':''; $field_id = preg_replace('#[^\w()/.%\-&]#',"", $this->field['id']);
		if(isset($this->field['label'])) {
			echo '<label class="select-desc">'.$this->field['label'].'</label>';
		}
		echo '<select id="'. $field_id.'" name="'.$this->args['opt_name'].'['.$this->field['id'].']" '.$class.'rows="6" >';
			
			foreach($this->field['options'] as $k => $v){
				
				echo '<option value="'.$k.'" '.selected($this->value, $k, false).'>'.$v.'</option>';
				
			}//foreach

		echo '</select>';

		echo (isset($this->field['desc']) && !empty($this->field['desc']))?' <span class="description">'.$this->field['desc'].'</span>':'';
		echo '</div>';
		
	}//function

	
	
}//class
?>