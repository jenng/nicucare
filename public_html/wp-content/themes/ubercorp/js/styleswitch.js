/**
* Styleswitch stylesheet switcher built on jQuery
* Under an Attribution, Share Alike License
* By Kelvin Luck ( http://www.kelvinluck.com/ )
**/

;(function($)
{
	$(document).ready(function() {
		$('.styleswitch').click(function()
		{
			switchStylestyle(jQuery(this).data('rel'));
			return false;
		});
		var c = readCookie('style');
		if (c) switchStylestyle(c);
		var br_url= jQuery("#base_url").val();
		var css_switcher="hide";
		jQuery('html.no-touch .css_switcher_open,html.no-touch .css_switcher_close').click(function(){
			$current_element=jQuery(this);
			if(css_switcher=="show") {
				jQuery(".css_switcher_items").animate({marginLeft: "-220px"}, "slow", function(){
					css_switcher="hide";
					$current_element.toggleClass('css_switcher_open');
				});
			}
			else {
				jQuery(".css_switcher_items").animate({marginLeft: "0px"}, "slow", function(){
					css_switcher="show";
					$current_element.toggleClass('css_switcher_open');
				});
			}
			return false;
		});
		set_patern();
		jQuery('.bg_patern_item').click(function(){
			$current_element=jQuery(this);
			var background_patren_value=$current_element.attr('rel');
			createCookie('background',background_patren_value,1);
			set_patern();
			return false;
		});
		function set_patern() {
			var bg_value = readCookie('background');
			if(bg_value) {
				jQuery("body").css("background-image", "url("+br_url+"/img/bg-patterns/"+bg_value+".png)");
			}
		}
	});

	function switchStylestyle(styleName)
	{
		$('link[rel*=style][title]').each(function(i) 
		{
			this.disabled = true;
			if (this.getAttribute('title') == styleName) this.disabled = false;
		});
		createCookie('style', styleName, 365);
	}
})(jQuery);
// cookie functions http://www.quirksmode.org/js/cookies.html
function createCookie(name,value,days)
{
	if (days)
	{
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}
function readCookie(name)
{
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++)
	{
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
function eraseCookie(name)
{
	createCookie(name,"",-1);
}
// /cookie functions