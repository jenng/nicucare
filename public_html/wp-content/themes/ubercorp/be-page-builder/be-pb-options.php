<?php 


add_action('init','be_shortcodes_init');

function be_shortcodes_init(){

	global $be_themes_data;
	global $be_shortcode;

	$be_font_icons = array(
	'none',	
	'plus',
	'minus',
	'info',
	'left-thin',
	'up-thin',
	'right-thin',
	'down-thin',
	'level-up',
	'level-down',
	'switch',
	'infinity',
	'plus-squared',
	'minus-squared',
	'home',
	'home-1',
	'keyboard',
	'erase',
	'pause',
	'fast-forward',
	'fast-backward',
	'to-end',
	'to-start',
	'hourglass',
	'stop',
	'up-dir',
	'play',
	'right-dir',
	'down-dir',
	'left-dir',
	'adjust',
	'cloud',
	'cloud-1',
	'star',
	'star-empty',
	'cup',
	'menu',
	'moon',
	'heart-empty',
	'heart',
	'note',
	'note-beamed',
	'layout',
	'flag',
	'tools',
	'cog',
	'cog-1',
	'attention',
	'flash',
	'record',
	'cloud-thunder',
	'cog-alt',
	'tape',
	'flight',
	'mail',
	'pencil',
	'feather',
	'check',
	'cancel',
	'cancel-circled',
	'cancel-squared',
	'help',
	'quote-left',
	'quote',
	'plus-circled',
	'minus-circled',
	'right',
	'direction',
	'forward',
	'ccw',
	'cw',
	'left',
	'up',
	'down',
	'list-add',
	'list',
	'left-bold',
	'right-bold',
	'up-bold',
	'down-bold',
	'user-add',
	'help-circled',
	'info-circled',
	'eye',
	'tag',
	'upload-cloud',
	'reply',
	'reply-all',
	'code',
	'export',
	'print',
	'retweet',
	'comment',
	'chat',
	'vcard',
	'address',
	'location',
	'map',
	'compass',
	'trash',
	'doc',
	'doc-text-inv',
	'docs',
	'doc-landscape',
	'archive',
	'rss',
	'share',
	'basket',
	'shareable',
	'login',
	'logout',
	'volume',
	'resize-full',
	'resize-small',
	'popup',
	'publish',
	'window',
	'arrow-combo',
	'chart-pie',
	'language',
	'air',
	'database',
	'drive',
	'bucket',
	'thermometer',
	'down-circled',
	'left-circled',
	'right-circled',
	'up-circled',
	'left-open',
	'right-open',
	'up-open',
	'down-open-mini',
	'left-open-mini',
	'right-open-mini',
	'up-open-mini',
	'down-open-big',
	'left-open-big',
	'right-open-big',
	'up-open-big',
	'progress-0',
	'progress-1',
	'progress-2',
	'progress-3',
	'back-in-time',
	'network',
	'inbox',
	'inbox-1',
	'install',
	'lifebuoy',
	'mouse',
	'dot',
	'dot-2',
	'dot-3',
	'suitcase',
	'flow-cascade',
	'flow-branch',
	'flow-tree',
	'flow-line',
	'flow-parallel',
	'brush',
	'paper-plane',
	'magnet',
	'gauge',
	'traffic-cone',
	'cc',
	'cc-by',
	'cc-nc',
	'cc-nc-eu',
	'cc-nc-jp',
	'cc-sa',
	'cc-nd',
	'cc-pd',
	'cc-zero',
	'cc-share',
	'cc-remix',
	'hdd',
	'tasks',
	'beaker',
	'magic',
	'gauge-1',
	'sitemap',
	'desktop',
	'laptop',
	'tablet',
	'mobile-1',
	'github',
	'github-circled',
	'flickr',
	'flickr-circled',
	'vimeo',
	'vimeo-circled',
	'twitter',
	'twitter-circled',
	'facebook',
	'facebook-circled',
	'facebook-squared',
	'gplus',
	'gplus-circled',
	'pinterest',
	'pinterest-circled',
	'tumblr',
	'tumblr-circled',
	'linkedin',
	'linkedin-circled',
	'dribbble',
	'dribbble-circled',
	'stumbleupon',
	'stumbleupon-circled',
	'lastfm',
	'lastfm-circled',
	'rdio',
	'rdio-circled',
	'spotify',
	'spotify-circled',
	'qq',
	'instagram',
	'dropbox',
	'evernote',
	'flattr',
	'skype',
	'skype-circled',
	'renren',
	'sina-weibo',
	'paypal',
	'picasa',
	'soundcloud',
	'mixi',
	'behance',
	'google-circles',
	'vkontakte',
	'smashing',
	'db-shape',
	'sweden',
	'logo-db',
	'picture',
	'globe',
	'globe-1',
	'leaf',
	'leaf-1',
	'graduation-cap',
	'mic',
	'palette',
	'ticket',
	'video',
	'target',
	'music',
	'trophy',
	'thumbs-up',
	'thumbs-down',
	'bag',
	'user',
	'users',
	'lamp',
	'alert',
	'water',
	'droplet',
	'credit-card',
	'monitor',
	'briefcase',
	'floppy',
	'cd',
	'folder',
	'doc-text',
	'calendar',
	'chart-line',
	'chart-bar',
	'chart-bar-1',
	'clipboard',
	'attach',
	'bookmarks', 
	'book',
	'book-open',
	'phone',
	'megaphone',
	'megaphone-1',
	'upload',
	'download',
	'box',
	'newspaper',
	'mobile',
	'signal',
	'signal-1',
	'camera',
	'shuffle',
	'loop',
	'arrows-ccw',
	'light-down',
	'light-up',
	'mute',
	'sound',
	'battery',
	'search',
	'key',
	'key-1',
	'lock',
	'lock-open',
	'bell',
	'bookmark',
	'link',
	'back',
	'fire',
	'flashlight',
	'wrench',
	'chart-area',
	'clock',
	'rocket',
	'block'
);

	$be_shortcode['title_icon'] = array(
		'name' => __('Title with Icon', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'single',
		'backend_output'=>true,
		'options' => array(
			'style' =>array(
				'title'=>__('Style','be-themes'),
				'type'=>'select',
				'options'=> array('small','large'),
				'default'=> 'small'
			),
			'icon' =>array(
				'title'=>__('Icon','be-themes'),
				'type'=>'select',
				'options'=> $be_font_icons,
				'default'=> 'none'
			),
			'circled' =>array(
				'title'=>__('Circled ?','be-themes'),
				'type'=>'checkbox',
				'default'=> 0
			),
			'icon_bg' => array(
				'title'=> __('Background of Icon if circled','be-themes'),
				'type'=>'color',
				'default'=>$be_themes_data['color_scheme']
			),
			'icon_color' => array(
				'title'=> __('Icon Color','be-themes'),
				'type'=>'color',
				'default'=>$be_themes_data['alt_bg_text_color']
			),
			'image' => array(
				'title'=> __('Upload Custom Icon as Image','be-themes'),
				'type'=>'media',
				'default'=>'',
				'select' => 'single'
			),
			'title' => array(
				'title' => __('Title', 'be-themes'),
				'type' => 'text',
				'default' => ''
			),
			'h_tag' =>array(
				'title'=>__('Heading tag to use for Title','be-themes'),
				'type'=>'select',
				'options'=> array('h1','h2','h3','h4','h5','h6'),
				'default'=> 'h4',
			),
			'description' =>array(
				'title'=>__('Content','be-themes'),
				'type'=>'tinymce',
				'default'=> '',
				'content'=>true
			)																			
		)
	);

	$be_shortcode['portfolio'] = array(
		'name' => __('Portfolio', 'be-themes'),
		'type' => 'single',
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'options' => array(
			'col' =>array(
				'title'=>__('Number of Columns','be-themes'),
				'type'=>'select',
				'options'=> array('one','two','three','four','fullscreen'),
				'default'=> 'three'
			),
			'show_filters' =>array(
				'title'=>__('Filterable Portfolio ?','be-themes'),
				'type'=>'select',
				'options'=> array('yes','no'),
				'default'=> 'yes'
			),
			'filter' =>array(
				'title'=>__('Filter to use ?','be-themes'),
				'type'=>'select',
				'options'=> array('categories','tags'),
				'default'=> 'categories'
			),
			'category' => array(
				'title'=> __('Portfolio Categories','be-themes'),
				'type'=>'taxo',
				'taxonomy'=> 'portfolio_categories'
			),										
			'style' =>array(
				'title'=>__('Style','be-themes'),
				'type'=>'select',
				'options'=> array('show_title','no_title','overlay_title'),
				'default'=> 'show_title'
			),
			'overlay_color' => array(
				'title'=>__('Overlay Color - Works only with overlay_title style','be-themes'),
				'type'=>'color'
			),
			'pagination' =>array(
				'title'=>__('Paginate Portfolio ?','be-themes'),
				'type'=>'select',
				'options'=> array('yes','no'),
				'default'=> 'yes'
			),			
			'items_per_page' =>array(
				'title'=>__('Number of Items per page','be-themes'),
				'type'=>'text',
				'default'=> '12'
			),							
		)
	);

	$be_shortcode['text'] = array(
		'name' => __('Text Block', 'be-themes'),
		'type' => 'single',
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'backend_output'=>true,
		'options' => array(
			'text_block' =>array(
				'title'=>__('Text Block Content','be-themes'),
				'type'=>'tinymce',
				'default'=> '',
				'content'=>true
			),							
		)
	);	

	$be_shortcode['premium_sliders'] = array(
		'name' => __('Premium Sliders', 'be-themes'),
		'type' => 'single',
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'options' => array(
			'text_block' =>array(
				'title'=>__('Slider Shortcode','be-themes'),
				'type'=>'tinymce',
				'default'=> '',
				'content'=>true
			),							
		)
	);		

	$be_shortcode['separator'] = array(
		'name' => __('Divider', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'single',
		'options' => array(

			'style' =>array(
				'title'=>__('Choose a divider style','be-themes'),
				'type'=>'select',
				'options'=> array('style-1','style-2','style-3'),
				'default'=> 'style-1'
			),
			'color' => array(
				'title'=> __('Color','be-themes'),
				'type'=>'color',
			),								
		)
	);

	$be_shortcode['special_heading'] = array(
		'name' => __('Special Title / Heading', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'single',
		'backend_output'=>true,
		'options' => array(
			'title_content' =>array(
				'title'=>__('Title','be-themes'),
				'type'=>'tinymce',
				'default'=> '',
				'content'=>true
			),			
			'h_tag' =>array(
				'title'=>__('Heading tag to use for Title','be-themes'),
				'type'=>'select',
				'options'=> array('h1','h2','h3','h4','h5','h6'),
				'default'=> 'h3',
			),			
			'divider_style' =>array(
				'title'=>__('Choose a divider style','be-themes'),
				'type'=>'select',
				'options'=> array('style-1','style-2'),
				'default'=> 'style-1'
			),
			'divider_position' =>array(
				'title'=>__('Divider Position','be-themes'),
				'type'=>'select',
				'options'=> array('bottom','center'),
				'default'=> 'bottom'
			),						
			'color' => array(
				'title'=> __('Color','be-themes'),
				'type'=>'color',
			),						
		)
	);

	$be_shortcode['blockquote'] = array(
		'name' => __('Blockquote', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'single',
		'backend_output'=>true,
		'options' => array(

			'style' =>array(
				'title'=>__('Choose a blockquote style','be-themes'),
				'type'=>'select',
				'options'=> array('style-1','style-2','style-3','style-4'),
				'default'=> 'style-1'
			),
			'author' => array(
				'title' => __('Author\'s Name', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),
			'company' => array(
				'title' => __('Author\'s Company', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),						
			'author_image' => array(
				'title'=> __('Author\'s picture','be-themes'),
				'type'=>'media',
				'select'=> 'single'
			),
			'bq_content' =>array(
				'title'=>__('Blockquote Content','be-themes'),
				'type'=>'tinymce',
				'default'=> '',
				'content'=>true
			)						
		)
	);	

	$be_shortcode['video'] = array(
		'name' => __('Video', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'single',
		'options' => array(
			'source' =>array(
				'title'=>__('Choose a Video style','be-themes'),
				'type'=>'select',
				'options'=> array('youtube','vimeo'),
				'default'=> 'youtube'
			),
			'url' => array(
				'title'=> __('Enter the video url','be-themes'),
				'type'=>'text',
				'default'=> ''
			)						
		)
	);

	$be_shortcode['notifications'] = array(
		'name' => __('Notifications', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'single',
		'backend_output'=> true,
		'options' => array(
			'type' =>array(
				'title'=>__('Type of Notification','be-themes'),
				'type'=>'select',
				'options'=> array('success','error','information','warning'),
				'default'=> 'success'
			),
			'notice' => array(
				'title'=> __('Notification Content','be-themes'),
				'type'=>'tinymce',
				'default'=> '',
				'content'=>true
			)						
		)
	);

	$be_shortcode['dropcap'] = array(
		'name' => __('Dropcaps', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'single',
		'backend_output'=>true,
		'options' => array(
			'letter'=>array(
				'title'=>__('Letter to be Dropcapped','be-themes'),
				'type'=>'text',
				'default'=> ''
			),
			'icon' =>array(
				'title'=>__('Icon to be Dropcapped  - prioritized over letter ','be-themes'),
				'type'=>'select',
				'options'=> $be_font_icons,
				'default'=> 'none'
			),			
			'type' =>array(
				'title'=>__('Dropcap Style','be-themes'),
				'type'=>'select',
				'options'=> array('circle','square','letter'),
				'default'=> 'circle'
			),
			'size' =>array(
				'title'=>__('Dropcap Size','be-themes'),
				'type'=>'select',
				'options'=> array('small','big'),
				'default'=> 'small'
			),
			'color' =>array(
				'title'=>__('Dropcap Color','be-themes'),
				'type'=>'color',
				'default'=> $be_themes_data['color_scheme']
			),						
			'dropcap_content' => array(
				'title'=> __('Dropcap Content','be-themes'),
				'type'=>'tinymce',
				'default'=> '',
				'content'=>true
			)						
		)
	);						


	$be_shortcode['button'] = array(
		'name' => __('Buttons', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'single',
		'backend_output'=> true,
		'options' => array(
			'button_text' =>array(
				'title'=>__('Button Text','be-themes'),
				'type'=>'text',
				'default'=> ''
			),			
			'type' =>array(
				'title'=>__('Button Size','be-themes'),
				'type'=>'select',
				'options'=> array('small','medium','large'),
				'default'=> 'small'
			),
			'gradient' =>array(
				'title'=>__('Gradient ?','be-themes'),
				'type'=>'checkbox',
				'default'=> '1'
			),
			'rounded' =>array(
				'title'=>__('Rounded Corners ?','be-themes'),
				'type'=>'checkbox',
				'default'=> '1'
			),
			'icon' =>array(
				'title'=>__('Button Icon','be-themes'),
				'type'=>'select',
				'options'=> $be_font_icons,
				'default'=> 'none'
			),									
			'color' =>array(
				'title'=>__('Default background Color','be-themes'),
				'type'=>'color',
				'default'=> $be_themes_data['color_scheme']
			),
			'hover' =>array(
				'title'=>__('Hover Background Color','be-themes'),
				'type'=>'color',
				'default'=> '#323232'
			),									
			'url' => array(
				'title'=> __('Button Links to','be-themes'),
				'type'=>'text',
				'default'=> 'http://www.mojo-themes.com'
			)						
		)
	);

 	$be_shortcode['services'] = array(
		'name' => __('Services', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'single',
		'backend_output'=>true,
		'options' => array(
			'description' => array(
				'title' => __('Description', 'be-themes'),
				'type' => 'tinymce',
				'default' => __('', 'be-themes'),
				'content'=>true
			),
			'icon' =>array(
				'title'=>__('Icon','be-themes'),
				'type'=>'select',
				'options'=> $be_font_icons,
				'default'=> 'none'
			),
			'circled' =>array(
				'title'=>__('Circled ?','be-themes'),
				'type'=>'checkbox',
				'default'=> 0
			),
			'icon_bg' => array(
				'title'=> __('Background of Icon if circled','be-themes'),
				'type'=>'color',
				'default'=>$be_themes_data['color_scheme']
			),
			'icon_color' => array(
				'title'=> __('Icon Color','be-themes'),
				'type'=>'color',
				'default'=>$be_themes_data['alt_bg_text_color']
			),						
			'image' => array(
				'title'=> __('Upload image - Has priority over icon','be-themes'),
				'type'=>'media',
				'select'=> 'single'
			),
			'background' => array(
				'title'=> __('Background Color of the box','be-themes'),
				'type'=>'color'
			),
			'border_size' => array(
				'title'=> __('Border Size (only numbers)','be-themes'),
				'type'=>'text',
				'default'=> ''
			),			
			'border_color' => array(
				'title'=> __('Border Color of box','be-themes'),
				'type'=>'color'
			),					
			'style' =>array(
				'title'=>__('Choose a Services style','be-themes'),
				'type'=>'select',
				'options'=> array('style-1','style-2'),
				'default'=> 'style-1'
			),
			'button_text' => array(
				'title' => __('Button Text', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),
			'button_link' => array(
				'title' => __('Button HyperLink', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),
			'button_type' =>array(
				'title'=>__('Button Style','be-themes'),
				'type'=>'select',
				'options'=> array('link','small','medium','large'),
				'default'=> 'link'
			)														
									
		)
	);


 	$be_shortcode['team'] = array(
		'name' => __('Team', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'single',
		'backend_output'=>true,
		'options' => array(
			'title' => array(
				'title' => __('Title', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),
			'h_tag' =>array(
				'title'=>__('Heading tag to use for Title','be-themes'),
				'type'=>'select',
				'options'=> array('h1','h2','h3','h4','h5','h6'),
				'default'=> 'h3',
			),			
			'description' => array(
				'title' => __('Description', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),			
			'image' => array(
				'title'=> __('Upload Team Member image','be-themes'),
				'type'=>'media',
				'select'=> 'single'
			),
			'designation' => array(
				'title' => __('Designation', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),		
			'facebook' => array(
				'title' => __('Facebook Profile Url', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),
			'twitter' => array(
				'title' => __('Twitter Profile Url', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),
			'google_plus' => array(
				'title' => __('Google Plus Url', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),
			'linkedin' => array(
				'title' => __('Linked In Profile Url', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),
			'youtube' => array(
				'title' => __('Youtube Profile Url', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),
			'vimeo' => array(
				'title' => __('Vimeo Profile Url', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),									
			'dribbble' => array(
				'title' => __('Dribbble Profile Url', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			)																		
									
		)
	);	

 	$be_shortcode['call_to_action'] = array(
		'name' => __('Call to Action Box', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'single',
		'backend_output'=>true,
		'options' => array(
			'title' => array(
				'title' => __('Title', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),		
			'description' => array(
				'title' => __('Description', 'be-themes'),
				'type' => 'tinymce',
				'content'=> true,
				'default' => __('', 'be-themes')
			),
			'h_tag' =>array(
				'title'=>__('Heading tag to use for Title','be-themes'),
				'type'=>'select',
				'options'=> array('h1','h2','h3','h4','h5','h6'),
				'default'=> 'h4',
			),
			'new_tab' =>array(
				'title'=>__('Open Link in New Tab','be-themes'),
				'type'=>'select',
				'options'=> array('yes','no'),
				'default'=> 'no',
			),
			'button_text' => array(
				'title' => __('Button Text', 'be-themes'),
				'type' => 'text',
				'default' => __('Click Here', 'be-themes')
			),
			'button_link' => array(
				'title' => __('Url to be linked to the button', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),
			'button_color' =>array(
				'title'=>__('Button Color','be-themes'),
				'type'=>'color',
				'default'=> $be_themes_data['color_scheme']
			),
			'background_color' =>array(
				'title'=>__('Background Color','be-themes'),
				'type'=>'color',
				'default'=> ''
			),
			'title_color' =>array(
				'title'=>__('Title Color','be-themes'),
				'type'=>'color',
				'default'=> ''
			),			
			'pattern' =>array(
				'title'=>__('Background Pattern ?','be-themes'),
				'type'=>'checkbox',
				'default'=> 0
			)													
									
		)
	);			       

	$be_shortcode['tabs'] = array(
		'name' => __('Tabs', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi',
		'multi_field'=> true,
		'single_field'=>'tab'		
	);

	$be_shortcode['tab'] = array(
		'name' => __('Tab', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi_single',			
		'options' => array(
			'title' => array(
				'title'=> __('Tab Title','be-themes'),
				'type'=>'text'
			),
			'icon' => array(
				'title'=> __('Choose an icon','be-themes'),
				'type'=>'select',
				'options'=> $be_font_icons  //array('none','twitter','facebook'),	
			),
			'tab_content' => array(
				'title'=> __('Tab Content','be-themes'),
				'type'=>'tinymce',
				'default'=>'',
				'content'=>true
			), 							
		)		
	);	

	$be_shortcode['accordion'] = array(
		'name' => __('Accordion', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi',
		'multi_field'=> true,
		'single_field'=>'toggle',
		'options' => array(
			'style' => array(
				'title'=> __('Style','be-themes'),
				'type'=>'select',
				'options'=>array('accordion','collapsed')
			)
		)			
	);

	$be_shortcode['toggle'] = array(
		'name' => __('Toggle', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi_single',
		'options' => array(
			'title' => array(
				'title'=> __('Accordion Title','be-themes'),
				'type'=>'text'
			),
			'accordion_content' => array(
				'title'=> __('Accordion Content','be-themes'),
				'type'=>'tinymce',
				'default'=>'',
				'content'=>true
			)								
		)		
	);

	$be_shortcode['skills'] = array(
		'name' => __('Skills Bar', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi',
		'multi_field'=> true,
		'single_field'=>'skill'		
	);

	$be_shortcode['skill'] = array(
		'name' => __('Skill', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi_single',
		'options' => array(
			'title' => array(
				'title'=> __('Skill Name','be-themes'),
				'type'=>'text',
			),
			'value' => array(
				'title'=> __('Skill Score in %','be-themes'),
				'type'=>'text',
				'default'=>'50',
			),
			'fill_color' => array(
				'title'=> __('Fill Color','be-themes'),
				'type'=>'color',
				'default'=>$be_themes_data['color_scheme'],
			),
			'bg_color' => array(
				'title'=> __('Background Color','be-themes'),
				'type'=>'color',
				'default'=>$be_themes_data['sec_bg'],
			), 			  							
		)		
	);

	$be_shortcode['lists'] = array(
		'name' => __('Custom Lists', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi',
		'multi_field'=> true,
		'single_field'=>'list'		
	);

	$be_shortcode['list'] = array(
		'name' => __('Custom List Item', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi_single',
		'options' => array(
			'icon' =>array(
				'title'=>__('Icon','be-themes'),
				'type'=>'select',
				'options'=> $be_font_icons,
				'default'=> 'none'
			),
			'circled' =>array(
				'title'=>__('Circled ?','be-themes'),
				'type'=>'checkbox',
				'default'=> 0
			),
			'icon_bg' => array(
				'title'=> __('Background of Icon if circled','be-themes'),
				'type'=>'color',
				'default'=>$be_themes_data['color_scheme']
			),
			'icon_color' => array(
				'title'=> __('Icon Color','be-themes'),
				'type'=>'color',
				'default'=>$be_themes_data['alt_bg_text_color']
			),
			'list_content' =>array(
				'title'=>__('Content','be-themes'),
				'type'=>'tinymce',
				'default'=> '',
				'content'=>true
			)																							
		)
	);		



	$be_shortcode['flex_slider'] = array(
		'name' => __('Flex Slider', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi',
		'multi_field'=> true,
		'single_field'=>'flex_slide',
		'options' => array(
			'animation' => array(
				'title'=> __('Animation style','be-themes'),
				'type'=>'select',
				'options' => array('slide','fade'),
				'default'=>'slide'
			),
			'auto_slide' => array(
				'title'=> __('Auto Slide','be-themes'),
				'type'=>'select',
				'options' => array('yes','no'),
				'default'=>'no'
			),
			'slide_interval' => array(
				'title'=> __('Slide Interval in milli secs if auto slide is enabled','be-themes'),
				'type'=>'text',
			)					
		)		
	);

	$be_shortcode['flex_slide'] = array(
		'name' => __('Slide', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi_single',			
		'options' => array(
			'image' => array(
				'title'=> __('Choose a slider image','be-themes'),
				'type'=>'media',
				'default'=>'',
				'select' => 'single'
			),
			'video' => array(
				'title'=> __('Enter Youtube/ Vimeo url if you wish to have video in the slide','be-themes'),
				'type'=>'text',
			),
			'show_title' => array(
				'title'=> __('Show Title ?','be-themes'),
				'type'=>'select',
				'options'=>array('yes','no'),
				'default'=>'no'	
			),
			'show_caption' => array(
				'title'=> __('Show Caption ?','be-themes'),
				'type'=>'select',
				'options'=>array('yes','no'),
				'default'=>'no'		
			), 				
			'title' => array(
				'title'=> __('Title','be-themes'),
				'type'=>'text',
			),
			'caption' => array(
				'title'=> __('Caption','be-themes'),
				'type'=>'text',
			)										
		)		
	);

	$be_shortcode['testimonials'] = array(
		'name' => __('Testimonials', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi',
		'multi_field'=> true,
		'single_field'=>'testimonial',
		'options' => array(
			'animation' => array(
				'title'=> __('Animation style','be-themes'),
				'type'=>'select',
				'options' => array('slide','fade'),
				'default'=>'fade'
			),
			'slide_interval' => array(
				'title'=> __('Slide Interval in milli secs if auto slide is enabled','be-themes'),
				'type'=>'text',
			)				
		)		
	);
	
	$be_shortcode['testimonial'] = array(
		'name' => __('Testimonial', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi_single',			
		'options' => array(
			'image' => array(
				'title'=> __('Choose a Testimonial Author image','be-themes'),
				'type'=>'media',
				'default'=>'',
				'select' => 'single'
			),				
			'author' => array(
				'title'=> __('Author','be-themes'),
				'type'=>'text',
			),
			'company' => array(
				'title'=> __('Company','be-themes'),
				'type'=>'text',
			),
			'description' => array(
				'title'=> __('Testimonial Content','be-themes'),
				'type'=>'tinymce',
				'content'=> true,
			)										
		)		
	);

	$be_shortcode['project_details'] = array(
		'name' => __('Portfolio Details', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'single'
	);

	$be_shortcode['linebreak'] = array(
		'name' => __('Extra Spacing', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'single',
		'options' => array(
			'height' => array(
				'title'=> __('Height of blank space (only numbers)','be-themes'),
				'type'=>'text',
				'default'=>'',
			)
		)			
	);	 

	$be_shortcode['clients'] = array(
		'name' => __('Clients', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi',
		'multi_field'=> true,
		'single_field'=>'client'		
	);	

	$be_shortcode['client'] = array(
		'name' => __('Client', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi_single',			
		'options' => array(
			'image' => array(
				'title'=> __('Choose a Client image','be-themes'),
				'type'=>'media',
				'default'=>'',
				'select' => 'single'
			),
			'link' => array(
				'title'=> __('Link to Client Website','be-themes'),
				'type'=>'text',
			),
			'new_tab' => array(
				'title'=> __('Open Link in New tab','be-themes'),
				'type'=>'select',
				'options'=>array('yes','no'),
				'default'=>'yes'
			)									
		)		
	);

	$be_shortcode['recent_projects'] = array(
		'name' => __('Recent Projects', 'be-themes'),
		'type' => 'single',
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'options' => array(
			'number' => array(
				'title'=> __('Number of Items','be-themes'),
				'type'=>'select',
				'options'=>array('three','four'),
				'default'=>'three'
			)							
		)
	);

	$be_shortcode['recent_posts'] = array(
		'name' => __('Recent Posts', 'be-themes'),
		'type' => 'single',
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'options' => array(
			'number' => array(
				'title'=> __('Number of Items','be-themes'),
				'type'=>'select',
				'options'=>array('three','four'),
				'default'=>'three'
			)							
		)
	);	

	$be_shortcode['section'] = array(
		'name' => __('Section Settings', 'be-themes'),
		'type' => 'single',
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'options' => array(
			'bg_color' => array(
				'title'=> __('Background Color','be-themes'),
				'type'=>'color',
				'default'=>''
			),			
			'bg_image' => array(
				'title'=> __('Background Image','be-themes'),
				'type'=>'media',
				'default'=>'',
				'select' => 'single'
			),
			'bg_repeat' => array(
				'title'=> __('Background Repeat','be-themes'),
				'type'=>'select',
				'options'=>array('repeat','repeat-x','four','repeat-y', 'no-repeat'),
				'default'=>'repeat'
			),
			'bg_attachment' => array(
				'title'=> __('Background Attachment','be-themes'),
				'type'=>'select',
				'options'=>array('scroll','fixed'),
				'default'=>'scroll'
			),
			'bg_position' => array(
				'title'=> __('Background Position','be-themes'),
				'type'=>'select',
				'options'=>array('top left','top top right','top center', 'center left', 'center right', 'center center','bottom left','bottom right','bottom center'),
				'default'=>'top left'
			),
			'bg_stretch' =>array(
				'title'=>__('Center Scale Image to occupy container','be-themes'),
				'type'=>'checkbox',
				'default'=> '',
			),				
			'border_size' => array(
				'title'=> __('Border Size (only numbers)','be-themes'),
				'type'=>'text',
				'default'=> '1'
			),
			'border_color' => array(
				'title'=> __('Border Color','be-themes'),
				'type'=>'color',
				'default'=>''
			),
			'padding_top' => array(
				'title'=> __('Top Padding','be-themes'),
				'type'=>'text',
				'default'=> '50'
			),
			'padding_bottom' => array(
				'title'=> __('Bottom Padding','be-themes'),
				'type'=>'text',
				'default'=> '50'
			)																							
		)
	);	

	$be_shortcode['row'] = array(
		'name' => __('Row Settings', 'be-themes'),
		'type' => 'single',
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'options' => array(
			'no_wrapper' =>array(
				'title'=>__('No Wrap ?','be-themes'),
				'type'=>'checkbox',
				'default'=> ''
			),
			'no_margin_bottom' =>array(
				'title'=>__('Zero Bottom Margin ?','be-themes'),
				'type'=>'checkbox',
				'default'=> ''
			),					
		)
	);

	$be_shortcode['pricing_column'] = array(
		'name' => __('Pricing Table', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi',
		'multi_field'=> true,
		'single_field'=>'pricing_feature',
		'options' => array(
			'title' => array(
				'title' => __('Title', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),		
			'h_tag' =>array(
				'title'=>__('Heading tag to use for Title','be-themes'),
				'type'=>'select',
				'options'=> array('h1','h2','h3','h4','h5','h6'),
				'default'=> 'h4',
			),
			'price' => array(
				'title' => __('Price', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),						
			'duration' => array(
				'title' => __('Duration', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),
			'currency' => array(
				'title' => __('Currency', 'be-themes'),
				'type' => 'text',
				'default' => __('$', 'be-themes')
			),				
			'button_text' => array(
				'title' => __('Button Text', 'be-themes'),
				'type' => 'text',
				'default' => __('Click Here', 'be-themes')
			),
			'button_link' => array(
				'title' => __('Url to be linked to the button', 'be-themes'),
				'type' => 'text',
				'default' => __('', 'be-themes')
			),
			'button_color' =>array(
				'title'=>__('Button Color','be-themes'),
				'type'=>'color',
				'default'=> $be_themes_data['color_scheme']
			),
			'highlight' =>array(
				'title'=>__('Highlight Column','be-themes'),
				'type'=>'select',
				'options'=> array('yes','no'),
				'default'=> 'no',
			),
			'style' =>array(
				'title'=>__('Style Options','be-themes'),
				'type'=>'select',
				'options'=> array('style-1','style-2'),
				'default'=> 'style-1',
			)																
		)				
	);

	$be_shortcode['pricing_feature'] = array(
		'name' => __('Pricing Feature', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'multi_single',			
		'options' => array(
			'feature' => array(
				'title'=> __('Feature','be-themes'),
				'type'=>'text',
			)									
		)		
	);

	$be_shortcode['gmaps'] = array(
		'name' => __('Google Map', 'be-themes'),
		'type' => 'single',
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'options' => array(
			'address' => array(
				'title'=> __('Address','be-themes'),
				'type'=>'text',
				'default'=>'',
			),
			'height' => array(
				'title'=> __('Height in px (only numbers)','be-themes'),
				'type'=>'text',
				'default'=>'300',
			),
			'zoom' => array(
				'title'=> __('Zoom value','be-themes'),
				'type'=>'text',
				'default'=>'20',
			),															
		)
	);

	$be_shortcode['icon'] = array(
		'name' => __('Font Icons', 'be-themes'),
		'type' => 'single',
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'options' => array(
			'name' =>array(
				'title'=>__('Icon','be-themes'),
				'type'=>'select',
				'options'=> $be_font_icons,
				'default'=> 'none'
			),
			'size' =>array(
				'title'=>__('Size','be-themes'),
				'type'=>'select',
				'options'=> array('small','medium','large'),
				'default'=> 'small',
			),			
			'style' =>array(
				'title'=>__('Style','be-themes'),
				'type'=>'select',
				'options'=> array('plain','square','circle'),
				'default'=> 'circle',
			),
			'color' => array(
				'title'=> __('Icon Color','be-themes'),
				'type'=>'color',
				'default'=>$be_themes_data['alt_bg_text_color'],
			),			
			'bg_color' => array(
				'title'=> __('Background of Icon if circled/ Square','be-themes'),
				'type'=>'color',
				'default'=>$be_themes_data['color_scheme'],
			),
			'hover_color' => array(
				'title'=> __('Icon Color during Mouse Over','be-themes'),
				'type'=>'color',
				'default'=>'#ffffff',
			),			
			'hover_bg_color' => array(
				'title'=> __('Background Color of Icon during hover','be-themes'),
				'type'=>'color',
				'default'=>'#3a3a3a',
			),
			'href' => array(
				'title'=> __('Icon Link URL','be-themes'),
				'type'=>'text',
				'default'=>'',
			),							
														
		)
	);	

	$be_shortcode['lightbox_image'] = array(
		'name' => __('Lightbox Image', 'be-themes'),
		'icon' => BE_PAGE_BUILDER_URL.'/images/shortcodes/icon.png',
		'type' => 'single',			
		'options' => array(
			'image' => array(
				'title'=> __('Choose a thumbnail image','be-themes'),
				'type'=>'media',
				'default'=>'',
				'select' => 'single'
			),
			'link' => array(
				'title'=> __('Enter the url the image needs to link to (optional)','be-themes'),
				'type'=>'text',
			),									
		)		
	);							

}

?>