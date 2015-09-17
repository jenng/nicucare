function last_child() {
	"use strict";
    if (/msie [1-8]{1}[^0-9]/.test(navigator.userAgent.toLowerCase())) {
        jQuery('.column-block *:last-child').addClass('be-last-child');
        jQuery('.be-section .be-row:last-child .column-block').css('margin-bottom','0px');
    }
}

jQuery(document).ready(function() {
	"use strict";
	last_child();
	jQuery('body').fitVids();
	var ajax_url = jQuery('#ajax_url').val();


	jQuery('.column-block .special-heading:only-child').parent('.one-col').css('margin-bottom','20px');
	jQuery('.column-block :header:only-child').parent('.one-col').css('margin-bottom','20px');
	jQuery('.one-col script:last-child').prev('.rev_slider_wrapper').parent('.one-col').css('margin-bottom','0px');
	jQuery('input[placeholder], textarea[placeholder]').placeholder();
	jQuery('a[href="#"]').on('click',function(e){
		e.preventDefault();
	});
	
/********************************
		Header 
********************************/
	
	jQuery('#header').waypoint('sticky');

/********************************
		Menu 
********************************/	

	var $menu = jQuery('#navigation').find('.menu').children('ul');	
	
	if($menu.closest('#navigation').hasClass('style1')) {
		var $alt_color = jQuery('#nav_colors').attr('data-color'),
			$border_color = jQuery('#nav_colors').attr('data-border-color');
		$menu.children('li').children('a').on({
			mouseenter:function() {
				jQuery(this).css('border-left','1px solid '+$alt_color);
				jQuery(this).parent('li').next().children('a').css('border-left','1px solid '+$alt_color);
			},
			mouseleave: function(){
				jQuery(this).css('border-left','1px solid '+$border_color);
				jQuery(this).parent('li').next().children('a').css('border-left','1px solid '+$border_color);
			}
		});
		jQuery('#navigation > ul li:last-child').children('a').css('padding-right','0');
	}

	$menu.tinyNav({ active: 'selected', header: 'Navigation'});
	$menu.menu();

/********************************
		Tabs 
********************************/	
						
	var tabs_wrapper = jQuery('.tabs_wrap');
	if(tabs_wrapper.length > 0) {
		tabs_wrapper.each(function(){
			jQuery(this).tabs({ fx: { height: 'toggle',opacity:'toggle', duration: 'slow' } });
			jQuery(this).css('visibility','visible');
			var config = {
				over: function(){
					jQuery(this).addClass("hover_active",100);
				},    
				timeout: 50,   
				out: function(){
					jQuery(this).removeClass("hover_active",100);
				} 
			};
			jQuery(".tabs li a").hoverIntent( config );
		});
	}

/********************************
		Accordion 
********************************/

	var accordion = jQuery(".accordion");
	var accordion_collapsed = jQuery(".accordion_all_collapsed");
	if(accordion.length > 0) {
		accordion.accordion({autoHeight: true, animate:300, heightStyle: "content"});
	}
	if(accordion_collapsed.length > 0) {
		accordion_collapsed.accordion({ active: false, autoHeight: true, collapsible: true, animate:300, heightStyle: "content" });
	}
	accordion.css('visibility','visible');
	accordion_collapsed.css('visibility','visible');

/********************************
		Clients 
********************************/
	
	var carousel = jQuery(".be-carousel");
	if(carousel.length > 0) {
		jQuery('.be-carousel').carouFredSel({
			width: '100%',
			scroll: 1,
			prev: '.prev',
			next: '.next',
			mousewheel: true,
			swipe: {
				onMouse: true,
				onTouch: true
			}
		});
	}

/********************************
		Portfolio 
********************************/

	var $portfolio_container = jQuery('.portfolio-container');
	$portfolio_container.imagesLoaded(function(){
		if($portfolio_container.parent('.portfolio').hasClass('fullscreen-col')) {
			$portfolio_container.isotope({
				itemSelector : '.element'
			});
		}
		else {
			$portfolio_container.isotope({
				itemSelector : '.element',
				masonry: {
					gutterWidth: 20
				}
			});
		}	
	});
	jQuery(".sort").on("click",function(){
		var $this = jQuery(this);
		$this.parent(".filters").children(".sort").removeClass("current_choice");
		$this.addClass("current_choice");
		var myClass = $this.attr("data-id");
		$this.closest('.portfolio').find($portfolio_container).isotope({ filter: '.'+myClass });
	});
	
	jQuery(function() {
		jQuery(".element-inner").hover(function() {
			jQuery(this).find('.portfolio-title,.portfolio-title a').stop(true, true).addClass('hover', 300);
			jQuery(this).find('.thumb-overlay').stop().fadeIn(300);
		}, function() {
			jQuery(this).find('.portfolio-title,.portfolio-title a').removeClass('hover', 300);
			jQuery(this).find('.thumb-overlay').stop().fadeOut(300);
		});
		
		jQuery(".overlay-thumb-icons a,.overlay-thumb-title a").hover(function() {
			jQuery(this).stop(true, true).addClass('hover', 300);
		}, function() {
			jQuery(this).removeClass('hover', 300);
		});
	});

 
    jQuery('.image-popup-vertical-fit').magnificPopup({
      closeOnContentClick: true,
      mainClass: 'mfp-img-mobile',
      gallery: {
         enabled: true
      },
      image: {
        verticalFit: true
      }
      
    });

	jQuery('.popup-gallery').magnificPopup({
          delegate: 'a',
          type: 'image',
          tLoading: 'Loading image #%curr%...',
          mainClass: 'mfp-img-mobile',
          gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
          },
          image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
          }
    });
 
    jQuery('.be-lightbox').on('click' , function(e){
    	e.preventDefault();
        jQuery(this).next('.popup-gallery').magnificPopup('open');
    });    



/********************************
		Contact
********************************/

	if(jQuery(".contact_form").length > 0) {
		jQuery(".contact_submit").on('click',function() {
			var $this = jQuery(this);
			var $contact_status = $this.closest('.contact_form').find(".contact_status");
			var $contact_loader = $this.closest('.contact_form').find(".contact_loader");
			$contact_loader.fadeIn();
			jQuery.ajax({
				type: "POST",
				url: ajax_url,
				dataType: 'json',
				data: "action=contact_authentication&"+jQuery(this).closest(".contact").serialize(),
				success	: function(msg) {
					$contact_loader.fadeOut();
					if(msg.status === "error") {
						$contact_status.removeClass("success").addClass("error");
					}
					else {
						$contact_status.addClass("success").removeClass("error");
					}
					$contact_status.html(msg.data).slideDown();
				},
				error: function() {
					$contact_status.html("Please Try Again Later").slideDown();
				}
			});
			return false;
		});
	}
	google_maps();
	function google_maps() {
		jQuery('.gmap').each(function() {
			var $address = jQuery(this).data('address');
			var $zoom = jQuery(this).data('zoom');
			jQuery(this).gmap3({	
				action: 'addMarker',
				address: $address,
				map: {
					center: true,
					zoom: $zoom,
					navigationControl: true
				}
			});
		});
	}

/********************************
		BUTTON 
********************************/
	var button = jQuery('.be-button');
	if(button.length > 0) {
		button.hover(function(){
			var hover_color=jQuery(this).attr("data-hover-color");
			jQuery(this).stop().animate({backgroundColor: hover_color}, 700);
		},function(){
			var default_color=jQuery(this).attr("data-default-color");
			jQuery(this).stop().animate({backgroundColor: default_color}, 700);
		});
	}

	var icon = jQuery('.icon-shortcode .font-icon');
	if(icon.length > 0) {
		icon.hover(function(){
			var hover_bg_color=jQuery(this).attr("data-bg-hover-color");
			var hover_color=jQuery(this).attr("data-hover-color");
			jQuery(this).stop().animate({backgroundColor: hover_bg_color,color: hover_color}, 400);
		},function(){
			var default__bg_color=jQuery(this).attr("data-bg-color");
			var default_color=jQuery(this).attr("data-color");
			jQuery(this).stop().animate({backgroundColor: default__bg_color,color: default_color}, 400);
		});
	}


});  //  end document ready function

jQuery(window).smartresize(function(){
	"use strict";
	jQuery('.portfolio-container').isotope( 'reLayout' );
});

jQuery(window).load(function(){
	
	"use strict";
	
	/********************************
		FlexSlider
	********************************/

	jQuery('.content-flexslider,.flexslider_testimonials').each(function() {
		var $animation_type = jQuery(this).attr('data-animation');
		var $slideshow = false;
		if(jQuery(this).attr('data-auto-slide') == 'yes') {
			$slideshow = true;
		}
		var $slide_interval = parseInt(jQuery(this).attr('data-slide-interval'),10);
		jQuery(this).flexslider({
			animation: $animation_type,
			slideshow: $slideshow,
			slideshowSpeed: $slide_interval,
			controlNav: false,
			smoothHeight: true,
			directionNav: true,
			prevText:'',
			nextText:'',
			start: function(slider){
				slider.closest(".be-flex-slider").removeClass('flex-loading');
			}
		});
	});
});