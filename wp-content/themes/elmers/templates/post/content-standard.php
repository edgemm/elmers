<div class="row-fluid">
	<?php //get_template_part('templates/post/content-meta'); ?>
	<div class="span12">
		<?php if (ct_get_option("posts_index_show_title", 1)): ?>
			<header>
				<a href="<?php the_permalink(); ?>"><h2 class="page-article-title"><?php the_title(); ?></h2></a>
			</header>
		<?php endif;?>

		<?php if (ct_get_option("posts_index_show_image", 1)): ?>
			<?php get_template_part('templates/post/content-featured-image'); ?>
		<?php endif; ?>

		<?php if (ct_get_option("posts_index_show_excerpt", 1)): ?>
			<?php the_excerpt(); ?>
		<?php endif;?>
		<?php if (ct_get_option("posts_index_show_fulltext", 0)): ?>
			<?php the_content();?>
		<?php endif;?>

		<?php if (ct_get_option("posts_index_show_more", 1)): ?>
			<p><a href="<?php the_permalink()?>" class="btn btn-primary"><?php _e('Read more', 'ct_theme')?></a></p>
		<?php endif;?>

	</div>
</div>