<?php get_template_part('templates/page', 'head'); ?>
<?php $breadcrumbs = ct_show_single_post_breadcrumbs('post') ? true : false; ?>
<?php $pageTitle = ct_get_single_post_title('post'); ?>
<?php $pageSubtitle = ct_get_single_post_subtitle('post'); ?>
<?php $bookTable = ct_show_single_post_book('post') ? true : false; ?>



		<?php if($pageSubtitle):?>
			<?php echo do_shortcode('[title_row main="no"]' . $pageSubtitle . '[/title_row]');?>
		<?php endif; ?>
		<?php if($bookTable):?>
			<?php // get_template_part('templates/content', 'book-table'); ?>
		<?php endif;?>

		<section id="blog">

			<?php get_template_part('templates/content', 'title'); ?>

			<?php echo do_shortcode('[title_row]' . get_the_title() . '[/title_row]');?>

			<div class="row-fluid"> <!-- blog -->
				<?php if (is_404()): ?><div class="span9"><?php else: ?><div class="<?php ct_blog_post_class()?>"><?php endif;?>
					<?php get_template_part('templates/content', 'single'); ?>
			    </div>

				<?php if (ct_use_blog_post_sidebar()): ?>
				    <div class="<?php roots_sidebar_class(); ?>">
						<?php get_template_part('templates/sidebar'); ?>
				    </div>
				<?php endif;?>
			</div>
			<!-- //row -->

		</section>

