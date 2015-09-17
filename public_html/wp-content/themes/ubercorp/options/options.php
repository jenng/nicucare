<?php
if ( ! class_exists('NHP_Options') ){
	
	// windows-proof constants: replace backward by forward slashes - thanks to: https://github.com/peterbouwmeester
	$fslashed_dir = trailingslashit(str_replace('\\','/',dirname(__FILE__)));
	$fslashed_abs = trailingslashit(str_replace('\\','/',ABSPATH));
	
	if(!defined('NHP_OPTIONS_DIR')){
		define('NHP_OPTIONS_DIR', $fslashed_dir);
	}

	
	if(!defined('NHP_OPTIONS_URL')){
		define('NHP_OPTIONS_URL', site_url(str_replace( $fslashed_abs, '', $fslashed_dir )));
	}
	
	if(!defined('THEME_NAME')){
		define('THEME_NAME', 'UberCorp');
	}
	
	if(!defined('THEME_VERSION')){
		define('THEME_VERSION', '1.0');
	}
	
class NHP_Options{
	
	protected $framework_url = 'http://leemason.github.com/NHP-Theme-Options-Framework/';
	protected $framework_version = '1.0.6';
		
	public $dir = NHP_OPTIONS_DIR;
	public $url = NHP_OPTIONS_URL;
	public $page = '';
	public $args = array();
	public $sections = array();
	public $extra_tabs = array();
	public $errors = array();
	public $warnings = array();
	public $options = array();
	public $theme_name = THEME_NAME;
	public $theme_version = THEME_VERSION;
	
	

	/**
	 * Class Constructor. Defines the args for the theme options class
	 *
	 * @since NHP_Options 1.0
	 *
	 * @param $array $args Arguments. Class constructor arguments.
	*/
	function __construct($sections = array(), $args = array(), $extra_tabs = array()){
		
		$defaults = array();
		
		$defaults['opt_name'] = '';//must be defined by theme/plugin
		
		$defaults['google_api_key'] = 'AIzaSyCkK4tQEoWgvuXMq5hN9jf2iG0knuZobzU';//must be defined for use with google webfonts field type
		
		$defaults['menu_icon'] = NHP_OPTIONS_URL.'/be-themes_image/icon/be-themes-small.png';
		$defaults['menu_title'] = __('Options', 'be-themes');
		$defaults['page_icon'] = 'icon-themes';
		$defaults['page_title'] = __('Options', 'be-themes');
		$defaults['page_slug'] = '_options';
		$defaults['page_cap'] = 'manage_options';
		$defaults['page_type'] = 'menu';
		$defaults['page_parent'] = '';
		$defaults['page_position'] = 100;
		$defaults['allow_sub_menu'] = false;
		
		$defaults['show_import_export'] = true;
		$defaults['dev_mode'] = false;
		$defaults['stylesheet_override'] = false;
		
		$defaults['footer_credit'] = '<span id="footer-thankyou">'.__('Ubercorp Options', 'be-themes').'</span>';
		
		$defaults['help_tabs'] = array();
		$defaults['help_sidebar'] = __('', 'be-themes');
		
		//get args
		$this->args = wp_parse_args($args, $defaults);
		$this->args = apply_filters('nhp-opts-args-'.$this->args['opt_name'], $this->args);
		
		//get sections
		$this->sections = apply_filters('nhp-opts-sections-'.$this->args['opt_name'], $sections);
		
		//get extra tabs
		$this->extra_tabs = apply_filters('nhp-opts-extra-tabs-'.$this->args['opt_name'], $extra_tabs);
		
		//set option with defaults
		add_action('init', array(&$this, '_set_default_options'));

		add_action('wp_ajax_be_themes_data_save', array(&$this, '_be_themes_save_ajax'));
		
		//options page
		add_action('admin_menu', array(&$this, '_options_page'));
		
		//register setting
		add_action('admin_init', array(&$this, '_register_setting'));
		
		//add the js for the error handling before the form
	//	add_action('nhp-opts-page-before-form-'.$this->args['opt_name'], array(&$this, '_errors_js'), 1);
		
		//add the js for the warning handling before the form
		add_action('nhp-opts-page-before-form-'.$this->args['opt_name'], array(&$this, '_warnings_js'), 2);
		
		//hook into the wp feeds for downloading the exported settings
		add_action('do_feed_nhpopts-'.$this->args['opt_name'], array(&$this, '_download_options'), 1, 1);
		
		//get the options for use later on
		$this->options = get_option($this->args['opt_name']);

		$this->google_font = $this->get_google_fonts() ;

		//var_dump($this->google_font);
		
	}//function
	
	
	/**
	 * ->get(); This is used to return and option value from the options array
	 *
	 * @since NHP_Options 1.0.1
	 *
	 * @param $array $args Arguments. Class constructor arguments.
	*/
	function get($opt_name, $default = null){
		return (!empty($this->options[$opt_name])) ? $this->options[$opt_name] : $default;
	}//function
	
	/**
	 * ->set(); This is used to set an arbitrary option in the options array
	 *
	 * @since NHP_Options 1.0.1
	 * 
	 * @param string $opt_name the name of the option being added
	 * @param mixed $value the value of the option being added
	 */
	function set($opt_name = '', $value = '') {
		if($opt_name != ''){
			$this->options[$opt_name] = $value;
			update_option($this->args['opt_name'], $this->options);
		}//if
	}
	
	/**
	 * ->show(); This is used to echo and option value from the options array
	 *
	 * @since NHP_Options 1.0.1
	 *
	 * @param $array $args Arguments. Class constructor arguments.
	*/
	function show($opt_name, $default = ''){
		$option = $this->get($opt_name);
		if(!is_array($option) && $option != ''){
			echo $option;
		}elseif($default != ''){
			echo $default;
		}
	}//function
	
	
	
	/**
	 * Get default options into an array suitable for the settings API
	 *
	 * @since NHP_Options 1.0
	 *
	*/
	function _default_values(){
		
		$defaults = array();
		
		foreach($this->sections as $k => $section){
			
			if(isset($section['fields'])){
		
				foreach($section['fields'] as $fieldk => $field){
					
					if(!isset($field['std'])){$field['std'] = '';}
						
						$defaults[$field['id']] = $field['std'];
					
				}//foreach
			
			}//if
			
		}//foreach
		
		//fix for notice on first page load
		$defaults['last_tab'] = 0;

		return $defaults;
		
	}
	
	
	
	/**
	 * Set default options on admin_init if option doesnt exist (theme activation hook caused problems, so admin_init it is)
	 *
	 * @since NHP_Options 1.0
	 *
	*/
	function _set_default_options(){
		if(!get_option($this->args['opt_name'])){
			add_option($this->args['opt_name'], $this->_default_values());
		}
		$this->options = get_option($this->args['opt_name']);
	}//function
	
	
	/**
	 * Class Theme Options Page Function, creates main options page.
	 *
	 * @since NHP_Options 1.0
	*/
	function _options_page(){
		if($this->args['page_type'] == 'submenu'){
			if(!isset($this->args['page_parent']) || empty($this->args['page_parent'])){
				$this->args['page_parent'] = 'themes.php';
			}
		/*	$this->page = add_submenu_page(
							$this->args['page_parent'],
							$this->args['page_title'], 
							$this->args['menu_title'], 
							$this->args['page_cap'], 
							$this->args['page_slug'], 
							array(&$this, '_options_page_html')
						); */
		}else{
			$this->page = add_theme_page(
							$this->args['page_title'], 
							$this->args['menu_title'], 
							$this->args['page_cap'], 
							$this->args['page_slug'], 
							array(&$this, '_options_page_html')
						);
			
		}//else 

		add_action('admin_print_styles-'.$this->page, array(&$this, '_enqueue'));
		add_action('load-'.$this->page, array(&$this, '_load_page'));
	}//function	
	
	

	/**
	 * enqueue styles/js for theme page
	 *
	 * @since NHP_Options 1.0
	*/
	function _enqueue(){
		
		wp_register_style(
				'nhp-opts-css', 
				$this->url.'css/options.css',
				array('farbtastic'),
				time(),
				'all'
			);
			
		wp_register_style(
			'nhp-opts-jquery-ui-css',
			apply_filters('nhp-opts-ui-theme', $this->url.'css/jquery-ui-aristo/aristo.css'),
			'',
			time(),
			'all'
		);
		
		wp_register_style(
			'bootstrap-icons',
			apply_filters('bootstrap-icons', $this->url.'css/bootstrap/css/bootstrap.min.css'),
			'',
			time(),
			'all'
		);
		wp_enqueue_style( 'bootstrap-icons' );
			
			
		if(false === $this->args['stylesheet_override']){
			wp_enqueue_style('nhp-opts-css');
		}
		
		
		wp_enqueue_script( 'pnotify-js', $this->url.'js/jquery.pnotify.min.js');

		wp_enqueue_script( 'nhp-opts-js', $this->url.'js/options.js', array('jquery','pnotify-js'));

		wp_localize_script('nhp-opts-js', 'nhp_opts', array('reset_confirm' => __('Are you sure? Resetting will loose all custom values.', 'be-themes'), 'opt_name' => $this->args['opt_name']));
		
		do_action('nhp-opts-enqueue-'.$this->args['opt_name']);
		
		
		foreach($this->sections as $k => $section){
			
			if(isset($section['fields'])){
				
				foreach($section['fields'] as $fieldk => $field){
					
					if(isset($field['type'])){
					
						$field_class = 'NHP_Options_'.$field['type'];
						
						if(!class_exists($field_class)){
							require_once($this->dir.'fields/'.$field['type'].'/field_'.$field['type'].'.php');
						}//if
				
						if(class_exists($field_class) && method_exists($field_class, 'enqueue')){
							$enqueue = new $field_class('','',$this);
							$enqueue->enqueue();
						}//if
						
					}//if type
					
				}//foreach
			
			}//if fields
			
		}//foreach
			
		
	}//function
	
	/**
	 * Download the options file, or display it
	 *
	 * @since NHP_Options 1.0.1
	*/
	function _download_options(){
		//-'.$this->args['opt_name']
		if(!isset($_GET['secret']) || $_GET['secret'] != md5(AUTH_KEY.SECURE_AUTH_KEY)){wp_die('Invalid Secret for options use');exit;}
		if(!isset($_GET['feed'])){wp_die('No Feed Defined');exit;}
		$backup_options = get_option(str_replace('nhpopts-','',$_GET['feed']));
		$backup_options['nhp-opts-backup'] = '1';
		$content = '###'.serialize($backup_options).'###';
		
		
		if(isset($_GET['action']) && $_GET['action'] == 'download_options'){
			header('Content-Description: File Transfer');
			header('Content-type: application/txt');
			header('Content-Disposition: attachment; filename="'.str_replace('nhpopts-','',$_GET['feed']).'_options_'.date('d-m-Y').'.txt"');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			echo $content;
			exit;
		}else{
			echo $content;
			exit;
		}
	}
	
	
	
	
	/**
	 * show page help
	 *
	 * @since NHP_Options 1.0
	*/
	function _load_page(){
		
		//do admin head action for this page
		add_action('admin_head', array(&$this, 'admin_head'));
		
		//do admin footer text hook
		add_filter('admin_footer_text', array(&$this, 'admin_footer_text'));
		
		$screen = get_current_screen();
		
		if(is_array($this->args['help_tabs'])){
			foreach($this->args['help_tabs'] as $tab){
				$screen->add_help_tab($tab);
			}//foreach
		}//if
		
		if($this->args['help_sidebar'] != ''){
			$screen->set_help_sidebar($this->args['help_sidebar']);
		}//if
		
		do_action('nhp-opts-load-page-'.$this->args['opt_name'], $screen);
		
	}//function
	
	
	/**
	 * do action nhp-opts-admin-head for theme options page
	 *
	 * @since NHP_Options 1.0
	*/
	function admin_head(){
		
		do_action('nhp-opts-admin-head-'.$this->args['opt_name'], $this);
		
	}//function
	
	
	function admin_footer_text($footer_text){
		return $this->args['footer_credit'];
	}//function
	
	
	
	
	/**
	 * Register Option for use
	 *
	 * @since NHP_Options 1.0
	*/
	function _register_setting(){
		
		register_setting($this->args['opt_name'].'_group', $this->args['opt_name'], array(&$this,'_validate_options'));
		
		foreach($this->sections as $k => $section){
			
			add_settings_section($k.'_section', $section['title'], array(&$this, '_section_desc'), $k.'_section_group');
			
			if(isset($section['fields'])){
			
				foreach($section['fields'] as $fieldk => $field){
					
					if(isset($field['title'])){
					
						$th = (isset($field['sub_desc']))?$field['title'].'<span class="description">'.$field['sub_desc'].'</span>':$field['title'];
					}else{
						$th = '';
					}
					$title = (isset($field['tooltip'])) ? '<a href="'.$field['tooltip'].'" class="tooltip"></a>'.$th : $th;											
					add_settings_field($fieldk.'_field', $title, array(&$this,'_field_input'), $k.'_section_group', $k.'_section', $field); // checkbox
					
				}//foreach
			
			}//if(isset($section['fields'])){
			
		}//foreach
		
		do_action('nhp-opts-register-settings-'.$this->args['opt_name']);
		
	}//function
	
	/**
	 * Ajax Options Saving.
	 *
	 * @since BE Themes V 2.0
	*/
	function _be_themes_save_ajax() {
		
		check_ajax_referer('be-themes-data', 'security');
		unset($_POST['security'], $_POST['action']);
		
		if($_POST['trigger'] == 'import'  ){
			$imported_options = stripslashes_deep($_POST[$this->args['opt_name']]['import_code']);
			$imported_options = unserialize(trim($imported_options,'###'));
			if(update_option($this->args['opt_name'], $imported_options))	
				die('1');
			else
				die('0');	
		}
		elseif($_POST['trigger'] == 'save'  && update_option($this->args['opt_name'], $_POST[$this->args['opt_name']])){	
			die('1');
		}
		elseif($_POST['trigger'] == 'reset' && update_option($this->args['opt_name'], $this->_default_values() )){
			die('2');
		}
		else{
			die('0');
		}
	}

	
	/**
	 * Validate the Options options before insertion
	 *
	 * @since NHP_Options 1.0
	*/
	function _validate_options($plugin_options){
		
		set_transient('nhp-opts-saved', '1', 1000 );
		
		if(!empty($plugin_options['import'])){
			
			if($plugin_options['import_code'] != ''){
				$import = $plugin_options['import_code'];
			}elseif($plugin_options['import_link'] != ''){
				$import = wp_remote_retrieve_body( wp_remote_get($plugin_options['import_link']) );
			}
			
			$imported_options = unserialize(trim($import,'###'));
			if(is_array($imported_options) && isset($imported_options['nhp-opts-backup']) && $imported_options['nhp-opts-backup'] == '1'){
				$imported_options['imported'] = 1;
				return $imported_options;
			}
			
			
		}
		
		
		if(!empty($plugin_options['defaults'])){
			$plugin_options = $this->_default_values();
			return $plugin_options;
		}//if set defaults

		
		//validate fields (if needed)
		$plugin_options = $this->_validate_values($plugin_options, $this->options);
		
		if($this->errors){
			set_transient('nhp-opts-errors-'.$this->args['opt_name'], $this->errors, 1000 );		
		}//if errors
		
		if($this->warnings){
			set_transient('nhp-opts-warnings-'.$this->args['opt_name'], $this->warnings, 1000 );		
		}//if errors
		
		do_action('nhp-opts-options-validate-'.$this->args['opt_name'], $plugin_options, $this->options);
		
		
		unset($plugin_options['defaults']);
		unset($plugin_options['import']);
		unset($plugin_options['import_code']);
		unset($plugin_options['import_link']);
		
		return $plugin_options;	
	
	}//function
	
	
	
	
	/**
	 * Validate values from options form (used in settings api validate function)
	 * calls the custom validation class for the field so authors can override with custom classes
	 *
	 * @since NHP_Options 1.0
	*/
	function _validate_values($plugin_options, $options){
		foreach($this->sections as $k => $section){
			
			if(isset($section['fields'])){
			
				foreach($section['fields'] as $fieldk => $field){
					$field['section_id'] = $k;
					
					if(isset($field['type']) && $field['type'] == 'multi_text'){continue;}//we cant validate this yet
					
					if(!isset($plugin_options[$field['id']]) || $plugin_options[$field['id']] == ''){
						continue;
					}
					
					//force validate of custom filed types
					
					if(isset($field['type']) && !isset($field['validate'])){
						if($field['type'] == 'color' || $field['type'] == 'color_gradient'){
							$field['validate'] = 'color';
						}elseif($field['type'] == 'date'){
							$field['validate'] = 'date';
						}
					}//if
	
					if(isset($field['validate'])){
						$validate = 'NHP_Validation_'.$field['validate'];
						
						if(!class_exists($validate)){
							require_once($this->dir.'validation/'.$field['validate'].'/validation_'.$field['validate'].'.php');
						}//if
						
						if(class_exists($validate)){
							$validation = new $validate($field, $plugin_options[$field['id']], $options[$field['id']]);
							$plugin_options[$field['id']] = $validation->value;
							if(isset($validation->error)){
								$this->errors[] = $validation->error;
							}
							if(isset($validation->warning)){
								$this->warnings[] = $validation->warning;
							}
							continue;
						}//if
					}//if
					
					
					if(isset($field['validate_callback']) && function_exists($field['validate_callback'])){
						
						$callbackvalues = call_user_func($field['validate_callback'], $field, $plugin_options[$field['id']], $options[$field['id']]);
						$plugin_options[$field['id']] = $callbackvalues['value'];
						if(isset($callbackvalues['error'])){
							$this->errors[] = $callbackvalues['error'];
						}//if
						if(isset($callbackvalues['warning'])){
							$this->warnings[] = $callbackvalues['warning'];
						}//if
						
					}//if
					
					
				}//foreach
			
			}//if(isset($section['fields'])){
			
		}//foreach
		return $plugin_options;
	}//function
	
	
	
	
	
	
	
	
	/**
	 * HTML OUTPUT.
	 *
	 * @since NHP_Options 1.0
	*/
	function _options_page_html(){
		
		echo '<div class="wrap">';
			echo '<div id="'.$this->args['page_icon'].'" class="icon32"><br/></div>';
			
			do_action('nhp-opts-page-before-form-'.$this->args['opt_name']);
			echo '<div id="be-themes-dialog" title="" class="pattern-wrapper"><img src="" /></div>';	
			echo '<form method="post" action="options.php" enctype="multipart/form-data" id="nhp-opts-form-wrapper">';
				
				$this->options['last_tab'] = (isset($this->options['last_tab'])) ?  (isset($_GET['tab']) && !get_transient('nhp-opts-saved'))?$_GET['tab']:$this->options['last_tab'] :  0;
				
				
				echo '<input type="hidden" id="last_tab" name="'.$this->args['opt_name'].'[last_tab]" value="'.$this->options['last_tab'].'" />';
				echo '<input type="hidden" class="field-url" value="'.NHP_OPTIONS_URL.'">';
				echo '<input type="hidden" name="action" value="be_themes_data_save" />';
    			echo '<input type="hidden" name="security" value="'.wp_create_nonce('be-themes-data').'" />';
    			echo '<input type="hidden" name="option_page" value="'.$this->args['opt_name'].'_group">';

				echo '<div id="nhp-opts-header" class="clearfix">';
				echo '<div class="left"><h1 class="opt-header-title">'.$this->theme_name.' <span>'.$this->theme_version.'</span></h1></div>';
				//echo '<div class="right"><a href="http://www.brandexponents.com/"><img src="'.$this->url.'/img/be-logo.png" alt="logo" width="112" height="72" /></a></div>';
				echo '</div>';
				
					if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' && get_transient('nhp-opts-saved') == '1'){
						if(isset($this->options['imported']) && $this->options['imported'] == 1){
							echo '<div id="nhp-opts-imported">'.apply_filters('nhp-opts-imported-text-'.$this->args['opt_name'], __('<strong>Settings Imported!</strong>', 'be-themes')).'</div>';
						}else{
							echo '<div id="nhp-opts-save">'.apply_filters('nhp-opts-saved-text-'.$this->args['opt_name'], __('<strong>Settings Saved!</strong>', 'be-themes')).'</div>';
						}
						delete_transient('nhp-opts-saved');
					}
					
					echo '<div id="nhp-opts-save">'.apply_filters('nhp-opts-saved-text-'.$this->args['opt_name'], __('<strong>Settings Saved!</strong>', 'be-themes')).'</div>';					
					echo '<div id="nhp-opts-field-reset">'.apply_filters('nhp-opts-saved-text-'.$this->args['opt_name'], __('<strong>Settings Reseted!</strong>', 'be-themes')).'</div>';					
					echo '<div id="nhp-opts-save-warn">'.apply_filters('nhp-opts-changed-text-'.$this->args['opt_name'], __('<strong>Settings have changed!, you should save them!</strong>', 'be-themes')).'</div>';
					echo '<div id="nhp-opts-field-errors">'.__('<strong><span></span> error(s) were found!</strong>', 'be-themes').'</div>';
					
					echo '<div id="nhp-opts-field-warnings">'.__('<strong><span></span> warning(s) were found!</strong>', 'be-themes').'</div>';

					echo '<div id="nhp-opts-field-not-save">'.__('<strong><span></span> No Changes Made!</strong>', 'be-themes').'</div>';
				
				echo '<div class="clear"></div><!--clearfix-->';
				
				
				
				echo '<div id="nhp-opts-main">';
					echo '<div id="nhp-opts-sidebar">';
					echo '<ul id="nhp-opts-group-menu">';
						foreach($this->sections as $k => $section){
							$icon = (!isset($section['icon']))?'<img src="'.$this->url.'img/glyphicons/glyphicons_019_cogwheel.png" /> ':'<img src="'.$section['icon'].'" /> ';
							echo '<li id="'.$k.'_section_group_li" class="nhp-opts-group-tab-link-li">';
								echo '<a href="javascript:void(0);" id="'.$k.'_section_group_li_a" class="nhp-opts-group-tab-link-a" data-rel="'.$k.'">'.$icon.'<span>'.$section['title'].'</span></a>';
							echo '</li>';
						}
						
						do_action('nhp-opts-after-section-menu-items-'.$this->args['opt_name'], $this);
						
						if(true === $this->args['show_import_export']){
							echo '<li id="import_export_default_section_group_li" class="nhp-opts-group-tab-link-li">';
									echo '<a href="javascript:void(0);" id="import_export_default_section_group_li_a" class="nhp-opts-group-tab-link-a" data-rel="import_export_default"><img src="'.$this->url.'img/glyphicons/glyphicons_082_roundabout.png" /> <span>'.__('Import / Export', 'be-themes').'</span></a>';
							echo '</li>';
						}//if
						
						
						
						
						
						foreach($this->extra_tabs as $k => $tab){
							$icon = (!isset($tab['icon']))?'<img src="'.$this->url.'img/glyphicons/glyphicons_019_cogwheel.png" /> ':'<img src="'.$tab['icon'].'" /> ';
							echo '<li id="'.$k.'_section_group_li" class="nhp-opts-group-tab-link-li">';
								echo '<a href="javascript:void(0);" id="'.$k.'_section_group_li_a" class="nhp-opts-group-tab-link-a custom-tab" data-rel="'.$k.'">'.$icon.'<span>'.$tab['title'].'</span></a>';
							echo '</li>';
						}

						
						if(true === $this->args['dev_mode']){
							echo '<li id="dev_mode_default_section_group_li" class="nhp-opts-group-tab-link-li">';
									echo '<a href="javascript:void(0);" id="dev_mode_default_section_group_li_a" class="nhp-opts-group-tab-link-a custom-tab" data-rel="dev_mode_default"><img src="'.$this->url.'img/glyphicons/glyphicons_195_circle_info.png" /> <span>'.__('Dev Mode Info', 'be-themes').'</span></a>';
							echo '</li>';
						}//if
						
					echo '</ul>';
				echo '</div>';
				
					foreach($this->sections as $k => $section){
						echo '<div id="'.$k.'_section_group'.'" class="nhp-opts-group-tab">';
							$this->custom_do_settings_sections($k.'_section_group');
						echo '</div>';
					}					
					
					
					if(true === $this->args['show_import_export']){
						echo '<div id="import_export_default_section_group'.'" class="nhp-opts-group-tab">';
							echo '<h3>'.__('Import / Export Options', 'be-themes').'</h3>';
							
							echo '<h4>'.__('Import Options', 'be-themes').'</h4>';
							
							echo '<p><a href="javascript:void(0);" id="nhp-opts-import-code-button" class="button-secondary">Import from file</a> <a href="javascript:void(0);" id="nhp-opts-import-link-button" class="button-secondary">Import from URL</a></p>';
							
							echo '<div id="nhp-opts-import-code-wrapper">';
							
								echo '<div class="nhp-opts-section-desc">';
				
									echo '<p class="description" id="import-code-description">'.apply_filters('nhp-opts-import-file-description',__('Input your backup file below and hit Import to restore your sites options from a backup.', 'be-themes')).'</p>';
								
								echo '</div>';
								
								echo '<textarea id="import-code-value" name="'.$this->args['opt_name'].'[import_code]" class="large-text" rows="8"></textarea>';
							
							echo '</div>';
							
							
							echo '<div id="nhp-opts-import-link-wrapper">';
							
								echo '<div class="nhp-opts-section-desc">';
									
									echo '<p class="description" id="import-link-description">'.apply_filters('nhp-opts-import-link-description',__('Input the URL to another sites options set and hit Import to load the options from that site.', 'be-themes')).'</p>';
								
								echo '</div>';

								echo '<input type="text" id="import-link-value" name="'.$this->args['opt_name'].'[import_link]" class="large-text" value="" />';
							
							echo '</div>';
							
							
							
							echo '<p id="nhp-opts-import-action"><input type="submit" id="nhp-opts-import" name="'.$this->args['opt_name'].'[import]" class="button-primary" value="'.__('Import', 'be-themes').'"> <span>'.apply_filters('nhp-opts-import-warning', __('WARNING! This will overwrite any existing options, please proceed with caution!', 'be-themes')).'</span></p>';
							echo '<div id="import_divide"></div>';
							
							echo '<h4>'.__('Export Options', 'be-themes').'</h4>';
							echo '<div class="nhp-opts-section-desc">';
								echo '<p class="description">'.apply_filters('nhp-opts-backup-description', __('Here you can copy/download your themes current option settings. Keep this safe as you can use it as a backup should anything go wrong. Or you can use it to restore your settings on this site (or any other site). You also have the handy option to copy the link to yours sites settings. Which you can then use to duplicate on another site', 'be-themes')).'</p>';
							echo '</div>';
							
								echo '<p><a href="javascript:void(0);" id="nhp-opts-export-code-copy" class="button-secondary">Copy</a> <a href="'.add_query_arg(array('feed' => 'nhpopts-'.$this->args['opt_name'], 'action' => 'download_options', 'secret' => md5(AUTH_KEY.SECURE_AUTH_KEY)), site_url()).'" id="nhp-opts-export-code-dl" class="button-primary">Download</a> <a href="javascript:void(0);" id="nhp-opts-export-link" class="button-secondary">Copy Link</a></p>';
								$backup_options = $this->options;
								$backup_options['nhp-opts-backup'] = '1';
								$encoded_options = '###'.serialize($backup_options).'###';
								echo '<textarea class="large-text" id="nhp-opts-export-code" rows="8">';print_r($encoded_options);echo '</textarea>';
								echo '<input type="text" class="large-text" id="nhp-opts-export-link-value" value="'.add_query_arg(array('feed' => 'nhpopts-'.$this->args['opt_name'], 'secret' => md5(AUTH_KEY.SECURE_AUTH_KEY)), site_url()).'" />';
							
						echo '</div>';
					}
					
					
					
					foreach($this->extra_tabs as $k => $tab){
						echo '<div id="'.$k.'_section_group'.'" class="nhp-opts-group-tab">';
						echo '<h3>'.$tab['title'].'</h3>';
						echo $tab['content'];
						echo '</div>';
					}

					
					
					if(true === $this->args['dev_mode']){
						echo '<div id="dev_mode_default_section_group'.'" class="nhp-opts-group-tab">';
							echo '<h3>'.__('Dev Mode Info', 'be-themes').'</h3>';
							echo '<div class="nhp-opts-section-desc">';
							echo '<textarea class="large-text" rows="24">'.print_r($this, true).'</textarea>';
							echo '</div>';
						echo '</div>';
					}
					
					
					do_action('nhp-opts-after-section-items-'.$this->args['opt_name'], $this);
				
					echo '<div class="clear"></div><!--clearfix-->';
				echo '</div>';
				echo '<div class="clear"></div><!--clearfix-->';
				
				echo '<div id="nhp-opts-footer">';
				
					if(isset($this->args['share_icons'])){
						echo '<div id="nhp-opts-share">';
						foreach($this->args['share_icons'] as $link){
							echo '<a href="'.$link['link'].'" title="'.$link['title'].'" target="_blank"><img src="'.$link['img'].'"/></a>';
						}
						echo '</div>';
					}
					
					submit_button('', 'primary', '', false,array('id'=>'bravo_opt_submit'));
					submit_button(__('Reset to Defaults', 'be-themes'), 'secondary', $this->args['opt_name'].'[defaults]', false,array('id'=>'bravo_opt_reset'));
					echo '<div class="clear"></div><!--clearfix-->';
				echo '</div>';
			
			echo '</form>';
			
			do_action('nhp-opts-page-after-form-'.$this->args['opt_name']);
			
			echo '<div class="clear"></div><!--clearfix-->';	
		echo '</div><!--wrap-->';

	}//function
	
	
	
	/**
	 * JS to display the errors on the page
	 *
	 * @since NHP_Options 1.0
	*/	
	function _errors_js(){
		
		if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' && get_transient('nhp-opts-errors-'.$this->args['opt_name'])){
				$errors = get_transient('nhp-opts-errors-'.$this->args['opt_name']);
				$section_errors = array();
				foreach($errors as $error){
					$section_errors[$error['section_id']] = (isset($section_errors[$error['section_id']]))?$section_errors[$error['section_id']]:0;
					$section_errors[$error['section_id']]++;
				}
				
				
				echo '<script type="text/javascript">';
					echo 'jQuery(document).ready(function(){';
						echo 'jQuery("#nhp-opts-field-errors span").html("'.count($errors).'");';
						echo 'jQuery("#nhp-opts-field-errors").show();';
						
						foreach($section_errors as $sectionkey => $section_error){
							echo 'jQuery("#'.$sectionkey.'_section_group_li_a").append("<span class=\"nhp-opts-menu-error\">'.$section_error.'</span>");';
						}
						
						foreach($errors as $error){
							echo 'jQuery("#'.$error['id'].'").addClass("nhp-opts-field-error");';
							echo 'jQuery("#'.$error['id'].'").closest("td").append("<span class=\"nhp-opts-th-error\">'.$error['msg'].'</span>");';
						}
					echo '});';
				echo '</script>';
				delete_transient('nhp-opts-errors-'.$this->args['opt_name']);
			}
		
	}//function
	
	
	
	/**
	 * JS to display the warnings on the page
	 *
	 * @since NHP_Options 1.0.3
	*/	
	function _warnings_js(){
		
		if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' && get_transient('nhp-opts-warnings-'.$this->args['opt_name'])){
				$warnings = get_transient('nhp-opts-warnings-'.$this->args['opt_name']);
				$section_warnings = array();
				foreach($warnings as $warning){
					$section_warnings[$warning['section_id']] = (isset($section_warnings[$warning['section_id']]))?$section_warnings[$warning['section_id']]:0;
					$section_warnings[$warning['section_id']]++;
				}
				
				
				echo '<script type="text/javascript">';
					echo 'jQuery(document).ready(function(){';
						echo 'jQuery("#nhp-opts-field-warnings span").html("'.count($warnings).'");';
						echo 'jQuery("#nhp-opts-field-warnings").show();';
						
						foreach($section_warnings as $sectionkey => $section_warning){
							echo 'jQuery("#'.$sectionkey.'_section_group_li_a").append("<span class=\"nhp-opts-menu-warning\">'.$section_warning.'</span>");';
						}
						
						foreach($warnings as $warning){
							echo 'jQuery("#'.$warning['id'].'").addClass("nhp-opts-field-warning");';
							echo 'jQuery("#'.$warning['id'].'").closest("td").append("<span class=\"nhp-opts-th-warning\">'.$warning['msg'].'</span>");';
						}
					echo '});';
				echo '</script>';
				delete_transient('nhp-opts-warnings-'.$this->args['opt_name']);
			}
		
	}//function
	
	

	
	
	/**
	 * Section HTML OUTPUT.
	 *
	 * @since NHP_Options 1.0
	*/	
	function _section_desc($section){
		
		$id = rtrim($section['id'], '_section');
		
		if(isset($this->sections[$id]['desc']) && !empty($this->sections[$id]['desc'])) {
			echo '<div class="nhp-opts-section-desc">'.$this->sections[$id]['desc'].'</div>';
		}
		
	}//function
	
	
	
	
	/**
	 * Field HTML OUTPUT.
	 *
	 * Gets option from options array, then calls the speicfic field type class - allows extending by other devs
	 *
	 * @since NHP_Options 1.0
	*/
	function _field_input($field){
		
		
		if(isset($field['callback']) && function_exists($field['callback'])){
			$value = (isset($this->options[$field['id']]))?$this->options[$field['id']]:'';
			do_action('nhp-opts-before-field-'.$this->args['opt_name'], $field, $value);
			call_user_func($field['callback'], $field, $value);
			do_action('nhp-opts-after-field-'.$this->args['opt_name'], $field, $value);
			return;
		}
		
		if(isset($field['type'])){
			
			$field_class = 'NHP_Options_'.$field['type'];
			
			if(class_exists($field_class)){
				require_once($this->dir.'fields/'.$field['type'].'/field_'.$field['type'].'.php');
			}//if
			
			if(class_exists($field_class)){
				$value = (isset($this->options[$field['id']]))?$this->options[$field['id']]:'';
				do_action('nhp-opts-before-field-'.$this->args['opt_name'], $field, $value);
				$render = '';
				$render = new $field_class($field, $value, $this);
				$render->render();
				do_action('nhp-opts-after-field-'.$this->args['opt_name'], $field, $value);
			}//if
			
		}//if $field['type']
		
	}//function

	/**
	 * HTML OUTPUT LAYOUT.
	 *
	 * @since BE Themes 2.0
	*/	
	function custom_do_settings_sections($page) {
        global $wp_settings_sections, $wp_settings_fields;

        if ( !isset($wp_settings_sections) || !isset($wp_settings_sections[$page]) )
            return;

        foreach( (array) $wp_settings_sections[$page] as $section ) {
        	echo "<h3>{$section['title']}</h3>\n";
            call_user_func($section['callback'], $section);
            if ( !isset($wp_settings_fields) ||
                 !isset($wp_settings_fields[$page]) ||
                 !isset($wp_settings_fields[$page][$section['id']]) )
                    continue;
            echo '<div class="settings-form-wrapper">';
            $this->custom_do_settings_fields($page, $section['id']);
            echo '</div>';
        }
    }
    function custom_do_settings_fields($page, $section) {
        global $wp_settings_fields;

        if ( !isset($wp_settings_fields) ||
             !isset($wp_settings_fields[$page]) ||
             !isset($wp_settings_fields[$page][$section]) )
            return;

        foreach ( (array) $wp_settings_fields[$page][$section] as $field ) {
            echo '<div class="settings-form-row clearfix">';
			echo '<div class="left">';
            if ( !empty($field['args']['label_for']) )
                echo '<label for="' . $field['args']['label_for'] . '">' .
                    $field['title'] . '</label><br />';
            else
                echo '<h4>' . $field['title'] . '</h4>';
			echo '</div>';
			echo '<div class="left right-section">';
            call_user_func($field['callback'], $field['args']);
			echo '</div>';
            echo '</div>';
        }
    }

    function get_google_fonts(){
    	
		// $google_fonts = get_transient('bravo-google-webfonts');
		
		// if(empty($google_fonts)){
		// 	$google_fonts = wp_remote_retrieve_body(wp_remote_get('https://www.googleapis.com/webfonts/v1/webfonts?key='.$this->args['google_api_key']));
		// 	set_transient('bravo-google-webfonts', $google_fonts, 60 * 60 * 24*60);
		// }

		$google_fonts = array ( 'default/Arial' => 'Arial', 'default/Arial Black' => 'Arial Black', 'default/Times New Roman' => 'Times New Roman', 'default/Comic Sans MS' => 'Comic Sans MS', 'default/Courier New' => 'Courier New', 'default/Georgia' => 'Georgia', 'default/Impact' => 'Impact', 'default/Lucida Console' => 'Lucida Console', 'default/Lucida Sans Unicode' => 'Lucida Sans Unicode', 'default/Palatino Linotype' => 'Palatino Linotype', 'default/Tahoma' => 'Tahoma', 'default/Trebuchet MS' => 'Trebuchet MS', 'default/Verdana' => 'Verdana', 'default/MS Sans Serif' => 'MS Sans Serif', 'default/MS Serif' => 'MS Serif', 'default/NovecentowideBookBold' => 'NovecentowideBookBold', 'default/NovecentowideUltraLightBold' => 'NovecentowideUltraLightBold', 'google/ABeeZee:regular' => 'ABeeZee - regular', 'google/ABeeZee:italic' => 'ABeeZee - italic', 'google/Abel:regular' => 'Abel - regular', 'google/Abril Fatface:regular' => 'Abril Fatface - regular', 'google/Aclonica:regular' => 'Aclonica - regular', 'google/Acme:regular' => 'Acme - regular', 'google/Actor:regular' => 'Actor - regular', 'google/Adamina:regular' => 'Adamina - regular', 'google/Advent Pro:100' => 'Advent Pro - 100', 'google/Advent Pro:200' => 'Advent Pro - 200', 'google/Advent Pro:300' => 'Advent Pro - 300', 'google/Advent Pro:regular' => 'Advent Pro - regular', 'google/Advent Pro:500' => 'Advent Pro - 500', 'google/Advent Pro:600' => 'Advent Pro - 600', 'google/Advent Pro:700' => 'Advent Pro - 700', 'google/Aguafina Script:regular' => 'Aguafina Script - regular', 'google/Akronim:regular' => 'Akronim - regular', 'google/Aladin:regular' => 'Aladin - regular', 'google/Aldrich:regular' => 'Aldrich - regular', 'google/Alef:regular' => 'Alef - regular', 'google/Alef:700' => 'Alef - 700', 'google/Alegreya:regular' => 'Alegreya - regular', 'google/Alegreya:italic' => 'Alegreya - italic', 'google/Alegreya:700' => 'Alegreya - 700', 'google/Alegreya:700italic' => 'Alegreya - 700italic', 'google/Alegreya:900' => 'Alegreya - 900', 'google/Alegreya:900italic' => 'Alegreya - 900italic', 'google/Alegreya SC:regular' => 'Alegreya SC - regular', 'google/Alegreya SC:italic' => 'Alegreya SC - italic', 'google/Alegreya SC:700' => 'Alegreya SC - 700', 'google/Alegreya SC:700italic' => 'Alegreya SC - 700italic', 'google/Alegreya SC:900' => 'Alegreya SC - 900', 'google/Alegreya SC:900italic' => 'Alegreya SC - 900italic', 'google/Alex Brush:regular' => 'Alex Brush - regular', 'google/Alfa Slab One:regular' => 'Alfa Slab One - regular', 'google/Alice:regular' => 'Alice - regular', 'google/Alike:regular' => 'Alike - regular', 'google/Alike Angular:regular' => 'Alike Angular - regular', 'google/Allan:regular' => 'Allan - regular', 'google/Allan:700' => 'Allan - 700', 'google/Allerta:regular' => 'Allerta - regular', 'google/Allerta Stencil:regular' => 'Allerta Stencil - regular', 'google/Allura:regular' => 'Allura - regular', 'google/Almendra:regular' => 'Almendra - regular', 'google/Almendra:italic' => 'Almendra - italic', 'google/Almendra:700' => 'Almendra - 700', 'google/Almendra:700italic' => 'Almendra - 700italic', 'google/Almendra Display:regular' => 'Almendra Display - regular', 'google/Almendra SC:regular' => 'Almendra SC - regular', 'google/Amarante:regular' => 'Amarante - regular', 'google/Amaranth:regular' => 'Amaranth - regular', 'google/Amaranth:italic' => 'Amaranth - italic', 'google/Amaranth:700' => 'Amaranth - 700', 'google/Amaranth:700italic' => 'Amaranth - 700italic', 'google/Amatic SC:regular' => 'Amatic SC - regular', 'google/Amatic SC:700' => 'Amatic SC - 700', 'google/Amethysta:regular' => 'Amethysta - regular', 'google/Anaheim:regular' => 'Anaheim - regular', 'google/Andada:regular' => 'Andada - regular', 'google/Andika:regular' => 'Andika - regular', 'google/Angkor:regular' => 'Angkor - regular', 'google/Annie Use Your Telescope:regular' => 'Annie Use Your Telescope - regular', 'google/Anonymous Pro:regular' => 'Anonymous Pro - regular', 'google/Anonymous Pro:italic' => 'Anonymous Pro - italic', 'google/Anonymous Pro:700' => 'Anonymous Pro - 700', 'google/Anonymous Pro:700italic' => 'Anonymous Pro - 700italic', 'google/Antic:regular' => 'Antic - regular', 'google/Antic Didone:regular' => 'Antic Didone - regular', 'google/Antic Slab:regular' => 'Antic Slab - regular', 'google/Anton:regular' => 'Anton - regular', 'google/Arapey:regular' => 'Arapey - regular', 'google/Arapey:italic' => 'Arapey - italic', 'google/Arbutus:regular' => 'Arbutus - regular', 'google/Arbutus Slab:regular' => 'Arbutus Slab - regular', 'google/Architects Daughter:regular' => 'Architects Daughter - regular', 'google/Archivo Black:regular' => 'Archivo Black - regular', 'google/Archivo Narrow:regular' => 'Archivo Narrow - regular', 'google/Archivo Narrow:italic' => 'Archivo Narrow - italic', 'google/Archivo Narrow:700' => 'Archivo Narrow - 700', 'google/Archivo Narrow:700italic' => 'Archivo Narrow - 700italic', 'google/Arimo:regular' => 'Arimo - regular', 'google/Arimo:italic' => 'Arimo - italic', 'google/Arimo:700' => 'Arimo - 700', 'google/Arimo:700italic' => 'Arimo - 700italic', 'google/Arizonia:regular' => 'Arizonia - regular', 'google/Armata:regular' => 'Armata - regular', 'google/Artifika:regular' => 'Artifika - regular', 'google/Arvo:regular' => 'Arvo - regular', 'google/Arvo:italic' => 'Arvo - italic', 'google/Arvo:700' => 'Arvo - 700', 'google/Arvo:700italic' => 'Arvo - 700italic', 'google/Asap:regular' => 'Asap - regular', 'google/Asap:italic' => 'Asap - italic', 'google/Asap:700' => 'Asap - 700', 'google/Asap:700italic' => 'Asap - 700italic', 'google/Asset:regular' => 'Asset - regular', 'google/Astloch:regular' => 'Astloch - regular', 'google/Astloch:700' => 'Astloch - 700', 'google/Asul:regular' => 'Asul - regular', 'google/Asul:700' => 'Asul - 700', 'google/Atomic Age:regular' => 'Atomic Age - regular', 'google/Aubrey:regular' => 'Aubrey - regular', 'google/Audiowide:regular' => 'Audiowide - regular', 'google/Autour One:regular' => 'Autour One - regular', 'google/Average:regular' => 'Average - regular', 'google/Average Sans:regular' => 'Average Sans - regular', 'google/Averia Gruesa Libre:regular' => 'Averia Gruesa Libre - regular', 'google/Averia Libre:300' => 'Averia Libre - 300', 'google/Averia Libre:300italic' => 'Averia Libre - 300italic', 'google/Averia Libre:regular' => 'Averia Libre - regular', 'google/Averia Libre:italic' => 'Averia Libre - italic', 'google/Averia Libre:700' => 'Averia Libre - 700', 'google/Averia Libre:700italic' => 'Averia Libre - 700italic', 'google/Averia Sans Libre:300' => 'Averia Sans Libre - 300', 'google/Averia Sans Libre:300italic' => 'Averia Sans Libre - 300italic', 'google/Averia Sans Libre:regular' => 'Averia Sans Libre - regular', 'google/Averia Sans Libre:italic' => 'Averia Sans Libre - italic', 'google/Averia Sans Libre:700' => 'Averia Sans Libre - 700', 'google/Averia Sans Libre:700italic' => 'Averia Sans Libre - 700italic', 'google/Averia Serif Libre:300' => 'Averia Serif Libre - 300', 'google/Averia Serif Libre:300italic' => 'Averia Serif Libre - 300italic', 'google/Averia Serif Libre:regular' => 'Averia Serif Libre - regular', 'google/Averia Serif Libre:italic' => 'Averia Serif Libre - italic', 'google/Averia Serif Libre:700' => 'Averia Serif Libre - 700', 'google/Averia Serif Libre:700italic' => 'Averia Serif Libre - 700italic', 'google/Bad Script:regular' => 'Bad Script - regular', 'google/Balthazar:regular' => 'Balthazar - regular', 'google/Bangers:regular' => 'Bangers - regular', 'google/Basic:regular' => 'Basic - regular', 'google/Battambang:regular' => 'Battambang - regular', 'google/Battambang:700' => 'Battambang - 700', 'google/Baumans:regular' => 'Baumans - regular', 'google/Bayon:regular' => 'Bayon - regular', 'google/Belgrano:regular' => 'Belgrano - regular', 'google/Belleza:regular' => 'Belleza - regular', 'google/BenchNine:300' => 'BenchNine - 300', 'google/BenchNine:regular' => 'BenchNine - regular', 'google/BenchNine:700' => 'BenchNine - 700', 'google/Bentham:regular' => 'Bentham - regular', 'google/Berkshire Swash:regular' => 'Berkshire Swash - regular', 'google/Bevan:regular' => 'Bevan - regular', 'google/Bigelow Rules:regular' => 'Bigelow Rules - regular', 'google/Bigshot One:regular' => 'Bigshot One - regular', 'google/Bilbo:regular' => 'Bilbo - regular', 'google/Bilbo Swash Caps:regular' => 'Bilbo Swash Caps - regular', 'google/Bitter:regular' => 'Bitter - regular', 'google/Bitter:italic' => 'Bitter - italic', 'google/Bitter:700' => 'Bitter - 700', 'google/Black Ops One:regular' => 'Black Ops One - regular', 'google/Bokor:regular' => 'Bokor - regular', 'google/Bonbon:regular' => 'Bonbon - regular', 'google/Boogaloo:regular' => 'Boogaloo - regular', 'google/Bowlby One:regular' => 'Bowlby One - regular', 'google/Bowlby One SC:regular' => 'Bowlby One SC - regular', 'google/Brawler:regular' => 'Brawler - regular', 'google/Bree Serif:regular' => 'Bree Serif - regular', 'google/Bubblegum Sans:regular' => 'Bubblegum Sans - regular', 'google/Bubbler One:regular' => 'Bubbler One - regular', 'google/Buda:300' => 'Buda - 300', 'google/Buenard:regular' => 'Buenard - regular', 'google/Buenard:700' => 'Buenard - 700', 'google/Butcherman:regular' => 'Butcherman - regular', 'google/Butterfly Kids:regular' => 'Butterfly Kids - regular', 'google/Cabin:regular' => 'Cabin - regular', 'google/Cabin:italic' => 'Cabin - italic', 'google/Cabin:500' => 'Cabin - 500', 'google/Cabin:500italic' => 'Cabin - 500italic', 'google/Cabin:600' => 'Cabin - 600', 'google/Cabin:600italic' => 'Cabin - 600italic', 'google/Cabin:700' => 'Cabin - 700', 'google/Cabin:700italic' => 'Cabin - 700italic', 'google/Cabin Condensed:regular' => 'Cabin Condensed - regular', 'google/Cabin Condensed:500' => 'Cabin Condensed - 500', 'google/Cabin Condensed:600' => 'Cabin Condensed - 600', 'google/Cabin Condensed:700' => 'Cabin Condensed - 700', 'google/Cabin Sketch:regular' => 'Cabin Sketch - regular', 'google/Cabin Sketch:700' => 'Cabin Sketch - 700', 'google/Caesar Dressing:regular' => 'Caesar Dressing - regular', 'google/Cagliostro:regular' => 'Cagliostro - regular', 'google/Calligraffitti:regular' => 'Calligraffitti - regular', 'google/Cambo:regular' => 'Cambo - regular', 'google/Candal:regular' => 'Candal - regular', 'google/Cantarell:regular' => 'Cantarell - regular', 'google/Cantarell:italic' => 'Cantarell - italic', 'google/Cantarell:700' => 'Cantarell - 700', 'google/Cantarell:700italic' => 'Cantarell - 700italic', 'google/Cantata One:regular' => 'Cantata One - regular', 'google/Cantora One:regular' => 'Cantora One - regular', 'google/Capriola:regular' => 'Capriola - regular', 'google/Cardo:regular' => 'Cardo - regular', 'google/Cardo:italic' => 'Cardo - italic', 'google/Cardo:700' => 'Cardo - 700', 'google/Carme:regular' => 'Carme - regular', 'google/Carrois Gothic:regular' => 'Carrois Gothic - regular', 'google/Carrois Gothic SC:regular' => 'Carrois Gothic SC - regular', 'google/Carter One:regular' => 'Carter One - regular', 'google/Caudex:regular' => 'Caudex - regular', 'google/Caudex:italic' => 'Caudex - italic', 'google/Caudex:700' => 'Caudex - 700', 'google/Caudex:700italic' => 'Caudex - 700italic', 'google/Cedarville Cursive:regular' => 'Cedarville Cursive - regular', 'google/Ceviche One:regular' => 'Ceviche One - regular', 'google/Changa One:regular' => 'Changa One - regular', 'google/Changa One:italic' => 'Changa One - italic', 'google/Chango:regular' => 'Chango - regular', 'google/Chau Philomene One:regular' => 'Chau Philomene One - regular', 'google/Chau Philomene One:italic' => 'Chau Philomene One - italic', 'google/Chela One:regular' => 'Chela One - regular', 'google/Chelsea Market:regular' => 'Chelsea Market - regular', 'google/Chenla:regular' => 'Chenla - regular', 'google/Cherry Cream Soda:regular' => 'Cherry Cream Soda - regular', 'google/Cherry Swash:regular' => 'Cherry Swash - regular', 'google/Cherry Swash:700' => 'Cherry Swash - 700', 'google/Chewy:regular' => 'Chewy - regular', 'google/Chicle:regular' => 'Chicle - regular', 'google/Chivo:regular' => 'Chivo - regular', 'google/Chivo:italic' => 'Chivo - italic', 'google/Chivo:900' => 'Chivo - 900', 'google/Chivo:900italic' => 'Chivo - 900italic', 'google/Cinzel:regular' => 'Cinzel - regular', 'google/Cinzel:700' => 'Cinzel - 700', 'google/Cinzel:900' => 'Cinzel - 900', 'google/Cinzel Decorative:regular' => 'Cinzel Decorative - regular', 'google/Cinzel Decorative:700' => 'Cinzel Decorative - 700', 'google/Cinzel Decorative:900' => 'Cinzel Decorative - 900', 'google/Clicker Script:regular' => 'Clicker Script - regular', 'google/Coda:regular' => 'Coda - regular', 'google/Coda:800' => 'Coda - 800', 'google/Coda Caption:800' => 'Coda Caption - 800', 'google/Codystar:300' => 'Codystar - 300', 'google/Codystar:regular' => 'Codystar - regular', 'google/Combo:regular' => 'Combo - regular', 'google/Comfortaa:300' => 'Comfortaa - 300', 'google/Comfortaa:regular' => 'Comfortaa - regular', 'google/Comfortaa:700' => 'Comfortaa - 700', 'google/Coming Soon:regular' => 'Coming Soon - regular', 'google/Concert One:regular' => 'Concert One - regular', 'google/Condiment:regular' => 'Condiment - regular', 'google/Content:regular' => 'Content - regular', 'google/Content:700' => 'Content - 700', 'google/Contrail One:regular' => 'Contrail One - regular', 'google/Convergence:regular' => 'Convergence - regular', 'google/Cookie:regular' => 'Cookie - regular', 'google/Copse:regular' => 'Copse - regular', 'google/Corben:regular' => 'Corben - regular', 'google/Corben:700' => 'Corben - 700', 'google/Courgette:regular' => 'Courgette - regular', 'google/Cousine:regular' => 'Cousine - regular', 'google/Cousine:italic' => 'Cousine - italic', 'google/Cousine:700' => 'Cousine - 700', 'google/Cousine:700italic' => 'Cousine - 700italic', 'google/Coustard:regular' => 'Coustard - regular', 'google/Coustard:900' => 'Coustard - 900', 'google/Covered By Your Grace:regular' => 'Covered By Your Grace - regular', 'google/Crafty Girls:regular' => 'Crafty Girls - regular', 'google/Creepster:regular' => 'Creepster - regular', 'google/Crete Round:regular' => 'Crete Round - regular', 'google/Crete Round:italic' => 'Crete Round - italic', 'google/Crimson Text:regular' => 'Crimson Text - regular', 'google/Crimson Text:italic' => 'Crimson Text - italic', 'google/Crimson Text:600' => 'Crimson Text - 600', 'google/Crimson Text:600italic' => 'Crimson Text - 600italic', 'google/Crimson Text:700' => 'Crimson Text - 700', 'google/Crimson Text:700italic' => 'Crimson Text - 700italic', 'google/Croissant One:regular' => 'Croissant One - regular', 'google/Crushed:regular' => 'Crushed - regular', 'google/Cuprum:regular' => 'Cuprum - regular', 'google/Cuprum:italic' => 'Cuprum - italic', 'google/Cuprum:700' => 'Cuprum - 700', 'google/Cuprum:700italic' => 'Cuprum - 700italic', 'google/Cutive:regular' => 'Cutive - regular', 'google/Cutive Mono:regular' => 'Cutive Mono - regular', 'google/Damion:regular' => 'Damion - regular', 'google/Dancing Script:regular' => 'Dancing Script - regular', 'google/Dancing Script:700' => 'Dancing Script - 700', 'google/Dangrek:regular' => 'Dangrek - regular', 'google/Dawning of a New Day:regular' => 'Dawning of a New Day - regular', 'google/Days One:regular' => 'Days One - regular', 'google/Delius:regular' => 'Delius - regular', 'google/Delius Swash Caps:regular' => 'Delius Swash Caps - regular', 'google/Delius Unicase:regular' => 'Delius Unicase - regular', 'google/Delius Unicase:700' => 'Delius Unicase - 700', 'google/Della Respira:regular' => 'Della Respira - regular', 'google/Denk One:regular' => 'Denk One - regular', 'google/Devonshire:regular' => 'Devonshire - regular', 'google/Didact Gothic:regular' => 'Didact Gothic - regular', 'google/Diplomata:regular' => 'Diplomata - regular', 'google/Diplomata SC:regular' => 'Diplomata SC - regular', 'google/Domine:regular' => 'Domine - regular', 'google/Domine:700' => 'Domine - 700', 'google/Donegal One:regular' => 'Donegal One - regular', 'google/Doppio One:regular' => 'Doppio One - regular', 'google/Dorsa:regular' => 'Dorsa - regular', 'google/Dosis:200' => 'Dosis - 200', 'google/Dosis:300' => 'Dosis - 300', 'google/Dosis:regular' => 'Dosis - regular', 'google/Dosis:500' => 'Dosis - 500', 'google/Dosis:600' => 'Dosis - 600', 'google/Dosis:700' => 'Dosis - 700', 'google/Dosis:800' => 'Dosis - 800', 'google/Dr Sugiyama:regular' => 'Dr Sugiyama - regular', 'google/Droid Sans:regular' => 'Droid Sans - regular', 'google/Droid Sans:700' => 'Droid Sans - 700', 'google/Droid Sans Mono:regular' => 'Droid Sans Mono - regular', 'google/Droid Serif:regular' => 'Droid Serif - regular', 'google/Droid Serif:italic' => 'Droid Serif - italic', 'google/Droid Serif:700' => 'Droid Serif - 700', 'google/Droid Serif:700italic' => 'Droid Serif - 700italic', 'google/Duru Sans:regular' => 'Duru Sans - regular', 'google/Dynalight:regular' => 'Dynalight - regular', 'google/EB Garamond:regular' => 'EB Garamond - regular', 'google/Eagle Lake:regular' => 'Eagle Lake - regular', 'google/Eater:regular' => 'Eater - regular', 'google/Economica:regular' => 'Economica - regular', 'google/Economica:italic' => 'Economica - italic', 'google/Economica:700' => 'Economica - 700', 'google/Economica:700italic' => 'Economica - 700italic', 'google/Electrolize:regular' => 'Electrolize - regular', 'google/Elsie:regular' => 'Elsie - regular', 'google/Elsie:900' => 'Elsie - 900', 'google/Elsie Swash Caps:regular' => 'Elsie Swash Caps - regular', 'google/Elsie Swash Caps:900' => 'Elsie Swash Caps - 900', 'google/Emblema One:regular' => 'Emblema One - regular', 'google/Emilys Candy:regular' => 'Emilys Candy - regular', 'google/Engagement:regular' => 'Engagement - regular', 'google/Englebert:regular' => 'Englebert - regular', 'google/Enriqueta:regular' => 'Enriqueta - regular', 'google/Enriqueta:700' => 'Enriqueta - 700', 'google/Erica One:regular' => 'Erica One - regular', 'google/Esteban:regular' => 'Esteban - regular', 'google/Euphoria Script:regular' => 'Euphoria Script - regular', 'google/Ewert:regular' => 'Ewert - regular', 'google/Exo:100' => 'Exo - 100', 'google/Exo:100italic' => 'Exo - 100italic', 'google/Exo:200' => 'Exo - 200', 'google/Exo:200italic' => 'Exo - 200italic', 'google/Exo:300' => 'Exo - 300', 'google/Exo:300italic' => 'Exo - 300italic', 'google/Exo:regular' => 'Exo - regular', 'google/Exo:italic' => 'Exo - italic', 'google/Exo:500' => 'Exo - 500', 'google/Exo:500italic' => 'Exo - 500italic', 'google/Exo:600' => 'Exo - 600', 'google/Exo:600italic' => 'Exo - 600italic', 'google/Exo:700' => 'Exo - 700', 'google/Exo:700italic' => 'Exo - 700italic', 'google/Exo:800' => 'Exo - 800', 'google/Exo:800italic' => 'Exo - 800italic', 'google/Exo:900' => 'Exo - 900', 'google/Exo:900italic' => 'Exo - 900italic', 'google/Expletus Sans:regular' => 'Expletus Sans - regular', 'google/Expletus Sans:italic' => 'Expletus Sans - italic', 'google/Expletus Sans:500' => 'Expletus Sans - 500', 'google/Expletus Sans:500italic' => 'Expletus Sans - 500italic', 'google/Expletus Sans:600' => 'Expletus Sans - 600', 'google/Expletus Sans:600italic' => 'Expletus Sans - 600italic', 'google/Expletus Sans:700' => 'Expletus Sans - 700', 'google/Expletus Sans:700italic' => 'Expletus Sans - 700italic', 'google/Fanwood Text:regular' => 'Fanwood Text - regular', 'google/Fanwood Text:italic' => 'Fanwood Text - italic', 'google/Fascinate:regular' => 'Fascinate - regular', 'google/Fascinate Inline:regular' => 'Fascinate Inline - regular', 'google/Faster One:regular' => 'Faster One - regular', 'google/Fasthand:regular' => 'Fasthand - regular', 'google/Fauna One:regular' => 'Fauna One - regular', 'google/Federant:regular' => 'Federant - regular', 'google/Federo:regular' => 'Federo - regular', 'google/Felipa:regular' => 'Felipa - regular', 'google/Fenix:regular' => 'Fenix - regular', 'google/Finger Paint:regular' => 'Finger Paint - regular', 'google/Fjalla One:regular' => 'Fjalla One - regular', 'google/Fjord One:regular' => 'Fjord One - regular', 'google/Flamenco:300' => 'Flamenco - 300', 'google/Flamenco:regular' => 'Flamenco - regular', 'google/Flavors:regular' => 'Flavors - regular', 'google/Fondamento:regular' => 'Fondamento - regular', 'google/Fondamento:italic' => 'Fondamento - italic', 'google/Fontdiner Swanky:regular' => 'Fontdiner Swanky - regular', 'google/Forum:regular' => 'Forum - regular', 'google/Francois One:regular' => 'Francois One - regular', 'google/Freckle Face:regular' => 'Freckle Face - regular', 'google/Fredericka the Great:regular' => 'Fredericka the Great - regular', 'google/Fredoka One:regular' => 'Fredoka One - regular', 'google/Freehand:regular' => 'Freehand - regular', 'google/Fresca:regular' => 'Fresca - regular', 'google/Frijole:regular' => 'Frijole - regular', 'google/Fruktur:regular' => 'Fruktur - regular', 'google/Fugaz One:regular' => 'Fugaz One - regular', 'google/GFS Didot:regular' => 'GFS Didot - regular', 'google/GFS Neohellenic:regular' => 'GFS Neohellenic - regular', 'google/GFS Neohellenic:italic' => 'GFS Neohellenic - italic', 'google/GFS Neohellenic:700' => 'GFS Neohellenic - 700', 'google/GFS Neohellenic:700italic' => 'GFS Neohellenic - 700italic', 'google/Gabriela:regular' => 'Gabriela - regular', 'google/Gafata:regular' => 'Gafata - regular', 'google/Galdeano:regular' => 'Galdeano - regular', 'google/Galindo:regular' => 'Galindo - regular', 'google/Gentium Basic:regular' => 'Gentium Basic - regular', 'google/Gentium Basic:italic' => 'Gentium Basic - italic', 'google/Gentium Basic:700' => 'Gentium Basic - 700', 'google/Gentium Basic:700italic' => 'Gentium Basic - 700italic', 'google/Gentium Book Basic:regular' => 'Gentium Book Basic - regular', 'google/Gentium Book Basic:italic' => 'Gentium Book Basic - italic', 'google/Gentium Book Basic:700' => 'Gentium Book Basic - 700', 'google/Gentium Book Basic:700italic' => 'Gentium Book Basic - 700italic', 'google/Geo:regular' => 'Geo - regular', 'google/Geo:italic' => 'Geo - italic', 'google/Geostar:regular' => 'Geostar - regular', 'google/Geostar Fill:regular' => 'Geostar Fill - regular', 'google/Germania One:regular' => 'Germania One - regular', 'google/Gilda Display:regular' => 'Gilda Display - regular', 'google/Give You Glory:regular' => 'Give You Glory - regular', 'google/Glass Antiqua:regular' => 'Glass Antiqua - regular', 'google/Glegoo:regular' => 'Glegoo - regular', 'google/Gloria Hallelujah:regular' => 'Gloria Hallelujah - regular', 'google/Goblin One:regular' => 'Goblin One - regular', 'google/Gochi Hand:regular' => 'Gochi Hand - regular', 'google/Gorditas:regular' => 'Gorditas - regular', 'google/Gorditas:700' => 'Gorditas - 700', 'google/Goudy Bookletter 1911:regular' => 'Goudy Bookletter 1911 - regular', 'google/Graduate:regular' => 'Graduate - regular', 'google/Grand Hotel:regular' => 'Grand Hotel - regular', 'google/Gravitas One:regular' => 'Gravitas One - regular', 'google/Great Vibes:regular' => 'Great Vibes - regular', 'google/Griffy:regular' => 'Griffy - regular', 'google/Gruppo:regular' => 'Gruppo - regular', 'google/Gudea:regular' => 'Gudea - regular', 'google/Gudea:italic' => 'Gudea - italic', 'google/Gudea:700' => 'Gudea - 700', 'google/Habibi:regular' => 'Habibi - regular', 'google/Hammersmith One:regular' => 'Hammersmith One - regular', 'google/Hanalei:regular' => 'Hanalei - regular', 'google/Hanalei Fill:regular' => 'Hanalei Fill - regular', 'google/Handlee:regular' => 'Handlee - regular', 'google/Hanuman:regular' => 'Hanuman - regular', 'google/Hanuman:700' => 'Hanuman - 700', 'google/Happy Monkey:regular' => 'Happy Monkey - regular', 'google/Headland One:regular' => 'Headland One - regular', 'google/Henny Penny:regular' => 'Henny Penny - regular', 'google/Herr Von Muellerhoff:regular' => 'Herr Von Muellerhoff - regular', 'google/Holtwood One SC:regular' => 'Holtwood One SC - regular', 'google/Homemade Apple:regular' => 'Homemade Apple - regular', 'google/Homenaje:regular' => 'Homenaje - regular', 'google/IM Fell DW Pica:regular' => 'IM Fell DW Pica - regular', 'google/IM Fell DW Pica:italic' => 'IM Fell DW Pica - italic', 'google/IM Fell DW Pica SC:regular' => 'IM Fell DW Pica SC - regular', 'google/IM Fell Double Pica:regular' => 'IM Fell Double Pica - regular', 'google/IM Fell Double Pica:italic' => 'IM Fell Double Pica - italic', 'google/IM Fell Double Pica SC:regular' => 'IM Fell Double Pica SC - regular', 'google/IM Fell English:regular' => 'IM Fell English - regular', 'google/IM Fell English:italic' => 'IM Fell English - italic', 'google/IM Fell English SC:regular' => 'IM Fell English SC - regular', 'google/IM Fell French Canon:regular' => 'IM Fell French Canon - regular', 'google/IM Fell French Canon:italic' => 'IM Fell French Canon - italic', 'google/IM Fell French Canon SC:regular' => 'IM Fell French Canon SC - regular', 'google/IM Fell Great Primer:regular' => 'IM Fell Great Primer - regular', 'google/IM Fell Great Primer:italic' => 'IM Fell Great Primer - italic', 'google/IM Fell Great Primer SC:regular' => 'IM Fell Great Primer SC - regular', 'google/Iceberg:regular' => 'Iceberg - regular', 'google/Iceland:regular' => 'Iceland - regular', 'google/Imprima:regular' => 'Imprima - regular', 'google/Inconsolata:regular' => 'Inconsolata - regular', 'google/Inconsolata:700' => 'Inconsolata - 700', 'google/Inder:regular' => 'Inder - regular', 'google/Indie Flower:regular' => 'Indie Flower - regular', 'google/Inika:regular' => 'Inika - regular', 'google/Inika:700' => 'Inika - 700', 'google/Irish Grover:regular' => 'Irish Grover - regular', 'google/Istok Web:regular' => 'Istok Web - regular', 'google/Istok Web:italic' => 'Istok Web - italic', 'google/Istok Web:700' => 'Istok Web - 700', 'google/Istok Web:700italic' => 'Istok Web - 700italic', 'google/Italiana:regular' => 'Italiana - regular', 'google/Italianno:regular' => 'Italianno - regular', 'google/Jacques Francois:regular' => 'Jacques Francois - regular', 'google/Jacques Francois Shadow:regular' => 'Jacques Francois Shadow - regular', 'google/Jim Nightshade:regular' => 'Jim Nightshade - regular', 'google/Jockey One:regular' => 'Jockey One - regular', 'google/Jolly Lodger:regular' => 'Jolly Lodger - regular', 'google/Josefin Sans:100' => 'Josefin Sans - 100', 'google/Josefin Sans:100italic' => 'Josefin Sans - 100italic', 'google/Josefin Sans:300' => 'Josefin Sans - 300', 'google/Josefin Sans:300italic' => 'Josefin Sans - 300italic', 'google/Josefin Sans:regular' => 'Josefin Sans - regular', 'google/Josefin Sans:italic' => 'Josefin Sans - italic', 'google/Josefin Sans:600' => 'Josefin Sans - 600', 'google/Josefin Sans:600italic' => 'Josefin Sans - 600italic', 'google/Josefin Sans:700' => 'Josefin Sans - 700', 'google/Josefin Sans:700italic' => 'Josefin Sans - 700italic', 'google/Josefin Slab:100' => 'Josefin Slab - 100', 'google/Josefin Slab:100italic' => 'Josefin Slab - 100italic', 'google/Josefin Slab:300' => 'Josefin Slab - 300', 'google/Josefin Slab:300italic' => 'Josefin Slab - 300italic', 'google/Josefin Slab:regular' => 'Josefin Slab - regular', 'google/Josefin Slab:italic' => 'Josefin Slab - italic', 'google/Josefin Slab:600' => 'Josefin Slab - 600', 'google/Josefin Slab:600italic' => 'Josefin Slab - 600italic', 'google/Josefin Slab:700' => 'Josefin Slab - 700', 'google/Josefin Slab:700italic' => 'Josefin Slab - 700italic', 'google/Joti One:regular' => 'Joti One - regular', 'google/Judson:regular' => 'Judson - regular', 'google/Judson:italic' => 'Judson - italic', 'google/Judson:700' => 'Judson - 700', 'google/Julee:regular' => 'Julee - regular', 'google/Julius Sans One:regular' => 'Julius Sans One - regular', 'google/Junge:regular' => 'Junge - regular', 'google/Jura:300' => 'Jura - 300', 'google/Jura:regular' => 'Jura - regular', 'google/Jura:500' => 'Jura - 500', 'google/Jura:600' => 'Jura - 600', 'google/Just Another Hand:regular' => 'Just Another Hand - regular', 'google/Just Me Again Down Here:regular' => 'Just Me Again Down Here - regular', 'google/Kameron:regular' => 'Kameron - regular', 'google/Kameron:700' => 'Kameron - 700', 'google/Karla:regular' => 'Karla - regular', 'google/Karla:italic' => 'Karla - italic', 'google/Karla:700' => 'Karla - 700', 'google/Karla:700italic' => 'Karla - 700italic', 'google/Kaushan Script:regular' => 'Kaushan Script - regular', 'google/Kavoon:regular' => 'Kavoon - regular', 'google/Keania One:regular' => 'Keania One - regular', 'google/Kelly Slab:regular' => 'Kelly Slab - regular', 'google/Kenia:regular' => 'Kenia - regular', 'google/Khmer:regular' => 'Khmer - regular', 'google/Kite One:regular' => 'Kite One - regular', 'google/Knewave:regular' => 'Knewave - regular', 'google/Kotta One:regular' => 'Kotta One - regular', 'google/Koulen:regular' => 'Koulen - regular', 'google/Kranky:regular' => 'Kranky - regular', 'google/Kreon:300' => 'Kreon - 300', 'google/Kreon:regular' => 'Kreon - regular', 'google/Kreon:700' => 'Kreon - 700', 'google/Kristi:regular' => 'Kristi - regular', 'google/Krona One:regular' => 'Krona One - regular', 'google/La Belle Aurore:regular' => 'La Belle Aurore - regular', 'google/Lancelot:regular' => 'Lancelot - regular', 'google/Lato:100' => 'Lato - 100', 'google/Lato:100italic' => 'Lato - 100italic', 'google/Lato:300' => 'Lato - 300', 'google/Lato:300italic' => 'Lato - 300italic', 'google/Lato:regular' => 'Lato - regular', 'google/Lato:italic' => 'Lato - italic', 'google/Lato:700' => 'Lato - 700', 'google/Lato:700italic' => 'Lato - 700italic', 'google/Lato:900' => 'Lato - 900', 'google/Lato:900italic' => 'Lato - 900italic', 'google/League Script:regular' => 'League Script - regular', 'google/Leckerli One:regular' => 'Leckerli One - regular', 'google/Ledger:regular' => 'Ledger - regular', 'google/Lekton:regular' => 'Lekton - regular', 'google/Lekton:italic' => 'Lekton - italic', 'google/Lekton:700' => 'Lekton - 700', 'google/Lemon:regular' => 'Lemon - regular', 'google/Libre Baskerville:regular' => 'Libre Baskerville - regular', 'google/Libre Baskerville:italic' => 'Libre Baskerville - italic', 'google/Libre Baskerville:700' => 'Libre Baskerville - 700', 'google/Life Savers:regular' => 'Life Savers - regular', 'google/Life Savers:700' => 'Life Savers - 700', 'google/Lilita One:regular' => 'Lilita One - regular', 'google/Lily Script One:regular' => 'Lily Script One - regular', 'google/Limelight:regular' => 'Limelight - regular', 'google/Linden Hill:regular' => 'Linden Hill - regular', 'google/Linden Hill:italic' => 'Linden Hill - italic', 'google/Lobster:regular' => 'Lobster - regular', 'google/Lobster Two:regular' => 'Lobster Two - regular', 'google/Lobster Two:italic' => 'Lobster Two - italic', 'google/Lobster Two:700' => 'Lobster Two - 700', 'google/Lobster Two:700italic' => 'Lobster Two - 700italic', 'google/Londrina Outline:regular' => 'Londrina Outline - regular', 'google/Londrina Shadow:regular' => 'Londrina Shadow - regular', 'google/Londrina Sketch:regular' => 'Londrina Sketch - regular', 'google/Londrina Solid:regular' => 'Londrina Solid - regular', 'google/Lora:regular' => 'Lora - regular', 'google/Lora:italic' => 'Lora - italic', 'google/Lora:700' => 'Lora - 700', 'google/Lora:700italic' => 'Lora - 700italic', 'google/Love Ya Like A Sister:regular' => 'Love Ya Like A Sister - regular', 'google/Loved by the King:regular' => 'Loved by the King - regular', 'google/Lovers Quarrel:regular' => 'Lovers Quarrel - regular', 'google/Luckiest Guy:regular' => 'Luckiest Guy - regular', 'google/Lusitana:regular' => 'Lusitana - regular', 'google/Lusitana:700' => 'Lusitana - 700', 'google/Lustria:regular' => 'Lustria - regular', 'google/Macondo:regular' => 'Macondo - regular', 'google/Macondo Swash Caps:regular' => 'Macondo Swash Caps - regular', 'google/Magra:regular' => 'Magra - regular', 'google/Magra:700' => 'Magra - 700', 'google/Maiden Orange:regular' => 'Maiden Orange - regular', 'google/Mako:regular' => 'Mako - regular', 'google/Marcellus:regular' => 'Marcellus - regular', 'google/Marcellus SC:regular' => 'Marcellus SC - regular', 'google/Marck Script:regular' => 'Marck Script - regular', 'google/Margarine:regular' => 'Margarine - regular', 'google/Marko One:regular' => 'Marko One - regular', 'google/Marmelad:regular' => 'Marmelad - regular', 'google/Marvel:regular' => 'Marvel - regular', 'google/Marvel:italic' => 'Marvel - italic', 'google/Marvel:700' => 'Marvel - 700', 'google/Marvel:700italic' => 'Marvel - 700italic', 'google/Mate:regular' => 'Mate - regular', 'google/Mate:italic' => 'Mate - italic', 'google/Mate SC:regular' => 'Mate SC - regular', 'google/Maven Pro:regular' => 'Maven Pro - regular', 'google/Maven Pro:500' => 'Maven Pro - 500', 'google/Maven Pro:700' => 'Maven Pro - 700', 'google/Maven Pro:900' => 'Maven Pro - 900', 'google/McLaren:regular' => 'McLaren - regular', 'google/Meddon:regular' => 'Meddon - regular', 'google/MedievalSharp:regular' => 'MedievalSharp - regular', 'google/Medula One:regular' => 'Medula One - regular', 'google/Megrim:regular' => 'Megrim - regular', 'google/Meie Script:regular' => 'Meie Script - regular', 'google/Merienda:regular' => 'Merienda - regular', 'google/Merienda:700' => 'Merienda - 700', 'google/Merienda One:regular' => 'Merienda One - regular', 'google/Merriweather:300' => 'Merriweather - 300', 'google/Merriweather:300italic' => 'Merriweather - 300italic', 'google/Merriweather:regular' => 'Merriweather - regular', 'google/Merriweather:italic' => 'Merriweather - italic', 'google/Merriweather:700' => 'Merriweather - 700', 'google/Merriweather:700italic' => 'Merriweather - 700italic', 'google/Merriweather:900' => 'Merriweather - 900', 'google/Merriweather:900italic' => 'Merriweather - 900italic', 'google/Merriweather Sans:300' => 'Merriweather Sans - 300', 'google/Merriweather Sans:300italic' => 'Merriweather Sans - 300italic', 'google/Merriweather Sans:regular' => 'Merriweather Sans - regular', 'google/Merriweather Sans:italic' => 'Merriweather Sans - italic', 'google/Merriweather Sans:700' => 'Merriweather Sans - 700', 'google/Merriweather Sans:700italic' => 'Merriweather Sans - 700italic', 'google/Merriweather Sans:800' => 'Merriweather Sans - 800', 'google/Merriweather Sans:800italic' => 'Merriweather Sans - 800italic', 'google/Metal:regular' => 'Metal - regular', 'google/Metal Mania:regular' => 'Metal Mania - regular', 'google/Metamorphous:regular' => 'Metamorphous - regular', 'google/Metrophobic:regular' => 'Metrophobic - regular', 'google/Michroma:regular' => 'Michroma - regular', 'google/Milonga:regular' => 'Milonga - regular', 'google/Miltonian:regular' => 'Miltonian - regular', 'google/Miltonian Tattoo:regular' => 'Miltonian Tattoo - regular', 'google/Miniver:regular' => 'Miniver - regular', 'google/Miss Fajardose:regular' => 'Miss Fajardose - regular', 'google/Modern Antiqua:regular' => 'Modern Antiqua - regular', 'google/Molengo:regular' => 'Molengo - regular', 'google/Molle:italic' => 'Molle - italic', 'google/Monda:regular' => 'Monda - regular', 'google/Monda:700' => 'Monda - 700', 'google/Monofett:regular' => 'Monofett - regular', 'google/Monoton:regular' => 'Monoton - regular', 'google/Monsieur La Doulaise:regular' => 'Monsieur La Doulaise - regular', 'google/Montaga:regular' => 'Montaga - regular', 'google/Montez:regular' => 'Montez - regular', 'google/Montserrat:regular' => 'Montserrat - regular', 'google/Montserrat:700' => 'Montserrat - 700', 'google/Montserrat Alternates:regular' => 'Montserrat Alternates - regular', 'google/Montserrat Alternates:700' => 'Montserrat Alternates - 700', 'google/Montserrat Subrayada:regular' => 'Montserrat Subrayada - regular', 'google/Montserrat Subrayada:700' => 'Montserrat Subrayada - 700', 'google/Moul:regular' => 'Moul - regular', 'google/Moulpali:regular' => 'Moulpali - regular', 'google/Mountains of Christmas:regular' => 'Mountains of Christmas - regular', 'google/Mountains of Christmas:700' => 'Mountains of Christmas - 700', 'google/Mouse Memoirs:regular' => 'Mouse Memoirs - regular', 'google/Mr Bedfort:regular' => 'Mr Bedfort - regular', 'google/Mr Dafoe:regular' => 'Mr Dafoe - regular', 'google/Mr De Haviland:regular' => 'Mr De Haviland - regular', 'google/Mrs Saint Delafield:regular' => 'Mrs Saint Delafield - regular', 'google/Mrs Sheppards:regular' => 'Mrs Sheppards - regular', 'google/Muli:300' => 'Muli - 300', 'google/Muli:300italic' => 'Muli - 300italic', 'google/Muli:regular' => 'Muli - regular', 'google/Muli:italic' => 'Muli - italic', 'google/Mystery Quest:regular' => 'Mystery Quest - regular', 'google/Neucha:regular' => 'Neucha - regular', 'google/Neuton:200' => 'Neuton - 200', 'google/Neuton:300' => 'Neuton - 300', 'google/Neuton:regular' => 'Neuton - regular', 'google/Neuton:italic' => 'Neuton - italic', 'google/Neuton:700' => 'Neuton - 700', 'google/Neuton:800' => 'Neuton - 800', 'google/New Rocker:regular' => 'New Rocker - regular', 'google/News Cycle:regular' => 'News Cycle - regular', 'google/News Cycle:700' => 'News Cycle - 700', 'google/Niconne:regular' => 'Niconne - regular', 'google/Nixie One:regular' => 'Nixie One - regular', 'google/Nobile:regular' => 'Nobile - regular', 'google/Nobile:italic' => 'Nobile - italic', 'google/Nobile:700' => 'Nobile - 700', 'google/Nobile:700italic' => 'Nobile - 700italic', 'google/Nokora:regular' => 'Nokora - regular', 'google/Nokora:700' => 'Nokora - 700', 'google/Norican:regular' => 'Norican - regular', 'google/Nosifer:regular' => 'Nosifer - regular', 'google/Nothing You Could Do:regular' => 'Nothing You Could Do - regular', 'google/Noticia Text:regular' => 'Noticia Text - regular', 'google/Noticia Text:italic' => 'Noticia Text - italic', 'google/Noticia Text:700' => 'Noticia Text - 700', 'google/Noticia Text:700italic' => 'Noticia Text - 700italic', 'google/Noto Sans:regular' => 'Noto Sans - regular', 'google/Noto Sans:italic' => 'Noto Sans - italic', 'google/Noto Sans:700' => 'Noto Sans - 700', 'google/Noto Sans:700italic' => 'Noto Sans - 700italic', 'google/Noto Serif:regular' => 'Noto Serif - regular', 'google/Noto Serif:italic' => 'Noto Serif - italic', 'google/Noto Serif:700' => 'Noto Serif - 700', 'google/Noto Serif:700italic' => 'Noto Serif - 700italic', 'google/Nova Cut:regular' => 'Nova Cut - regular', 'google/Nova Flat:regular' => 'Nova Flat - regular', 'google/Nova Mono:regular' => 'Nova Mono - regular', 'google/Nova Oval:regular' => 'Nova Oval - regular', 'google/Nova Round:regular' => 'Nova Round - regular', 'google/Nova Script:regular' => 'Nova Script - regular', 'google/Nova Slim:regular' => 'Nova Slim - regular', 'google/Nova Square:regular' => 'Nova Square - regular', 'google/Numans:regular' => 'Numans - regular', 'google/Nunito:300' => 'Nunito - 300', 'google/Nunito:regular' => 'Nunito - regular', 'google/Nunito:700' => 'Nunito - 700', 'google/Odor Mean Chey:regular' => 'Odor Mean Chey - regular', 'google/Offside:regular' => 'Offside - regular', 'google/Old Standard TT:regular' => 'Old Standard TT - regular', 'google/Old Standard TT:italic' => 'Old Standard TT - italic', 'google/Old Standard TT:700' => 'Old Standard TT - 700', 'google/Oldenburg:regular' => 'Oldenburg - regular', 'google/Oleo Script:regular' => 'Oleo Script - regular', 'google/Oleo Script:700' => 'Oleo Script - 700', 'google/Oleo Script Swash Caps:regular' => 'Oleo Script Swash Caps - regular', 'google/Oleo Script Swash Caps:700' => 'Oleo Script Swash Caps - 700', 'google/Open Sans:300' => 'Open Sans - 300', 'google/Open Sans:300italic' => 'Open Sans - 300italic', 'google/Open Sans:regular' => 'Open Sans - regular', 'google/Open Sans:italic' => 'Open Sans - italic', 'google/Open Sans:600' => 'Open Sans - 600', 'google/Open Sans:600italic' => 'Open Sans - 600italic', 'google/Open Sans:700' => 'Open Sans - 700', 'google/Open Sans:700italic' => 'Open Sans - 700italic', 'google/Open Sans:800' => 'Open Sans - 800', 'google/Open Sans:800italic' => 'Open Sans - 800italic', 'google/Open Sans Condensed:300' => 'Open Sans Condensed - 300', 'google/Open Sans Condensed:300italic' => 'Open Sans Condensed - 300italic', 'google/Open Sans Condensed:700' => 'Open Sans Condensed - 700', 'google/Oranienbaum:regular' => 'Oranienbaum - regular', 'google/Orbitron:regular' => 'Orbitron - regular', 'google/Orbitron:500' => 'Orbitron - 500', 'google/Orbitron:700' => 'Orbitron - 700', 'google/Orbitron:900' => 'Orbitron - 900', 'google/Oregano:regular' => 'Oregano - regular', 'google/Oregano:italic' => 'Oregano - italic', 'google/Orienta:regular' => 'Orienta - regular', 'google/Original Surfer:regular' => 'Original Surfer - regular', 'google/Oswald:300' => 'Oswald - 300', 'google/Oswald:regular' => 'Oswald - regular', 'google/Oswald:700' => 'Oswald - 700', 'google/Over the Rainbow:regular' => 'Over the Rainbow - regular', 'google/Overlock:regular' => 'Overlock - regular', 'google/Overlock:italic' => 'Overlock - italic', 'google/Overlock:700' => 'Overlock - 700', 'google/Overlock:700italic' => 'Overlock - 700italic', 'google/Overlock:900' => 'Overlock - 900', 'google/Overlock:900italic' => 'Overlock - 900italic', 'google/Overlock SC:regular' => 'Overlock SC - regular', 'google/Ovo:regular' => 'Ovo - regular', 'google/Oxygen:300' => 'Oxygen - 300', 'google/Oxygen:regular' => 'Oxygen - regular', 'google/Oxygen:700' => 'Oxygen - 700', 'google/Oxygen Mono:regular' => 'Oxygen Mono - regular', 'google/PT Mono:regular' => 'PT Mono - regular', 'google/PT Sans:regular' => 'PT Sans - regular', 'google/PT Sans:italic' => 'PT Sans - italic', 'google/PT Sans:700' => 'PT Sans - 700', 'google/PT Sans:700italic' => 'PT Sans - 700italic', 'google/PT Sans Caption:regular' => 'PT Sans Caption - regular', 'google/PT Sans Caption:700' => 'PT Sans Caption - 700', 'google/PT Sans Narrow:regular' => 'PT Sans Narrow - regular', 'google/PT Sans Narrow:700' => 'PT Sans Narrow - 700', 'google/PT Serif:regular' => 'PT Serif - regular', 'google/PT Serif:italic' => 'PT Serif - italic', 'google/PT Serif:700' => 'PT Serif - 700', 'google/PT Serif:700italic' => 'PT Serif - 700italic', 'google/PT Serif Caption:regular' => 'PT Serif Caption - regular', 'google/PT Serif Caption:italic' => 'PT Serif Caption - italic', 'google/Pacifico:regular' => 'Pacifico - regular', 'google/Paprika:regular' => 'Paprika - regular', 'google/Parisienne:regular' => 'Parisienne - regular', 'google/Passero One:regular' => 'Passero One - regular', 'google/Passion One:regular' => 'Passion One - regular', 'google/Passion One:700' => 'Passion One - 700', 'google/Passion One:900' => 'Passion One - 900', 'google/Pathway Gothic One:regular' => 'Pathway Gothic One - regular', 'google/Patrick Hand:regular' => 'Patrick Hand - regular', 'google/Patrick Hand SC:regular' => 'Patrick Hand SC - regular', 'google/Patua One:regular' => 'Patua One - regular', 'google/Paytone One:regular' => 'Paytone One - regular', 'google/Peralta:regular' => 'Peralta - regular', 'google/Permanent Marker:regular' => 'Permanent Marker - regular', 'google/Petit Formal Script:regular' => 'Petit Formal Script - regular', 'google/Petrona:regular' => 'Petrona - regular', 'google/Philosopher:regular' => 'Philosopher - regular', 'google/Philosopher:italic' => 'Philosopher - italic', 'google/Philosopher:700' => 'Philosopher - 700', 'google/Philosopher:700italic' => 'Philosopher - 700italic', 'google/Piedra:regular' => 'Piedra - regular', 'google/Pinyon Script:regular' => 'Pinyon Script - regular', 'google/Pirata One:regular' => 'Pirata One - regular', 'google/Plaster:regular' => 'Plaster - regular', 'google/Play:regular' => 'Play - regular', 'google/Play:700' => 'Play - 700', 'google/Playball:regular' => 'Playball - regular', 'google/Playfair Display:regular' => 'Playfair Display - regular', 'google/Playfair Display:italic' => 'Playfair Display - italic', 'google/Playfair Display:700' => 'Playfair Display - 700', 'google/Playfair Display:700italic' => 'Playfair Display - 700italic', 'google/Playfair Display:900' => 'Playfair Display - 900', 'google/Playfair Display:900italic' => 'Playfair Display - 900italic', 'google/Playfair Display SC:regular' => 'Playfair Display SC - regular', 'google/Playfair Display SC:italic' => 'Playfair Display SC - italic', 'google/Playfair Display SC:700' => 'Playfair Display SC - 700', 'google/Playfair Display SC:700italic' => 'Playfair Display SC - 700italic', 'google/Playfair Display SC:900' => 'Playfair Display SC - 900', 'google/Playfair Display SC:900italic' => 'Playfair Display SC - 900italic', 'google/Podkova:regular' => 'Podkova - regular', 'google/Podkova:700' => 'Podkova - 700', 'google/Poiret One:regular' => 'Poiret One - regular', 'google/Poller One:regular' => 'Poller One - regular', 'google/Poly:regular' => 'Poly - regular', 'google/Poly:italic' => 'Poly - italic', 'google/Pompiere:regular' => 'Pompiere - regular', 'google/Pontano Sans:regular' => 'Pontano Sans - regular', 'google/Port Lligat Sans:regular' => 'Port Lligat Sans - regular', 'google/Port Lligat Slab:regular' => 'Port Lligat Slab - regular', 'google/Prata:regular' => 'Prata - regular', 'google/Preahvihear:regular' => 'Preahvihear - regular', 'google/Press Start 2P:regular' => 'Press Start 2P - regular', 'google/Princess Sofia:regular' => 'Princess Sofia - regular', 'google/Prociono:regular' => 'Prociono - regular', 'google/Prosto One:regular' => 'Prosto One - regular', 'google/Puritan:regular' => 'Puritan - regular', 'google/Puritan:italic' => 'Puritan - italic', 'google/Puritan:700' => 'Puritan - 700', 'google/Puritan:700italic' => 'Puritan - 700italic', 'google/Purple Purse:regular' => 'Purple Purse - regular', 'google/Quando:regular' => 'Quando - regular', 'google/Quantico:regular' => 'Quantico - regular', 'google/Quantico:italic' => 'Quantico - italic', 'google/Quantico:700' => 'Quantico - 700', 'google/Quantico:700italic' => 'Quantico - 700italic', 'google/Quattrocento:regular' => 'Quattrocento - regular', 'google/Quattrocento:700' => 'Quattrocento - 700', 'google/Quattrocento Sans:regular' => 'Quattrocento Sans - regular', 'google/Quattrocento Sans:italic' => 'Quattrocento Sans - italic', 'google/Quattrocento Sans:700' => 'Quattrocento Sans - 700', 'google/Quattrocento Sans:700italic' => 'Quattrocento Sans - 700italic', 'google/Questrial:regular' => 'Questrial - regular', 'google/Quicksand:300' => 'Quicksand - 300', 'google/Quicksand:regular' => 'Quicksand - regular', 'google/Quicksand:700' => 'Quicksand - 700', 'google/Quintessential:regular' => 'Quintessential - regular', 'google/Qwigley:regular' => 'Qwigley - regular', 'google/Racing Sans One:regular' => 'Racing Sans One - regular', 'google/Radley:regular' => 'Radley - regular', 'google/Radley:italic' => 'Radley - italic', 'google/Raleway:100' => 'Raleway - 100', 'google/Raleway:200' => 'Raleway - 200', 'google/Raleway:300' => 'Raleway - 300', 'google/Raleway:regular' => 'Raleway - regular', 'google/Raleway:500' => 'Raleway - 500', 'google/Raleway:600' => 'Raleway - 600', 'google/Raleway:700' => 'Raleway - 700', 'google/Raleway:800' => 'Raleway - 800', 'google/Raleway:900' => 'Raleway - 900', 'google/Raleway Dots:regular' => 'Raleway Dots - regular', 'google/Rambla:regular' => 'Rambla - regular', 'google/Rambla:italic' => 'Rambla - italic', 'google/Rambla:700' => 'Rambla - 700', 'google/Rambla:700italic' => 'Rambla - 700italic', 'google/Rammetto One:regular' => 'Rammetto One - regular', 'google/Ranchers:regular' => 'Ranchers - regular', 'google/Rancho:regular' => 'Rancho - regular', 'google/Rationale:regular' => 'Rationale - regular', 'google/Redressed:regular' => 'Redressed - regular', 'google/Reenie Beanie:regular' => 'Reenie Beanie - regular', 'google/Revalia:regular' => 'Revalia - regular', 'google/Ribeye:regular' => 'Ribeye - regular', 'google/Ribeye Marrow:regular' => 'Ribeye Marrow - regular', 'google/Righteous:regular' => 'Righteous - regular', 'google/Risque:regular' => 'Risque - regular', 'google/Roboto:100' => 'Roboto - 100', 'google/Roboto:100italic' => 'Roboto - 100italic', 'google/Roboto:300' => 'Roboto - 300', 'google/Roboto:300italic' => 'Roboto - 300italic', 'google/Roboto:regular' => 'Roboto - regular', 'google/Roboto:italic' => 'Roboto - italic', 'google/Roboto:500' => 'Roboto - 500', 'google/Roboto:500italic' => 'Roboto - 500italic', 'google/Roboto:700' => 'Roboto - 700', 'google/Roboto:700italic' => 'Roboto - 700italic', 'google/Roboto:900' => 'Roboto - 900', 'google/Roboto:900italic' => 'Roboto - 900italic', 'google/Roboto Condensed:300' => 'Roboto Condensed - 300', 'google/Roboto Condensed:300italic' => 'Roboto Condensed - 300italic', 'google/Roboto Condensed:regular' => 'Roboto Condensed - regular', 'google/Roboto Condensed:italic' => 'Roboto Condensed - italic', 'google/Roboto Condensed:700' => 'Roboto Condensed - 700', 'google/Roboto Condensed:700italic' => 'Roboto Condensed - 700italic', 'google/Roboto Slab:100' => 'Roboto Slab - 100', 'google/Roboto Slab:300' => 'Roboto Slab - 300', 'google/Roboto Slab:regular' => 'Roboto Slab - regular', 'google/Roboto Slab:700' => 'Roboto Slab - 700', 'google/Rochester:regular' => 'Rochester - regular', 'google/Rock Salt:regular' => 'Rock Salt - regular', 'google/Rokkitt:regular' => 'Rokkitt - regular', 'google/Rokkitt:700' => 'Rokkitt - 700', 'google/Romanesco:regular' => 'Romanesco - regular', 'google/Ropa Sans:regular' => 'Ropa Sans - regular', 'google/Ropa Sans:italic' => 'Ropa Sans - italic', 'google/Rosario:regular' => 'Rosario - regular', 'google/Rosario:italic' => 'Rosario - italic', 'google/Rosario:700' => 'Rosario - 700', 'google/Rosario:700italic' => 'Rosario - 700italic', 'google/Rosarivo:regular' => 'Rosarivo - regular', 'google/Rosarivo:italic' => 'Rosarivo - italic', 'google/Rouge Script:regular' => 'Rouge Script - regular', 'google/Ruda:regular' => 'Ruda - regular', 'google/Ruda:700' => 'Ruda - 700', 'google/Ruda:900' => 'Ruda - 900', 'google/Rufina:regular' => 'Rufina - regular', 'google/Rufina:700' => 'Rufina - 700', 'google/Ruge Boogie:regular' => 'Ruge Boogie - regular', 'google/Ruluko:regular' => 'Ruluko - regular', 'google/Rum Raisin:regular' => 'Rum Raisin - regular', 'google/Ruslan Display:regular' => 'Ruslan Display - regular', 'google/Russo One:regular' => 'Russo One - regular', 'google/Ruthie:regular' => 'Ruthie - regular', 'google/Rye:regular' => 'Rye - regular', 'google/Sacramento:regular' => 'Sacramento - regular', 'google/Sail:regular' => 'Sail - regular', 'google/Salsa:regular' => 'Salsa - regular', 'google/Sanchez:regular' => 'Sanchez - regular', 'google/Sanchez:italic' => 'Sanchez - italic', 'google/Sancreek:regular' => 'Sancreek - regular', 'google/Sansita One:regular' => 'Sansita One - regular', 'google/Sarina:regular' => 'Sarina - regular', 'google/Satisfy:regular' => 'Satisfy - regular', 'google/Scada:regular' => 'Scada - regular', 'google/Scada:italic' => 'Scada - italic', 'google/Scada:700' => 'Scada - 700', 'google/Scada:700italic' => 'Scada - 700italic', 'google/Schoolbell:regular' => 'Schoolbell - regular', 'google/Seaweed Script:regular' => 'Seaweed Script - regular', 'google/Sevillana:regular' => 'Sevillana - regular', 'google/Seymour One:regular' => 'Seymour One - regular', 'google/Shadows Into Light:regular' => 'Shadows Into Light - regular', 'google/Shadows Into Light Two:regular' => 'Shadows Into Light Two - regular', 'google/Shanti:regular' => 'Shanti - regular', 'google/Share:regular' => 'Share - regular', 'google/Share:italic' => 'Share - italic', 'google/Share:700' => 'Share - 700', 'google/Share:700italic' => 'Share - 700italic', 'google/Share Tech:regular' => 'Share Tech - regular', 'google/Share Tech Mono:regular' => 'Share Tech Mono - regular', 'google/Shojumaru:regular' => 'Shojumaru - regular', 'google/Short Stack:regular' => 'Short Stack - regular', 'google/Siemreap:regular' => 'Siemreap - regular', 'google/Sigmar One:regular' => 'Sigmar One - regular', 'google/Signika:300' => 'Signika - 300', 'google/Signika:regular' => 'Signika - regular', 'google/Signika:600' => 'Signika - 600', 'google/Signika:700' => 'Signika - 700', 'google/Signika Negative:300' => 'Signika Negative - 300', 'google/Signika Negative:regular' => 'Signika Negative - regular', 'google/Signika Negative:600' => 'Signika Negative - 600', 'google/Signika Negative:700' => 'Signika Negative - 700', 'google/Simonetta:regular' => 'Simonetta - regular', 'google/Simonetta:italic' => 'Simonetta - italic', 'google/Simonetta:900' => 'Simonetta - 900', 'google/Simonetta:900italic' => 'Simonetta - 900italic', 'google/Sintony:regular' => 'Sintony - regular', 'google/Sintony:700' => 'Sintony - 700', 'google/Sirin Stencil:regular' => 'Sirin Stencil - regular', 'google/Six Caps:regular' => 'Six Caps - regular', 'google/Skranji:regular' => 'Skranji - regular', 'google/Skranji:700' => 'Skranji - 700', 'google/Slackey:regular' => 'Slackey - regular', 'google/Smokum:regular' => 'Smokum - regular', 'google/Smythe:regular' => 'Smythe - regular', 'google/Sniglet:800' => 'Sniglet - 800', 'google/Snippet:regular' => 'Snippet - regular', 'google/Snowburst One:regular' => 'Snowburst One - regular', 'google/Sofadi One:regular' => 'Sofadi One - regular', 'google/Sofia:regular' => 'Sofia - regular', 'google/Sonsie One:regular' => 'Sonsie One - regular', 'google/Sorts Mill Goudy:regular' => 'Sorts Mill Goudy - regular', 'google/Sorts Mill Goudy:italic' => 'Sorts Mill Goudy - italic', 'google/Source Code Pro:200' => 'Source Code Pro - 200', 'google/Source Code Pro:300' => 'Source Code Pro - 300', 'google/Source Code Pro:regular' => 'Source Code Pro - regular', 'google/Source Code Pro:500' => 'Source Code Pro - 500', 'google/Source Code Pro:600' => 'Source Code Pro - 600', 'google/Source Code Pro:700' => 'Source Code Pro - 700', 'google/Source Code Pro:900' => 'Source Code Pro - 900', 'google/Source Sans Pro:200' => 'Source Sans Pro - 200', 'google/Source Sans Pro:200italic' => 'Source Sans Pro - 200italic', 'google/Source Sans Pro:300' => 'Source Sans Pro - 300', 'google/Source Sans Pro:300italic' => 'Source Sans Pro - 300italic', 'google/Source Sans Pro:regular' => 'Source Sans Pro - regular', 'google/Source Sans Pro:italic' => 'Source Sans Pro - italic', 'google/Source Sans Pro:600' => 'Source Sans Pro - 600', 'google/Source Sans Pro:600italic' => 'Source Sans Pro - 600italic', 'google/Source Sans Pro:700' => 'Source Sans Pro - 700', 'google/Source Sans Pro:700italic' => 'Source Sans Pro - 700italic', 'google/Source Sans Pro:900' => 'Source Sans Pro - 900', 'google/Source Sans Pro:900italic' => 'Source Sans Pro - 900italic', 'google/Special Elite:regular' => 'Special Elite - regular', 'google/Spicy Rice:regular' => 'Spicy Rice - regular', 'google/Spinnaker:regular' => 'Spinnaker - regular', 'google/Spirax:regular' => 'Spirax - regular', 'google/Squada One:regular' => 'Squada One - regular', 'google/Stalemate:regular' => 'Stalemate - regular', 'google/Stalinist One:regular' => 'Stalinist One - regular', 'google/Stardos Stencil:regular' => 'Stardos Stencil - regular', 'google/Stardos Stencil:700' => 'Stardos Stencil - 700', 'google/Stint Ultra Condensed:regular' => 'Stint Ultra Condensed - regular', 'google/Stint Ultra Expanded:regular' => 'Stint Ultra Expanded - regular', 'google/Stoke:300' => 'Stoke - 300', 'google/Stoke:regular' => 'Stoke - regular', 'google/Strait:regular' => 'Strait - regular', 'google/Sue Ellen Francisco:regular' => 'Sue Ellen Francisco - regular', 'google/Sunshiney:regular' => 'Sunshiney - regular', 'google/Supermercado One:regular' => 'Supermercado One - regular', 'google/Suwannaphum:regular' => 'Suwannaphum - regular', 'google/Swanky and Moo Moo:regular' => 'Swanky and Moo Moo - regular', 'google/Syncopate:regular' => 'Syncopate - regular', 'google/Syncopate:700' => 'Syncopate - 700', 'google/Tangerine:regular' => 'Tangerine - regular', 'google/Tangerine:700' => 'Tangerine - 700', 'google/Taprom:regular' => 'Taprom - regular', 'google/Tauri:regular' => 'Tauri - regular', 'google/Telex:regular' => 'Telex - regular', 'google/Tenor Sans:regular' => 'Tenor Sans - regular', 'google/Text Me One:regular' => 'Text Me One - regular', 'google/The Girl Next Door:regular' => 'The Girl Next Door - regular', 'google/Tienne:regular' => 'Tienne - regular', 'google/Tienne:700' => 'Tienne - 700', 'google/Tienne:900' => 'Tienne - 900', 'google/Tinos:regular' => 'Tinos - regular', 'google/Tinos:italic' => 'Tinos - italic', 'google/Tinos:700' => 'Tinos - 700', 'google/Tinos:700italic' => 'Tinos - 700italic', 'google/Titan One:regular' => 'Titan One - regular', 'google/Titillium Web:200' => 'Titillium Web - 200', 'google/Titillium Web:200italic' => 'Titillium Web - 200italic', 'google/Titillium Web:300' => 'Titillium Web - 300', 'google/Titillium Web:300italic' => 'Titillium Web - 300italic', 'google/Titillium Web:regular' => 'Titillium Web - regular', 'google/Titillium Web:italic' => 'Titillium Web - italic', 'google/Titillium Web:600' => 'Titillium Web - 600', 'google/Titillium Web:600italic' => 'Titillium Web - 600italic', 'google/Titillium Web:700' => 'Titillium Web - 700', 'google/Titillium Web:700italic' => 'Titillium Web - 700italic', 'google/Titillium Web:900' => 'Titillium Web - 900', 'google/Trade Winds:regular' => 'Trade Winds - regular', 'google/Trocchi:regular' => 'Trocchi - regular', 'google/Trochut:regular' => 'Trochut - regular', 'google/Trochut:italic' => 'Trochut - italic', 'google/Trochut:700' => 'Trochut - 700', 'google/Trykker:regular' => 'Trykker - regular', 'google/Tulpen One:regular' => 'Tulpen One - regular', 'google/Ubuntu:300' => 'Ubuntu - 300', 'google/Ubuntu:300italic' => 'Ubuntu - 300italic', 'google/Ubuntu:regular' => 'Ubuntu - regular', 'google/Ubuntu:italic' => 'Ubuntu - italic', 'google/Ubuntu:500' => 'Ubuntu - 500', 'google/Ubuntu:500italic' => 'Ubuntu - 500italic', 'google/Ubuntu:700' => 'Ubuntu - 700', 'google/Ubuntu:700italic' => 'Ubuntu - 700italic', 'google/Ubuntu Condensed:regular' => 'Ubuntu Condensed - regular', 'google/Ubuntu Mono:regular' => 'Ubuntu Mono - regular', 'google/Ubuntu Mono:italic' => 'Ubuntu Mono - italic', 'google/Ubuntu Mono:700' => 'Ubuntu Mono - 700', 'google/Ubuntu Mono:700italic' => 'Ubuntu Mono - 700italic', 'google/Ultra:regular' => 'Ultra - regular', 'google/Uncial Antiqua:regular' => 'Uncial Antiqua - regular', 'google/Underdog:regular' => 'Underdog - regular', 'google/Unica One:regular' => 'Unica One - regular', 'google/UnifrakturCook:700' => 'UnifrakturCook - 700', 'google/UnifrakturMaguntia:regular' => 'UnifrakturMaguntia - regular', 'google/Unkempt:regular' => 'Unkempt - regular', 'google/Unkempt:700' => 'Unkempt - 700', 'google/Unlock:regular' => 'Unlock - regular', 'google/Unna:regular' => 'Unna - regular', 'google/VT323:regular' => 'VT323 - regular', 'google/Vampiro One:regular' => 'Vampiro One - regular', 'google/Varela:regular' => 'Varela - regular', 'google/Varela Round:regular' => 'Varela Round - regular', 'google/Vast Shadow:regular' => 'Vast Shadow - regular', 'google/Vibur:regular' => 'Vibur - regular', 'google/Vidaloka:regular' => 'Vidaloka - regular', 'google/Viga:regular' => 'Viga - regular', 'google/Voces:regular' => 'Voces - regular', 'google/Volkhov:regular' => 'Volkhov - regular', 'google/Volkhov:italic' => 'Volkhov - italic', 'google/Volkhov:700' => 'Volkhov - 700', 'google/Volkhov:700italic' => 'Volkhov - 700italic', 'google/Vollkorn:regular' => 'Vollkorn - regular', 'google/Vollkorn:italic' => 'Vollkorn - italic', 'google/Vollkorn:700' => 'Vollkorn - 700', 'google/Vollkorn:700italic' => 'Vollkorn - 700italic', 'google/Voltaire:regular' => 'Voltaire - regular', 'google/Waiting for the Sunrise:regular' => 'Waiting for the Sunrise - regular', 'google/Wallpoet:regular' => 'Wallpoet - regular', 'google/Walter Turncoat:regular' => 'Walter Turncoat - regular', 'google/Warnes:regular' => 'Warnes - regular', 'google/Wellfleet:regular' => 'Wellfleet - regular', 'google/Wendy One:regular' => 'Wendy One - regular', 'google/Wire One:regular' => 'Wire One - regular', 'google/Yanone Kaffeesatz:200' => 'Yanone Kaffeesatz - 200', 'google/Yanone Kaffeesatz:300' => 'Yanone Kaffeesatz - 300', 'google/Yanone Kaffeesatz:regular' => 'Yanone Kaffeesatz - regular', 'google/Yanone Kaffeesatz:700' => 'Yanone Kaffeesatz - 700', 'google/Yellowtail:regular' => 'Yellowtail - regular', 'google/Yeseva One:regular' => 'Yeseva One - regular', 'google/Yesteryear:regular' => 'Yesteryear - regular', 'google/Zeyada:regular' => 'Zeyada - regular', );		

		return $google_fonts;

    }
	
	
}//class
}//if
?>