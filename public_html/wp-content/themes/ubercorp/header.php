<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<!--[if IE]>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" >
	<![endif]-->

	<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
	<meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
	<?php
	global $be_themes_data; // Get Backend Options
		if($be_themes_data['favicon']) {
			echo '<link rel="icon" type="image/png" href="'.$be_themes_data['favicon'].'">';
		}
	?>
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri() ?>">

    <?php 
    	if ( is_singular() ) { 
    		wp_enqueue_script( 'comment-reply' );
    	}
    	wp_head(); 
    ?>
</head>

<body <?php body_class(); ?>>
		<?php 
			$in_mobile = 'no-mobile';
			if( isset($be_themes_data['enable_header_top_in_mobile']) && 1 == $be_themes_data['enable_header_top_in_mobile'] ) {
				$in_mobile = 'show-mobile';
			}
		?>
		<?php 
		$show_top_header = get_post_meta(get_the_ID(),'be_themes_show_header_top',true);
		if(empty($show_top_header)) {
			$show_top_header = 'yes';
		}

		if($show_top_header == 'yes'):	
		?>		
		<header id="header-top" class="<?php echo $in_mobile; ?>">
			<div class="be-row be-wrap clearfix">
				<div class="left one-half column-block">
					<?php 
						empty($be_themes_data['header_top_left'])? ($left_widget = 'contact') : ($left_widget = $be_themes_data['header_top_left']);
						be_get_widget($left_widget); 
					?>
				</div>
				<div class="right one-half column-block">
					<?php 
						empty($be_themes_data['header_top_right'])? ($right_widget = 'social') : ($right_widget = $be_themes_data['header_top_right']);
						be_get_widget($right_widget);
					?>
				</div>
			</div>
		</header> <!-- END TOP HEADER WIDGETS -->
		<?php endif; ?>

		<?php 
			$be_themes_layout = 'layout-wide';
			$be_themes_sticky_header = 'header-sticky';
			if( ! empty( $be_themes_data['layout'] ) ) {
				$be_themes_layout = $be_themes_data['layout'];
			}
			if( ! empty( $be_themes_data['sticky_header'] ) ) {
				$be_themes_sticky_header = $be_themes_data['layout'];
			}

		?>			

		<div id="main" class="<?php echo $be_themes_data['layout']; ?> <?php echo $be_themes_data['sticky_header']; ?>" >

			<header id="header">
				<div id="header-wrap" class="be-wrap clearfix">
					<?php 
						$logo = get_template_directory_uri().'/img/ubercorp-logo.png';
						if( ! empty( $be_themes_data['logo'] ) ) {
							$logo = $be_themes_data['logo'];
						}  
					?>
					<div id="logo" class="left">
						 <a href="<?php echo site_url(); ?>"> <img src="<?php echo $logo; ?>" alt="" /></a>
					</div> <!-- END LOGO -->

					<nav id="navigation" class="clearfix <?php echo $be_themes_data['menu_styling']; ?>">	
					<?php $defaults = array(
							'theme_location'=>'main_nav',
							'depth'=>3,
							'container_class'=>'menu',
							'menu_id' => 'menu',
							'menu_class' => '',
						);
						wp_nav_menu( $defaults );
					?> 
					</nav><!-- End Navigation -->
				</div>
			</header> <!-- END HEADER -->

			<?php 
			$show_title_bar = get_post_meta(get_the_ID(),'be_themes_show_page_titlebar',true);
			if(empty($show_title_bar)) {
				$show_title_bar = 'yes';
			}

			if($show_title_bar == 'yes'):	
			?>

			<header id="page-title">
				<div id="page-title-wrap" class="be-wrap">
					<div class="be-row clearfix">
						<h1 class="two-third column-block"> 
							<?php get_template_part('page','title'); ?>
						</h1>

						<div id="title-widget" class="one-third column-block">
							<?php
								if( isset( $be_themes_data['enable_search_in_title'] ) && 1 == $be_themes_data['enable_search_in_title'] )	{ 
									the_widget('WP_Widget_Search');
								} 
							?>
						</div>
					</div> 
				</div>
			</header>

			<?php endif; ?>

			<?php 
			$show_breadcrumbs = get_post_meta(get_the_ID(),'be_themes_show_breadcrumbs',true);
			if(empty($show_breadcrumbs)) {
				$show_breadcrumbs = 'yes';
			}

			if($show_breadcrumbs == 'yes'):	
			?>		

			<nav id="breadcrumbs">
				<div class="be-wrap clearfix">
					<?php be_themes_breadcrumb(); ?>
				</div>
			</nav>

			<?php endif; ?>