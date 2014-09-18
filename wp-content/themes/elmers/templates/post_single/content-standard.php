<div class="row-fluid">
	<?php // get_template_part('templates/post_single/content-meta'); ?>
	<div class="span12">
		<?php if (ct_get_option("posts_single_show_image", 1)): ?>
			<?php get_template_part('templates/post_single/content-featured-image'); ?>
		<?php endif; ?>

		<?php if (ct_get_option("posts_single_show_content", 1)): ?>
		    <?php the_content();?>
			<?php wp_link_pages(array('before' => '<nav class="pager">', 'after' => '</nav>')); ?>
		<?php endif;?>

	</div>
</div>