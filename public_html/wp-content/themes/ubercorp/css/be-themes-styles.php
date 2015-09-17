/* ======================
    Backgrounds
   ====================== */

body {
    <?php be_themes_set_backgrounds('body'); ?>
}

#header-top {
    <?php be_themes_set_backgrounds('header_top'); ?>
}

#header {
    <?php be_themes_set_backgrounds('header'); ?>
}

#page-title {
    <?php be_themes_set_backgrounds('page_title_background'); ?>
}

#footer {
    <?php be_themes_set_backgrounds('footer'); ?>
}

#content , #breadcrumbs{
    <?php be_themes_set_backgrounds('content'); ?>
}

#bottom-widgets{
    <?php be_themes_set_backgrounds('bottom_widgets'); ?>
    border-top: 3px solid <?php echo $be_themes_data['color_scheme']; ?>;
}

#header-top{
    border-bottom: 3px solid <?php echo $be_themes_data['color_scheme']; ?>;
}

<?php 

if(!isset($be_themes_data['content']['none'])) {  ?>
    .special-h-tag, ul.tabs li.ui-tabs-active, .separator.style-2:after {
         <?php be_themes_set_backgrounds('content'); ?>
    }
<?php } 

else{ ?>
    .special-h-tag, ul.tabs li.ui-tabs-active, .separator.style-2:after {
         <?php be_themes_set_backgrounds('body'); ?>
    }
<?php } ?>



/* ======================
    Typography
   ====================== */

body{
    <?php be_themes_print_typography('body_text'); ?>
}

#header-top{
  color: <?php echo $be_themes_data['header_top_color']; ?>; 
}   


h1{
     <?php be_themes_print_typography('h1'); ?>
}

h2{
    <?php be_themes_print_typography('h2'); ?>
}
h3{
    <?php be_themes_print_typography('h3'); ?>
}
h4{
    <?php be_themes_print_typography('h4'); ?>
}

h5{
    <?php be_themes_print_typography('h5'); ?>
}
h6{
    <?php be_themes_print_typography('h6'); ?>
}
.post-title a, .fn a, .post-title a:visited{
  color: <?php echo $be_themes_data['post-title-color']; ?>; 
}
#navigation{
    <?php be_themes_print_typography('navigation_text'); ?>
}
#footer{
    <?php be_themes_print_typography('footer_text'); ?>
}

#page-title h1{
    <?php be_themes_print_typography('page_title'); ?>
}

#bottom-widgets{
    <?php be_themes_print_typography('bottom_widget_text'); ?>
}
.sidebar-widgets{
	<?php be_themes_print_typography('sidebar_widget_text'); ?>
}

.ui-accordion .font-icon, ul.tabs li h6 { font-size: <?php echo $be_themes_data['body_text']['size']; ?> !important; }

.breadcrumbs a, .breadcrumbs a:visited { color: <?php echo $be_themes_data['body_text']['color']; ?> !important; } 

/* ======================
    Layout 
   ====================== */

#header-top{
    margin-bottom: <?php echo $be_themes_data['top_header_bottom_margin'].'px' ?>;
}   

#logo{
	margin-top: <?php echo $be_themes_data['logo_top_margin'].'px' ?>;
	margin-bottom: <?php echo $be_themes_data['logo_bottom_margin'].'px' ?>;
}

#navigation{
  <?php
    $logo_id = get_attachment_id_from_src($be_themes_data['logo']);
    $logo = wp_get_attachment_image_src($logo_id,'full');
    $logo_height = 26;
    if( isset( $logo[2] ) || !empty( $logo[2] ) ) {
      $logo_height = $logo[2];
    }
    $logo_height = $be_themes_data['logo_top_margin']+$be_themes_data['logo_bottom_margin']+$logo_height;
  ?>
   line-height: <?php echo $logo_height; ?>px;
}

#page-title h1{
	margin-top: <?php echo $be_themes_data['page_title_top_margin'].'px' ?>;
	margin-bottom: <?php echo $be_themes_data['page_title_bottom_margin'].'px' ?>;
} 
.left-sidebar-page,.right-sidebar-page,.dual-sidebar-page, .no-sidebar-page .be-section:first-child, .page-template-page-940-php #content {
    padding-top: <?php echo $be_themes_data['content_top_margin'].'px' ?>;
}  
.left-sidebar-page .be-section:first-child, .right-sidebar-page .be-section:first-child, .dual-sidebar-page .be-section:first-child {
    padding-top:0 !important;
}


/* ======================
    Colors 
   ====================== */



.sec-bg,
.tagcloud a,
input[type="text"],
input[type="email"], 
input[type="password"],
.pages_list a,
blockquote,
textarea,
th, 
.photostream ul li a img,
.post-tags a {
    background: <?php echo $be_themes_data['sec_bg']; ?>;
}


.sec-color,
.tagcloud a,
input[type="text"],
input[type="email"], 
input[type="password"],
.pages_list a,
blockquote,
.pagination a:visited,
textarea ,
th,
.post-tags a {
    color: <?php echo $be_themes_data['sec_color']; ?>;
}

.sec-border,
.tagcloud a,
input[type="text"],
input[type="email"], 
input[type="password"],
blockquote,
textarea,
table ,
.post-tags a{
    border: 1px solid <?php echo $be_themes_data['sec_border_color']; ?>;
}

.sec-border-bottom{
    border-bottom: 1px solid <?php echo $be_themes_data['sec_border_color']; ?>;
}

#bottom-widgets .sec-bg, .tagcloud a,.photostream ul li a img, blockquote {
  background: <?php echo $be_themes_data['bottom_widget_sec_bg']; ?>;
}
#bottom-widgets .sec-color, .tagcloud a, blockquote {
  color: <?php echo $be_themes_data['bottom_widget_sec_color']; ?>;
}
#bottom-widgets .sec-border ,.tagcloud a,.photostream ul li a img, blockquote {
  border: 1px solid <?php echo $be_themes_data['bottom_widget_sec_border_color']; ?>;
}
#bottom-widgets .sec-title-color {
  color: <?php echo $be_themes_data['bottom_widget_sec_title_color']; ?>;
}
#bottom-widgets h5 {
  color: <?php echo $be_themes_data['bottom_widgets_title_color']; ?>;
}

.alt-color,
li.ui-tabs-active h6 a,
#navigation.style1 a:hover,
#navigation.style1 .current-menu-item > a,
#navigation.style1 .current-menu-ancestor > a,
a,
a:visited,
.social_media_icons a:hover,
.post-title a:hover,
.fn a:hover,
.pricing-table .price,
a.team_icons:hover,
.portfolio.one-col .portfolio-title a:hover {
    color: <?php echo $be_themes_data['color_scheme']; ?>;
}

.ui-accordion-header-active a {
	color: <?php echo $be_themes_data['color_scheme']; ?> !important;
}

.alt-bg,
input[type="submit"],
.tagcloud a:hover,
.pagination a:hover,
.post-tags a:hover,
#navigation.style2 ul li a:hover,
#navigation.style2 .current-menu-item > a,
#navigation.style2 .current-menu-ancestor > a {
    background-color: <?php echo $be_themes_data['color_scheme']; ?>;
    transition: 0.2s linear all;
}
.three-col .be-hoverlay .element-inner .portfolio-title.hover,
.four-col .be-hoverlay .element-inner .portfolio-title.hover,
.two-col .be-hoverlay .element-inner .portfolio-title.hover,
.fullscreen-col .be-hoverlay .element-inner .portfolio-title.hover,
.related-items .be-hoverlay .element-inner .portfolio-title.hover {
	background-color: <?php echo $be_themes_data['color_scheme']; ?>;
}
.alt-bg-text-color,
input[type="submit"],
.tagcloud a:hover,
.pagination a:hover,
.post-tags a:hover,
#navigation.style2 .current-menu-item > a,
#navigation.style2 .current-menu-ancestor > a {
    color: <?php echo $be_themes_data['alt_bg_text_color'];  ?> !important;
    transition: 0.2s linear all;
}
.three-col .be-hoverlay .element-inner .portfolio-title a.hover,
.two-col .be-hoverlay .element-innerover .portfolio-title a.hover,
.four-col .be-hoverlay .element-inner .portfolio-title a.hover,
.fullscreen-col .be-hoverlay .element-inner .portfolio-title a.hover,
.related-items .be-hoverlay .element-inner .portfolio-title a.hover {
	color: <?php echo $be_themes_data['alt_bg_text_color'];  ?> !important;
}

.thumb-icons a {
	background-color: <?php echo $be_themes_data['color_scheme']; ?>;
	transition: 0.2s linear all;
}
.thumb-icons a {
	color: <?php echo $be_themes_data['alt_bg_text_color'];  ?>;
	transition: 0.2s linear all;
}
.thumb-icons a:hover{
	color: <?php echo $be_themes_data['color_scheme']; ?>;
}
.thumb-icons a:hover {
	background-color: <?php echo $be_themes_data['alt_bg_text_color'];  ?>;
}
.overlay-thumb-icons a,.overlay-thumb-title a,.overlay-thumb-title span {
	color: <?php echo $be_themes_data['alt_bg_text_color'];  ?>;
}

.filters span, .project_navigation{
    border-top:1px solid <?php echo $be_themes_data['sec_border_color']; ?>;
    border-bottom:1px solid <?php echo $be_themes_data['sec_border_color']; ?>;
}

.filters .current_choice{
   border-top:1px solid <?php echo $be_themes_data['color_scheme']; ?>;
   border-bottom:1px solid <?php echo $be_themes_data['color_scheme']; ?>;
   color:<?php echo $be_themes_data['color_scheme']; ?>;   
}

.sec-title-color,
th ,
a.team_icons ,
.portfolio-title a{
    color:<?php echo $be_themes_data['sec_title_color']; ?>;
}
.be-shadow, .photostream ul li a img{
    box-shadow: 0 0 2px rgba(0,0,0,0.2);
}

.ui-accordion-header:first-child {
     border-top: 1px solid <?php echo $be_themes_data['sec_border_color']; ?> !important;
}

#navigation.style1 ul li a{
    border-left: 1px solid <?php echo $be_themes_data['nav_border_color']; ?>;
}

.sidebar-navigation .current_page_item {
    border-right: 3px solid <?php echo $be_themes_data['color_scheme']; ?>;
    background: <?php echo $be_themes_data['alt_bg_text_color'];  ?> ;
}

.post-meta, .post-meta a{
    color: #999999;
}

blockquote{
    border-left:2px solid <?php echo $be_themes_data['color_scheme'] ?>;
}

pre {
    background-image: -webkit-repeating-linear-gradient(top, <?php echo $be_themes_data['content']['color']; ?> 0px, <?php echo $be_themes_data['content']['color']; ?> 30px, <?php echo $be_themes_data['sec_bg']; ?> 24px, <?php echo $be_themes_data['sec_bg']; ?> 56px);
    background-image: -moz-repeating-linear-gradient(top, <?php echo $be_themes_data['content']['color']; ?> 0px, <?php echo $be_themes_data['content']['color']; ?> 30px, <?php echo $be_themes_data['sec_bg']; ?> 24px, <?php echo $be_themes_data['sec_bg']; ?> 56px);
    background-image: -ms-repeating-linear-gradient(top, <?php echo $be_themes_data['content']['color']; ?> 0px, <?php echo $be_themes_data['content']['color']; ?> 30px, <?php echo $be_themes_data['sec_bg']; ?> 24px, <?php echo $be_themes_data['sec_bg']; ?> 56px);
    background-image: -o-repeating-linear-gradient(top, <?php echo $be_themes_data['content']['color']; ?> 0px, <?php echo $be_themes_data['content']['color']; ?> 30px, <?php echo $be_themes_data['sec_bg']; ?> 24px, <?php echo $be_themes_data['sec_bg']; ?> 56px);
    background-image: repeating-linear-gradient(top, <?php echo $be_themes_data['content']['color']; ?> 0px, <?php echo $be_themes_data['content']['color']; ?> 30px, <?php echo $be_themes_data['sec_bg']; ?> 24px, <?php echo $be_themes_data['sec_bg']; ?> 56px);
    display: block;
    line-height: 28px;
    margin-bottom: 50px;
    overflow: auto;
    padding: 0px 10px;
    border:1px solid <?php echo $be_themes_data['sec_border_color']; ?>;
}

.separator, .special-heading hr {
  border-color: <?php echo $be_themes_data['separator_color'];  ?> ;
  color: <?php echo $be_themes_data['separator_color'];  ?> ;
}

/*  Optiopn Panel Css */
<?php echo stripslashes_deep(htmlspecialchars_decode($be_themes_data['custom_css'],ENT_QUOTES));  ?>