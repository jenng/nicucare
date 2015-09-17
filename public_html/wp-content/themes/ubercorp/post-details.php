<nav class="post-nav secondary_text sec-border">
	<ul class="clearfix">
		<li class="post-author post-meta left"><i class="icon-user font-icon"></i><?php the_author(); ?></li>
		<li class="post-comment-total post-meta left"><i class="icon-comment font-icon"></i><?php comments_number('0','1','%');?><?php _e(' comments','be-themes'); ?></li>
		<li class="post-category post-meta left"><i class="icon-tag font-icon"></i><?php be_themes_category_list($id); ?></li>
		<?php 
		if(!is_single()) : ?>
			<li class="post-read-more right last">
				<a href="<?php echo get_permalink(get_the_ID()); ?>" class="alt-color"><?php _e('Read More','be-themes') ?> <i class="icon-right-open"></i></a>
			</li>
		<?php endif; ?>
	</ul>
</nav>