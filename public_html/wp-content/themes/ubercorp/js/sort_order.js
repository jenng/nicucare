jQuery(document).ready(function(){
	jQuery('.be-themes-sort-order').sortable();
	
	jQuery('#be-themes-sort-save').on('click',function(){
		$posts = jQuery('.be-themes-sort-order').find('li');	
		$ids = [];
		ajax_url = jQuery('#ajax_url').val();
		$posts.each(function(){
			$ids.push(jQuery(this).data('post-id'));
		});
		
		$ajax_data = { 'action':'be_themes_save_sort_order', 'post_id' : $ids };
		console.log($ajax_data);
		jQuery.ajax({
				type: "POST",
				url: ajax_url,
				data: $ajax_data, //{ 'action':'save_sort_order', 'post_id' : $ids }, //"action=save_sort_order&post_id[]="+$ids,
				success	: function(msg) {
						
					jQuery('<div class="notification green">Successfully Saved<span class="close"></span></div>').hide().prependTo('#be-themes-save-wrap').fadeIn();
					setTimeout( "jQuery('#be-themes-save-wrap .notification').fadeOut(500, function() { jQuery(this).remove(); });",2000 );
				},
				error: function(msg) {
					
				},
				complete: function() {
					
				}
		});
	});

});