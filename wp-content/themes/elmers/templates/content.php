<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		<?php $format = get_post_format();
			$format = $format ? $format : 'standard';
			$class = 'blog-post ' . $format . '-post page-article';
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class($class); ?>>
		    <?php get_template_part('templates/post/content-' . $format);?>
	    </article> <!-- / blogItem -->
	<?php endwhile; ?>

<?php else: ?>
	<article class="noResults">
		<?php echo do_shortcode('[alert_box type="warning"]' . __('Sorry, no results were found.', 'ct_theme') . '[/alert_box]')?>
		<?php get_search_form(); ?>
	</article>
<?php endif; ?>